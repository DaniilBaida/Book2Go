<div class="flex justify-end gap-3 items-center">
    @if($role === 'client')
        <!-- Pay Button -->
        @if($booking->status === 'accepted')
            <form method="POST" action="{{ route('client.pay', $booking) }}">
                @csrf
                <x-button type="submit" class="text-sm bg-blue-500 hover:bg-blue-600 px-4 py-2 duration-300">
                    <i class="fa-brands fa-paypal"></i>
                </x-button>
            </form>
        @endif

        <!-- Cancel Booking Actions -->
        @if($booking->status === 'accepted' || $booking->status === 'paid' || $booking->status === 'completed')
            <!-- Disabled Cancel Button -->
            <x-danger-button 
                class="text-sm opacity-50 cursor-not-allowed px-4 py-2"
                disabled
            >
                Cancel Booking
            </x-danger-button>
        @else
            <!-- Cancel Button -->
            <x-danger-button x-on:click="$dispatch('open-modal', 'cancel-booking-{{ $booking->id }}')" class="px-4 py-2">
                Cancel Booking
            </x-danger-button>

            <!-- Cancel Booking Modal -->
            <x-modal name="cancel-booking-{{ $booking->id }}" maxWidth="md" type="deletion">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Confirm Cancellation:</h2>
                    <p class="text-gray-600 mt-2">
                        Are you sure you want to cancel this booking? 
                        <span class="font-bold">This action cannot be undone.</span>
                    </p>
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
    @elseif($role === 'business')
        @include('business.bookings.partials.business-booking-actions', ['booking' => $booking])
    @endif
</div>
