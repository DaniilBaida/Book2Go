<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile avatar") }}
        </p>

    </header>
    <form action="{{ route('admin.users.update-avatar', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div>
            <label for="avatar">Upload New Avatar:</label>
            <input type="file" name="avatar" id="avatar" required>
        </div>
        <button type="submit">Update Avatar</button>
    </form>

</section>
