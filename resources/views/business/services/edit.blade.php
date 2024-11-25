<x-business-layout>
    <div class="flex max-md:flex-col gap-10">
        <!-- Entire Form Container -->
        <form method="POST" action="{{ route('business.services.update', $service) }}" enctype="multipart/form-data" class="flex max-md:flex-col gap-10 w-full">
            @csrf
            @method('PUT')

            <!-- Left Container for Service Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:w-1/2">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl text-gray-800 font-bold mb-5">Edit Service</h1>

                    <!-- Service Name Input -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Service Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $service->name) }}" required autofocus />
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Service Category Dropdown -->
                    <div class="mb-4">
                        <x-input-label for="service_category_id" :value="__('Category')" />
                        <x-select-input id="service_category_id" name="service_category_id" class="block mt-1 w-full">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('service_category_id', $service->service_category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-select-input>
                        @error('service_category_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Price Input -->
                    <div class="mb-4">
                        <x-input-label for="price" :value="__('Price (€)')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" value="{{ old('price', $service->price) }}" required step="0.01" />
                        @error('price')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Duration Dropdown -->
                    <div class="mb-4">
                        <x-input-label for="duration_minutes" :value="__('Duration (minutes)')" />
                        <x-select-input id="duration_minutes" name="duration_minutes" class="block mt-1 w-full" required>
                            @foreach(\App\Models\Service::allowedDurations() as $duration)
                                <option value="{{ $duration }}" {{ old('duration_minutes', $service->duration_minutes) == $duration ? 'selected' : '' }}>
                                    {{ $duration }} minutes
                                </option>
                            @endforeach
                        </x-select-input>
                        @error('duration_minutes')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Available Days Selection -->
                    <div class="mb-4">
                        <x-input-label for="available_days" :value="__('Available Days')" />
                        <div class="flex gap-2 mt-1">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <label class="flex items-center">
                                    <input type="checkbox" name="available_days[]" value="{{ $day }}" class="rounded-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                                        {{ in_array($day, old('available_days', $service->available_days ?? [])) ? 'checked' : '' }}>
                                    <span class="ml-2">{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('available_days')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Time Range Picker -->
                    <div class="mb-4">
                        <x-input-label for="time_range" :value="__('Service Time Range')" />
                        <input type="text" id="time_range" name="time_range" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Select time range">
                        <input type="hidden" id="start_time" name="start_time" value="{{ old('start_time', $service->start_time) }}">
                        <input type="hidden" id="end_time" name="end_time" value="{{ old('end_time', $service->end_time) }}">
                        @error('start_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        @error('end_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Right Container for Service Image and Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:w-1/2">
                <div class="p-6 text-gray-900">
                    <!-- Description Textarea -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm resize-none" rows="7">{{ old('description', $service->description) }}</textarea>
                        @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Service Image Upload -->
                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Service Image')" />
                        <x-upload-avatar 
                            name="image" 
                            currentImage="{{ $service->image_path ? Storage::url($service->image_path) : null }}" 
                        />
                        @error('image')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Service Status Dropdown -->
                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <x-select-input id="status" name="status" class="block mt-1 w-full">
                            <option value="active" {{ old('status', $service->status) === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="inactive" {{ old('status', $service->status) === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            <option value="archived" {{ old('status', $service->status) === 'archived' ? 'selected' : '' }}>{{ __('Archived') }}</option>
                        </x-select-input>
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
                </div>
            </div>
        </form>
    </div>

    <!-- Script to initialize Flatpickr for time range selection -->
    <script>
        $(document).ready(function () {
            flatpickr("#time_range", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                mode: "range",
                defaultDate: ["{{ $service->start_time }}", "{{ $service->end_time }}"],
                onClose: function (selectedDates) {
                    if (selectedDates.length === 2) {
                        document.getElementById('start_time').value = flatpickr.formatDate(selectedDates[0], "H:i");
                        document.getElementById('end_time').value = flatpickr.formatDate(selectedDates[1], "H:i");
                    }
                },
                locale: {
                    rangeSeparator: " to "
                }
            });
        });
    </script>
</x-business-layout>
