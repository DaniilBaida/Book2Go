<div class="flex flex-col">
    <!-- Booking Actions -->
    <div class="md:flex justify-between items-center mb-4">
        <!-- Search Bar -->
        <form method="GET" action="{{ route($role . '.bookings') }}" class="max-md:mb-6 flex items-center max-md:gap-y-2 w-full md:w-auto">
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
                    <a href="{{ route($role . '.bookings') }}">
                        <x-danger-button type="button" class="text-sm">
                            Clear
                        </x-danger-button>
                    </a>
                @endif
            </div>
        </form>

        <!-- Action Buttons: Only for Business Role -->
        @if($role === 'business')
            <form id="bulk-update-form" method="POST" action="{{ route('business.bookings.bulk') }}">
                @csrf
                <input type="hidden" name="action" id="bulk-update-action">
                <!-- Selected bookings will be appended here dynamically -->
                <div id="selected-bookings"></div>

                <div class="max-sm:flex-col flex sm:items-center gap-2 mt-2 md:mt-0">
                    <!-- Approve Selected Button -->
                    <x-button id="approve-button" type="button" class="text-sm bg-green-500 hover:bg-green-400 disabled:opacity-50 disabled:pointer-events-none"
                            disabled onclick="submitBulkUpdate('accept')">
                        <i class="fa-solid fa-check mr-2"></i>
                        Approve Selected
                    </x-button>
                    <!-- Deny Selected Button -->
                    <x-danger-button id="deny-button" type="button" class="text-sm disabled:opacity-50 disabled:pointer-events-none"
                                    disabled onclick="openDenyModal()">
                        <i class="fa-solid fa-x text-sm mr-2"></i>
                        Deny Selected
                    </x-danger-button>
                </div>
            </form>
        @endif

        <!-- Bulk Deny Modal -->
        @if($role === 'business')
            <x-modal name="bulk-deny-modal" maxWidth="md" type="deletion" x-on:open-modal.window="if ($event.detail === 'bulk-deny-modal') $dispatch('open-modal', 'bulk-deny-modal')">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Deny Selected Bookings</h2>
                    <p class="text-gray-600 mt-2">
                        Are you sure you want to deny the selected bookings? You can later approve them if needed.
                    </p>
                    <div class="flex justify-end gap-2 mt-4">
                        <!-- Close Modal -->
                        <x-button-secondary x-on:click="$dispatch('close-modal', 'bulk-deny-modal')">
                            No, Go Back
                        </x-button-secondary>
                        <!-- Submit Deny Form -->
                        <x-danger-button type="button" onclick="submitBulkUpdate('deny')">
                            Yes, Deny Bookings
                        </x-danger-button>
                    </div>
                </div>
            </x-modal>
        @endif
    </div>    
    @if($bookings->isEmpty())
        <p class="text-gray-600 mt-6">
            {{ $role === 'client' ? 'You have no bookings at the moment.' : 'No bookings available.' }}
        </p>
    @else
        <!-- Table -->
        <div class="flex-grow overflow-y-auto">
            <table class="w-full border-collapse table-auto">
                <thead>
                    <tr class="text-gray-500 uppercase text-xs leading-normal border-y h-6">
                        @if($role === 'business')
                            <!-- Checkbox Column for Business -->
                            <th class="p-3 text-left w-1/15">
                                <input
                                    type="checkbox"
                                    id="select-all"
                                    class="form-checkbox text-blue-600 rounded-md ring-0 ring-transparent"
                                >
                            </th>
                            <!-- User Column for Business -->
                            <th class="p-3 text-left w-1/5">
                                <a href="{{ route('business.bookings', ['sort' => 'user', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                    User
                                    @if(request('sort') === 'user')
                                        <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                        @endif
                        <!-- Shared Columns -->
                        <th class="p-3 text-left w-1/5">
                            <a href="{{ route($role . '.bookings', ['sort' => 'service', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Service
                                @if(request('sort') === 'service')
                                    <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th class="p-3 text-left w-1/7">
                            <a href="{{ route($role . '.bookings', ['sort' => 'date', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Date
                                @if(request('sort') === 'date')
                                    <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th class="p-3 text-left w-1/7">
                            <a href="{{ route($role . '.bookings', ['sort' => 'start_time', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Time
                                @if(request('sort') === 'start_time')
                                    <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th class="p-3 text-left w-1/7">
                            <a href="{{ route($role . '.bookings', ['sort' => 'status', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                                Status
                                @if(request('sort') === 'status')
                                    <i class="fa-solid fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th class="p-3 text-right w-[100px]">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-light">
                    @foreach($bookings as $booking)
                        <tr class="border-b border-gray-100 hover:bg-gray-100">
                            @if($role === 'business')
                                <!-- Checkbox Column for Business -->
                                <td class="p-3">
                                    <input
                                        type="checkbox"
                                        name="bookings[]"
                                        value="{{ $booking->id }}"
                                        class="form-checkbox h-4 w-4 text-blue-500 booking-checkbox rounded-md"
                                        {{ $booking->status === 'completed' ? 'disabled' : '' }}
                                    >
                                </td>
                                <!-- User Column for Business -->
                                <td class="p-3 font-bold flex items-center gap-3">
                                    <!-- VIEW USER PROFILE -->
                                    <a href="{{ route('business.users.show', $booking->user->id) }}">
                                        <button class="bg-blue-400/20 hover:bg-blue-400/40 duration-300 rounded-full p-2 flex items-center justify-center">
                                            <i class="fa-solid fa-eye text-blue-800"></i>
                                        </button>
                                    </a>
                                    <span class="ml-2">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</span>
                                </td>
                            @endif
                            <!-- Shared Columns -->
                            <td class="p-3 font-bold">
                                @if($role === 'client')
                                <div class="flex gap-3">
                                    <!-- VIEW BOOKING -->
                                    <a href="{{ route($role . '.bookings.show', $booking) }}">
                                        <button class="bg-blue-400/20 hover:bg-blue-400/40 duration-300 rounded-full p-2 flex items-center justify-center">
                                            <i class="fa-solid fa-eye text-blue-800"></i>
                                        </button>
                                    </a>
                                    <span class="flex items-center">{{ $booking->service->name }}</span>
                                @endif
                                @if($role === 'business')
                                    <span class="flex items-center">{{ $booking->service->name }}</span>
                                @endif
                            </td>
                            <td class="p-3">{{ $booking->date->format('d M Y') }}</td>
                            <td class="p-3">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 text-[12px] font-normal rounded-full
                                    {{ $booking->status === 'accepted' ? 'bg-green-500/20 text-green-500' : 
                                    ($booking->status === 'pending' ? 'bg-zinc-500/20 text-zinc-500' : 
                                    ($booking->status === 'denied' ? 'bg-red-500/20 text-red-500' : 
                                    ($booking->status === 'completed' ? 'bg-yellow-500/20 text-yellow-500' : ''))) }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="p-3 flex justify-end gap-2">
                                <!-- CLIENT -->
                                @if($role === 'client')
                                    @include('client.bookings.partials.client-booking-actions', ['booking' => $booking])
                                @elseif($role === 'business')
                                    @include('business.bookings.partials.business-booking-actions', ['booking' => $booking])
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($bookings->hasPages())
            <div class="mt-6">
                {{ $bookings->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    @endif
</div>

<!-- Bulk Update JavaScript -->
<script>
    const checkboxes = document.querySelectorAll('.booking-checkbox');
    const approveButton = document.getElementById('approve-button');
    const denyButton = document.getElementById('deny-button');

    // Monitor checkbox state
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', toggleBulkButtons);
    });

    // Select All toggle
    document.getElementById('select-all').addEventListener('change', function () {
        const selectAllState = this.checked; // Get the state of the "Select All" checkbox
        checkboxes.forEach(checkbox => {
            if (!checkbox.disabled) { // Skip disabled checkboxes
                checkbox.checked = selectAllState;
            }
        });
        toggleBulkButtons(); // Update button states after selection
    });

    function toggleBulkButtons() {
        // Check if there are any enabled and checked checkboxes
        const anyChecked = [...checkboxes].some(checkbox => checkbox.checked && !checkbox.disabled);
        
        // Disable buttons if no valid checkboxes are selected
        approveButton.disabled = !anyChecked;
        denyButton.disabled = !anyChecked;
    }

    function submitBulkUpdate(action) {
        const selectedBookings = document.querySelectorAll('.booking-checkbox:checked');
        const selectedContainer = document.getElementById('selected-bookings');
        selectedContainer.innerHTML = ''; // Clear previous selections

        if (selectedBookings.length === 0) {
            alert('Please select at least one booking.');
            return;
        }

        // Append selected bookings to the form
        selectedBookings.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'bookings[]';
            input.value = checkbox.value;
            selectedContainer.appendChild(input);
        });

        // Set action type (accept/deny)
        document.getElementById('bulk-update-action').value = action;

        // Submit the form
        document.getElementById('bulk-update-form').submit();
    }

    // Deny Modal
    function openDenyModal() {
        const selectedBookings = document.querySelectorAll('.booking-checkbox:checked');

        if (selectedBookings.length === 0) {
            alert('Please select at least one booking to deny.');
            return;
        }

        // Open the modal by dispatching the correct event
        window.dispatchEvent(new CustomEvent('open-modal', { detail: 'bulk-deny-modal' }));
    }
</script>
