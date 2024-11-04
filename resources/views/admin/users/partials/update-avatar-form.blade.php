<form action="{{ route('admin.users.update-avatar', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div>
        <label for="avatar">Upload New Avatar:</label>
        <input type="file" name="avatar" id="avatar" required>
    </div>
    <button type="submit">Update Avatar</button>
</form>
