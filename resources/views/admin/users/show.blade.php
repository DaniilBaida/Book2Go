<x-admin-layout>
    <div class="flex flex-col gap-y-5">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <h1 class="text-3xl text-gray-800 font-bold">User Details</h1>
        </div>
        <div class="flex flex-col space-y-8 w-full">
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl space-y-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Basic Information</h3>
                        <div class="flex items-center space-x-2">
                            <p class="font-medium text-lg text-gray-800">
                                {{ $user->first_name }} {{ $user->last_name }}
                            </p>
                            @if($user->is_verified)
                                <span class="relative flex items-center justify-center w-5 h-5 rounded-full bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 p-0.5">
                                    <div class="flex items-center justify-center w-full h-full bg-white rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Contact Details</h3>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Phone:</strong> {{ $user->phone_number ?? 'Not provided' }}</p>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Verification Status</h3>
                        <span class="px-3 py-1 text-sm rounded-full font-medium
                            {{ $user->email_verified_at ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <a href="{{ url()->previous() }}">
                <x-button>
                    Back
                </x-button>
            </a>
        </div>
    </div>
</x-admin-layout>
