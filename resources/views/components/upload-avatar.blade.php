<div class="flex items-center justify-center w-full">
    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
            </svg>
            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
            <p class="text-xs text-gray-500">SVG, PNG or JPG (MAX. 2048MB)</p>
        </div>
        <input id="dropzone-file" type="file" class="hidden" name="avatar_path" />
    </label>
</div>

<x-input-error :messages="$errors->get('avatar_path')" class="mt-2" />

<div class="flex items-center gap-4 mt-4">
    <!-- Botão de envio do formulário -->
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none">
        {{ __('Save') }}
    </button>

    @if (session('status') === 'avatar-updated')
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-green-500"
        >{{ __('Saved.') }}</p>
    @endif
</div>
