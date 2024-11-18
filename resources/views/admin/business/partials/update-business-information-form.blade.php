<form method="POST" action="{{ route('admin.businesses.update-general-info', $business->id) }}">
    @csrf
    @method('PATCH')
    <div class="flex flex-col gap-y-2">
        <label class="text-sm font-semibold" for="name">Business Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $business->name) }}" class="border rounded px-3 py-2">
        @error('name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        <label class="text-sm font-semibold mt-4" for="description">Description</label>
        <textarea name="description" id="description" class="border rounded px-3 py-2">{{ old('description', $business->description) }}</textarea>
        @error('description')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        <button type="submit" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded">Update Information</button>
    </div>
</form>