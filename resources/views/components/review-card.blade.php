<article class="p-6 mb-6 text-base bg-white rounded-lg">
    <div class="flex items-center mb-4">
        <img class="w-10 h-10 me-4 rounded-full"
             src="{{ $review->user->avatar_path ? asset($review->user->avatar_path) : asset('images/default-user.png') }}"
             alt="{{ $review->user->name  }} Avatar">
        <div class="font-medium text-gray-900">
            <p>{{ $review->user->name }} <time datetime="{{ $review->created_at->toW3cString() }}" class="block text-sm text-gray-500">Reviewed on {{ $review->created_at->format('F j, Y') }}</time></p>
        </div>
    </div>
    <div class="flex items-center mb-1 space-x-1 rtl:space-x-reverse">
        @for ($i = 1; $i <= 5; $i++)
            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-300' : 'text-gray-300' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
            </svg>
        @endfor
        <h3 class="ms-2 text-sm font-semibold text-gray-900">{{ $review->title }}</h3>
    </div>
    <footer class="mb-5 text-sm text-gray-500"><p>Reviewed on <time datetime="{{ $review->created_at->toW3cString() }}">{{ $review->created_at->format('F j, Y') }}</time></p></footer>
    <p class="mb-2 text-gray-500">{{ $review->comment }}</p>
    <aside>
        <div class="flex items-center mt-3 space-x-3">
            <button class="px-2 py-1.5 text-xs font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Helpful</button>
            <a href="#" class="text-sm font-medium text-blue-600 hover:underline">Report abuse</a>
        </div>
    </aside>
</article>
