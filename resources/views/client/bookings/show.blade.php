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
                        class="w-full max-w-md h-auto object-contain rounded-lg"
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
                    <div>
                        <p class="text-gray-600"><strong>Business Name:</strong></p>
                        <p class="text-gray-800">{{ $booking->service->business->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><strong>Contact Email:</strong></p>
                        <p class="text-gray-800">{{ $booking->service->business->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><strong>Phone:</strong></p>
                        <p class="text-gray-800">{{ $booking->service->business->phone_number ?? 'Not provided' }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-gray-600"><strong>Address:</strong></p>
                        <p class="text-gray-800">
                            {{ $booking->service->business->address }},
                            {{ $booking->service->business->city }},
                            {{ $booking->service->business->country }} -
                            {{ $booking->service->business->postal_code }}
                        </p>
                    </div>

                    <!-- Booking Status -->
                    <div class="sm:col-span-2">
                        <p class="text-gray-600"><strong>Status:</strong></p>
                        <span class="px-2 py-1 rounded-full text-white {{ $booking->status === 'accepted' ? 'bg-green-500' : ($booking->status === 'denied' ? 'bg-red-500' : 'bg-yellow-500') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('client.bookings') }}">
                        <x-button>Back to Bookings</x-button>
                    </a>
                    @if($booking->status === 'pending')
                        <form action="{{ route('client.bookings.cancel', $booking) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Cancel Booking
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-client-layout>
