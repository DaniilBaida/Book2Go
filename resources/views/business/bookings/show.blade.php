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

        <!-- Alerts -->
        @if(session('success'))
            <div class="mt-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mt-4 p-4 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif

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
                    <dd class="text-gray-800">
                        {{ $booking->user->first_name }} {{ $booking->user->last_name }} <br>
                        <strong>Email:</strong> {{ $booking->user->email }} <br>
                        <strong>Phone:</strong> {{ $booking->user->phone_number ?? 'Not provided' }}
                    </dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-600">Status</dt>
                    <dd class="px-2 py-1 rounded text-white {{ $statusClasses[$booking->status] ?? 'bg-gray-500' }}">
                        {{ ucfirst($booking->status) }}
                    </dd>
                </div>
                <div>
                    <dt class="font-medium text-gray-600">Additional Notes</dt>
                    <dd class="text-gray-800">{{ $booking->notes ?? 'No additional notes provided.' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Conditional Actions -->
        <div class="mt-6">
            @if($booking->status === 'pending')
                <div class="flex space-x-4">
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
            @elseif($booking->status === 'accepted')
                <div class="flex space-x-4">
                    <form action="{{ route('business.bookings.complete', $booking) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Mark as Completed
                        </button>
                    </form>
                </div>
            @elseif($booking->status === 'completed' && !$booking->reviews->where('type', 'client')->count())
                <a href="{{ route('business.reviews.create', $booking) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Leave a Review for Client
                </a>
            @endif
        </div>
    </div>
</x-business-layout>
