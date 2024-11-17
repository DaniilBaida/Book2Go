<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Livewire\Livewire;

class BookingController extends Controller
{
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

        // Get the business owner of the service
        $business = $service->business;

        // Automatically set auto_accept for the business if it's enabled
        $autoAccept = $business ? $business->auto_accept_bookings : false;

        // Calculate the end time for the booking
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        // Check if the slot is available (doesn't conflict with other bookings)
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

        // If auto_accept is enabled for the business, automatically accept the booking
        // For clients, bookings will always be pending
        $status = $autoAccept ? 'accepted' : 'pending';

        // Create the booking with the correct status
        $booking = Booking::create([
            'service_id' => $service->id,
            'user_id' => auth()->id(), // This is the client
            'date' => $validated['date'],
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $status,
            'auto_accept' => $autoAccept,
        ]);

        return redirect()->route('client.bookings')->with('success', 'Booking created successfully.');
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

    /**
     * View all the client's bookings.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get all bookings for the current client (user)
        $bookings = Booking::where('user_id', auth()->id())->get();
        return view('client.bookings.index', compact('bookings'));
    }

    /**
     * View a specific booking.
     *
     * @param Booking $booking The booking to view.
     * @return \Illuminate\View\View
     */
    public function show(Booking $booking)
    {
        // Check if the booking belongs to the authenticated user
        if ($booking->user_id != auth()->id()) {
            return redirect()->route('client.bookings')->with('error', 'Unauthorized access.');
        }

        return view('client.bookings.show', compact('booking'));
    }

    /**
     * Accept a booking manually (by the business).
     *
     * @param Booking $booking
     * @return RedirectResponse
     */
    public function acceptBooking(Booking $booking)
    {
        // Check if the business is authorized to accept the booking
        if ($booking->service->business_id != auth()->user()->business->id) {
            return redirect()->route('business.bookings.index')->with('error', 'Unauthorized action.');
        }

        // Change the booking status to accepted
        $booking->update(['status' => 'accepted']);

        return redirect()->route('business.bookings.index')->with('success', 'Booking accepted.');
    }

    /**
     * Deny a booking manually (by the business).
     *
     * @param Booking $booking
     * @return RedirectResponse
     */
    public function denyBooking(Booking $booking)
    {
        // Check if the business is authorized to deny the booking
        if ($booking->service->business_id != auth()->user()->business->id) {
            return redirect()->route('business.bookings.index')->with('error', 'Unauthorized action.');
        }

        // Change the booking status to denied
        $booking->update(['status' => 'denied']);

        return redirect()->route('business.bookings.index')->with('success', 'Booking denied.');
    }
}
