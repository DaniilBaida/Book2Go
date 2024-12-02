<div
    x-data="{
        show: false,
        focusables() {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])';
            return [...$el.querySelectorAll(selector)].filter(el => !el.hasAttribute('disabled'));
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    class="relative"
>
    <!-- Button to Open Modal -->
    <x-button 
        @click="show = true"
    >
        View Reply
    </x-button>

    <!-- Modal -->
    <div
        x-show="show"
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6 sm:px-0 bg-gray-800 bg-opacity-50"
        x-on:click.away="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <!-- Modal Content -->
        <div
            class="bg-white p-6 rounded-2xl shadow-md max-md:m-2 md:w-2/5 max-h-[90vh] overflow-auto"
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <!-- Reply Details -->
            <div class="border-b pb-4 mb-4">
                <h3 class="font-bold text-lg">Reply Details</h3>
                <p class="text-sm text-gray-700 mt-2 text-justify">
                    <!-- Example reply; this can be dynamically passed -->
                    {{ $reply ?? 'No reply available.' }}
                </p>
            </div>
            <!-- Close Modal Button -->
            <div class="mt-4 flex justify-end">
                <x-button-secondary 
                    @click="show = false"
                >
                    Close
                </x-button-secondary>
            </div>
        </div>
    </div>
</div>
