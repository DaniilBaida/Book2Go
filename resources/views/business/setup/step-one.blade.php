<x-guest-layout>
    <form method="POST" action="{{ route('business.setup.storeStepOne') }}" enctype="multipart/form-data">
        @csrf
        <h2 class="text-xl font-bold mb-4">Step 1: Basic Business Information</h2>

        <!-- Business Name -->
        <div>
            <x-input-label for="name" :value="__('Business Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="organization" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Business Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Address Line 1 -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Street Address')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autocomplete="address-line1" />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

            @csrf
            <!-- Country Dropdown -->
            <div class="mt-4">
                <x-input-label for="country">{{ __('Country') }}</x-input-label>
                <select id="country" name="country" class="block w-full p-2.5 bg-gray-50 border text-gray-900 text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                    <option value="" disabled selected>{{ __('Select Country') }}</option>
                    @foreach(config('countries') as $country)
                        <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('country')" class="mt-2" />
            </div>

            <!-- City Dropdown -->
            <div class="mt-4">
                <x-input-label for="city">{{ __('City') }}</x-input-label>
                <select id="city" name="city" class="block w-full p-2.5 bg-gray-50 border text-gray-900 text-sm border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                    <option value="" disabled selected>{{ __('Select City') }}</option>
                </select>
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>

        <!-- Postal Code -->
        <div class="mt-4">
            <x-input-label for="postal_code" :value="__('Postal Code')" />
            <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')" required autocomplete="postal-code" />
            <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
        </div>

        <!-- Next Step Button -->
        <div class="flex items-center justify-end mt-4">
            <x-button>
                {{ __('Next Step') }}
            </x-button>
        </div>
    </form>
</x-guest-layout>

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
