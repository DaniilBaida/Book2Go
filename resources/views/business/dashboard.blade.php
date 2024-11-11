<x-business-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as a Business Owner!") }}
                </div>
            </div>
            
            <!-- Displaying Company Information -->
            <div class="bg-white shadow-sm sm:rounded-lg mt-6 p-6">
                <h3 class="text-lg font-semibold text-blue-600 mb-4">Company Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <strong>Company Name:</strong> {{ $businessProfile->company_name ?? 'Not provided' }}
                    </div>
                    <div>
                        <strong>Location:</strong> {{ $businessProfile->location ?? 'Not provided' }}
                    </div>
                    <div>
                        <strong>Operating Hours:</strong> {{ $businessProfile->operating_hours ?? 'Not provided' }}
                    </div>
                    <div>
                        <strong>Company Logo:</strong>
                        @if($businessProfile && $businessProfile->company_logo)
                            <img src="{{ $businessProfile->company_logo }}" alt="Company Logo" class="h-16 mt-2">
                        @else
                            No logo uploaded
                        @endif
                    </div>
                    <div>
                        <strong>Service Category:</strong> {{ $businessProfile->service_category ?? 'Not provided' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-business-layout>
