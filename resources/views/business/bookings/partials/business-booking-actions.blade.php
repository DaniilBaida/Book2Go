<!-- BUSINESS: Approve Booking -->
<form method="POST" action="{{ route('business.bookings.accept', $booking) }}">
    @csrf
    @method('PATCH')
    <x-button class="bg-green-600 hover:bg-green-500">
        <i class="fa-solid fa-check"></i>
    </x-button>
</form>

<!-- BUSINESS: Deny Booking Button -->
<x-danger-button x-on:click="$dispatch('open-modal', 'deny-booking-{{ $booking->id }}')">
    <i class="fa-solid fa-x"></i>
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
