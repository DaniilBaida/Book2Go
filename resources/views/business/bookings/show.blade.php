<x-business-layout>
    <div class="space-y-5">
        <div class="p-6 bg-white shadow-sm sm:rounded-lg">
            <h1 class="text-3xl text-gray-800 font-bold mb-5">{{ $booking->user->first_name }} {{ $booking->user->last_name }}'s Booking Details</h1>
            <!-- User Details -->
            <div class="flex max-sm:flex-col space-x-4">
                @if($booking->user->image_path)
                    <!-- Display client profile picture -->
                    <img src="{{ asset($booking->user->image_path) }}" class="w-24 h-24 rounded-full border-1 border border-zinc-200">
                @else
                    <!-- Placeholder image if no service image is provided -->
                    <img src="{{ asset('images/placeholder.png') }}" alt="No Image" class="w-24 h-24 rounded-full bg-zinc-500 flex justify-center text-center">
                @endif
                <div class="my-auto flex flex-col">
                    <h3 class="text-2xl font-bold">{{ $booking->user->first_name }} {{ $booking->user->last_name }}</h3>
                    <p class="text-gray-800 font-bold">{{ $booking->user->email }}</p>
                    <p class="text-gray-600">{{ $booking->user->phone_number ?? 'Not provided' }}</p>
                </div>
            </div>

            <!-- Alertas -->
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

            <!-- Ações Condicionais -->
            <div class="flex flex-col mt-4 border-t pt-4">
                <h1 class="text-2xl text-gray-800 font-bold mb-3">Actions</h1>
                <div class="flex gap-x-4">
                    @if($booking->status === 'pending')
                        <form action="{{ route('business.bookings.accept', $booking) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <x-button type="submit" class="bg-green-500 hover:bg-green-700 text-white">
                                Accept Booking
                            </x-button>
                        </form>
                        <form action="{{ route('business.bookings.deny', $booking) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <x-button type="submit" class="bg-red-500 hover:bg-red-700 text-white">
                                Deny Booking
                            </x-button>
                        </form>
                    @elseif($booking->status === 'paid')
                        <form action="{{ route('business.bookings.complete', $booking) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <x-button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white">
                                Mark as Completed
                            </x-button>
                        </form>
                    @elseif($booking->status === 'completed' && !$booking->reviews->where('type', 'client')->count())
                        <a href="{{ route('business.reviews.create', $booking) }}">
                            <x-button>Leave a Review for Client</x-button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Informações do Booking -->
            <h1 class="text-3xl text-gray-800 font-bold mb-5">Service</h1>
            <!-- Service Details -->
            <div class="flex max-sm:flex-col space-x-4">
                @if($booking->service->image_path)
                    <!-- Display service image -->
                    <img src="{{ asset($booking->service->image_path) }}" alt="{{ $booking->service->name }}" class="w-24 h-24 rounded-full border-1 border border-zinc-200">
                @else
                    <!-- Placeholder image if no service image is provided -->
                    <img src="{{ asset('images/placeholder.png') }}" alt="No Image" class="w-24 h-24 rounded-full bg-zinc-500 flex justify-center text-center">
                @endif
                <div>
                    <h3 class="text-2xl font-bold">{{ $booking->service->name }}</h3>
                    <p class="text-gray-800 font-bold">€{{ number_format($booking->service->price, 2) }}</p>
                    <p class="text-gray-600">{{ $booking->service->category->name }}</p>
                </div>
            </div>
            <div class="flex flex-col space-y-2 mt-5">
                <div class="flex gap-2">
                    <h1 class="font-bold">Date:</h1>
                    <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</p>
                </div>
                <div class="flex gap-2">
                    <h1 class="font-bold">Time:</h1>
                    <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                </div>
                <div class="flex gap-2">
                    <h1 class="font-bold">Notes:</h1>
                    <p class="text-gray-800">{{ $booking->notes ?? 'No additional notes provided.' }}</p>
                </div>
                <div class="flex gap-2 border-t pt-3">
                    <h1 class="font-bold">Status:</h1>
                    <p class="px-2 py-1 rounded-full text-white text-xs {{ $booking->status === 'accepted' ? 'bg-green-500' : ($booking->status === 'canceled' ? 'bg-red-500' : ($booking->status === 'paid' ? 'bg-pink-500' : 'bg-yellow-500')) }}">
                        {{ ucfirst($booking->status) }}</p>
                </div>
            </div>
        </div>
        <!-- Botão para voltar -->
        <div class="mt-4">
            <a href="{{ route('business.bookings') }}" >          
                <x-button>Back to Bookings</x-button>
            </a>
        </div>
    </div>
</x-business-layout>
