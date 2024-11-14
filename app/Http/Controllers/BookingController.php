<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request, Service $service)
    {
        $validated = $request->validate([
            'booking_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
        ]);

        $startTime = Carbon::parse($validated['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration_minutes);

        // Check for conflicts
        $exists = Booking::where('service_id', $service->id)
            ->where('booking_date', $validated['booking_date'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime]);
            })->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['start_time' => 'Selected time slot is not available.']);
        }

        Booking::create([
            'service_id' => $service->id,
            'user_id' => auth()->id(),
            'booking_date' => $validated['booking_date'],
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        return redirect()->route('client.bookings.index')->with('success', 'Booking confirmed!');
    }

    public function availableSlots(Request $request, Service $service)
    {
        $request->validate(['date' => 'required|date']);

        $slots = $service->getAvailableSlots($request->input('date'));

        return response()->json($slots);
    }
}
