@if($booking->status === 'accepted')
    <!-- Disabled Cancel Button with Tooltip -->
    <div x-data="{ showTooltip: false }" class="relative">
        <!-- Tooltip Component -->
        <x-tooltip message="Booking has already been accepted and cannot be canceled.">
            <x-danger-button 
                class="flex-1 w-full justify-center text-sm opacity-50 cursor-not-allowed"
                disabled 
                @mouseenter="showTooltip = true" 
                @mouseleave="showTooltip = false">
                Cancel Booking
            </x-danger-button>
        </x-tooltip>
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
