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
            ->get();

        return view('client.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {

        return view('client.bookings.show', compact('booking'));
    }

}
