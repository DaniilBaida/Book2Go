@if($booking->status === 'accepted')
    <!-- Disabled Cancel Button with Tooltip -->
    <div x-data="{ showTooltip: false }" class="relative">
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
    </div>
@else
    <!-- Cancel Button -->
    <x-danger-button x-on:click="$dispatch('open-modal', 'cancel-booking-{{ $booking->id }}')">
        Cancel Booking
    </x-danger-button>

    <!-- Cancel Booking Modal -->
    <x-modal name="cancel-booking-{{ $booking->id }}" maxWidth="md" type="deletion">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Confirm Cancellation:</h2>
            <p class="text-gray-600 mt-2">Are you sure you want to cancel this booking? <span class="font-bold">This action cannot be undone.</span></p>
            <div class="flex justify-end gap-2 mt-4">
                <!-- Close Modal -->
                <x-button-secondary x-on:click="$dispatch('close-modal', 'cancel-booking-{{ $booking->id }}')">
                    No, Go Back
                </x-button-secondary>
                <!-- Cancel Form -->
                <form method="POST" action="{{ route('client.bookings.cancel', $booking) }}">
                    @csrf
                    @method('DELETE')
                    <x-danger-button type="submit">Yes, Cancel Booking</x-danger-button>
                </form>
            </div>
        </div>
    </x-modal>
@endif
