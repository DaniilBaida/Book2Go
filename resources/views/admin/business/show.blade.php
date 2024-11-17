<x-admin-layout>
    <div class="flex flex-col gap-y-5">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <h1 class="text-3xl text-gray-800 font-bold">Business Details</h1>
        </div>
        <div class="flex flex-col space-y-8 w-full">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl space-y-4">
                    <div>
                        <h2 class="text-lg font-semibold">Name:</h2>
                        <p class="text-gray-700">{{ $business->name }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">Email:</h2>
                        <p class="text-gray-700">{{ $business->email }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">Phone Number:</h2>
                        <p class="text-gray-700">{{ $business->phone_number }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">Address:</h2>
                        <p class="text-gray-700">{{ $business->address }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">City:</h2>
                        <p class="text-gray-700">{{ $business->city }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">Country:</h2>
                        <p>{{ collect(config('countries'))->firstWhere('code', $business->country)['name'] ?? $business->country }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">Postal Code:</h2>
                        <p class="text-gray-700">{{ $business->postal_code }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">Operating Hours:</h2>
                        <p class="text-gray-700">{{ $business->operating_hours }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">Setup Complete:</h2>
                        <p class="text-gray-700">{{ $business->setup_complete ? 'Yes' : 'No' }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">Created At:</h2>
                        <p class="text-gray-700">{{ $business->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold">Updated At:</h2>
                        <p class="text-gray-700">{{ $business->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>