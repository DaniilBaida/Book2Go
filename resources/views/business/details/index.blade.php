<x-business-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Display business details -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6">Overview</h1>
            
            <div class="flex gap-5 items-center mb-8">
                <!-- Avatar Section -->
                @if($business->avatar_path)
                    <img src="{{ asset('storage/' . $business->avatar_path) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover">
                @else
                    <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">
                        No Avatar
                    </div>
                @endif

                <!-- Business Name and Description -->
                <div>
                    <h2 class="text-2xl font-bold">{{ $business->name }}</h2>
                    <p class="text-gray-600">{{ $business->description }}</p>
                </div>
            </div>

            <h3 class="text-2xl font-bold mb-4">Business, Administrative & Contact Information</h3>

            <!-- Business details -->
            <table class="w-full border-collapse border border-gray-300">
                <tbody>
                    <tr class="bg-gray-100">
                        <td class="p-2 font-semibold text-gray-800 border border-gray-300">Registered Business Name</td>
                        <td class="p-2 text-gray-700 border border-gray-300">{{ $business->name }}</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="p-2 font-semibold text-gray-800 border border-gray-300">Phone Number</td>
                        <td class="p-2 text-gray-700 border border-gray-300">{{ $business->phone_number }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td class="p-2 font-semibold text-gray-800 border border-gray-300">E-mail</td>
                        <td class="p-2 text-gray-700 border border-gray-300">{{ $business->email }}</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="p-2 font-semibold text-gray-800 border border-gray-300">Country</td>
                        <td class="p-2 text-gray-700 border border-gray-300">{{ $business->country }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td class="p-2 font-semibold text-gray-800 border border-gray-300">City</td>
                        <td class="p-2 text-gray-700 border border-gray-300">{{ $business->city }}</td>
                    </tr>
                    <tr class="bg-gray-50">
                        <td class="p-2 font-semibold text-gray-800 border border-gray-300">Physical Address</td>
                        <td class="p-2 text-gray-700 border border-gray-300">{{ $business->address }}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td class="p-2 font-semibold text-gray-800 border border-gray-300">Postal Code</td>
                        <td class="p-2 text-gray-700 border border-gray-300">{{ $business->postal_code }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-6">
                <a href="{{ route('business.details.edit') }}">
                    <x-button>Edit Details</x-button>
                </a>
            </div>
        </div>
    </div>
</x-business-layout>
