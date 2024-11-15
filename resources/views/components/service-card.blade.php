<div class="bg-white shadow-md rounded-2xl overflow-hidden relative hover:shadow-lg transition-all duration-300">
    <img class="w-full h-48 object-cover"
         src="{{ $service->image_path ? asset($service->image_path) : asset('images/default-service.png') }}"
         alt="{{ $service->name }}"
         onerror="this.onerror=null; this.src='{{ asset('images/default-service.png') }}';">

    <div class="p-4">
        <h3 class="font-bold text-lg">{{ $service->name }}</h3>
        <p class="text-gray-600 text-sm">{{ $service->category->name }}</p>
        <p class="text-gray-800 font-semibold mt-2">{{ __('€') . number_format($service->price, 2) }} / {{ __('session') }}</p>
        <p class="text-sm text-gray-500">{{ $service->duration_minutes }} {{ __('minutes') }}</p>

        <!-- Description -->
        @if($service->description)
            <p class="text-gray-700 mt-2">{{ $service->description }}</p>
        @endif
        

        <!-- Reviews and Bookings -->
        <div class="mt-4 flex items-center space-x-4 align-middle">
            <div class="flex items-center">
                <i class="fas fa-star text-yellow-300 text-base mr-1 flex items-center"></i>
                <p class="text-sm font-bold text-gray-900">
                    {{ number_format($service->reviews_avg_rating, 1) }}
                </p>
                <span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full"></span>
                <a href="#" class="text-sm font-medium text-gray-900 underline hover:no-underline">
                    {{ $service->reviews_count }} reviews
                </a>
            </div>
            <div class="flex items-center border-l border-gray-200/80 pl-4">
                <i class="fas fa-user text-gray-800 text-base mr-2 flex items-center"></i>
                <span class="text-sm text-gray-600">{{ $service->bookings_count }} {{ __('Bookings') }}</span>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mt-4">
            <span class="px-2 py-1 text-xs rounded-full
                {{ $service->status === 'active' ? 'bg-green-100 text-green-800' :
                   ($service->status === 'inactive' ? 'bg-red-100 text-red-800' :
                   ($service->status === 'archived' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                {{ ucfirst($service->status) }}
            </span>
        </div>
    </div>

    <!-- View/Edit/Delete Buttons -->
    <div class="p-4 border-t border-gray-200/80 flex justify-between items-center gap-3">
        @if ($role == \App\Models\User::ROLE_BUSINESS)
            <a href="{{ route('business.services.show', $service->id) }}" class="w-1/3 ajax-link">
                <x-primary-button class="flex-1 w-full justify-center">{{ __('View') }}</x-primary-button>
            </a>
            <a href="{{ route('business.services.edit', $service->id) }}" class="w-1/3 ajax-link">
                <x-secondary-button class="flex-1 w-full justify-center">{{ __('Edit') }}</x-secondary-button>
            </a>

            <!-- Delete Button with Confirmation Modal -->
            <div x-data="{ open: false }" class="w-1/3">
                <x-danger-button @click="open = true" class="flex-1 w-full justify-center">{{ __('Delete') }}</x-danger-button>

                <!-- Confirmation Modal -->
                <div 
                    x-cloak 
                    x-show="open" 
                    x-transition 
                    class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50"
                >
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h2 class="text-lg font-medium text-gray-900">{{ __('Are you sure you want to delete this service?') }}</h2>
                        <p class="mt-2 text-sm text-gray-600">{{ __('This action cannot be undone.') }}</p>

                        <div class="mt-4 flex justify-end space-x-3">
                            <x-secondary-button @click="open = false">{{ __('Cancel') }}</x-secondary-button>

                            <form method="POST" action="{{ route('business.services.destroy', $service->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">{{ __('Confirm Delete') }}</x-danger-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @elseif ($role == \App\Models\User::ROLE_ADMIN)
            <p class="text-gray-500 text-sm">{{ __('Managed by Business') }}</p>
        @elseif ($role == \App\Models\User::ROLE_CLIENT)
            <a type="button" href="{{ route('client.services.show', $service) }}" class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ajax-link">{{ __('View') }}</a>
        @endif
    </div>
</div>
