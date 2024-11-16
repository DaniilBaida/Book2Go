<x-client-layout>
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
                    <label for="date" class="block text-gray-700">{{ __('Booking Date') }}</label>
                    <input
                        type="date"
                        id="date"
                        name="date"
                        class="block mt-1 w-full"
                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                        max="{{ \Carbon\Carbon::now()->addDays(60)->format('Y-m-d') }}"
                        required>
                    @error('date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Available Slots -->
                <div class="mb-4">
                    <label for="available_slots" class="block text-gray-700">{{ __('Available Slots') }}</label>
                    <div id="available_slots" class="flex flex-wrap gap-2">
                        <!-- Buttons for available slots will be injected here -->
                    </div>
                    <input type="hidden" id="selected_slot" name="start_time" required>
                    @error('start_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Book Now') }}
                </button>
            </form>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('client.services') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ajax-link">
                {{ __('Back to Services') }}
            </a>
        </div>
    </div>

    <script>
        document.getElementById('date').addEventListener('change', function() {
            const date = this.value;
            const serviceId = {{ $service->id }};
            const slotsContainer = document.getElementById('available_slots');
            const selectedSlotInput = document.getElementById('selected_slot');

            slotsContainer.innerHTML = '';
            selectedSlotInput.value = '';

            if (!date) {
                slotsContainer.innerHTML = '<p class="text-gray-500 mt-2">Please select a date to view available slots.</p>';
                return;
            }

            fetch(`/client/services/${serviceId}/available-slots?date=${date}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Invalid date for booking or server error.');
                    }
                    return response.json();
                })
                .then(slots => {
                    console.log('Slots fetched:', slots); // Debugging
                    if (!Array.isArray(slots)) {
                        throw new Error('Slots data is not an array.');
                    }

                    if (slots.length === 0) {
                        slotsContainer.innerHTML = '<p class="text-gray-500 mt-2">No slots available for the selected date.</p>';
                    } else {
                        slots.forEach(slot => {
                            const button = document.createElement('button');
                            button.type = 'button';
                            button.textContent = slot;
                            button.className = 'text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2';

                            button.addEventListener('click', () => {
                                document.querySelectorAll('#available_slots button').forEach(btn => btn.classList.remove('bg-green-700', 'text-white'));
                                button.classList.add('bg-green-700', 'text-white');
                                selectedSlotInput.value = slot;
                            });

                            slotsContainer.appendChild(button);
                        });
                    }
                })
                .catch(error => {
                    slotsContainer.innerHTML = `<p class="text-red-500 mt-2">${error.message}</p>`;
                });
        });

        // Trigger initial empty state to show default message if no date is selected
        document.getElementById('date').dispatchEvent(new Event('change'));

    </script>

</x-client-layout>

