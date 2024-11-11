<x-guest-layout>
    <form method="POST" action="{{ route('business.setup.storeStepTwo') }}" enctype="multipart/form-data">
        @csrf
        <h2 class="text-xl font-bold mb-4">Step 2: Additional Business Details</h2>

        <!-- Description -->
        <div>
            <x-input-label for="description" :value="__('Business Description')" />
            <textarea id="description" class="block mt-1 w-full" name="description" rows="5" autofocus>
                {{ old('description') }}
            </textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Logo Upload -->
        <div class="mt-4">
            <x-input-label for="logo_path" :value="__('Business Logo')" />
            <input id="logo_path" class="block mt-1 w-full" type="file" name="logo_path" accept="image/*" />
            <x-input-error :messages="$errors->get('logo_path')" class="mt-2" />
        </div>

        <!-- Complete Setup Button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Complete Setup') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
