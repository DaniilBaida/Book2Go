<x-business-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Container for the form with padding and shadow -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Form to create a new service -->
                <form method="POST" action="{{ route('business.services.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Service Name Input -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Service Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required autofocus />
                        <!-- Validation error message for service name -->
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Service Category Dropdown -->
                    <div class="mb-4">
                        <x-input-label for="service_category_id" :value="__('Category')" />
                        <select id="service_category_id" name="service_category_id" class="block mt-1 w-full">
                            <!-- Loop through service categories for dropdown options -->
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('service_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <!-- Validation error message for service category -->
                        @error('service_category_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Price Input -->
                    <div class="mb-4">
                        <x-input-label for="price" :value="__('Price (€)')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" value="{{ old('price') }}" required step="0.01" />
                        <!-- Validation error message for price -->
                        @error('price')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Duration Dropdown -->
                    <div class="mb-4">
                        <x-input-label for="duration_minutes" :value="__('Duration (minutes)')" />
                        <select id="duration_minutes" name="duration_minutes" class="block mt-1 w-full" required>
                            <!-- Loop through predefined durations -->
                            @foreach(\App\Models\Service::allowedDurations() as $duration)
                                <option value="{{ $duration }}" {{ old('duration_minutes') == $duration ? 'selected' : '' }}>
                                    {{ $duration }} minutes
                                </option>
                            @endforeach
                        </select>
                        <!-- Validation error message for duration -->
                        @error('duration_minutes')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Available Days Selection -->
                    <div class="mb-4">
                        <x-input-label for="available_days" :value="__('Available Days')" />
                        <div class="flex gap-2 mt-1">
                            <!-- Checkbox inputs for each day of the week -->
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <label class="flex items-center">
                                    <input type="checkbox" name="available_days[]" value="{{ $day }}"
                                        {{ in_array($day, old('available_days', $service->available_days ?? [])) ? 'checked' : '' }}>
                                    <span class="ml-2">{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                        <!-- Validation error message for available days -->
                        @error('available_days')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Time Range Picker -->
                    <div class="mb-4">
                        <x-input-label for="time_range" :value="__('Service Time Range')" />
                        <input type="text" id="time_range" name="time_range" class="block mt-1 w-full" placeholder="Select time range">
                        <!-- Hidden inputs for storing start and end times -->
                        <input type="hidden" id="start_time" name="start_time" value="{{ old('start_time', '08:00') }}">
                        <input type="hidden" id="end_time" name="end_time" value="{{ old('end_time', '17:00') }}">
                        <!-- Validation error messages for start and end times -->
                        @error('start_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        @error('end_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description Textarea -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="block mt-1 w-full" rows="4">{{ old('description') }}</textarea>
                        <!-- Validation error message for description -->
                        @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Service Image Upload -->
                    <div class="mb-4">
                        <x-input-label for="image" :value="__('Service Image')" />
                        <input id="image" type="file" name="image" class="block mt-1 w-full" accept="image/*" />
                        <!-- Validation error message for image -->
                        @error('image')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Service Status Dropdown -->
                    <div class="mb-4">
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status" class="block mt-1 w-full">
                            <!-- Options for service status -->
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>{{ __('Archived') }}</option>
                        </select>
                        <!-- Validation error message for status -->
                        @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="ml-4">
                            {{ __('Create Service') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script to initialize Flatpickr for time range selection -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#time_range", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                mode: "range",
                defaultDate: ["09:00", "18:00"],
                onClose: function(selectedDates) {
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
