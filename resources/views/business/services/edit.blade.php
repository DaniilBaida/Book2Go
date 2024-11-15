<x-business-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Title -->
        <h1 class="text-3xl text-gray-800 font-bold">Edit Service</h1>
        <!-- Service Content -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form method="POST" action="{{ route('business.services.update', $service) }}"
                        enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Service Name -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Service Name')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                        value="{{ old('name', $service->name) }}" required autofocus/>
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <x-input-label for="service_category_id" :value="__('Category')"/>
                        <select id="service_category_id" name="service_category_id" class="block mt-1 w-full">
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}" {{ $service->service_category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_category_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <x-input-label for="price" :value="__('Price (€)')"/>
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price"
                                        value="{{ old('price', $service->price) }}" required step="0.01"/>
                        @error('price')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div class="mb-4">
                        <x-input-label for="duration_minutes" :value="__('Duration (minutes)')" />
                        <select id="duration_minutes" name="duration_minutes" class="block mt-1 w-full" required>
                            @foreach(\App\Models\Service::allowedDurations() as $duration)
                                <option value="{{ $duration }}" {{ old('duration_minutes') == $duration ? 'selected' : '' }}>
                                    {{ $duration }} minutes
                                </option>
                            @endforeach
                        </select>
                        @error('duration_minutes')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label for="start_time" :value="__('Start Time')" />
                        <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" value="{{ old('start_time', $service->start_time) }}" required />
                        @error('start_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-input-label for="end_time" :value="__('End Time')" />
                        <x-text-input id="end_time" class="block mt-1 w-full" type="time" name="end_time" value="{{ old('end_time', $service->end_time) }}" required />
                        @error('end_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')"/>
                        <textarea id="description" name="description" class="block mt-1 w-full"
                                    rows="4">{{ old('description', $service->description) }}</textarea>
                        @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Service Image')"/>
                        <input id="image" type="file" name="image" class="block mt-1 w-full" accept="image/*"/>
                        @if ($service->image_path)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->name }}"
                                        class="w-32 h-32 object-cover rounded">
                            </div>
                        @endif
                        @error('image')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status')"/>
                        <select id="status" name="status" class="block mt-1 w-full">
                            <option
                                value="active" {{ $service->status === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option
                                value="inactive" {{ $service->status === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            <option
                                value="archived" {{ $service->status === 'archived' ? 'selected' : '' }}>{{ __('Archived') }}</option>
                        </select>
                        @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="ml-4">
                            {{ __('Update Service') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-business-layout>
