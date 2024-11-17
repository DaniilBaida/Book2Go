<x-client-layout>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">My Bookings</h2>

        @if($bookings->isEmpty())
            <p class="text-gray-600">You have no bookings at the moment.</p>
        @else
            <table class="w-full border-collapse">
                <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="p-3 text-left">Service</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Time</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-light">
                @foreach($bookings as $booking)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="p-3">{{ $booking->service->name }}</td>
                        <td class="p-3">{{ $booking->date->format('d M Y') }}</td>
                        <td class="p-3">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</td>
                        <td class="p-3">
                                <span class="px-2 py-1 text-sm font-semibold rounded
                                    {{ $booking->status === 'accepted' ? 'bg-green-500 text-white' : ($booking->status === 'pending' ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                        </td>
                        <td class="p-3">
                            <a href="{{ route('client.bookings.show', $booking) }}" class="text-blue-500 hover:underline">
                                View
                            </a>
                            @if($booking->status === 'pending')
                                <form action="{{ route('client.bookings.cancel', $booking) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-client-layout>
