<nav class="bg-gray-800 p-2">
    <div class="max-w-7xl container mx-auto grid grid-cols-2 items-center gap-2 px-4 sm:px-6 lg:px-8">
        <div class="flex">
            <a href="/" class="text-white">
                Book2Go
            </a>
        </div>

        @if (Route::has('login'))
            <div class="-mx-3 flex flex-1 justify-end">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-800 hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <img class="mr-2 w-8 h-8 rounded-full object-cover" src="{{ asset(Auth::user()->avatar_path) }}" alt="User Avatar">
                                <span>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">

                            <x-dropdown-link :href="Auth::user()->role_id === \App\Models\User::ROLE_BUSINESS ? route('business.dashboard') : route('admin.dashboard')">
                                {{ __('Dashboard') }}
                            </x-dropdown-link>

                            <!-- Log Out -->
                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Log in Button for Guests -->
                    <a href="{{ route('login') }}">
                        <x-button-secondary>
                            Log in
                        </x-button-secondary>
                    </a>
                @endauth
            </div>
        @endif
    </div>
</nav>
