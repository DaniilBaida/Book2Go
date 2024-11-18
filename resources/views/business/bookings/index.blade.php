<x-business-layout>
    <div class="p-6 bg-white shadow-sm sm:rounded-lg flex flex-col gap-4">
        <h1 class="text-3xl text-gray-800 font-bold">Manage Bookings</h1>
        <x-booking-table :bookings="$bookings" role="business" />
    </div>
</x-business-layout>
