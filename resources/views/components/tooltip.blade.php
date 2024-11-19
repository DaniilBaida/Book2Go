<div x-data="{ showTooltip: false }" class="relative">
    <!-- Tooltip Trigger -->
    <div 
        @mouseenter="showTooltip = true" 
        @mouseleave="showTooltip = false"
        class="inline-flex items-center">
        {{ $slot }}
    </div>

    <!-- Tooltip Content -->
    <div 
        x-show="showTooltip" 
        x-cloak
        x-transition:enter="transition ease-out duration-200" 
        x-transition:enter-start="opacity-0 scale-90" 
        x-transition:enter-end="opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-150" 
        x-transition:leave-start="opacity-100 scale-100" 
        x-transition:leave-end="opacity-0 scale-90"
        class="absolute top-[-5rem] left-1/2 transform -translate-x-1/2 z-50 whitespace-normal break-words rounded-lg bg-gray-700 py-1.5 px-3 text-center font-sans text-sm font-normal text-white w-[200px] pointer-events-none">
        {{ $message }}
    </div>
</div>
