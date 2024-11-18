<x-client-layout>
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-4">Leave a Review for {{ $booking->service->name }}</h2>

        <form method="POST" action="{{ route('client.reviews.store', $booking) }}">
            @csrf

            <!-- Rating Section -->
            <div class="mb-4">
                <label for="rating" class="block text-sm font-medium">Rating</label>
                <select id="rating" name="rating" required class="w-full border rounded p-2">
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
                <p id="rating-preview" class="mt-2 text-sm text-gray-600">Selected: 1 Star</p>
            </div>

            <!-- Comment Section -->
            <div class="mb-4">
                <label for="comment" class="block text-sm font-medium">Comment (Optional)</label>
                <textarea id="comment" name="comment" rows="4" placeholder="Share your experience..." class="w-full border rounded p-2"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Submit Review
            </button>
        </form>
    </div>

    <script>
        document.getElementById('rating').addEventListener('change', function () {
            const selectedRating = this.value;
            document.getElementById('rating-preview').textContent = `Selected: ${selectedRating} Star${selectedRating > 1 ? 's' : ''}`;
        });
    </script>
</x-client-layout>
