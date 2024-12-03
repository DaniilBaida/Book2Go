<x-business-layout>
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Reply to Review</h2>

        <!-- Display the review being replied to -->
        <div class="mb-6">
            <p><strong>Reviewer:</strong> 
                {{ $review->reviewer_type === 'client' 
                    ? $review->booking->user->first_name . ' ' . $review->booking->user->last_name 
                    : $review->booking->service->business->name }}
            </p>
            <p><strong>Rating:</strong> {{ $review->rating }} Stars</p>
            <p><strong>Comment:</strong> {{ $review->comment ?? 'No comment provided.' }}</p>
        </div>

        <!-- Reply form -->
        <form method="POST" action="{{ route('business.replies.store', $review->id) }}">
            @csrf
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium">Your Reply</label>
                <textarea id="content" name="content" rows="4" required 
                          class="w-full border rounded p-2"></textarea>
            </div>

            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Submit Reply
            </button>
        </form>
    </div>
</x-business-layout>
