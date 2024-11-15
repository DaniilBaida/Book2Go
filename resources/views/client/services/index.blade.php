<x-client-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Services') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Bar -->
            <div class="flex justify-between items-center mb-6">
                <!-- Search Bar -->
                <form method="GET" action="{{ route('client.services') }}" class="mb-6 flex items-center">
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
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search for services"
                        >
                    </div>
                    <button type="submit" class="ml-2 text-blue-600 hover:text-blue-800">Search</button>
                    @if(request('search'))
                        <a href="{{ route('client.services') }}" class="ml-2 text-red-600 hover:text-red-800">Clear</a>
                    @endif
                </form>
            </div>

            <!-- Service Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($services as $service)
                    <x-service-card :service="$service" role="1" />
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
</x-client-layout>
