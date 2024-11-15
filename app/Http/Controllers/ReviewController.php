<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Service $service)
    {
        // Validate the incoming review data
        $request->validate([
            'rating' => 'required|integer|min:1|max:5', // Rating must be an integer between 1 and 5
            'comment' => 'nullable|string', // Comment is optional but must be a string
        ]);

        // Create a new review with the authenticated user's ID
        $review = new Review([
            'user_id' => auth()->id(),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        // Associate the review with the service and save it
        $service->reviews()->save($review);

        // Redirect back to the service page with a success message
        return redirect()->route('client.services.show', $service)
            ->with('success', 'Review submitted successfully.');
    }
}
