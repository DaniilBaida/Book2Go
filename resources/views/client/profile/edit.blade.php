<x-client-layout>
    <div class="flex flex-col gap-y-5">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <h1 class="text-3xl font-bold">Profile</h1>
        </div>

        <!-- Average Rating Section -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-xl font-semibold mb-4">Average Rating</h2>
                @php
                    $averageRating = Auth::user()->reviews()->avg('rating');
                @endphp
                <div class="flex items-center">
                    <span class="text-yellow-500 text-lg font-bold">
                        {{ number_format($averageRating, 1) ?? 'N/A' }}
                    </span>
                    <span class="ml-2 text-gray-600">/ 5 Stars</span>
                </div>
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('client.profile.partials.update-avatar')
            </div>
        </div>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('client.profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('client.profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('client.profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-client-layout>
