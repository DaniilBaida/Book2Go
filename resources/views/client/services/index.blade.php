<x-client-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Service actions -->
        <h1 class="text-3xl text-gray-800 font-bold">Services</h1>
        <div class="md:flex justify-between items-center">
            <!-- Search Bar -->
            <form id="search-form" method="GET" action="{{ route('client.services') }}" class="max-md:mb-6 flex max-md:flex-col md:items-center max-md:gap-y-2">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        id="table-search-services"
                        value="{{ request('search') }}"
                        class="block w-full ps-10 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search for services"
                    >
                </div>
                <div class="flex gap-2 justify-start">
                    <!-- AJAX Search Button -->
                    <x-button-secondary type="button" class="ajax-search-button md:ml-2 text-blue-600 hover:text-blue-800">Search</x-button-secondary>
                    
                    <!-- Clear Button -->
                    @if(request('search'))
                        <a href="{{ route('client.services') }}" class="ajax-link">
                            <x-danger-button type="button">Clear</x-danger-button>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Filter Dropdown -->
            <x-dropdown align="right" width="auto">
                <x-slot:trigger>
                    <x-button-secondary type="button" class="text-blue-600 hover:text-blue-800">
                        <i class="fa-solid fa-filter text-zinc-600"></i>
                    </x-button-secondary>
                </x-slot:trigger>

                <x-slot:content>
                    <form id="filter-form" method="GET" action="{{ route('client.services') }}" class="p-4">
                        <div class="flex items-center gap-2">
                            <input
                                type="checkbox"
                                id="hide-booked"
                                name="hide_booked"
                                value="1"
                                {{ request('hide_booked') ? 'checked' : '' }}
                                class="form-checkbox h-5 w-5 text-blue-600 rounded-full"
                                onchange="document.getElementById('filter-form').submit()"
                            >
                            <label for="hide-booked" class="text-gray-700 text-sm whitespace-nowrap">Hide Booked Services</label>
                        </div>
                    </form>
                </x-slot:content>
            </x-dropdown>
        </div>

        <!-- Service Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @forelse ($services as $service)
                <x-service-card :service="$service" role="1" />
            @empty
                <p>{{ __('No services found.') }}</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $services->appends(['search' => request('search'), 'hide_booked' => request('hide_booked')])->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</x-client-layout>
