<x-business-layout>
    <div class="flex flex-col gap-y-5">
        <h1 class="text-3xl text-gray-800 font-bold">Your Service</h1>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold">{{ $service->name }}</h3>
                    <a href="{{ route('business.services.index') }}" class="border-2 rounded-full border-gray-800
                    hover:bg-gray-800 duration-300 group">
                        <i class="fa fa-arrow-left p-2 text-gray-800 group-hover:text-white" aria-hidden="true"></i>
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
                            <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->name }}"
                                    class="w-full max-w-md mt-2 rounded">
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

                    <div>
                        <strong class="text-gray-700">{{ __('Bookings Count') }}:</strong>
                        <span>{{ $service->bookings_count }}</span>
                    </div>

                    <div>
                        <strong class="text-gray-700">{{ __('Status') }}:</strong>
                        <span
                            class="px-2 py-1 rounded-full {{ $service->status === 'active' ? 'bg-green-100 text-green-800' : ($service->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($service->status) }}
                        </span>
                    </div>
                </div>

                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('business.services.edit', $service) }}">
                        <x-primary-button>
                            {{ __('Edit Service') }}
                        </x-primary-button>
                    </a>
                    <form action="{{ route('business.services.destroy', $service) }}" method="POST"
                            class="inline-block">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">
                            {{ __('Delete Service') }}
                        </x-danger-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-business-layout>
