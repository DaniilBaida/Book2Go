<x-admin-layout>
    <div class="flex flex-col gap-y-5">
        <!-- Heading -->
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-5">
            <h1 class="text-3xl font-bold">Manage Discount Codes</h1>
            <a href="{{ route('admin.discounts.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Create Discount Code
            </a>
        </div>

        <!-- Search and Table -->
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <!-- Sucesso -->
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 bg-green-200 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search Bar -->
            <form method="GET" action="{{ route('admin.discounts.index') }}" class="flex items-center mb-4 space-x-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search discount codes"
                    class="border rounded-lg px-4 py-2 w-64 focus:ring-2 focus:ring-blue-500"
                />
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Search
                </button>
            </form>

            <!-- Table -->
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">Code</th>
                            <th class="px-6 py-3">Type</th>
                            <th class="px-6 py-3">Value</th>
                            <th class="px-6 py-3">Max Uses</th>
                            <th class="px-6 py-3">Current Uses</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Expires At</th>
                            <th class="px-6 py-3">Created By</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($discountCodes as $code)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $code->code }}</td>
                                <td class="px-6 py-4">{{ ucfirst($code->type) }}</td>
                                <td class="px-6 py-4">{{ $code->value }}</td>
                                <td class="px-6 py-4">{{ $code->max_uses ?? 'Unlimited' }}</td>
                                <td class="px-6 py-4">{{ $code->uses }}</td>
                                <td class="px-6 py-4">{{ ucfirst($code->status) }}</td>
                                <td class="px-6 py-4">
                                    {{ $code->expires_at ? \Carbon\Carbon::parse($code->expires_at)->format('Y-m-d') : 'No Expiry' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($code->admin_id)
                                        Admin
                                    @elseif($code->business)
                                        {{ $code->business->name }}
                                    @else
                                        Unknown
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('admin.discounts.edit', $code->id) }}" class="text-yellow-500 hover:underline">Edit</a>
                                    <button onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-confirmation-{{ $code->id }}' }))"
                                            class="text-red-600 hover:underline">
                                        Delete
                                    </button>

                                    <!-- Delete Confirmation Modal -->
                                    <x-modal name="delete-confirmation-{{ $code->id }}" :show="false" maxWidth="md">
                                        <div class="p-6">
                                            <h2 class="text-lg font-medium text-gray-900">
                                                Are you sure you want to delete the discount code "{{ $code->code }}"?
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
                                                <!-- Confirm Delete Form -->
                                                <form method="POST" action="{{ route('admin.discounts.destroy', $code->id) }}" class="ml-3">
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
            </div>

            <!-- Paginação -->
            <div class="mt-6">
                {{ $discountCodes->links('vendor.pagination.tailwind') }}
                {{ $discountCodes->appends(['search' => request('search')])->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-admin-layout>
