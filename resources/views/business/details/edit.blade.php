<x-business-layout>
    <div class="flex flex-col gap-y-5">
        <h1 class="text-3xl text-gray-800 font-bold">Edit Business Details</h1>

        <form action="{{ route('business.details.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Input fields for business details -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="name" class="block">Business Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $business->name) }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="email" class="block">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $business->email) }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="phone_number" class="block">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $business->phone_number) }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="address" class="block">Address</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $business->address) }}" class="form-input" required>
                </div>

                <!-- Country Dropdown -->
                <div class="form-group">
                    <x-input-label for="country">{{ __('Country') }}</x-input-label>
                    <select id="country" name="country" class="form-input block w-full p-2.5 bg-gray-50 border text-gray-900 text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                        <option value="" disabled>{{ __('Select Country') }}</option>
                        @foreach(config('countries') as $country)
                            <option value="{{ $country['code'] }}" {{ old('country', $business->country) == $country['code'] ? 'selected' : '' }}>{{ $country['name'] }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('country')" class="mt-2" />
                </div>

                <!-- City Dropdown -->
                <div class="form-group">
                    <x-input-label for="city">{{ __('City') }}</x-input-label>
                    <select id="city" name="city" class="form-input block w-full p-2.5 bg-gray-50 border text-gray-900 text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                        <option value="" disabled>{{ __('Select City') }}</option>
                        @if(old('city', $business->city))
                            <option value="{{ old('city', $business->city) }}" selected>{{ old('city', $business->city) }}</option>
                        @endif
                    </select>
                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                </div>

                <div class="form-group">
                    <label for="postal_code" class="block">Postal Code</label>
                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $business->postal_code) }}" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="description" class="block">Description</label>
                    <textarea id="description" name="description" class="form-input">{{ old('description', $business->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="logo_path" class="block">Business Logo (optional)</label>
                    <input type="file" id="logo_path" name="logo_path" class="form-input">
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md">Save Changes</button>
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
