<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BusinessBookingController extends Controller
{
    /**
     * Show the list of bookings for the business.
     */
    public function index(Request $request)
    {
        $query = Booking::whereHas('service', function ($query) {
            $query->where('business_id', auth()->user()->business->id);
        });

        // Sorting logic
        $sortableColumns = [
            'user' => 'users.first_name', // Sort by user's first name
            'service' => 'services.name', // Sort by service name
            'date' => 'date',             // Sort by booking date
            'start_time' => 'start_time', // Sort by start time
            'status' => 'status',         // Sort by booking status
        ];

        if ($request->has('sort') && $request->has('direction')) {
            $sortColumn = $sortableColumns[$request->get('sort')] ?? null;
            $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

            if ($sortColumn) {
                $query->join('services', 'bookings.service_id', '=', 'services.id')
                    ->join('users', 'bookings.user_id', '=', 'users.id')
                    ->orderBy($sortColumn, $direction);
            }
        }

        $query->select('bookings.*');

        $bookings = $query->with(['user', 'service'])->paginate(9);

        return view('business.bookings.index', compact('bookings'));
    }

    /**
     * Show the details of a booking.
     */
    public function show(Booking $booking)
    {
        return view('business.bookings.show', compact('booking'));
    }

    /**
     * Accept a booking.
     */
    public function accept(Booking $booking)
    {
        $booking->update(['status' => 'accepted']);

        return redirect()->route('business.bookings')->with('success', 'Booking accepted.');
    }

    /**
     * Deny a booking.
     */
    public function deny(Booking $booking)
    {

        $booking->update(['status' => 'denied']);

        return redirect()->route('business.bookings')->with('success', 'Booking denied.');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'bookings' => 'required|array',
            'bookings.*' => 'exists:bookings,id',
            'action' => 'required|in:accept,deny',
        ]);

        $status = $request->action === 'accept' ? 'accepted' : 'denied';

        Booking::whereIn('id', $request->bookings)
            ->whereHas('service', function ($query) {
                $query->where('business_id', auth()->user()->business->id);
            })
            ->update(['status' => $status]);

        return response()->json(['success' => true, 'message' => 'Bookings updated successfully.']);
    }

}
