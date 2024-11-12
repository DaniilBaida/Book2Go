<x-client-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Service Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Service Title -->
                <h3 class="text-2xl font-bold">{{ $service->name }}</h3>

                <!-- Image -->
                @if($service->image_path)
                    <div class="mt-4">
                        <img src="{{ $service->image_path ? asset($service->image_path) : asset('images/default-service.png') }}" alt="{{ $service->name }}" class="w-40 max-w-md mt-2 rounded">
                    </div>
                @endif

                <!-- Service Price -->
                <p class="text-gray-800 font-bold mt-4">€{{ number_format($service->price, 2) }}</p>

                <!-- Category -->
                <div class="mt-2">
                    <strong class="text-gray-700">{{ __('Category') }}:</strong>
                    <span>{{ $service->category->name }}</span>
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <strong class="text-gray-700">{{ __('Description') }}:</strong>
                    <p class="mt-2 text-gray-600">{{ $service->description }}</p>
                </div>


                @foreach ($service->reviews as $review)
                    <x-review-card :review="$review" />
                @endforeach

                @include('client.services.partial.review-submit')

                <!-- Back Button -->
                <div class="mt-6">
                    <a href="{{ route('client.services.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Back to Services') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-client-layout>
