<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

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
