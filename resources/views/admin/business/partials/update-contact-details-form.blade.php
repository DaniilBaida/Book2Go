<form method="POST" action="{{ route('admin.businesses.update-contact', $business->id) }}">
    @csrf
    @method('PATCH')

    <div class="flex flex-col gap-y-4">
        <!-- Phone Number -->
        <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input 
                type="text" 
                name="phone_number" 
                id="phone_number" 
                value="{{ old('phone_number', $business->phone_number) }}" 
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            >
            @error('phone_number')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Address -->
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input 
                type="text" 
                name="address" 
                id="address" 
                value="{{ old('address', $business->address) }}" 
                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            >
            @error('address')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Country Dropdown -->
        <div>
            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
            <select 
                id="country" 
                name="country" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                onchange="fetchCities(this.value)"
            >
                <option value="">Select a Country</option>
                @foreach (config('countries') as $country)
                    <option 
                        value="{{ $country['code'] }}" 
                        {{ old('country', $business->country) === $country['code'] ? 'selected' : '' }}
                    >
                        {{ $country['name'] }}
                    </option>
                @endforeach
            </select>
            @error('country')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- City Dropdown -->
        <div>
            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
            <select 
                id="city" 
                name="city" 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
            >
                <option value="{{ $business->city }}" selected>{{ $business->city }}</option>
            </select>
            @error('city')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded">Update Contact Details</button>
    </div>
</form>

<script>
    async function fetchCities(countryCode) {
        const citySelect = document.getElementById('city');
        citySelect.innerHTML = '<option value="">Loading...</option>';
        if (countryCode) {
            try {
                const response = await fetch(`/get-cities/${countryCode}`);
                const cities = await response.json();
                citySelect.innerHTML = '<option value="">Select a City</option>';
                cities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city;
                    option.textContent = city;
                    citySelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching cities:', error);
                citySelect.innerHTML = '<option value="">Error loading cities</option>';
            }
        } else {
            citySelect.innerHTML = '<option value="">Select a City</option>';
        }
    }
</script>