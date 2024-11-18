<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('is_approved', false)->get();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {

        return view('admin.reviews.show', compact('review'));

    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);

        return redirect()->route('admin.reviews.index')->with('success', 'Review approved successfully.');
    }

    public function reject(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review rejected successfully.');
    }

    public function resolve(Request $request, Review $review)
    {
        $request->validate(['action' => 'required|in:approve,reject']);

        if ($request->action === 'approve') {
            $review->update(['is_approved' => true, 'reported_at' => null]);
        } else {
            $review->delete(); // Or set as rejected
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Review resolution action completed.');
    }
}
