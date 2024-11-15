<x-business-layout>
    <div class="flex flex-col gap-y-5">
        <h1 class="text-3xl text-gray-800 font-bold">Business Details</h1>

        <!-- Display business details -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold">Business Information</h2>
            <ul class="mt-4 space-y-2">
                <li><strong>Name:</strong> {{ $business->name }}</li>
                <li><strong>Email:</strong> {{ $business->email }}</li>
                <li><strong>Phone Number:</strong> {{ $business->phone_number }}</li>
                <li><strong>Address:</strong> {{ $business->address }}</li>
                <li><strong>City:</strong> {{ $business->city }}</li>
                <li><strong>Postal Code:</strong> {{ $business->postal_code }}</li>
                <li><strong>Country:</strong> {{ $business->country }}</li>
                <li><strong>Description:</strong> {{ $business->description }}</li>
            </ul>

            <div class="mt-6">
                <a href="{{ route('business.details.edit') }}" class="ajax-link px-4 py-2 bg-blue-500 text-white rounded-md">
                    Edit Details
                </a>
            </div>
        </div>
    </div>
</x-business-layout>
