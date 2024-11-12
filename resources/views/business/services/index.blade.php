<x-business-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Service Management') }}
        </h2>
    </x-slot>

    <div class="py-12 max-sm:px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Bar and Create Button -->
            <div class="md:flex justify-between items-center mb-6">
                <!-- Search Bar -->
                <form method="GET" action="{{ route('business.services.index') }}" class="max-md:mb-6 flex max-md:flex-col md:items-center max-md:gap-y-2">
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
                            class="block w-full ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search for services"
                        >
                    </div>
                    <div class="flex gap-2 justify-start">
                        <x-secondary-button type="submit" class="md:ml-2 text-blue-600 hover:text-blue-800">Search</x-secondary-button>
                        @if(request('search'))
                            <a href="{{ route('business.services.index') }}">
                                <x-danger-button type="button">Clear</x-danger-button>
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Create Service Button -->
                <a href="{{ route('business.services.create') }}">
                    <x-primary-button>{{ __('+ Add New') }}</x-primary-button>
                </a>
            </div>

            <!-- Service Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($services as $service)
                    <x-service-card :service="$service" :role="$role" :tags="$service->tags ?? []" />

                @empty
                    <p>{{ __('No services found.') }}</p>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $services->appends(['search' => request('search')])->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-business-layout>
