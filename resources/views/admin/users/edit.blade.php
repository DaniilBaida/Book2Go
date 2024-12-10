<x-admin-layout>
    <div class="flex flex-col gap-y-5">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <h1 class="text-3xl text-gray-800 font-bold">Edit User</h1>
        </div>
        <div class="flex flex-col space-y-8 w-full">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('admin.users.partials.update-user-information-form')
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('admin.users.partials.edit-user-password')
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
