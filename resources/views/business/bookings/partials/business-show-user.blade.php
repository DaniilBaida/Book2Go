<x-business-layout>
    <div class="p-6 bg-white shadow-sm sm:rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-800">User Profile</h2>

        <div class="mt-4 flex items-center space-x-4">
            <img 
                src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('default-avatar.png') }}" 
                alt="{{ $user->first_name }} {{ $user->last_name }}" 
                class="w-24 h-24 rounded-full object-cover shadow-md">
            
            <div>
                <strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}<br>
                <strong>Email:</strong> {{ $user->email }}<br>
                <strong>Phone:</strong> {{ $user->phone_number ?? 'Not provided' }}<br>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('business.bookings') }}" class="text-blue-500 hover:underline">Back to Bookings</a>
        </div>
    </div>
</x-business-layout>
