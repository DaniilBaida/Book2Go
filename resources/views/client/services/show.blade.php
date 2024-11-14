<x-client-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Service Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Service Title -->
                <h3 class="text-2xl font-bold">{{ $service->name }}</h3>

                <!-- Image -->
                @if($service->image_path)
                    <div class="mt-4">
                        <img src="{{ $service->image_path ? asset($service->image_path) : asset('images/default-service.png') }}" alt="{{ $service->name }}" class="w-40 max-w-md mt-2 rounded">
                    </div>
                @endif

                <!-- Service Price -->
                <p class="text-gray-800 font-bold mt-4">€{{ number_format($service->price, 2) }}</p>

                <!-- Category -->
                <div class="mt-2">
                    <strong class="text-gray-700">{{ __('Category') }}:</strong>
                    <span>{{ $service->category->name }}</span>
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <strong class="text-gray-700">{{ __('Description') }}:</strong>
                    <p class="mt-2 text-gray-600">{{ $service->description }}</p>
                </div>

                <!-- Booking Form -->
                <div class="mt-6">
                    <form id="booking-form" method="POST" action="{{ route('client.bookings.store', $service) }}">
                        @csrf

                        <!-- Booking Date -->
                        <div class="mb-4">
                            <label for="booking_date" class="block text-gray-700">{{ __('Booking Date') }}</label>
                            <input type="date" id="booking_date" name="booking_date" class="block mt-1 w-full" required>
                        </div>

                        <!-- Available Slots -->
                        <div class="mb-4">
                            <label for="available_slots" class="block text-gray-700">{{ __('Available Slots') }}</label>
                            <select id="available_slots" name="start_time" class="block mt-1 w-full" required>
                                <option value="">{{ __('Select a time slot') }}</option>
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Book Now') }}
                        </button>
                    </form>
                </div>

                <!-- Back Button -->
                <div class="mt-6">
                    <a href="{{ route('client.services.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Back to Services') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('booking_date').addEventListener('change', function() {
            const date = this.value;
            const serviceId = {{ $service->id }};

            fetch(`/services/${serviceId}/available-slots?date=${date}`)
                .then(response => response.json())
                .then(slots => {
                    const slotSelect = document.getElementById('available_slots');
                    slotSelect.innerHTML = '<option value="">{{ __('Select a time slot') }}</option>';

                    slots.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot;
                        option.textContent = slot;
                        slotSelect.appendChild(option);
                    });
                });
        });
    </script>
</x-client-layout>
