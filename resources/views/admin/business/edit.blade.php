<x-admin-layout>
    <div class="flex flex-col gap-y-5">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <h1 class="text-3xl text-gray-800 font-bold">Edit Business</h1>
        </div>
        <div class="flex flex-col space-y-8 w-full">
            <!-- Update Business Logo -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('admin.business.partials.update-logo-form')
                </div>
            </div>

            <!-- Update Business Information -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('admin.business.partials.update-business-information-form')
                </div>
            </div>

            <!-- Update Business Contact Details -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('admin.business.partials.update-contact-details-form')
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>