<x-client-layout>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">My Bookings</h2>

        @if($bookings->isEmpty())
            <p class="text-gray-600">You have no bookings at the moment.</p>
        @else
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-200">
                    <th class="p-3 text-left">Service</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Time</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bookings as $booking)
                    <tr class="border-t">
                        <td class="p-3">{{ $booking->service->name }}</td>
                        <td class="p-3">{{ $booking->date->format('d M Y') }}</td>
                        <td class="p-3">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</td>
                        <td class="p-3">
                                <span class="px-2 py-1 text-sm rounded {{ $booking->date->isPast() ? 'bg-gray-500 text-white' : 'bg-green-500 text-white' }}">
                                    {{ $booking->date->isPast() ? 'Completed' : 'Upcoming' }}
                                </span>
                        </td>
                        <td class="p-3">
                            <a href="{{ route('client.bookings.show', $booking) }}" class="text-blue-500 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-client-layout>
