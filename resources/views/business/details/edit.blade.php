<x-business-layout>
    <div class="px-4 py-8 max-w-8xl mx-auto">
        <div class="flex flex-col space-y-8 w-full">
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

                    <div class="form-group">
                        <label for="city" class="block">City</label>
                        <input type="text" id="city" name="city" value="{{ old('city', $business->city) }}" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="postal_code" class="block">Postal Code</label>
                        <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $business->postal_code) }}" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label for="country" class="block">Country</label>
                        <input type="text" id="country" name="country" value="{{ old('country', $business->country) }}" class="form-input" required>
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
    </div>
</x-business-layout>
