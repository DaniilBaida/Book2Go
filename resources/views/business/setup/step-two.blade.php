<x-guest-layout>
    <form method="POST" action="{{ route('business.setup.storeStepTwo') }}" enctype="multipart/form-data">
        @csrf
        <h2 class="text-xl font-bold mb-4">Step 2: Additional Business Details</h2>

        <!-- Description -->
        <div>
            <x-input-label for="description" :value="__('Business Description')" />
            <textarea id="description" class="block mt-1 w-full rounded-lg resize-none border-zinc-300" name="description" rows="5" autofocus>{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Business Logo Upload -->
        <div class="mt-4">
            <x-input-label for="logo_path" :value="__('Business Logo')" />
            <x-upload-business-logo />
        </div>

        <!-- Complete Setup and Back to Step 1 Buttons -->
        <div class="flex items-center justify-between mt-4">
            
            <!-- Complete Setup Button -->
            <x-button>
                {{ __('Complete Setup') }}
            </x-button>

            <!-- Back to Step 1 Button -->
            <a href="{{ route('business.setup.stepOne') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300">
                {{ __('Back') }}
            </a>
        </div>
    </form>
</x-guest-layout>
