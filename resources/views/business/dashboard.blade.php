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

            <!-- Informações da Empresa -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4 text-blue-600">Company Information</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nome da Empresa -->
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Company Name:</p>
                            <p class="text-gray-800">{{ Auth::user()->company_name ?? 'Not provided' }}</p>
                        </div>

                        <!-- Localização -->
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Location:</p>
                            <p class="text-gray-800">{{ Auth::user()->location ?? 'Not provided' }}</p>
                        </div>

                        <!-- Horário de Funcionamento -->
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Operating Hours:</p>
                            <p class="text-gray-800">{{ Auth::user()->operating_hours ?? 'Not provided' }}</p>
                        </div>

                        <!-- Logo da Empresa -->
                        <div class="flex flex-col items-start">
                            <p class="text-lg font-semibold text-gray-700">Company Logo:</p>
                            @if(Auth::user()->company_logo)
                                <img src="{{ Auth::user()->company_logo }}" alt="Company Logo" class="mt-2 w-32 h-32 rounded-full border">
                            @else
                                <p class="text-gray-800">No logo uploaded</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-business-layout>
