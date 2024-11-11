<x-guest-layout>
    <form method="POST" action="{{ route('business.setup.storeStepOne') }}" enctype="multipart/form-data">
        @csrf
        <h2>Setup da Empresa - Passo 1</h2>
        
        <!-- Company Name -->
        <div>
            <x-input-label for="company_name" :value="__('Company Name')" />
            <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" required />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <!-- Company Logo Upload -->
        <div class="mt-4">
            <label for="company_logo" class="block text-sm font-medium text-gray-700">Company Logo</label>
            <input type="file" id="company_logo" name="company_logo" class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100" />
            <x-input-error :messages="$errors->get('company_logo')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
            <x-primary-button>
                {{ __('Next Step') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
