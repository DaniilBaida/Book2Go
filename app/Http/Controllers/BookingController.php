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
        // Validate the incoming request for date and time
        $validated = $request->validate([
            'date' => [
                'required',
                'date',
                'after:yesterday', // Ensure the booking date is today or in the future
                'before_or_equal:' . now()->addDays(60)->format('Y-m-d'), // Limit to max 60 days from today
            ],
            'start_time' => 'required|date_format:H:i', // Ensure start time is in correct format
        ]);

        // Parse start time and calculate end time based on service duration
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        // Check if the selected time slot overlaps with an existing booking
        $exists = Booking::where('service_id', $service->id)
            ->where('date', $validated['date'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime->subMinute()]) // Ensure start time doesn't fall within any booking
                ->orWhereBetween('end_time', [$startTime->addMinute(), $endTime]); // Ensure end time doesn't fall within any booking
            })
            ->exists();

        // If the time slot is not available, return an error
        if ($exists) {
            return redirect()->back()->withErrors(['start_time' => 'The selected time slot is not available.']);
        }

        // Create the new booking if time slot is available
        Booking::create([
            'service_id' => $service->id,
            'user_id' => auth()->id(),
            'date' => $validated['date'],
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        // Redirect to the services page with a success message
        return redirect()->route('client.services')->with('success', 'Booking confirmed!');
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

        // Get available time slots for the given date
        $slots = $service->getAvailableSlots($request->input('date'));

        // Return available slots as a JSON response
        return response()->json($slots);
    }
}
