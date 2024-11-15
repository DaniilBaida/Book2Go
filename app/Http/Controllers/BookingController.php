<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Livewire;

class BookingController extends Controller
{
    public function store(Request $request, Service $service)
    {
        $validated = $request->validate([
            'date' => [
                'required',
                'date',
                'after:yesterday', // Ensure the booking date is today or in the future
                'before_or_equal:' . now()->addDays(60)->format('Y-m-d'), // Limit to max 60 days from today
            ],
            'start_time' => 'required|date_format:H:i',
        ]);

        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        // Check for overlapping bookings
        $exists = Booking::where('service_id', $service->id)
            ->where('date', $validated['date'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime->subMinute()]) // Ensure start time doesn't fall within any booking
                ->orWhereBetween('end_time', [$startTime->addMinute(), $endTime]); // Ensure end time doesn't fall within any booking
            })
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['start_time' => 'The selected time slot is not available.']);
        }

        // Create the booking
        Booking::create([
            'service_id' => $service->id,
            'user_id' => auth()->id(),
            'date' => $validated['date'],
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        return redirect()->route('client.services.index')->with('success', 'Booking confirmed!');
    }


    public function availableSlots(Request $request, Service $service)
    {
        $request->validate(['date' => 'required|date']);

        $slots = $service->getAvailableSlots($request->input('date'));

        return response()->json($slots);
    }
}
