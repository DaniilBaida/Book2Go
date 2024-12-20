<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class ClientBookingController extends Controller
{
    public function index(Request $request)
    {
        // Build query to fetch bookings for the authenticated user
        $query = auth()->user()->bookings()
            ->with('service') // Eager load the related service
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc');

        // Add search logic
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('service', function ($serviceQuery) use ($search) {
                $serviceQuery->where('name', 'like', '%' . $search . '%');
            });
        }

        // Paginate results
        $bookings = $query->paginate(9);

        // Return the view with the bookings
        return view('client.bookings.index', compact('bookings'));
    }

    /**
     * Store a new booking for the selected service.
     *
     * @param Request $request The incoming request containing booking details.
     * @param Service $service The service being booked.
     *
     * @return RedirectResponse Redirect response after booking creation.
     */
    public function store(Request $request, Service $service)
    {
        $validated = $request->validate([
            'date' => 'required|date|after:yesterday',
            'start_time' => 'required|date_format:H:i',
        ]);

        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        // Check if the slot is already booked (pending or accepted)
        $exists = Booking::where('service_id', $service->id)
            ->where('date', $validated['date'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where('start_time', '<=', $startTime->format('H:i'))
                    ->where('end_time', '>=', $endTime->format('H:i'));
            })
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['start_time' => 'The selected time slot is not available.']);
        }

        // Create the booking
        Booking::create([
            'service_id' => $service->id,
            'user_id' => auth()->id(),
            'date' => $validated['date'],
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'status' => 'pending',
        ]);

        return redirect()->route('client.bookings')->with('success', 'Booking created successfully.');
    }

    public function pay(Booking $booking)
    {
        // Ensure the booking is in 'accepted' status
        if ($booking->status !== 'accepted') {
            return redirect()->route('client.bookings')->with('error', 'Cannot proceed to payment for this booking.');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => $booking->service->price,
                    ],
                    "description" => "Booking for service: " . $booking->service->name,
                ]
            ],
            "application_context" => [
                "cancel_url" => route('client.payment.cancel', $booking),
                "return_url" => route('client.payment.success', $booking),
            ]
        ]);

        // Redirect to PayPal approval URL
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('client.bookings')->with('error', 'Unable to create PayPal order. Please try again.');
    }

    public function paymentSuccess(Request $request, Booking $booking)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);
    
            // Captura os detalhes do pagamento
            $response = $provider->capturePaymentOrder($request->input('token'));
    
            // Verifica se o pagamento foi completado
            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                // Atualiza o status da reserva para "paid"
                $booking->update(['status' => 'paid']);

                // Prepare the payment details for the email
                $paymentDetails = [
                    'id' => $response['id'],
                    'amount' => $response['purchase_units'][0]['amount']['value'], // Captura o valor
                    'currency' => $response['purchase_units'][0]['amount']['currency_code'], // Captura a moeda
                    'status' => $response['status'],
                ];

    
                // Enviar recibo por email
                \Mail::to($booking->user->email)->send(new \App\Mail\PaymentReceiptMail($booking, $paymentDetails));
    
                return redirect()->route('client.bookings')->with('success', 'Payment successful. Receipt sent to your email.');
            }
    
            return redirect()->route('client.bookings')->with('error', 'Payment was not successful. Please try again.');
    
        } catch (\Exception $e) {
            \Log::error('Payment Error: ' . $e->getMessage());
    
            return redirect()->route('client.bookings')->with('error', 'An error occurred while processing your payment. Please try again later.');
        }
    }

    public function checkout(Booking $booking)
    {
        return view('client.checkout.checkout', compact('booking'));
    }

    public function applyDiscount(Request $request, Booking $booking)
    {
        $request->validate([
            'discount_code' => 'required|string',
        ]);

        $discountCode = $request->input('discount_code');

        // Check for valid discount code
        $discount = \App\Models\DiscountCode::where('code', $discountCode)
            ->where('status', 'active')
            ->where(function ($query) use ($booking) {
                $query->whereNull('business_id') // Admin-level discounts
                    ->orWhere('business_id', $booking->service->business_id); // Business-specific discounts
            })
            ->first();

        if (!$discount || ($discount->uses >= $discount->max_uses)) {
            return back()->withErrors(['discount_code' => 'Invalid or expired discount code.']);
        }

        // Calculate discount value
        $discountValue = $discount->type === 'fixed'
            ? $discount->value
            : $booking->service->price * ($discount->value / 100);

        // Store discount in session
        session(['discount' => [
            'code' => $discount->code,
            'value' => min($discountValue, $booking->service->price),
        ]]);

        return back()->with('success', 'Discount applied successfully.');
    }

    
    

    public function show(Booking $booking)
    {

        return view('client.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {

        $booking->delete();

        return redirect()->route('client.bookings')->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Fetch available time slots for a given service on a specific date.
     *
     * @param Request $request The incoming request with the selected date.
     * @param Service $service The service for which available slots are fetched.
     *
     * @return JsonResponse JSON response with available time slots.
     */
    public function availableSlots(Request $request, Service $service)
    {
        // Validate the date parameter
        $request->validate(['date' => 'required|date']);

        // Parse the date
        $date = $request->input('date');

        // Convert service duration to minutes
        $serviceDuration = $service->duration_minutes;

        // Generate available slots based on service working hours
        $startTime = Carbon::parse($service->start_time);
        $endTime = Carbon::parse($service->end_time);
        $allSlots = [];

        while ($startTime->lessThan($endTime)) {
            $allSlots[] = $startTime->format('H:i');
            $startTime->addMinutes($serviceDuration);
        }

        // Fetch already booked slots for the selected date
        $bookedSlots = Booking::where('service_id', $service->id)
            ->where('date', $date)
            ->whereIn('status', ['pending', 'accepted'])
            ->get(['start_time', 'end_time']);

        // Filter out conflicting slots
        $availableSlots = array_filter($allSlots, function ($slot) use ($bookedSlots, $serviceDuration) {
            $slotStart = Carbon::parse($slot);
            $slotEnd = $slotStart->copy()->addMinutes($serviceDuration);

            foreach ($bookedSlots as $booked) {
                $bookedStart = Carbon::parse($booked->start_time);
                $bookedEnd = Carbon::parse($booked->end_time);

                // Check if the current slot overlaps with any booked slot
                if ($slotEnd->greaterThan($bookedStart) && $slotStart->lessThan($bookedEnd)) {
                    return false;
                }
            }
            return true;
        });

        // Return available slots
        return response()->json(array_values($availableSlots));
    }



}
