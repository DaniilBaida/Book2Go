<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="flex max-md:flex-col gap-10 w-full">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <!-- Left Container for Service Details -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:w-1/2">
        <div class="p-6 text-gray-900">
            <h1 class="text-3xl text-gray-800 font-bold mb-5">{{ $title }}</h1>

            <!-- Service Name Input -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Service Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $service->name ?? '') }}" required autofocus />
                @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Service Category Dropdown -->
            <div class="mb-4">
                <x-input-label for="service_category_id" :value="__('Category')" />
                <x-select-input id="service_category_id" name="service_category_id" class="block mt-1 w-full">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('service_category_id', $service->service_category_id ?? '') == $category->id ? 'selected' : '' }}>
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
                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" value="{{ old('price', $service->price ?? '') }}" required step="0.01" />
                @error('price')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Duration Dropdown -->
            <div class="mb-4">
                <x-input-label for="duration_minutes" :value="__('Duration (minutes)')" />
                <x-select-input id="duration_minutes" name="duration_minutes" class="block mt-1 w-full" required>
                    @foreach(\App\Models\Service::allowedDurations() as $duration)
                        <option value="{{ $duration }}" {{ old('duration_minutes', $service->duration_minutes ?? '') == $duration ? 'selected' : '' }}>
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

            <div class="flex gap-5">
                <!-- Time Range Picker -->
                <div class="mb-4 w-1/2">
                    <x-input-label for="time_range" :value="__('Service Time Range')" />
                    <input type="text" id="time_range" name="time_range" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Select time range">
                    <!-- Hidden inputs for storing start and end times -->
                    <input type="hidden" id="start_time" name="start_time" value="{{ old('start_time', '08:00') }}">
                    <input type="hidden" id="end_time" name="end_time" value="{{ old('end_time', '17:00') }}">
                    @error('start_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    @error('end_time')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Service Status Dropdown -->
                <div class="mb-4 w-1/2">
                    <x-input-label for="status" :value="__('Status')" />
                    <x-select-input id="status" name="status" class="block mt-1 w-full">
                        <option value="active" {{ old('status', $service->status ?? 'active') === 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="inactive" {{ old('status', $service->status ?? '') === 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        <option value="archived" {{ old('status', $service->status ?? '') === 'archived' ? 'selected' : '' }}>{{ __('Archived') }}</option>
                    </x-select-input>
                    @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Right Container for Service Image and Status -->
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg md:w-1/2">
        <div class="p-6 text-gray-900">
            <!-- Description Textarea -->
            <div class="mb-4">
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm resize-none" rows="7">{{ old('description', $service->description ?? '') }}</textarea>
                @error('description')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Service Image Upload -->
            <div class="mb-4">
                <x-input-label for="image" :value="__('Image')" />
                <x-upload-avatar name="image" currentImage="{{ $service->image_path ?? '' }}" class="block mt-1 w-full" />
                @error('image')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Auto-Accept Bookings Toggle -->
            <div class="mb-4">
                <x-input-label for="auto_accept" :value="__('Auto-Accept Bookings')" />
                <div class="flex items-center mt-1">
                    <label for="auto_accept" class="inline-flex items-center cursor-pointer">
                        <input id="auto_accept" name="auto_accept" type="checkbox" value="1" 
                            class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                            {{ old('auto_accept', $service->auto_accept ?? false) ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700">{{ __('Enable Auto-Accept') }}</span>
                    </label>
                </div>
                @error('auto_accept')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end mt-6">
                <x-button class="ml-4">
                    {{ $buttonText }}
                </x-button>
            </div>
        </div>
    </div>
</form>

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

        // Initialize Flatpickr for the time range input
        flatpickr("#time_range", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            mode: "range",
            defaultDate: ["09:00", "18:00"],
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
