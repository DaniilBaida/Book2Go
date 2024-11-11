<x-guest-layout>
    <form method="POST" action="{{ route('business.setup.storeStepTwo') }}">
        @csrf
        <h2 class="text-xl font-bold mb-4">Step 2: City</h2>

        <div class="mb-4">
            <label for="city" class="block text-gray-700">City</label>
            <input type="text" id="city" name="city" class="border rounded w-full p-2 mt-1" required>
        </div>


        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Next Step') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
