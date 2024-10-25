<div class="relative overflow-x-auto sm:rounded-lg">
    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search for users">
        </div>
    </div>

    <table class="w-full text-sm text-left text-gray-500 ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3">Name</th>
            <th scope="col" class="px-6 py-3">Email</th>
            <th scope="col" class="px-6 py-3">Email Verified</th>
            <th scope="col" class="px-6 py-3">Role</th>
            <th scope="col" class="px-6 py-3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr class="bg-white border-b hover:bg-gray-50">
                <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                    <img class="w-10 h-10 rounded-full" src="{{ asset($user->avatar_path) }}" alt="{{ $user->name }}">
                    <div class="ps-3">
                        <div class="text-base font-semibold">{{ $user->name }}</div>
                        <div class="font-normal text-gray-500">{{ $user->email }}</div>
                    </div>
                </th>
                <td class="px-6 py-4">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="h-2.5 w-2.5 rounded-full {{ $user->email_verified_at ? 'bg-green-500' : 'bg-red-500' }} me-2"></div>
                        {{ $user->email_verified_at ? 'Yes' : 'No' }}
                    </div>
                </td>
                <td class="px-6 py-4">{{ $user->role->name }}</td>
                <td class="px-6 py-4 items-center">
                    <!-- Show Details Button -->
                    <a href="{{ route('admin.users.show', $user->id) }}" class="font-medium text-blue-600 inline-block">
                        <div class="hover:bg-gray-200 rounded-md p-0.5 transition">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </div>
                    </a>

                    <!-- Edit Button -->
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="font-medium text-yellow-500 inline-block">
                        <div class="hover:bg-gray-200 rounded-md p-0.5 transition">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.441 1.559a1.907 1.907 0 0 1 0 2.698l-6.069 6.069L10 19l.674-3.372 6.07-6.07a1.907 1.907 0 0 1 2.697 0Z"/>
                            </svg>
                        </div>
                    </a>

                    <!-- Delete Button to Trigger Modal -->
                    <button onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-confirmation-{{ $user->id }}' }))"
                            class="font-medium text-red-600 inline-block">
                        <div class="hover:bg-gray-200 rounded-md p-0.5 transition">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                            </svg>
                        </div>
                    </button>

                    <!-- Delete Confirmation Modal -->
                    <x-modal name="delete-confirmation-{{ $user->id }}" :show="false" maxWidth="md">
                        <div class="p-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                Are you sure you want to delete {{ $user->name }}?
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
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="ml-3">
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

    <!-- Pagination -->
    <nav class="flex items-center justify-between pt-4" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500">
            Showing <span class="font-semibold text-gray-900">{{ $users->firstItem() }}</span> to
            <span class="font-semibold text-gray-900">{{ $users->lastItem() }}</span> of
            <span class="font-semibold text-gray-900">{{ $users->total() }}</span>
        </span>

        <ul class="inline-flex -space-x-px text-sm h-8">
            <!-- Previous Link -->
            @if ($users->onFirstPage())
                <li>
                    <span class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 rounded-s-lg">Previous</span>
                </li>
            @else
                <li>
                    <a href="{{ $users->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                </li>
            @endif

            <!-- Page Links -->
            @for ($page = 1; $page <= $users->lastPage(); $page++)
                @if ($page == $users->currentPage())
                    <li>
                        <span class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50">{{ $page }}</span>
                    </li>
                @else
                    <li>
                        <a href="{{ $users->url($page) }}" class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            <!-- Next Link -->
            @if ($users->hasMorePages())
                <li>
                    <a href="{{ $users->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
                </li>
            @else
                <li>
                    <span class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 rounded-e-lg">Next</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
