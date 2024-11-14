@props(['logoRoute', 'links' => [], 'variant' => 'default'])

<div class="min-w-fit">
    <!-- Sidebar backdrop (mobile only) -->
    <div
        class="fixed inset-0 bg-gray-900 bg-opacity-30 z-40 lg:hidden transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
        aria-hidden="true" x-cloak
    ></div>

    <!-- Sidebar -->
    <div id="sidebar"
         x-data="{ sidebarExpanded: false }"
        class="rounded-r-2xl flex lg:!flex flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:!w-64 shrink-0 bg-white p-4 transition-all duration-200 ease-in-out"
         :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'"
         @click.outside="sidebarOpen = false" @keydown.escape.window="sidebarOpen = false">

        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-gray-800 hover:text-gray-400" @click.stop="sidebarOpen = !sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <i class="fa-solid fa-arrow-left"></i>
            </button>

            <!-- Logo -->
            <a href="{{ $logoRoute }}" class="block">
                <x-application-logo/>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <h3 class="text-xs uppercase text-gray-400 font-semibold xl:pl-3 pl-1 2xl:pl-3">
                <span class="lg:sidebar-expanded:block 2xl:block">Pages</span>
            </h3>
            <ul class="mt-3">
                @foreach ($links as $link)
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))] {{ $link['isActive'] ? 'from-blue-300/[0.12] to-blue-500/15' : '' }}">
                        <a class="block text-gray-600 truncate transition {{ !$link['isActive'] ? 'hover:text-gray-900' : '' }}" href="{{ $link['route'] }}">
                            <div class="flex items-center">
                                <i class="{{ $link['icon'] }} shrink-0 {{ $link['isActive'] ? 'text-blue-500/90' : '' }}"></i>
                                <span class="text-sm font-medium ml-4 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ $link['label'] }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
