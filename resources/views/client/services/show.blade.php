<x-client-layout>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="space-y-5">
        <!-- Book Service -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-3xl text-gray-800 font-bold mb-5">Booking Service</h1>
            <!-- Service Header -->
            <div class="flex max-sm:flex-col space-x-4">
                @if($service->image_path)
                    <!-- Display service image -->
                    <img src="{{ asset($service->image_path) }}" alt="{{ $service->name }}" class="w-24 h-24 rounded-full object-cover border-1 border border-zinc-200">
                @else
                    <!-- Placeholder image if no service image is provided -->
                    <img src="{{ asset('images/placeholder.png') }}" alt="No Image" class="w-24 h-24 rounded-full bg-zinc-500 flex justify-center text-center">
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
        </div>
        <!-- Book Details -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-3xl text-gray-800 font-bold mb-5">Booking Details</h1>
            <!-- Booking Section -->
            <div class="mt-6">
                @if($existingBooking)
                    <!-- Existing Booking Message -->
                    <div class="p-4 bg-green-100 text-green-800 rounded">
                        <p>{{ __('You have already booked this service for :date at :time.', ['date' => $existingBooking->date->format('d M Y'), 'time' => $existingBooking->start_time->format('H:i')]) }}</p>
                        <a href="{{ route('client.bookings.show', $existingBooking) }}">
                            <x-button class="mt-2">
                                {{ __('View Booking') }}
                            </x-button>
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
                        <x-button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            {{ __('Book Now') }}
                        </x-button>
                    </form>
                @endif
            </div>
        </div>
        <!-- Book Reviews -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-3xl text-gray-800 font-bold mb-5">Booking Reviews</h1>
            <!-- Reviews Section -->
            <div class="mt-8">
                <div class="space-y-4 mt-4">
                    @foreach($serviceReviews as $review)
                        <div class="bg-gray-100 p-4 rounded">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h4 class="font-semibold text-gray-800">
                                        {{ ucfirst($review->reviewer_type) }} <!-- Display reviewer type -->
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

                            <!-- Replies Section -->
                            <div class="mt-4 pl-4 border-l-2 border-gray-300">
                                <h5 class="font-semibold text-gray-700">Replies:</h5>
                                @forelse($review->replies as $reply)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">
                                            {{ $reply->user->name }} replied on {{ $reply->created_at->format('d M Y') }}:
                                        </p>
                                        <p class="text-gray-800">{{ $reply->content }}</p>
                                    </div>
                                @empty
                                    <p class="text-gray-500">No replies yet.</p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('client.services') }}">
                <x-button>
                    {{ __('Back to Services') }}
                </x-button>
            </a>
        </div>
    </div>

    <!-- Script Section -->
    <script>
        $(document).ready(function () {
            // Initialize the booking form when the page is ready
            initializeBookingForm();

            // Listen for changes when content is loaded dynamically
            $(document).on('ajaxComplete', function () {
                // Reinitialize Flatpickr every time new content is loaded via AJAX or other methods
                initializeBookingForm();
            });

            // Or if you're using Turbo (Turbo.js for SPA-style navigation):
            document.addEventListener('turbo:frame-load', function () {
                // Reinitialize Flatpickr when Turbo loads new content
                initializeBookingForm();
            });
        });

        function initializeBookingForm() {
            // Ensure Flatpickr is only initialized once by checking for the instance
            if ($('#date').data('flatpickr')) {
                return;
            }

            // Get available days for the service
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

            // Initialize Flatpickr
            flatpickr("#date", {
                dateFormat: "Y-m-d",
                disable: [date => !enabledDays.includes(date.getDay())],
                locale: { firstDayOfWeek: 1 },
                minDate: "today",
                maxDate: new Date().fp_incr(60)
            });

            $('#date').data('flatpickr', true);

            $('#date').on('change', function () {
                const date = this.value;
                const slotsContainer = document.getElementById('available_slots');
                const selectedSlotInput = document.getElementById('selected_slot');

                slotsContainer.innerHTML = '';
                selectedSlotInput.value = '';

                if (!date) {
                    slotsContainer.innerHTML = '<p class="text-gray-500 mt-2">Please select a date to view available slots.</p>';
                    return;
                }

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

            $('#date').trigger('change');
        }
    </script>
</x-client-layout>
