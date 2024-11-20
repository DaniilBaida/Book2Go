<div class="bg-white shadow-md rounded-2xl overflow-hidden relative hover:shadow-lg transition-all duration-300">
    <img class="w-full h-48 object-cover"
         src="{{ $service->image_path ? asset($service->image_path) : asset('images/default-service.png') }}"
         alt="{{ $service->name }}"
         onerror="this.onerror=null; this.src='{{ asset('images/default-service.png') }}';">

    <div class="p-4 flex flex-col gap-2">
        <!-- INFORMATION -->
        <div class="gap-2 flex flex-col">
            <div class="flex justify-between">
                <!-- INFORMATION -->
                <span class="px-2 py-1 text-xs rounded-full bg-zinc-800 text-white font-bold w-fit">
                    {{ $service->category->name }}
                </span>
                <!-- Status Badge -->
                <div>
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $service->bookings->contains('user_id', auth()->id()) ? 'bg-blue-100 text-blue-800' :
                        ($service->status === 'active' ? 'bg-green-100 text-green-800' :
                        ($service->status === 'inactive' ? 'bg-red-100 text-red-800' :
                        ($service->status === 'archived' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'))) }}">
                        @if($service->bookings->contains('user_id', auth()->id()))
                            <i class="fa-solid fa-check"></i> {{ __('Booked') }}
                        @else
                            {{ ucfirst($service->status) }}
                        @endif
                    </span>
                </div>
            </div>
            <h3 class="font-bold text-xl">{{ $service->name }}</h3>
        </div>

        <!-- REVIEWS -->
        <div class="flex items-center">
            <!-- Star Rating -->
            <div class="flex">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star text-base mr-1"
                    style="color: {{ $i <= floor($service->reviews_avg_rating) ? '#FFC107' : '#E0E0E0' }};">
                    </i>
                @endfor
            </div>
            <!-- Average Rating -->
            <p class="text-sm font-bold text-gray-900 ml-2">
                {{ number_format($service->reviews_avg_rating, 1) }}
            </p>
        </div>

        <!-- BOOKINGS -->
        <div class="flex items-center">
            <i class="fas fa-user text-gray-800 text-base mr-2 flex items-center"></i>
            <span class="text-sm text-gray-600">{{ $service->bookings_count }} {{ __('Bookings') }}</span>
        </div>

        <!-- Description -->
        @if($service->description)
            <p class="text-gray-700">{{ $service->description }}</p>
        @endif

        <p class="text-gray-800 font-semibold">{{ __('€') . number_format($service->price, 2) }} / {{ __('session') }}</p>
        <p class="text-sm text-gray-500">{{ $service->duration_minutes }} {{ __('minutes') }}</p>
    </div>

    <!-- View/Edit/Delete Buttons -->
    <div class="p-4 border-t border-gray-200/80 flex items-center gap-3">
        @if ($role == \App\Models\User::ROLE_BUSINESS)
            <a href="{{ route('business.services.show', $service->id) }}" class="ajax-link">
                <x-button class="text-sm">{{ __('View') }}</x-button>
            </a>
            <a href="{{ route('business.services.edit', $service->id) }}" class="ajax-link">
                <x-button-secondary class="text-sm hover:text-blue-800">{{ __('Edit') }}</x-button-secondary>
            </a>

            <!-- Delete Button with Confirmation Modal -->
            <div x-data="{ open: false }" class="ml-auto">
                <!-- Trigger Button -->
                <x-danger-button
                    class="flex-1 w-full justify-center text-sm"
                    @click="$dispatch('open-modal', 'confirm-service-deletion-{{ $service->id }}')">
                    <i class="fa-solid fa-trash"></i>
                </x-danger-button>

                <!-- Confirmation Modal -->
                <x-modal name="confirm-service-deletion-{{ $service->id }}" :show="false" maxWidth="md">
                    <div>
                        <h2 class="text-xl font-medium text-black">
                            {{ __('Delete Service:') }} <span class="font-bold">{{ $service->name }}</span>?
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">
                            {{ __('Are you sure you want to delete this service? This action cannot be undone.') }}
                        </p>
                        <div class="mt-6 flex justify-end gap-4">
                            <!-- Cancel Button -->
                            <x-button-secondary
                                @click="$dispatch('close-modal', 'confirm-service-deletion-{{ $service->id }}')"
                                class="text-sm">
                                {{ __('Cancel') }}
                            </x-button-secondary>

                            <!-- Confirm Delete Form -->
                            <form method="POST" action="{{ route('business.services.destroy', $service->id) }}" class="inline text-sm">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">
                                    {{ __('Yes, Delete') }} <span class="font-bold">{{ $service->name }}</span>
                                </x-danger-button>
                            </form>
                        </div>
                    </div>
                </x-modal>
            </div>

        @elseif ($role == \App\Models\User::ROLE_ADMIN)
            <p class="text-gray-500 text-sm">{{ __('Managed by Business') }}</p>
        @elseif ($role == \App\Models\User::ROLE_CLIENT)
            <a type="button" href="{{ route('client.services.show', $service) }}" class="ajax-link">
                <x-button class="text-sm">{{ __('View') }}</x-button></a>
        @endif
    </div>
</div>
