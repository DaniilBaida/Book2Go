<form method="POST" action="{{ route('admin.businesses.update-logo', $business->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div class="mb-4">
        <label for="logo" class="block text-sm font-medium text-gray-700">Business Logo</label>
        <input type="file" name="logo" id="logo" class="mt-1 block w-full" required>
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Logo</button>
</form>