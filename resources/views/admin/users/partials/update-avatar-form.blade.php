<form action="{{ route('admin.users.update-avatar', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="avatar">Alterar Avatar:</label>
    <input type="file" name="avatar" id="avatar" required class="mt-1 block w-full">
    <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">Atualizar Avatar</button>
</form>
