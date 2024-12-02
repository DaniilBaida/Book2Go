<div class="md:flex justify-between items-center mb-4">
    <!-- Search Bar -->
    <div class="md:flex justify-between items-center mb-4 w-full">
        <form method="GET" action="{{ route('admin.user-verification-requests.index') }}" class="max-md:mb-6 flex items-center max-md:gap-y-2 w-full md:w-auto">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="text-sm block w-full ps-10 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 max-sm:flex-1"
                    placeholder="Search for users"
                />
            </div>
            <div class="flex gap-2 justify-start mt-0">
                <!-- Search Button -->
                <x-button-secondary type="submit" class="text-sm ml-2 text-blue-600 hover:text-blue-800">
                    Search
                </x-button-secondary>
                <!-- Clear Button -->
                @if(request('search'))
                    <a href="{{ route('admin.user-verification-requests.index') }}">
                        <x-danger-button type="button" class="text-sm">
                            Clear
                        </x-danger-button>
                    </a>
                @endif
            </div>
        </form>

        <!-- Filter Buttons -->
        <div class="max-sm:flex-col flex sm:items-center gap-2 mt-2 md:mt-0">
            <x-button onclick="filterRequests('all')" class="text-sm disabled:pointer-events-none">
                All
            </x-button>
            <x-button onclick="filterRequests('approved')" class="text-sm bg-green-500 hover:bg-green-400 disabled:opacity-50 disabled:pointer-events-none">
                <i class="fa-solid fa-check mr-2"></i>
                Approved
            </x-button>
            <button onclick="filterRequests('pending')" class="px-4 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-400 text-sm font-semibold">
                <i class="fa-solid fa-hourglass-start text-sm mr-2"></i>
                Pending
            </button>
            <x-danger-button onclick="filterRequests('rejected')" class="text-sm disabled:opacity-50 disabled:pointer-events-none">
                <i class="fa-solid fa-x text-sm mr-2"></i>
                Rejected
            </x-danger-button>
        </div>
    </div>
</div>

<script>
    function clearSearch() {
        const searchField = document.getElementById('table-search-requests');
        searchField.value = '';
        filterRequests('all'); // Reset table filter
    }

    function filterRequests(status) {
        const rows = document.querySelectorAll('.verification-row');
        rows.forEach((row) => {
            if (status === 'all' || row.dataset.status === status) {
                row.style.display = ''; // Show row
            } else {
                row.style.display = 'none'; // Hide row
            }
        });
    }

    // Default to showing all rows
    filterRequests('all');
</script>

