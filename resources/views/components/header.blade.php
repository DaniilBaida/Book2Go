<header
    x-data="{ notificationsOpen: false }"
    class="sticky top-0 before:absolute before:inset-0 before:backdrop-blur-md max-lg:before:bg-white/90 before:-z-10 z-30 max-lg:shadow-sm lg:before:bg-gray-100/90"
>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:border-b border-gray-200">
            <!-- Header: Left side -->
            <div class="flex items-center">
                <button
                    class="text-gray-500 hover:text-gray-600 lg:hidden"
                    @click.stop="sidebarOpen = !sidebarOpen"
                    aria-controls="sidebar"
                    :aria-expanded="sidebarOpen"
                >
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars w-6 h-6 fill-current"></i>
                </button>

                @if(Auth::user()->business && Auth::user()->business->setup_complete)
                    <hr class="hidden sm:flex lg:hidden w-px h-6 bg-gray-200 border-none mx-5" />
                    <div class="hidden sm:flex text-gray-500 font-medium text-sm gap-2 items-center">
                        <i class="fa-solid fa-building"></i>
                        <div>{{ Auth::user()->business->name }}</div>
                    </div>
                @endif
            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <!-- Notification Bell Icon -->
                    <button class="relative text-gray-500 hover:text-gray-600" @click="notificationsOpen = !notificationsOpen">
                        <i class="fas fa-bell w-6 h-6"></i>

                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-500 rounded-full"></span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div
                        x-show="notificationsOpen"
                        @click.away="notificationsOpen = false"
                        class="absolute right-0 mt-2 w-64 bg-white border border-gray-200 shadow-lg rounded-md z-50"
                        x-cloak
                    >
                        <div class="p-4">
                            <h3 class="text-sm font-medium text-gray-800">Notifications</h3>
                        </div>

                        <div class="max-h-60 overflow-y-auto">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <div class="px-4 py-2 hover:bg-gray-100">
                                    <p class="text-sm text-gray-700">{{ $notification->data['message'] }}</p>
                                    <small class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            @empty
                                <div class="px-4 py-2 text-sm text-gray-500">No new notifications.</div>
                            @endforelse
                        </div>

                        <div class="p-4 border-t border-gray-200 text-center">
                            <a href="javascript:void(0);"
                               class="text-sm text-blue-500 hover:underline"
                               id="mark-all-read">
                                Mark all as read
                            </a>
                        </div>
                        <div class="p-4 border-t border-gray-200 text-center">
                            <a href="{{route('notifications.index')}}"
                               class="text-sm text-blue-500 hover:underline"
                               id="view-all-notifications">
                                View All Notifications
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <hr class="w-px h-6 bg-gray-200 border-none" />

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <img class="mr-2 w-10 h-10 rounded-full object-cover" src="{{ asset(Auth::user()->avatar_path) }}" alt="User Avatar">
                            <div>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                            <div class="ms-1">
                                <i class="fas fa-caret-down fill-current h-4 w-4"></i>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 text-sm text-gray-700">
                            <div class="font-medium">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                            <div class="text-xs text-gray-500 italic">{{ $roleLabel }}</div>
                        </div>

                        <x-dropdown-link :href="$profileRoute" class="ajax-link" data-path="{{ parse_url($profileRoute, PHP_URL_PATH) }}">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
    <script>
        $('#mark-all-read').on('click', function () {
            $.ajax({
                url: '{{ route('notifications.markAllAsRead') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update the UI to reflect that notifications are read
                    $('.notification-count').text(''); // Clear the notification count
                    $('.max-h-60').html(`
                    <div class="px-4 py-2 text-sm text-gray-500">
                        No new notifications.
                    </div>`);
                },
                error: function(xhr) {
                    console.error('Failed to mark notifications as read');
                }
            });
        });
    </script>
</header>
