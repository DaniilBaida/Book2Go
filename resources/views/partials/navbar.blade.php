<nav class="sticky top-0 z-50 bg-[#171719] min-h-20 items-center border-1 border-b border-zinc-700">
    <div class="max-w-9xl container mx-auto">
        <div class="relative flex justify-between text-center h-20 px-4 sm:px-6 lg:px-8">
            <!-- Logo Section -->
            <div class="flex items-center">
                <a href="/" class="text-white flex items-center">
                    <img src="{{ asset('images/squarelogo_landingpage.png') }}" alt="Book2Go Logo" style="max-height: 30px; margin-right: 10px;">
                </a>
            </div>

            <!-- User Section -->
            @if (Route::has('login'))
                <div class="flex justify-end items-center space-x-6">
                    <!-- User Avatar Section -->
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
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
        <!-- Navigation Links -->
        <div class="h-20 flex md:hidden sm:px-6 lg:px-8">
            <ul class="w-full flex gap-3 lg:gap-8 text-white text-sm font-medium h-full justify-between overflow-x-scroll">
                <li class="relative hover:text-blue-300 cursor-pointer group h-full flex items-center">
                    <a href="#home" class="scroll-link h-full flex items-center px-4">
                        Home
                    </a>
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-300 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </li>
                <li class="relative hover:text-blue-300 cursor-pointer group h-full flex items-center">
                    <a href="#search" class="scroll-link h-full flex items-center px-4">
                        Search
                    </a>
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-300 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </li>
                <li class="relative hover:text-blue-300 cursor-pointer group h-full flex items-center">
                    <a href="#" class="h-full flex items-center px-4">
                        Messages
                    </a>
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-300 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </li>
                <li class="relative hover:text-blue-300 cursor-pointer group h-full flex items-center">
                    <a href="#" class="h-full flex items-center px-4">
                        Community
                    </a>
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-300 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </li>
                <li class="relative hover:text-blue-300 cursor-pointer group h-full flex items-center">
                    <a href="#" class="h-full flex items-center px-4">
                        Resources
                    </a>
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-300 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
                </li>
            </ul>
        </div>
    </div>
</nav>
