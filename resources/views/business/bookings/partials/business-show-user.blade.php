<x-business-layout>
    <div class="p-6 bg-white shadow-sm sm:rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-800">User Profile</h2>

        <!-- Informações do Usuário -->
        <div class="mt-4">
            <strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}<br>
            <strong>Email:</strong> {{ $user->email }}<br>
            <strong>Phone:</strong> {{ $user->phone_number ?? 'Not provided' }}<br>
        </div>

        <!-- Média das Reviews -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800">Average Rating</h3>
            <div class="flex items-center space-x-2">
                <!-- Estrelas -->
                <div class="flex">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star {{ $i <= floor($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                    @endfor
                </div>
                <!-- Média e Total -->
                <span class="text-sm text-gray-600">
                    ({{ number_format($averageRating, 1) }} / 5 from {{ $totalReviews }} reviews)
                </span>
            </div>
        </div>

        <!-- Botão para exibir as reviews -->
        <div class="mt-4">
            <button 
                x-data 
                @click="document.getElementById('reviews-section').classList.toggle('hidden')" 
                class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700"
            >
                View Reviews
            </button>
        </div>

        <!-- Seção de Reviews (escondida por padrão) -->
        <div id="reviews-section" class="mt-6 hidden">
            <h3 class="text-lg font-semibold text-gray-800">Reviews</h3>
            @if($user->reviews->count() > 0)
                <div class="mt-4 space-y-4">
                    @foreach($user->reviews as $review)
                        <div class="p-4 bg-gray-100 rounded shadow-sm">
                            <div class="flex items-center space-x-2">
                                <!-- Estrelas da Review -->
                                <div class="flex">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                                <!-- Nota -->
                                <span class="text-sm text-gray-600">({{ $review->rating }} / 5)</span>
                            </div>
                            <p class="mt-2 text-sm text-gray-700">{{ $review->comment ?? 'No comment provided.' }}</p>
                            <p class="mt-1 text-xs text-gray-500">
                                By {{ ucfirst($review->reviewer_type) }} on {{ $review->created_at->format('d M Y') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="mt-4 text-sm text-gray-500">No reviews available.</p>
            @endif
        </div>

        <!-- Botão de Voltar -->
        <div class="mt-6">
            <a href="{{ route('business.bookings') }}" class="text-blue-500 hover:underline">Back to Bookings</a>
        </div>
    </div>
</x-business-layout>
