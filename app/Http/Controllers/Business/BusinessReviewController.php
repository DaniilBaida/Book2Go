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

        return view('business.index.create', compact('booking'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        // TODO: this is HARDCODED, make reviews work with the backend
        $reviews = [
            ['id' => 1, 'reviewer' => 'Brian Howie', 'rating' => 5, 'comment' => 'Great service!', 'status' => 'answered', 'reply' => 'Thank you for your kind words!'],
            ['id' => 3, 'reviewer' => 'Brian Howies', 'rating' => 4, 'comment' => 'Great service!', 'status' => 'answered', 'reply' => 'Thank you for your kind words!'],
            ['id' => 2, 'reviewer' => 'Jane Doe', 'rating' => 4, 'comment' => 'Good experience, but can improve.', 'status' => 'unanswered']
        ];

        // Search for reviewer name
        if ($search) {
            $reviews = array_filter($reviews, function ($review) use ($search) {
                return stripos($review['reviewer'], $search) !== false;
            });
        }

        // Sorting Logic
        if ($request->has('sort') && $request->has('direction')) {
            $sortField = $request->input('sort');
            $direction = $request->input('direction');

            usort($reviews, function ($a, $b) use ($sortField, $direction) {
                if ($direction === 'asc') {
                    return strcmp($a[$sortField], $b[$sortField]);
                } else {
                    return strcmp($b[$sortField], $a[$sortField]);
                }
            });
        }

        return view('business.reviews.index', compact('reviews'));
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
