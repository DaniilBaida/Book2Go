<x-client-layout>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Booking Details</h2>

        <p><strong>Service:</strong> {{ $booking->service->name }}</p>
        <p><strong>Date:</strong> {{ $booking->date->format('d M Y') }}</p>
        <p><strong>Time:</strong> {{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</p>
        <p><strong>Status:</strong> {{ $booking->date->isPast() ? 'Completed' : 'Upcoming' }}</p>

        <div class="mt-6">
            <a href="{{ route('client.bookings') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Bookings
            </a>
        </div>
    </div>
</x-client-layout>
