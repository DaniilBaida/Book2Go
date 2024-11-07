<x-guest-layout>
    <form method="POST" action="{{ route('business.setup.storeStepOne') }}" enctype="multipart/form-data">
        @csrf
        <h2 class="text-xl font-bold mb-4">Step 1: Company Name and Logo</h2>

        <!-- Campo para Nome da Empresa -->
        <div class="mb-4">
            <label for="company_name" class="block text-gray-700">Company Name</label>
            <input type="text" id="company_name" name="company_name" class="border rounded w-full p-2 mt-1" required>
        </div>

        <!-- Campo para Upload do Logo -->
        <div class="mb-4">
            <label for="logo" class="block text-gray-700">Company Logo</label>
            <input type="file" id="logo" name="logo" class="border rounded w-full p-2 mt-1" accept="image/*">
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Next Step') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
