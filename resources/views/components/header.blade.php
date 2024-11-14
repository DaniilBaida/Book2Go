{{-- resources/views/components/header.blade.php --}}
@props([
    'profileRoute' => '#',
    'roleLabel' => 'User',
])

<header class="sticky top-0 before:absolute before:inset-0 before:backdrop-blur-md max-lg:before:bg-white/90 before:-z-10 z-30 max-lg:shadow-sm lg:before:bg-gray-100/90">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:border-b border-gray-200">

            <!-- Header: Left side -->
            <div class="flex items-center space-x-8">
                <!-- Hamburger button for mobile -->
                <button
                    class="text-gray-500 hover:text-gray-600 lg:hidden"
                    @click.stop="sidebarOpen = !sidebarOpen"
                    aria-controls="sidebar"
                    :aria-expanded="sidebarOpen"
                >
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars w-6 h-6 fill-current"></i>
                </button>
            </div>

            <!-- Header: Right side -->
            <div class="flex items-center space-x-3">
                <!-- Divider -->
                <hr class="w-px h-6 bg-gray-200 border-none" />
                
                <!-- User button with dropdown -->
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
                        
                        <!-- Profile Button -->
                        <x-dropdown-link :href="$profileRoute">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Log Out Button -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</header>
