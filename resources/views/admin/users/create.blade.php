<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="px-4 py-8 max-w-8xl mx-auto">
        <div class="flex flex-col space-y-8 w-full">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('admin.profile.partials.update-avatar')
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
