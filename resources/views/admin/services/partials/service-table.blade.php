<div class="relative overflow-x-auto sm:rounded-lg">
    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text" id="table-search-services" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search for services">
        </div>
    </div>

    <table class="w-full text-sm text-left text-gray-500 mb-4">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3">Service Name</th>
            <th scope="col" class="px-6 py-3">Category</th>
            <th scope="col" class="px-6 py-3">Price</th>
            <th scope="col" class="px-6 py-3">Duration</th>
            <th scope="col" class="px-6 py-3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($services as $service)
            <tr class="bg-white border-b hover:bg-gray-50">
                <th scope="row" class="px-6 py-4 text-gray-900 whitespace-nowrap">
                    <div class="font-semibold">{{ $service->name }}</div>
                    <div class="text-gray-500">{{ $service->description }}</div>
                </th>
                <td class="px-6 py-4">{{ $service->category->name }}</td>
                <td class="px-6 py-4">€{{ number_format($service->price, 2) }}</td>
                <td class="px-6 py-4">{{ $service->duration_minutes }} minutes</td>
                <td class="px-6 py-4 items-center">
                    <!-- View Details Button -->
                    <a href="{{ route('admin.services.show', $service->id) }}" class="font-medium text-blue-600 inline-block">
                        <div class="hover:bg-gray-200 rounded-md p-0.5 transition">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </div>
                    </a>

                    <!-- Delete Button to Trigger Modal -->
                    <button onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-confirmation-{{ $service->id }}' }))"
                            class="font-medium text-red-600 inline-block">
                        <div class="hover:bg-gray-200 rounded-md p-0.5 transition">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                            </svg>
                        </div>
                    </button>

                    <!-- Delete Confirmation Modal -->
                    <x-modal name="delete-confirmation-{{ $service->id }}" :show="false" maxWidth="md">
                        <div class="p-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                Are you sure you want to delete {{ $service->name }}?
                            </h2>
                            <p class="mt-2 text-sm text-gray-600">
                                This action cannot be undone.
                            </p>

                            <div class="mt-6 flex justify-end">
                                <!-- Cancel Button -->
                                <button x-on:click="show = false"
                                        class="py-2 px-4 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                    Cancel
                                </button>

                                <!-- Confirm Deletion Form -->
                                <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" class="ml-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="py-2 px-4 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        Yes, delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </x-modal>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $services->links('vendor.pagination.tailwind') }}
</div>
