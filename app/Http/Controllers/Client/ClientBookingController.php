<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientBookingController extends Controller
{
    public function index()
    {
        // Get current user's bookings with related service data using Eloquent
        $bookings = auth()->user()->bookings()
            ->with('service') // Eager load the related service
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

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

        // Fetch the business associated with the service
        $autoAccept = $service->business->auto_accept_bookings;

        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        // Check if slot is available
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

        // Set booking status based on auto-accept
        $status = $autoAccept ? 'accepted' : 'pending';

        // Create the booking
        Booking::create([
            'service_id' => $service->id,
            'user_id' => auth()->id(),
            'date' => $validated['date'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $status,
        ]);

        return redirect()->route('client.bookings')->with('success', 'Booking created successfully.');
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
