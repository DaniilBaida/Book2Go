<x-business-layout>
    <div class="flex flex-wrap gap-10">
        <!-- Form Container -->
        <form method="POST" action="{{ route('business.details.update') }}" enctype="multipart/form-data" class="flex max-md:flex-col gap-5 w-full">
            @csrf
            @method('PATCH')

            <!-- Left Section: Business Details -->
            <div class="bg-white shadow-md rounded-lg p-6 md:w-1/2 w-full">
                <!-- Title -->
                <div class="flex gap-5 my-auto mb-5">
                    <button class="flex align-middle my-auto">
                        <i class="fa-solid fa-backward text-gray-400 hover:text-gray-800 duration-300"></i>
                    </button>
                    <h1 class="text-3xl font-bold text-gray-800 my-auto">Edit Business Details</h1>
                </div>

                <!-- Business Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Business Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $business->name) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required />
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $business->email) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required />
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Phone Number -->
                <div class="mb-4">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number *</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $business->phone_number) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required />
                    @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Country -->
                <div class="mb-4">
                    <label for="country" class="block text-sm font-medium text-gray-700">Country *</label>
                    <select id="country" name="country" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="" disabled>{{ __('Select Country') }}</option>
                        @foreach(config('countries') as $country)
                            <option value="{{ $country['code'] }}" {{ old('country', $business->country) == $country['code'] ? 'selected' : '' }}>{{ $country['name'] }}</option>
                        @endforeach
                    </select>
                    @error('country') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Postal Code -->
                <div class="mb-4">
                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code *</label>
                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $business->postal_code) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required />
                    @error('postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address *</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $business->address) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required />
                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Right Section: Address, City, and Description -->
            <div class="bg-white shadow-md rounded-lg p-6 md:w-1/2 w-full">
                <!-- City -->
                <div class="mb-4">
                    <label for="city" class="block text-sm font-medium text-gray-700">City *</label>
                    <select id="city" name="city" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                        <option value="" disabled>{{ __('Select City') }}</option>
                        @if(old('city', $business->city))
                            <option value="{{ old('city', $business->city) }}" selected>{{ old('city', $business->city) }}</option>
                        @endif
                    </select>
                    @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                    <textarea id="description" name="description" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" rows="5">{{ old('description', $business->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Business Image Upload -->
                <div class="mb-4">
                    <x-input-label for="business_image" :value="__('Business Image')" />
                    <x-upload-avatar 
                        name="business_image" 
                        currentImage="{{ $business->image_path ? Storage::url($business->image_path) : null }}" 
                    />
                    @error('business_image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end mt-6">
                    <x-button>
                        Save Changes
                    </x-button>
                </div>
            </div>
        </form>
    </div>
</x-business-layout>

<!-- JavaScript to Handle Country Selection and Load Cities -->
<script>
        document.getElementById('country').addEventListener('change', function() {
            var countryCode = this.value;
            var citySelect = document.getElementById('city');
            
            // Clear existing options
            citySelect.innerHTML = '<option value="" disabled selected>{{ __("Select City") }}</option>';

            if (countryCode) {
                fetch(`/get-cities/${countryCode}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(city => {
                            var option = document.createElement('option');
                            option.value = city;
                            option.textContent = city;
                            citySelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching cities:', error));
            }
        });
    </script>
