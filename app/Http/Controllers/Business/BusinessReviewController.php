<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class BusinessReviewController extends Controller
{
    use AuthorizesRequests;

    public function create(Booking $booking)
    {
        try {
            $this->authorize('leaveClientReview', $booking);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->route('business.notifications.index')
                ->with('error', $e->getMessage());
        }

        return view('business.reviews.create', compact('booking'));
    }



    public function store(Request $request, Booking $booking)
    {
        // Aplicar a Policy para verificar permissão
        $this->authorize('leaveClientReview', $booking);

        // Validar os dados
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Criar a review
        Review::create([
            'booking_id' => $booking->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'reviewer_type' => 'business',
            'is_approved' => false,
        ]);

        return redirect()->route('business.bookings')
            ->with('success', 'Review submitted successfully.');
    }

    public function report(Review $review)
    {
        $review->markAsReported();

        return back()->with('success', 'Review has been reported and will be reviewed by an administrator.');
    }
}
