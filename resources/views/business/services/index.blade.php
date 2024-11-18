<x-business-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Page Header -->
        <h1 class="text-3xl text-gray-800 font-bold">Your Services</h1>

        <!-- Service Actions -->
        <div class="md:flex justify-between items-center">
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
                        class="block w-full ps-10 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search for services"
                    >
                </div>
                <div class="flex gap-2 justify-start">
                    <x-button-secondary type="submit" class="md:ml-2 text-blue-600 hover:text-blue-800">Search</x-button-secondary>
                    @if(request('search'))
                        <a href="{{ route('business.services.index') }}">
                            <x-danger-button type="button">Clear</x-danger-button>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Create Service Button -->
            <a href="{{ route('business.services.create') }}">
                <x-button>{{ __('Add Service') }}</x-button>
            </a>
        </div>

        <!-- Service Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @forelse ($services as $service)
                <x-service-card :service="$service" :role="$role" />
            @empty
                <p>{{ __('No services found.') }}</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $services->appends(['search' => request('search')])->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <!-- Toast Notifications -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if (session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 5000, // Display for 5 seconds
                    close: true,
                    gravity: "bottom", // Display at the top
                    position: "right", // Align to the right
                    backgroundColor: "#4caf50", // Green for success
                    stopOnFocus: true // Pause on hover
                }).showToast();
            @endif

            @if (session('error'))
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 5000, // Display for 5 seconds
                    close: true,
                    gravity: "bottom", // Display at the top
                    position: "right", // Align to the right
                    backgroundColor: "#f44336", // Red for error
                    stopOnFocus: true // Pause on hover
                }).showToast();
            @endif
        });
    </script>
</x-business-layout>
