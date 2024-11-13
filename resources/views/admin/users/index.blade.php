<x-admin-layout>
    <div class="px-4 py-8 max-w-8xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <h1 class="text-3xl text-gray-800 font-bold mb-10">User Management</h1>
        </div>
        <div class="flex flex-col space-y-8 w-full">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    @include('admin.users.partials.user-table', ['users' => $users])
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
