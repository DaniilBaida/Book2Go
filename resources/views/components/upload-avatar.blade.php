@props(['name', 'currentImage' => null])

<div class="relative">
    <!-- Hidden file input -->
    <input 
        type="file" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        accept="image/*" 
        class="hidden" 
        onchange="previewImage(event, '{{ $name }}')">

    <!-- Image preview or existing image -->
    <div 
        class="border-dashed border-2 border-gray-300 rounded-lg flex items-center justify-center w-full h-48 cursor-pointer relative"
        onclick="document.getElementById('{{ $name }}').click()">
        <img 
            id="preview-{{ $name }}" 
            src="{{ $currentImage ? asset($currentImage) : '' }}" 
            alt="Image Preview" 
            class="object-cover max-w-full max-h-40 rounded-lg {{ $currentImage ? '' : 'hidden' }}" />

        <!-- Text to prompt upload if no image exists -->
        <div id="placeholder-{{ $name }}" class="absolute inset-0 flex flex-col items-center justify-center text-gray-500 {{ $currentImage ? 'hidden' : '' }}">
            <p class="text-sm">Click to upload</p>
            <p class="text-xs">SVG, PNG, JPG (MAX. 2MB)</p>
        </div>
    </div>

    <!-- Error message -->
    @error($name)
    <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>

<script>
    function previewImage(event, name) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                // Update the image preview
                const preview = document.getElementById('preview-' + name);
                preview.src = e.target.result;
                preview.classList.remove('hidden');

                // Hide the placeholder
                const placeholder = document.getElementById('placeholder-' + name);
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            };
            reader.readAsDataURL(file);
        }
    }
</script>
