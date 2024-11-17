<x-client-layout>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Booking Details</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Service Information -->
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
            <div class="sm:col-span-2 mt-6">
                <p class="text-gray-600"><strong>Status:</strong></p>
                <span class="px-2 py-1 rounded text-white {{ $booking->status === 'accepted' ? 'bg-green-500' : ($booking->status === 'denied' ? 'bg-red-500' : 'bg-yellow-500') }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('client.bookings') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Bookings
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
</x-client-layout>
