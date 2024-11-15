<x-admin-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Service Management Heading -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-5">
            <h1 class="text-3xl font-bold">Manage Business Services</h1>
        </div>

        <!-- Service Table -->
        <div class="flex flex-col space-y-8 w-full">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    @include('admin.services.partials.service-table', ['services' => $services])
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
