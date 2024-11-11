<x-guest-layout>
    <form method="POST" action="{{ route('business.setup.storeStepOne') }}" enctype="multipart/form-data">
        @csrf
        <h2 class="text-xl font-bold mb-4">Step 1: Company Name and Logo</h2>

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Company Name</label>
            <input type="text" id="name" name="name" class="border rounded w-full p-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label for="logo_path" class="block text-gray-700">Company Logo</label>
            <input type="file" id="logo_path" name="logo_path" class="border rounded w-full p-2 mt-1" accept="image/*">
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Next Step') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
