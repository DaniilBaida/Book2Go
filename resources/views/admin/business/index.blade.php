<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-5">
        <h1 class="text-3xl font-bold">Business Management</h1>
    </div>
    <div class="flex flex-col space-y-8 w-full">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div>
                @include('admin.business.partials.business-table', ['businesses' => $businesses])
            </div>
        </div>
    </div>
</x-admin-layout>