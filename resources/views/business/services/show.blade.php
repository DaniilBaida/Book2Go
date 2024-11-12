<x-business-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Service Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold">{{ $service->name }}</h3>
                        <a href="{{ route('business.services.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Back to Services') }}
                        </a>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div>
                            <strong class="text-gray-700">{{ __('Category') }}:</strong>
                            <span>{{ $service->category->name }}</span>
                        </div>

                        <div>
                            <strong class="text-gray-700">{{ __('Price') }}:</strong>
                            <span>€{{ number_format($service->price, 2) }}</span>
                        </div>

                        @if($service->original_price)
                            <div>
                                <strong class="text-gray-700">{{ __('Original Price') }}:</strong>
                                <span>€{{ number_format($service->original_price, 2) }}</span>
                            </div>
                        @endif

                        @if($service->discount_price)
                            <div>
                                <strong class="text-gray-700">{{ __('Discount Price') }}:</strong>
                                <span>€{{ number_format($service->discount_price, 2) }}</span>
                            </div>
                        @endif

                        @if($service->discount_start_date && $service->discount_end_date)
                            <div>
                                <strong class="text-gray-700">{{ __('Discount Period') }}:</strong>
                                <span>{{ $service->discount_start_date->format('d-m-Y H:i') }} to {{ $service->discount_end_date->format('d-m-Y H:i') }}</span>
                            </div>
                        @endif

                        <div>
                            <strong class="text-gray-700">{{ __('Duration') }}:</strong>
                            <span>{{ $service->duration_minutes }} {{ __('minutes') }}</span>
                        </div>

                        <div>
                            <strong class="text-gray-700">{{ __('Description') }}:</strong>
                            <p class="mt-2">{{ $service->description }}</p>
                        </div>

                        @if ($service->image_path)
                            <div>
                                <strong class="text-gray-700">{{ __('Image') }}:</strong>
                                <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->name }}" class="w-full max-w-md mt-2 rounded">
                            </div>
                        @endif

                        @if ($service->video_path)
                            <div>
                                <strong class="text-gray-700">{{ __('Video') }}:</strong>
                                <video controls class="w-full max-w-md mt-2 rounded">
                                    <source src="{{ asset('storage/' . $service->video_path) }}" type="video/mp4">
                                    {{ __('Your browser does not support the video tag.') }}
                                </video>
                            </div>
                        @endif

                        <div>
                            <strong class="text-gray-700">{{ __('Average Rating') }}:</strong>
                            <span>{{ number_format($service->average_rating, 1) }} / 5</span>
                        </div>

                        <div>
                            <strong class="text-gray-700">{{ __('Reviews Count') }}:</strong>
                            <span>{{ $service->reviews_count }}</span>
                        </div>

                        @if($service->max_capacity)
                            <div>
                                <strong class="text-gray-700">{{ __('Max Capacity') }}:</strong>
                                <span>{{ $service->max_capacity }}</span>
                            </div>
                        @endif

                        @if($tagsArray && count($tagsArray) > 0)
                            <div class="mt-2">
                                <strong class="text-gray-700">{{ __('Tags') }}:</strong>
                                <ul class="list-disc list-inside">
                                    @foreach($tagsArray as $tag)
                                        <li class="text-gray-600">{{ $tag }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($service->add_ons)
                            <div>
                                <strong class="text-gray-700">{{ __('Add-Ons') }}:</strong>
                                <ul class="list-disc list-inside">
                                    @foreach($service->add_ons as $addOn)
                                        <li>{{ $addOn }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div>
                            <strong class="text-gray-700">{{ __('Bookings Count') }}:</strong>
                            <span>{{ $service->bookings_count }}</span>
                        </div>

                        <div>
                            <strong class="text-gray-700">{{ __('Status') }}:</strong>
                            <span class="px-2 py-1 rounded-full {{ $service->status === 'active' ? 'bg-green-100 text-green-800' : ($service->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($service->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('business.services.edit', $service) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Edit Service') }}
                        </a>
                        <form action="{{ route('business.services.destroy', $service) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Delete Service') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-business-layout>
