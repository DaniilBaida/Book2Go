<x-guest-layout>
    <form method="POST" action="{{ route('business.setup.storeStepTwo') }}">
        @csrf
        <h2 class="text-xl font-bold mb-4">Step 2: Location and Operating Hours</h2>

        <!-- Campo para Localização -->
        <div class="mb-4">
            <label for="location" class="block text-gray-700">Location</label>
            <input type="text" id="location" name="location" class="border rounded w-full p-2 mt-1" required>
        </div>

        <!-- Campo para Horário de Funcionamento -->
        <div class="mb-4">
            <label for="operating_hours" class="block text-gray-700">Operating Hours</label>
            <input type="text" id="operating_hours" name="operating_hours" placeholder="e.g., Mon-Fri 9am-5pm" class="border rounded w-full p-2 mt-1" required>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Next Step') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
