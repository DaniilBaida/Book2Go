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
            'date' => [
                'required',
                'date',
                'after:yesterday',
                function ($attribute, $value, $fail) use ($service) {
                    $dayName = Carbon::parse($value)->format('l');
                    if (!in_array($dayName, $service->available_days)) {
                        $fail('The selected date is not available for this service.');
                    }
                },
            ],
            'start_time' => 'required|date_format:H:i',
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

        // Parse the date and get the day name
        $date = Carbon::parse($request->input('date'));
        $dayName = $date->format('l'); // E.g., 'Monday'

        // Check if the selected day is in the service's available days
        if (!in_array($dayName, $service->available_days)) {
            return response()->json([]); // Return an empty array for unavailable days
        }

        // Get available slots
        $slots = $service->getAvailableSlots($date->format('Y-m-d'));

        // Always return a JSON array
        return response()->json($slots);
    }
}
