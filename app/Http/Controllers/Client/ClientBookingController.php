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

        $autoAccept = $service->business->auto_accept_bookings;
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        $exists = Booking::where('service_id', $service->id)
            ->where('date', $validated['date'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime->subMinute()])
                    ->orWhereBetween('end_time', [$startTime->addMinute(), $endTime]);
            })
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['start_time' => 'The selected time slot is not available.']);
        }

        $status = $service->auto_accept ? 'accepted' : 'pending';

        $booking = Booking::create([
            'service_id' => $service->id,
            'user_id' => auth()->id(),
            'date' => $validated['date'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $status,
        ]);

        // Initialize PayPal
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
                        "value" => $service->price,
                    ],
                    "description" => "Booking for service: " . $service->name,
                ]
            ],
            "application_context" => [
                "cancel_url" => route('client.payment.cancel', $booking),
                "return_url" => route('client.payment.success', $booking),
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()
                ->route('client.bookings')
                ->with('error', 'Unable to create PayPal order. Please try again.');
        }
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

        // Parse the date and get the day name
        $date = Carbon::parse($request->input('date'));
        $dayName = $date->format('l'); // E.g., 'Monday'

        // Check if the selected day is in the service's available days
        if (!in_array($dayName, $service->available_days)) {
            return response()->json([]); // Return an empty array for unavailable days
        }

        // Get available slots and exclude the pending bookings
        $slots = $service->getAvailableSlots($date->format('Y-m-d'));

        // Always return a JSON array
        return response()->json($slots);
    }

}
