<x-client-layout>
    <div class="p-6 bg-white shadow-sm sm:rounded-lg flex flex-col gap-4">
        <h1 class="text-3xl text-gray-800 font-bold">My Bookings</h1>
        <x-booking-table :bookings="$bookings" role="client" />
    </div>
</x-client-layout>
