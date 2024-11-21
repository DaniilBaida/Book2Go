<!-- BUSINESS: View Booking Details Button -->
<a href="{{ route('business.bookings.show', $booking->id) }}">
   <button class="bg-gray-500/40 hover:bg-gray-500/60 duration-300 h-full p-3 rounded-full flex items-center">
        <i class="fa-solid fa-info-circle text-gray-500"></i>
   </button>
</a>

<!-- BUSINESS: Approve Booking -->
@if($booking->status !== 'completed')
    <form method="POST" action="{{ route('business.bookings.accept', $booking) }}">
        @csrf
        @method('PATCH')
        <x-button class="bg-green-500/40 hover:bg-green-500/60 duration-300 h-full">
            <i class="fa-solid fa-check text-green-500"></i>
        </x-button>
    </form>
@endif

<!-- BUSINESS: Deny Booking Button -->
@if($booking->status !== 'completed')
    <x-danger-button x-on:click="$dispatch('open-modal', 'deny-booking-{{ $booking->id }}')" class="bg-red-500/40 hover:bg-red-500/60 duration-300">
        <i class="fa-solid fa-x text-red-500"></i>
    </x-danger-button>

    <!-- BUSINESS: Deny Booking Modal -->
    <x-modal name="deny-booking-{{ $booking->id }}" maxWidth="md" type="deletion">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Deny Booking for:
                <span class="font-bold">{{ $booking->service->name }}</span>
            </h2>
            <p class="text-gray-600 mt-2">
                Are you sure you want to deny this booking? You can later approve it again if needed.
            </p>
            <div class="flex justify-end gap-2 mt-4">
                <!-- Close Modal -->
                <x-button-secondary x-on:click="$dispatch('close-modal', 'deny-booking-{{ $booking->id }}')">
                    No, Go Back
                </x-button-secondary>
                <!-- Submit Deny Form -->
                <form method="POST" action="{{ route('business.bookings.deny', $booking) }}">
                    @csrf
                    @method('PATCH')
                    <x-danger-button type="submit">Yes, Deny Booking</x-danger-button>
                </form>
            </div>
        </div>
    </x-modal>
@endif
