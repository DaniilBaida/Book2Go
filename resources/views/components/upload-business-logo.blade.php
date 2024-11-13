<div class="flex items-center justify-center w-full">
    <label for="business-logo-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer">
        <div id="preview-container" class="flex flex-col items-center justify-center pt-5 pb-6 w-full h-full">
            <!-- Preview Image Placeholder -->
            <img id="image-preview" src="#" alt="Image Preview" class="hidden w-auto max-h-full h-auto object-contain rounded-lg" />
            
            <!-- Default Upload Prompt -->
            <div id="default-upload" class="flex flex-col items-center">
                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                </svg>
                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                <p class="text-xs text-gray-500">SVG, PNG, or JPG (MAX. 2048MB)</p>
            </div>
        </div>
        <input id="business-logo-file" type="file" class="hidden" name="logo_path" accept="image/*" onchange="previewImage(event)" />
    </label>
</div>

<x-input-error :messages="$errors->get('logo_path')" class="mt-2" />
