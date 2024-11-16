<x-business-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Title -->
        <h1 class="text-3xl text-gray-800 font-bold">Edit Service</h1>

        <!-- Service Content -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form method="POST" action="{{ route('business.services.update', $service) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Service Name -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Service Name')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $service->name) }}" required autofocus/>
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <x-input-label for="service_category_id" :value="__('Category')"/>
                        <select id="service_category_id" name="service_category_id" class="block mt-1 w-full">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('service_category_id', $service->service_category_id) == $category->id ? 'selected' : '' }}>
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
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" value="{{ old('price', $service->price) }}" required step="0.01"/>
                        @error('price')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div class="mb-4">
                        <x-input-label for="duration_minutes" :value="__('Duration (minutes)')"/>
                        <select id="duration_minutes" name="duration_minutes" class="block mt-1 w-full" required>
                            @foreach(\App\Models\Service::allowedDurations() as $duration)
                                <option value="{{ $duration }}" {{ old('duration_minutes', $service->duration_minutes) == $duration ? 'selected' : '' }}>
                                    {{ $duration }} minutes
                                </option>
                            @endforeach
                        </select>
                        @error('duration_minutes')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Available Days -->
                    <div class="mb-4">
                        <x-input-label for="available_days" :value="__('Available Days')" />
                        <div class="flex gap-2 mt-1">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <label class="flex items-center">
                                    <input type="checkbox" name="available_days[]" value="{{ $day }}"
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
                        <input type="text" id="time_range" name="time_range" class="block mt-1 w-full" placeholder="Select time range">
                        <input type="hidden" id="start_time" name="start_time" value="{{ old('start_time', $service->start_time) }}">
                        <input type="hidden" id="end_time" name="end_time" value="{{ old('end_time', $service->end_time) }}">
                        @error('start_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        @error('end_time')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')"/>
                        <textarea id="description" name="description" class="block mt-1 w-full" rows="4">{{ old('description', $service->description) }}</textarea>
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
                                <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->name }}" class="w-32 h-32 object-cover rounded">
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
                            <option value="active" {{ old('status', $service->status) === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="inactive" {{ old('status', $service->status) === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            <option value="archived" {{ old('status', $service->status) === 'archived' ? 'selected' : '' }}>{{ __('Archived') }}</option>
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

    <!-- Script to initialize Flatpickr for time range selection -->
    <script>
        $(document).ready(function () {
            // Initialize the time range picker when the page is ready
            initializeTimeRangePicker();

            // Listen for changes when content is loaded dynamically
            $(document).on('ajaxComplete', function () {
                // Reinitialize the time range picker every time new content is loaded via AJAX or other methods
                initializeTimeRangePicker();
            });

            // Or if you're using Turbo (Turbo.js for SPA-style navigation):
            document.addEventListener('turbo:frame-load', function () {
                // Reinitialize the time range picker when Turbo loads new content
                initializeTimeRangePicker();
            });
        });

        function initializeTimeRangePicker() {
            // Ensure Flatpickr is only initialized once by checking for the instance
            if ($('#time_range').data('flatpickr')) {
                // If Flatpickr is already initialized, return
                return;
            }

            // Initialize Flatpickr for the time range input with dynamic data
            flatpickr("#time_range", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                mode: "range",
                defaultDate: ["{{$service->start_time}}", "{{$service->end_time}}"], // Use dynamic start and end time
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

            // Mark Flatpickr as initialized by storing the instance in the data attribute
            $('#time_range').data('flatpickr', true);
        }

    </script>
</x-business-layout>
