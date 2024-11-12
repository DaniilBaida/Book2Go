<div class="bg-white shadow-md rounded-lg overflow-hidden relative hover:shadow-lg transition-all duration-300">
    <img class="w-full h-48 object-cover"
         src="{{ $service->image_path ? asset($service->image_path) : asset('images/default-service.png') }}"
         alt="{{ $service->name }}"
         onerror="this.onerror=null; this.src='{{ asset('images/default-service.png') }}';">


    <div class="p-4">
        <h3 class="font-bold text-lg">{{ $service->name }}</h3>
        <p class="text-gray-600 text-sm">{{ $service->category->name }}</p>
        <p class="text-gray-800 font-semibold mt-2">{{ __('€') . number_format($service->price, 2) }}
            / {{ __('session') }}</p>
        <p class="text-sm text-gray-500">{{ $service->duration_minutes }} {{ __('minutes') }}</p>

        <!-- Description -->
        @if($service->description)
            <p class="text-gray-700 mt-2">{{ $service->description }}</p>
        @endif

        <!-- Tags Section -->
        @if($service->tags && count($service->tags) > 0)
            <div class="mt-2 flex flex-wrap gap-2">
                @foreach($service->tags as $tag)
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                {{ $tag }}
            </span>
                @endforeach
            </div>
        @endif

        <!-- Add-Ons -->
        @if(!empty($service->add_ons))
            <div class="mt-2">
                <strong class="text-gray-700">{{ __('Add-Ons') }}:</strong>
                <ul class="list-disc list-inside">
                    @foreach($service->add_ons as $addOn)
                        <li class="text-gray-600">{{ $addOn }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Reviews and Bookings -->
        <div class="mt-4 flex items-center space-x-4">
            <!-- Reviews -->
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                     height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                </svg>
                <span class="ml-2 text-gray-600">{{ $service->reviews_count }} {{ __('Reviews') }}</span>
            </div>
            <!-- Bookings -->
            <div class="flex items-center">
                <svg class="w-6 h-6 text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                     height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                          d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                          clip-rule="evenodd"/>
                </svg>
                <span class="ml-2 text-gray-600">{{ $service->bookings_count }} {{ __('Bookings') }}</span>
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

    <div class="p-4 border-t border-gray-100 flex justify-between items-center">
        @if ($role == \App\Models\User::ROLE_BUSINESS)
            <a href="{{ route('business.services.show', $service->id) }}"
               class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
                {{ __('View') }}
            </a>
            <a href="{{ route('business.services.edit', $service->id) }}"
               class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">
                {{ __('Edit') }}
            </a>
            <form action="{{ route('business.services.destroy', $service->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                    {{ __('Delete') }}
                </button>
            </form>
        @elseif ($role == \App\Models\User::ROLE_ADMIN)
            <p class="text-gray-500 text-sm">{{ __('Managed by Business') }}</p>
        @elseif ($role == \App\Models\User::ROLE_CLIENT)
            <p class="text-green-500 font-bold">{{ __('Book Now') }}</p>
        @endif
    </div>
</div>
