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
                        {{ $service->status === 'active' ? 'bg-green-100 text-green-800' :
                        ($service->status === 'inactive' ? 'bg-red-100 text-red-800' :
                        ($service->status === 'archived' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                        {{ ucfirst($service->status) }}
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
            <div x-data="{ open: false }">
                <x-danger-button 
                    class="flex-1 w-full justify-center text-sm"         
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-service-deletion')">{{ __('Delete') }}</x-danger-button>

                <!-- Confirmation Modal -->
                <x-modal name="confirm-service-deletion" :show="$errors->serviceDeletion->isNotEmpty()" maxWidth="md">
                    <div>
                        <div class="rounded-full bg-zinc-500/10 p-2 flex">
                            <i class="fa-solid fa-exclamation rounded-full text-[10px] bg-red-500 py-1 px-2 text-white"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-medium text-black">
                            {{ __('Delete Service?') }}
                        </h2>

                        <p class="mt-2 text-sm text-gray-600">
                            {{ __('This action cannot be undone.') }}
                        </p>

                        <div class="mt-6 flex justify-end">
                            <x-button-secondary x-on:click="$dispatch('close-modal', 'confirm-service-deletion')" class="text-sm">
                                {{ __('Cancel') }}
                            </x-button-secondary>

                            <form method="POST" action="{{ route('business.services.destroy', $service->id) }}" class="inline text-sm ms-3">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">
                                    {{ __('Yes, Delete it') }}
                                </x-danger-button>
                            </form>
                        </div>
                    </div>
                </x-modal>

            </div>
        @elseif ($role == \App\Models\User::ROLE_ADMIN)
            <p class="text-gray-500 text-sm">{{ __('Managed by Business') }}</p>
        @elseif ($role == \App\Models\User::ROLE_CLIENT)
            <a type="button" href="{{ route('client.services.show', $service) }}" class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 ajax-link">{{ __('View') }}</a>
        @endif
    </div>
</div>
