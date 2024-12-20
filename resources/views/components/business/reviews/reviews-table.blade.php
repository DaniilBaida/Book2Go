<div class="flex flex-col">
    <!-- Search Bar -->
    <div class="md:flex justify-between items-center mb-4">
        <form method="GET" action="{{ route('business.reviews.index') }}" class="max-md:mb-6 flex items-center max-md:gap-y-2 w-full md:w-auto">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    id="table-search-reviews"
                    value="{{ request('search') }}"
                    class="text-sm block w-full ps-10 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search for reviews"
                />
            </div>
            <div class="flex gap-2 justify-start mt-0">
                <!-- Search Button -->
                <x-button-secondary type="submit" class="text-sm ml-2 text-blue-600 hover:text-blue-800">Search</x-button-secondary>
                <!-- Clear Button -->
                @if(request('search'))
                    <a href="{{ route('business.reviews.index') }}">
                        <x-danger-button type="button" class="text-sm">Clear</x-danger-button>
                    </a>
                @endif
            </div>
        </form>
        <!-- Filter Buttons -->
        <div class="flex items-center gap-2 mt-2 md:mt-0">
            <x-button onclick="filterReviews('answered')" class="text-sm">Answered Reviews</x-button>
            <x-button-secondary onclick="filterReviews('unanswered')" class="text-sm">Unanswered Reviews</x-button-secondary>
        </div>
    </div>

    <!-- Reviews Table -->
    @props(['reviews'])
    <div class="overflow-x-auto">
        <table class="w-full border-collapse table-auto">
            <thead>
                <tr class="text-gray-500 uppercase text-xs leading-normal border-y h-6">
                    <th class="p-3 text-left w-1/5">Reviewer</th>
                    <th class="p-3 text-left w-1/7">Rating</th>
                    <th class="p-3 text-left w-1/2">Comment</th>
                    <th class="p-3 text-right w-[200px]">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-light">
                @foreach($reviews as $review)
                    <tr class="border-b border-gray-100 hover:bg-gray-100 review-row" data-status="{{ $review->reply ? 'answered' : 'unanswered' }}"  data-reviewer-type="{{ $review->reviewer_type }}">
                        <td class="p-3 font-bold flex items-center gap-3">
                            <a href="{{ route('business.users.show', $review->user->id) }}" class="text-blue-600 hover:underline">
                                {{ $review->user->first_name . " " . $review->user->last_name }}
                            </a>
                        </td>
                        <td class="p-3">{{ $review->rating }} ★</td>
                        <td class="p-3">{{ $review->comment }}</td>
                        <td class="p-3 flex justify-end gap-2">
                            @if($review->reply)
                                <!-- View Reply Modal -->
                                <x-business.reviews.view-modal-review :review="$review" />
                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('business.replies.destroy', ['reply' => $review->reply->id]) }}" onsubmit="return confirm('Are you sure you want to delete this reply?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>
                                        Delete Reply
                                    </x-danger-button>
                                </form>
                            @else
                                <!-- Reply Modal -->
                                <x-business.reviews.response-modal-review :review="$review" />
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript for Filtering -->
<script>
    function filterReviews(status) {
        const rows = document.querySelectorAll('.review-row');
        rows.forEach(row => {
            const reviewStatus = row.dataset.status; // Get the review's status
            const reviewerType = row.dataset.reviewerType; // Get the reviewer's type

            // Ensure only client reviews are shown
            if ((reviewStatus === status || status === 'all') && reviewerType === 'client') {
                row.style.display = ''; // Show row
            } else {
                row.style.display = 'none'; // Hide row
            }
        });
    }

    // Default to showing unanswered client reviews
    filterReviews('unanswered');
</script>
