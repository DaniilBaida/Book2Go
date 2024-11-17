<x-business-layout>
    <div class="p-6 bg-white shadow-sm sm:rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-800">Booking Details</h2>

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('business.bookings') }}" class="text-blue-500 hover:underline flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Bookings
            </a>
        </div>

        <!-- Booking Information -->
        <div class="mt-6 border-t pt-4">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <dt class="font-medium text-gray-600">Service</dt>
                    <dd class="text-gray-800">{{ $booking->service->name }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-600">Date</dt>
                    <dd class="text-gray-800">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-600">Time</dt>
                    <dd class="text-gray-800">
                        {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                    </dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-600">Client Details</dt>
                    <dd class="text-gray-800">{{ $booking->user->first_name }} {{ $booking->user->last_name }} | {{ $booking->user->email }}</dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-600">Status</dt>
                    <dd class="px-2 py-1 rounded text-white {{ $booking->status === 'accepted' ? 'bg-green-500' : ($booking->status === 'denied' ? 'bg-red-500' : 'bg-yellow-500') }}">
                        {{ ucfirst($booking->status) }}
                    </dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-600">Additional Notes</dt>
                    <dd class="text-gray-800">{{ $booking->notes ?? 'No additional notes provided.' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Actions for Pending Bookings -->
        @if($booking->status === 'pending')
            <div class="mt-6 flex space-x-4">
                <form action="{{ route('business.bookings.accept', $booking) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Accept Booking
                    </button>
                </form>
                <form action="{{ route('business.bookings.deny', $booking) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Deny Booking
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-business-layout>
