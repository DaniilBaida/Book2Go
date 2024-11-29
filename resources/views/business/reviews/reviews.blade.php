<x-business-layout>
    <div class="p-6 bg-white rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Reviews</h1>

        <!-- Buttons to Filter Reviews -->
        <div class="mb-4 flex gap-4">
            <button 
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none"
                onclick="filterReviews('answered')"
            >
                Answered Reviews
            </button>
            <button 
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 focus:outline-none"
                onclick="filterReviews('unanswered')"
            >
                Unanswered Reviews
            </button>
        </div>

        <!-- Reviews Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse" id="reviews-table">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border">Reviewer</th>
                        <th class="px-4 py-2 border">Rating</th>
                        <th class="px-4 py-2 border">Comment</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Hardcoded Review - Answered -->
                    <tr class="review-row" data-status="answered">
                        <td class="px-4 py-2 border">Brian Howie</td>
                        <td class="px-4 py-2 border">5 ★</td>
                        <td class="px-4 py-2 border">Great service!</td>
                        <td class="px-4 py-2 border">
                            @include('components.business.reviews.response-modal-review')
                        </td>
                    </tr>
                    <!-- Hardcoded Review - Unanswered -->
                    <tr class="review-row" data-status="unanswered">
                        <td class="px-4 py-2 border">Jane Doe</td>
                        <td class="px-4 py-2 border">4 ★</td>
                        <td class="px-4 py-2 border">Good experience, but can improve.</td>
                        <td class="px-4 py-2 border">
                            @include('components.business.reviews.response-modal-review')
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterReviews(status) {
            // Get all review rows
            const rows = document.querySelectorAll('.review-row');
            rows.forEach(row => {
                // Show or hide rows based on the status
                if (row.dataset.status === status || status === 'all') {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Default to showing all reviews
        filterReviews('all');
    </script>
</x-business-layout>
