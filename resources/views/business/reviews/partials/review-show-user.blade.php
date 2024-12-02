<x-business-layout>
    <h2 class="text-3xl font-bold text-gray-800 mb-3">Reviewer Profile</h2>
    <div class="p-6 bg-white shadow-md sm:rounded-lg">
        <!-- Reviewer Profile Header -->
        <div class="flex-col items-center space-x-4 mb-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Reviewer Information</h3>
            <div class="flex items-center space-x-4 mb-6">
                <!-- Avatar Section -->
                @if($reviewer->avatar_path)
                    <img 
                        src="{{ asset('storage/' . $reviewer->avatar_path) }}" 
                        alt="Avatar" 
                        class="w-24 h-24 rounded-full object-cover"
                    >
                @else
                    <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">
                        No Avatar
                    </div>
                @endif
                <!-- Reviewer Information -->
                <div>
                    <div class="space-y-1">
                        <p><strong>Name:</strong> {{ $reviewer->first_name }} {{ $reviewer->last_name }}</p>
                        <p><strong>Email:</strong> {{ $reviewer->email }}</p>
                        <p><strong>Phone:</strong> {{ $reviewer->phone_number ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Verification Status -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Verification Status</h3>
            <span class="px-3 py-1 text-sm rounded-full font-medium
                {{ $reviewer->email_verified_at ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                {{ $reviewer->email_verified_at ? 'Verified' : 'Not Verified' }}
            </span>
        </div>

        <!-- Average Rating -->
        <div class="border-b pb-4 mb-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Average Rating</h3>
            <div class="flex items-center space-x-3">
                <!-- Stars -->
                <div class="flex">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star {{ $i <= floor($averageRating) ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                    @endfor
                </div>
                <!-- Rating Details -->
                <span class="text-sm text-gray-600">
                    ({{ number_format($averageRating, 1) }} / 5 from {{ $totalReviews }} reviews)
                </span>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Reviews Given</h3>
            @if($reviewer->reviews->count() > 0)
                <div class="space-y-4">
                    @foreach($reviewer->reviews as $review)
                        <div class="p-4 bg-gray-100 rounded-lg shadow-sm">
                            <div class="flex items-center space-x-3 mb-2">
                                <!-- Stars -->
                                <div class="flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <!-- Rating -->
                                <span class="text-sm text-gray-600">({{ $review->rating }} / 5)</span>
                            </div>
                            <!-- Review Comment -->
                            <p class="text-sm text-gray-700">{{ $review->comment ?? 'No comment provided.' }}</p>
                            <!-- Review Details -->
                            <p class="mt-2 text-xs text-gray-500">
                                For {{ $review->service_name ?? 'Unknown Service' }} on {{ $review->created_at->format('d M Y') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm">No reviews available.</p>
            @endif
        </div>

        <!-- Back Button -->
        <div>
            <a href="{{ route('business.reviews.index') }}">
                <x-button>
                    Back to Reviews
                </x-button>
            </a>
        </div>
    </div>
</x-business-layout>
