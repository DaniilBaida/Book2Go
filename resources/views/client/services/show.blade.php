<x-client-layout>
    <div class="bg-white shadow-md rounded-lg p-6">
        <!-- Service Header -->
        <div class="flex items-center space-x-4">
            @if($service->image_path)
                <img src="{{ asset($service->image_path) }}" alt="{{ $service->name }}" class="w-24 h-24 rounded">
            @endif
            <div>
                <h3 class="text-2xl font-bold">{{ $service->name }}</h3>
                <p class="text-gray-800 font-bold">€{{ number_format($service->price, 2) }}</p>
                <p class="text-gray-600">{{ $service->category->name }}</p>
            </div>
        </div>

        <!-- Service Description -->
        <div class="mt-4">
            <h4 class="text-lg font-semibold">{{ __('Description') }}</h4>
            <p class="mt-2 text-gray-600">{{ $service->description }}</p>
        </div>

        <!-- Booking Section -->
        <div class="mt-6">
            @if($existingBooking)
                <!-- Existing Booking Message -->
                <div class="p-4 bg-green-100 text-green-800 rounded">
                    <p>{{ __('You have already booked this service for :date at :time.', ['date' => $existingBooking->date->format('d M Y'), 'time' => $existingBooking->start_time->format('H:i')]) }}</p>
                    <a href="{{ route('client.bookings.show', $existingBooking) }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('View Booking') }}
                    </a>
                </div>
            @else
                <!-- Booking Form -->
                <form method="POST" action="{{ route('client.bookings.store', $service) }}" class="space-y-4">
                    @csrf
                    <!-- Date Picker -->
                    <div>
                        <label for="date" class="block text-gray-700">{{ __('Booking Date') }}</label>
                        <input
                            type="text"
                            id="date"
                            name="date"
                            class="block mt-1 w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                            required>
                        @error('date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Available Slots -->
                    <div>
                        <label for="available_slots" class="block text-gray-700">{{ __('Available Slots') }}</label>
                        <div id="available_slots" class="flex flex-wrap gap-2 mt-2"></div>
                        <input type="hidden" id="selected_slot" name="start_time" required>
                        @error('start_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        {{ __('Book Now') }}
                    </button>
                </form>
            @endif
        </div>

        <!-- Reviews Section -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-800">Reviews</h3>

            @php
                // Filter reviews specifically for the service (from clients)
                $serviceReviews = $service->reviews->where('review_type', 'service');
            @endphp

            @if($serviceReviews->isEmpty())
                <p class="text-gray-600 mt-4">No reviews available for this service yet.</p>
            @else
                <div class="space-y-4 mt-4">
                    @foreach($serviceReviews as $review)
                        <div class="bg-gray-100 p-4 rounded">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-semibold text-gray-800">
                                        {{ $review->reviewer->first_name }} {{ $review->reviewer->last_name }}
                                    </h4>
                                    <p class="text-sm text-gray-600">{{ $review->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="text-yellow-500">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="mt-2 text-gray-700">{{ $review->comment ?? 'No comment provided.' }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('client.services') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Back to Services') }}
            </a>
        </div>
    </div>

    <!-- Script Section -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dateInput = document.getElementById('date');
            const slotsContainer = document.getElementById('available_slots');
            const selectedSlotInput = document.getElementById('selected_slot');

            // Function to fetch and display available slots
            function fetchAvailableSlots(date) {
                slotsContainer.innerHTML = ''; // Clear existing slots
                selectedSlotInput.value = ''; // Reset selected slot

                if (!date) {
                    slotsContainer.innerHTML = '<p class="text-gray-500 mt-2">Please select a date to view available slots.</p>';
                    return;
                }

                // Fetch available slots from the server
                fetch(`/client/services/{{ $service->id }}/available-slots?date=${date}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch available slots');
                        }
                        return response.json();
                    })
                    .then(slots => {
                        if (slots.length === 0) {
                            slotsContainer.innerHTML = '<p class="text-gray-500 mt-2">No slots available for the selected date.</p>';
                        } else {
                            // Render available slots
                            slots.forEach(slot => {
                                const button = document.createElement('button');
                                button.type = 'button';
                                button.textContent = slot; // Display the slot time
                                button.className = 'text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2';

                                // Add click event to select the slot
                                button.addEventListener('click', () => {
                                    document.querySelectorAll('#available_slots button').forEach(btn => btn.classList.remove('bg-green-700', 'text-white'));
                                    button.classList.add('bg-green-700', 'text-white');
                                    selectedSlotInput.value = slot; // Set the selected slot value
                                });

                                slotsContainer.appendChild(button); // Append button to the container
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching slots:', error);
                        slotsContainer.innerHTML = '<p class="text-red-500 mt-2">Failed to load available slots.</p>';
                    });
            }

            // Initialize Flatpickr for date selection
            function initializeFlatpickr() {
                const availableDays = @json($service->available_days);

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

                flatpickr("#date", {
                    dateFormat: "Y-m-d",
                    disable: [date => !enabledDays.includes(date.getDay())],
                    locale: { firstDayOfWeek: 1 },
                    minDate: "today",
                    maxDate: new Date().fp_incr(60), // Allow bookings up to 60 days in advance
                    onChange: function (selectedDates, dateStr) {
                        fetchAvailableSlots(dateStr); // Fetch slots when the date changes
                    }
                });
            }

            // Initialize the booking form
            initializeFlatpickr();

            // Fetch slots for the pre-selected date if any
            if (dateInput.value) {
                fetchAvailableSlots(dateInput.value);
            }
        });
    </script>

</x-client-layout>
