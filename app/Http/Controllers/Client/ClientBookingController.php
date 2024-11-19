<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
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
            ->paginate(9);

        return view('client.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {

        return view('client.bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->delete();

        return redirect()->route('client.bookings')->with('success', 'Booking cancelled successfully.');
    }

}
