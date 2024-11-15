<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-5">
        <h1 class="text-3xl font-bold">User Management</h1>
    </div>
    <div class="flex flex-col space-y-8 w-full">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div>
                @include('admin.users.partials.user-table', ['users' => $users])
            </div>
        </div>
    </div>
</x-admin-layout>
