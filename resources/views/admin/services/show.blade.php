<x-admin-layout>
    <div class="flex flex-col gap-y-5">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold">{{ $service->name }}</h3>
                    <a href="{{ route('admin.services.index') }}" class="border-2 rounded-full border-gray-800
                    hover:bg-gray-800 duration-300 group">
                        <i class="fa fa-arrow-left p-2 text-gray-800 group-hover:text-white" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="mt-6 space-y-4">
                    <div><strong class="text-gray-700">{{ __('Category') }}:</strong> <span>{{ $service->category->name }}</span></div>
                    <div><strong class="text-gray-700">{{ __('Price') }}:</strong> <span>€{{ number_format($service->price, 2) }}</span></div>
                    <div><strong class="text-gray-700">{{ __('Duration') }}:</strong> <span>{{ $service->duration_minutes }} {{ __('minutes') }}</span></div>
                    <div><strong class="text-gray-700">{{ __('Description') }}:</strong> <p class="mt-2">{{ $service->description }}</p></div>
                    <div><strong class="text-gray-700">{{ __('Status') }}:</strong>
                        <span class="px-2 py-1 rounded-full {{ $service->status === 'active' ? 'bg-green-100 text-green-800' : ($service->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($service->status) }}
                        </span>
                    </div>
                </div>

                <!-- Delete Button with Text Triggering Modal -->
                <div class="mt-6 flex space-x-4">
                    <button onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-confirmation-{{ $service->id }}' }))"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                        Delete Service
                    </button>
                </div>

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
            </div>
        </div>
    </div>
</x-admin-layout>
