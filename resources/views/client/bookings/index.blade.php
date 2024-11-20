<x-client-layout>
    <h1 class="text-3xl text-gray-800 font-bold mb-5">My Bookings</h1>
    <div class="p-6 bg-white shadow-sm sm:rounded-lg flex flex-col gap-4">
        <x-booking-table :bookings="$bookings" role="client" />
    </div>
</x-client-layout>
