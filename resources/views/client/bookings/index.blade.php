<x-client-layout>
    <div class="flex flex-col gap-y-5">
        <h1 class="text-3xl text-gray-800 font-bold">My Bookings</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            @if($bookings->isEmpty())
                <p class="text-gray-600">You have no bookings at the moment.</p>
            @else
                <table class="w-full border-collapse table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="p-3 text-left w-1/4">Service</th>
                            <th class="p-3 text-left w-1/5">Date</th>
                            <th class="p-3 text-left w-1/5">Time</th>
                            <th class="p-3 text-left w-1/5">Status</th>
                            <th class="p-3 text-left w-1/5">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm font-light">
                        @foreach($bookings as $booking)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="p-3 font-bold">{{ $booking->service->name }}</td>
                                <td class="p-3">{{ $booking->date->format('d M Y') }}</td>
                                <td class="p-3">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 text-sm font-semibold rounded-full
                                        {{ $booking->status === 'accepted' ? 'bg-green-500 text-white' : ($booking->status === 'pending' ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="p-3 flex justify-end gap-2">
                                    <a href="{{ route('client.bookings.show', $booking) }}" class="text-blue-500">
                                        <x-button-secondary>View</x-button-secondary>
                                    </a>
                                    <!-- Cancel Booking -->
                                    <div x-data="{ showTooltip: false }" class="relative">
                                        @if($booking->status === 'accepted')
                                            <!-- Disabled Cancel Button with Tooltip -->
                                            <x-danger-button 
                                                class="flex-1 w-full justify-center text-sm opacity-50 cursor-not-allowed"
                                                disabled 
                                                @mouseenter="showTooltip = true" 
                                                @mouseleave="showTooltip = false">
                                                Cancel Booking
                                            </x-danger-button>
                                            <!-- Tooltip -->
                                            <div 
                                                x-show="showTooltip" 
                                                x-cloak
                                                x-transition:enter="transition ease-out duration-200" 
                                                x-transition:enter-start="opacity-0 scale-90" 
                                                x-transition:enter-end="opacity-100 scale-100" 
                                                x-transition:leave="transition ease-in duration-150" 
                                                x-transition:leave-start="opacity-100 scale-100" 
                                                x-transition:leave-end="opacity-0 scale-90"
                                                class="absolute top-[-5rem] left-1/2 transform -translate-x-1/2 z-50 whitespace-normal break-words rounded-lg bg-zinc-600 py-1.5 px-3 text-center font-sans text-sm font-normal text-white w-[200px] pointer-events-none">
                                                Booking has already been accepted and cannot be canceled.
                                            </div>
                                        @else
                                            <!-- Active Cancel Button with Confirmation Modal -->
                                            <div x-data="{ open: false }">
                                                <!-- Trigger Button -->
                                                <x-danger-button 
                                                    class="flex-1 w-full justify-center text-sm"
                                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-cancel-booking')">
                                                    Cancel Booking
                                                </x-danger-button>

                                                <!-- Confirmation Modal -->
                                                <x-modal name="confirm-cancel-booking" :show="$errors->bookingCancellation->isNotEmpty()" maxWidth="md">
                                                    <div>
                                                        <div class="rounded-full bg-zinc-500/10 p-2 flex">
                                                            <i class="fa-solid fa-exclamation rounded-full text-[10px] bg-red-500 py-1 px-2 text-white"></i>
                                                        </div>
                                                    </div>
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
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-client-layout>
