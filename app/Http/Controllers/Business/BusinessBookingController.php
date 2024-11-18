<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Notifications\ReviewRequestNotification;
use Illuminate\Http\Request;

class BusinessBookingController extends Controller
{
    /**
     * Show the list of bookings for the business.
     */
    public function index()
    {
        $bookings = Booking::whereHas('service', function ($query) {
            $query->where('business_id', auth()->user()->business->id);
        })->get();

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

    public function complete(Booking $booking)
    {
        if ($booking->status !== 'accepted') {
            return redirect()->back()->withErrors(['error' => 'Only accepted bookings can be marked as completed.']);
        }

        $booking->update(['status' => 'completed']);

        // Notify both client and business
        $booking->user->notify(new ReviewRequestNotification($booking)); // Notify client
        $booking->service->business->user->notify(new ReviewRequestNotification($booking)); // Notify business

        return redirect()->route('business.bookings')->with('success', 'Booking marked as completed. Both parties can now leave a review.');
    }

}
