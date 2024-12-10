<x-client-layout>
    <div class="flex flex-col gap-y-5">
        <h1 class="text-3xl text-gray-800 font-bold">Booking Details</h1>
        <div class="bg-white shadow-md rounded-lg p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Right Column: Service Image (comes first on mobile) -->
            <div class="flex items-center justify-center order-1 sm:order-2">
                @if($booking->service->image_path)
                    <img
                        src="{{ asset($booking->service->image_path) }}"
                        alt="{{ $booking->service->name }}"
                        class="w-full max-w-md h-auto rounded-lg object-contain"
                    />
                @else
                    <p class="text-gray-500 text-center">No image available for this service.</p>
                @endif
            </div>

            <!-- Left Column: Booking Information -->
            <div class="flex flex-col gap-y-5 order-2 sm:order-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Service Information -->
                    <div class="sm:col-span-2">
                        <h3 class="text-xl font-semibold text-gray-800">Service Information</h3>
                    </div>
                    <div>
                        <p class="text-gray-600"><strong>Service:</strong></p>
                        <p class="text-gray-800">{{ $booking->service->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><strong>Price:</strong></p>
                        <p class="text-gray-800">€{{ number_format($booking->service->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><strong>Date:</strong></p>
                        <p class="text-gray-800">{{ $booking->date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><strong>Time:</strong></p>
                        <p class="text-gray-800">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</p>
                    </div>

                    <!-- Business Information -->
                    <div class="sm:col-span-2 mt-6">
                        <h3 class="text-xl font-semibold text-gray-800">Business Information</h3>
                    </div>
                    <!-- Business Name -->
                    <div>
                        <p class="text-gray-600"><strong>Business Name:</strong></p>
                        <p class="text-gray-800">{{ $booking->service->business->name }}</p>
                    </div>
                    <!-- Business Email -->
                    <div>
                        <p class="text-gray-600"><strong>Contact Email:</strong></p>
                        <p class="text-gray-800">{{ $booking->service->business->email }}</p>
                    </div>
                    <!-- Business Phone -->
                    <div>
                        <p class="text-gray-600"><strong>Phone:</strong></p>
                        <p class="text-gray-800">{{ $booking->service->business->phone_number ?? 'Not provided' }}</p>
                    </div>
                    <!-- Booking Status -->
                    <div>
                        <p class="text-gray-600"><strong>Status:</strong></p>
                        <span class="px-2 py-1 rounded-full text-white text-xs {{ $booking->status === 'accepted' ? 'bg-green-500' : ($booking->status === 'canceled' ? 'bg-red-500' : ($booking->status === 'paid' ? 'bg-pink-500' : 'bg-yellow-500')) }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    <!-- Business Address -->
                    <div class="sm:col-span-2">
                        <p class="text-gray-800">
                            <p><strong>Adress: </strong>{{ $booking->service->business->address }}</p>
                            <p><strong>City: </strong>{{ $booking->service->business->city }}</p>
                            <p><strong>Country: </strong>{{ $booking->service->business->country }}</p>
                            <p><strong>Postal Code: </strong>{{ $booking->service->business->postal_code }}</p>
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-3 flex space-x-3">
                    <!-- Back -->
                    <a href="{{ url()->previous() }}">
                        <x-button class="text-sm">Back</x-button>
                    </a>
                    <!-- Cancel Booking -->
                    @if($booking->status === 'pending')
                        <!-- Cancel Button with Confirmation Modal -->
                        <div x-data="{ open: false }" class="ml-auto">
                            <!-- Trigger Button -->
                            <x-danger-button
                                class="flex-1 w-full justify-center text-sm"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-cancel-booking')">
                                Cancel Booking
                            </x-danger-button>

                            <!-- Confirmation Modal -->
                            <x-modal name="confirm-cancel-booking" :show="$errors->bookingCancellation->isNotEmpty()" maxWidth="md">
                                <div>
                                    <h2 class="text-xl font-medium text-black">
                                        {{ __('Cancel Booking?') }}
                                    </h2>

                                    <p class="mt-2 text-sm text-gray-600">
                                        {{ __('Are you sure you want to cancel this booking? This action cannot be undone.') }}
                                    </p>

                                    <div class="mt-6 flex justify-end">
                                        <!-- Cancel Modal Button -->
                                        <x-button-secondary
                                            x-on:click="$dispatch('close-modal', 'confirm-cancel-booking')"
                                            class="text-sm">
                                            {{ __('No, Go Back') }}
                                        </x-button-secondary>

                                        <!-- Confirm Cancellation Form -->
                                        <form method="POST" action="{{ route('client.bookings.cancel', $booking) }}" class="inline text-sm ms-3">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button type="submit">
                                                {{ __('Yes, Cancel it') }}
                                            </x-danger-button>
                                        </form>
                                    </div>
                                </div>
                            </x-modal>
                        </div>
                    @endif

                    <!-- Pay Button -->
                    @if($booking->status === 'accepted')
                        <a href="{{ route('client.checkout', $booking) }}">
                            <x-button class="text-sm bg-blue-500 hover:bg-blue-600 px-4 py-2 duration-300">
                                <i class="fa-solid fa-credit-card mr-2"></i> Proceed to Checkout
                            </x-button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-client-layout>
