<x-business-layout>
    <h2 class="text-3xl font-bold text-gray-800 mb-3">User Profile</h2>
    <div class="p-6 bg-white shadow-md sm:rounded-lg">
        <!-- User Profile Header -->
        <div class="flex-col items-center space-x-4 mb-6">
        <h3 class="text-xl font-semibold text-gray-700 mb-2">Basic Information</h3>
        <div class="flex items-center space-x-4 mb-6">
            <!-- User Information -->
            <div>
                <div class="space-y-1">
                    <div class="flex items-center space-x-2">
                        <p class="font-medium text-lg text-gray-800">
                            {{ $user->first_name }} {{ $user->last_name }}
                        </p>
                        @if($user->is_verified == 1)
                            <span class="relative flex items-center justify-center w-5 h-5 rounded-full bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 p-0.5">
                                <div class="flex items-center justify-center w-full h-full bg-white rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </span>
                        @endif
                    </div>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Phone:</strong> {{ $user->phone_number ?? 'Not provided' }}</p>
                </div>
            </div>
        </div>
    </div>



        <!-- Verification Status -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Verification Status</h3>
            <span class="px-3 py-1 text-sm rounded-full font-medium
                {{ $user->email_verified_at ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
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
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Reviews</h3>
            @if($user->reviews->count() > 0)
                <div class="space-y-4">
                    @foreach($user->reviews as $review)
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
                                By {{ ucfirst($review->reviewer_type) }} on {{ $review->created_at->format('d M Y') }}
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
            <a href="{{ url()->previous() }}">
                <x-button>
                    Back
                </x-button>
            </a>
        </div>
    </div>
</x-business-layout>
