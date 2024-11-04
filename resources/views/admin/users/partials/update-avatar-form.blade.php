<form action="{{ route('admin.users.update-avatar', ['user' => $user->id]) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <div>
        <x-upload-avatar />
    </div>
</form>
