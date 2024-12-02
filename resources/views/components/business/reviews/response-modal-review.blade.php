<div
    x-data="{
        show: false,
        focusables() {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])';
            return [...$el.querySelectorAll(selector)].filter(el => ! el.hasAttribute('disabled'));
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
        Reply
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
            <!-- Customer Review -->
            <div class="border-b pb-4 mb-4">
                <div class="justify-between flex items-center">
                    <div class="flex items-center mb-2">
                        <img 
                            src="https://via.placeholder.com/40" 
                            alt="Customer Avatar" 
                            class="rounded-full w-10 h-10 mr-3"
                        >
                        <div>
                            <h3 class="font-bold text-lg">Brian Howie</h3>
                            <p class="text-sm text-gray-500">2 reviews · 2 weeks ago</p>
                        </div>
                    </div>
                    <div class="">
                        <button>
                            <i class="fa-solid fa-circle-exclamation text-red-400 hover:text-red-500 text-2xl duration-300 hover:cursor-pointer"></i>
                        </button>
                    </div>
                </div>
                <div class="flex items-center mb-2">
                    <span class="text-yellow-500">
                        ★★★★☆
                    </span>
                </div>
                <p class="text-sm text-gray-700 text-justify">
                    My wife and I just purchased a 2019 Audi A8 from Audi Westwood. It was the best car buying experience I have had. The whole process was customer-focused, engaged, and transparent. Our Sales Rep was Justin Vargas, and he made the whole experience very customer-focused. His knowledge of the vehicles, options, and approach to the buying process was outstanding. Would highly recommend both Justin and Audi Westwood for your car buying needs.
                </p>
            </div>

            <!-- Reply Section -->
            <div>
                <form>
                    <div class="flex gap-5">
                        <div class="px-[2px] bg-zinc-300"></div>
                        <div class="w-full">
                            <h4 class="font-bold mb-2">Reply</h4>
                            <textarea
                                rows="4"
                                placeholder="Write your reply here..."
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none"
                            ></textarea>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end gap-3">
                        <x-button-secondary 
                            @click="show = false"
                        >
                            Cancel
                        </x-button-secondary>
                        <x-button onclick="alert('Reply submitted!')"
                        >
                            Submit Reply
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
