<x-business-layout>
    <h1 class="text-3xl text-gray-800 font-bold mb-5">Edit Reply</h1>
    <div class="p-6 bg-white shadow-sm sm:rounded-lg">
        <form action="{{ route('business.replies.update', $reply->id) }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="mb-4">
                <label for="content" class="block text-sm font-medium text-gray-700">Reply Content</label>
                <textarea
                    id="content"
                    name="content"
                    rows="4"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    required
                >{{ old('content', $reply->content) }}</textarea>
                @error('content')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="flex justify-end">
                <x-button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white">Update Reply</x-button>
                <a href="{{ route('business.reviews.index') }}" class="ml-3 text-blue-500 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</x-business-layout>
