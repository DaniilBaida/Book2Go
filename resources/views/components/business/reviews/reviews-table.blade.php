<div class="flex flex-col">
    <!-- Search Bar -->
    <div class="md:flex justify-between items-center mb-4">
        <!-- Search Bar -->
        <form method="GET" action="{{ route('business.reviews.index') }}" class="max-md:mb-6 flex items-center max-md:gap-y-2 w-full md:w-auto">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    id="table-search-bookings"
                    value="{{ request('search') }}"
                    class="text-sm block w-full ps-10 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 max-sm:flex-1"
                    placeholder="Search for bookings"
                >
            </div>
            <div class="flex gap-2 justify-start mt-0">
                <!-- Search Button -->
                <x-button-secondary type="submit" class="text-sm ml-2 text-blue-600 hover:text-blue-800">
                    Search
                </x-button-secondary>

                <!-- Clear Button -->
                @if(request('search'))
                    <a href="{{ route('business.reviews.index') }}">
                        <x-danger-button type="button" class="text-sm">
                            Clear
                        </x-danger-button>
                    </a>
                @endif
            </div>
        </form>

        <!-- Filter Buttons -->
        <div class="max-sm:flex-col flex sm:items-center gap-2 mt-2 md:mt-0">
            <x-button onclick="filterReviews('answered')" class="text-sm">
                Answered Reviews
            </x-button>
            <x-button-secondary
                onclick="filterReviews('unanswered')" class="text-sm">
                Unanswered Reviews
            </x-button-secondary>
        </div>
    </div>

    <!-- Reviews Table -->
    @props(['reviews'])
    <div class="overflow-x-auto">
        <table class="w-full border-collapse table-auto">
            <thead>
                <tr class="text-gray-500 uppercase text-xs leading-normal border-y h-6">
                    <!-- Reviewer Column -->
                    <th class="p-3 text-left w-1/5">
                        <a href="{{ route('business.reviews.index', ['sort' => 'reviewer', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Reviewer
                            @if(request('sort') === 'reviewer')
                                <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <!-- Rating Column -->
                    <th class="p-3 text-left w-1/7">
                        <a href="{{ route('business.reviews.index', ['sort' => 'rating', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Rating
                            @if(request('sort') === 'rating')
                                <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <!-- Comment Column -->
                    <th class="p-3 text-left w-1/2">
                        <a href="{{ route('business.reviews.index', ['sort' => 'comment', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Comment
                            @if(request('sort') === 'comment')
                                <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </a>
                    </th>
                    <!-- Actions Column -->
                    <th class="p-3 text-right w-[150px]">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-light">
                @foreach($reviews as $review)
                    <tr class="border-b border-gray-100 hover:bg-gray-100 review-row" data-status="{{ $review['status'] ?? 'answered' }}">
                        <td class="p-3 font-bold flex items-center gap-3">
                            <!-- VIEW USER PROFILE -->
                            <a href="{{ route('business.users.show', $review->user->id) }}">
                                <button class="bg-blue-400/20 hover:bg-blue-400/40 duration-300 rounded-full p-2 flex items-center justify-center">
                                    <i class="fa-solid fa-eye text-blue-800"></i>
                                </button>
                            </a>
                            {{ $review->user->first_name. " ". $review->user->last_name}}
                        </td>
                        <td class="p-3">{{ $review['rating'] }} ★</td>
                        <td class="p-3">{{ $review['comment'] }}</td>
                        <td class="p-3 flex justify-end gap-2">
                            <!-- Conditional Actions -->
                            @if($review['status'] === 'unanswered')
                                <!-- Response Modal for Unanswered Reviews -->
                                <x-business.reviews.response-modal-review />
                            @elseif($review['status'] === 'answered')
                                <!-- View Reply Button for Answered Reviews -->
                                <x-business.reviews.view-modal-review />
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
            if (row.dataset.status === status || status === 'all') {
                row.style.display = ''; // Show row
            } else {
                row.style.display = 'none'; // Hide row
            }
        });
    }

    function replyToReview(reviewer) {
        alert(`Replying to ${reviewer}`);
        // Add logic to open reply modal or perform action
    }

    // Default to showing all reviews
    filterReviews('answered');
</script>
