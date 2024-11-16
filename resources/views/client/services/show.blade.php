<x-client-layout>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-2xl font-bold">{{ $service->name }}</h3>

        @if($service->image_path)
            <div class="mt-4">
                <img src="{{ asset($service->image_path) }}" alt="{{ $service->name }}" class="w-40 max-w-md mt-2 rounded">
            </div>
        @endif

        <p class="text-gray-800 font-bold mt-4">€{{ number_format($service->price, 2) }}</p>
        <div class="mt-2">
            <strong>{{ __('Category') }}:</strong> <span>{{ $service->category->name }}</span>
        </div>
        <div class="mt-4">
            <strong>{{ __('Description') }}:</strong>
            <p class="mt-2 text-gray-600">{{ $service->description }}</p>
        </div>

        @if($existingBooking)
            <!-- Message and button for users who already booked -->
            <div class="mt-6 p-4 bg-green-100 text-green-800 rounded">
                <p>You have already booked this service for {{ $existingBooking->date->format('d M Y') }} at {{ $existingBooking->start_time->format('H:i') }}.</p>
                <a href="{{ route('client.bookings', $existingBooking) }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    View Booking
                </a>
            </div>
        @else
            <!-- Booking form for users who haven't booked yet -->
            <div class="mt-6">
                <form method="POST" action="{{ route('client.bookings.store', $service) }}">
                    @csrf

                    <div class="mb-4">
                        <label for="date" class="block text-gray-700">{{ __('Booking Date') }}</label>
                        <input
                            type="text"
                            id="date"
                            name="date"
                            class="block mt-1 w-full"
                            required>
                        @error('date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="available_slots" class="block text-gray-700">{{ __('Available Slots') }}</label>
                        <div id="available_slots" class="flex flex-wrap gap-2"></div>
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
        @endif

        <div class="mt-6">
            <a href="{{ route('client.services') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Services') }}
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pass available days from the service model to JavaScript
            const availableDays = @json($service->available_days);

            // Map day names to indices for comparison
            const dayIndices = {
                'Sunday': 0,
                'Monday': 1,
                'Tuesday': 2,
                'Wednesday': 3,
                'Thursday': 4,
                'Friday': 5,
                'Saturday': 6
            };

            const enabledDays = availableDays.map(day => dayIndices[day]);

            // Initialize Flatpickr with working days logic
            flatpickr("#date", {
                dateFormat: "Y-m-d",
                disable: [
                    function (date) {
                        return !enabledDays.includes(date.getDay()); // Disable non-working days
                    }
                ],
                locale: {
                    firstDayOfWeek: 1 // Start the week on Monday
                },
                minDate: "today", // Prevent past dates
                maxDate: new Date().fp_incr(60) // Allow booking within the next 60 days
            });

            document.getElementById('date').addEventListener('change', function () {
                const date = this.value;
                const slotsContainer = document.getElementById('available_slots');
                const selectedSlotInput = document.getElementById('selected_slot');

                // Reset available slots
                slotsContainer.innerHTML = '';
                selectedSlotInput.value = '';

                if (!date) {
                    slotsContainer.innerHTML = '<p class="text-gray-500 mt-2">Please select a date to view available slots.</p>';
                    return;
                }

                // Fetch available slots via API
                fetch(`/client/services/{{ $service->id }}/available-slots?date=${date}`)
                    .then(response => response.json())
                    .then(slots => {
                        if (slots.length === 0) {
                            slotsContainer.innerHTML = '<p class="text-gray-500 mt-2">No slots available for the selected date.</p>';
                        } else {
                            slots.forEach(slot => {
                                const button = document.createElement('button');
                                button.type = 'button';
                                button.textContent = slot;
                                button.className = 'text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2';

                                button.addEventListener('click', () => {
                                    // Highlight the selected slot
                                    document.querySelectorAll('#available_slots button').forEach(btn => btn.classList.remove('bg-green-700', 'text-white'));
                                    button.classList.add('bg-green-700', 'text-white');
                                    selectedSlotInput.value = slot;
                                });

                                slotsContainer.appendChild(button);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching slots:', error);
                        slotsContainer.innerHTML = '<p class="text-red-500 mt-2">Failed to load available slots.</p>';
                    });
            });

            // Trigger initial event for empty state
            document.getElementById('date').dispatchEvent(new Event('change'));
        });
    </script>

</x-client-layout>

