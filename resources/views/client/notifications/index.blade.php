<x-client-layout>
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Notifications</h2>

        @if($notifications->isEmpty())
            <p class="text-gray-600">You have no notifications.</p>
        @else
            <div class="space-y-4">
                @foreach($notifications as $notification)
                    <div class="p-4 bg-gray-100 rounded flex justify-between items-center">
                        <div>
                            <p class="text-gray-800 font-semibold">
                                {{ $notification->data['message'] ?? 'You have a new notification.' }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <!-- Conditional buttons based on notification type for CLIENT only -->
                        @if($notification->data['type'] === 'review_request' && isset($notification->data['booking_id']))
                            <a href="{{ route('client.reviews.create', $notification->data['booking_id']) }}"
                               class="text-blue-500 hover:underline">
                                Leave a Review
                            </a>
                        @elseif($notification->data['type'] === 'booking_update' && isset($notification->data['booking_id']))
                            <a href="{{ route('client.bookings.show', $notification->data['booking_id']) }}"
                               class="text-blue-500 hover:underline">
                                View Booking
                            </a>
                        @else
                            <p class="text-gray-500 text-sm">
                                No action available.
                            </p>
                        @endif

                        <!-- Mark as read button -->
                        @if(!$notification->read_at)
                            <form action="{{ route('client.notifications.markAsRead', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700 text-sm">
                                    Mark as Read
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Mark all as read button -->
        @if($notifications->whereNull('read_at')->count() > 0)
            <form action="{{ route('client.notifications.markAllAsRead') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Mark All as Read
                </button>
            </form>
        @endif
    </div>
</x-client-layout>
