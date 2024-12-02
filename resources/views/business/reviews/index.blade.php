<x-business-layout>
    <h1 class="text-3xl text-gray-800 font-bold mb-5">Manage Reviews</h1>
    <div class="p-6 bg-white shadow-sm sm:rounded-lg flex flex-col gap-4">
        <x-business.reviews.reviews-table :reviews="$reviews" />
    </div>
</x-business-layout>
