<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Reply;
use App\Models\Review;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class BusinessReplyController extends Controller
{
    use AuthorizesRequests;

    public function create(Review $review)
    {
        return view('business.replies.create', compact('review'));
    }

    // Store a new reply
    public function store(Request $request, Review $review)
    {
        // Validate the input
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Check if the user has already replied to this review
        $existingReply = $review->replies()->where('user_id', auth()->id())->first();
        if ($existingReply) {
            return redirect()->route('business.reviews.index')->with('error', 'You have already replied to this review.');
        }

        // Create the reply
        $review->replies()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Redirect back to the review page with a success message
        return redirect()->route('business.reviews.index')->with('success', 'Reply added successfully.');
    }


    // Edit an existing reply
    public function edit(Reply $reply)
    {
        $this->authorize('update', $reply);
        return view('business.replies.edit', compact('reply'));
    }

    // Update a reply
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        // Validate the reply content
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Update the reply in the database
        $reply->update([
            'content' => $request->content,
        ]);

        // Redirect back to the reviews page with a success message
        return redirect()->route('business.reviews.index')->with('success', 'Reply updated successfully.');
    }


    // Delete a reply
    public function destroy(Reply $reply)
    {
        // Ensure the user has permission to delete
        $this->authorize('delete', $reply);

        // Delete the reply
        $reply->delete();

        // Redirect back with a success message
        return redirect()->route('business.reviews.index')->with('success', 'Reply deleted successfully.');
    }
}
