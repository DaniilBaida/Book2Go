<x-business-layout>
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Leave a Review for {{ $booking->user->first_name }} {{ $booking->user->last_name }}</h2>

        <form method="POST" action="{{ route('business.reviews.store', $booking) }}">
            @csrf
            <div class="mb-4">
                <label for="rating" class="block text-sm font-medium">Rating</label>
                <select id="rating" name="rating" required class="w-full border rounded p-2">
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium">Comment (Optional)</label>
                <textarea id="comment" name="comment" rows="4" class="w-full border rounded p-2"></textarea>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Submit Review
            </button>
        </form>
    </div>
</x-business-layout>
