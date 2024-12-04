<section>
    <!-- Search Service Field -->
    <div class="bg-[#171719] min-h-20 items-center border-1 border-y border-zinc-700 py-auto flex">
        <div class="max-w-9xl container mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h1 class="text-white text-4xl md:text-8xl font-bold mb-5">Services</h1>
            <div class="relative w-full items-center flex gap-5">
                <!-- Input Field -->
                <input
                    type="text"
                    placeholder="Search for services"
                    class="w-full px-4 py-3 text-lg text-white bg-[#202022] rounded-lg placeholder-[#ceced6] h-12
                    focus:outline-none focus:ring-2 focus:ring-blue-300"
                />
                <button class="h-12 bg-blue-300 rounded-lg px-3 md:px-10 font-bold text-lg md:text-xl">Find</button>
            </div>
        </div>
    </div>
    <!-- Services -->
    <div class="bg-[#D8DAD7] flex">
        <div class="max-w-9xl container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="my-10 flex max-lg:flex-col gap-10">
                <!-- Filters -->
                <div class="flex flex-col">
                    <div class="flex justify-between mb-5">
                        <div class="font-bold text-2xl">Filters</div>
                        <div class="font-bold text-lg my-auto flex">
                            <i class="fa-solid fa-sliders text-[#6D6E6E]"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-5">
                        <div class="flex justify-between gap-10">
                            <div class="font-bold text-lg">Account subject</div>
                            <button class="bg-[#F2F4F0] rounded-full px-3 py-1 my-auto flex text-sm font-bold">Reset</button>
                        </div>
                        <div class="mt-4 space-y-3">
                            <!-- Checkbox List -->
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="w-5 h-5 accent-black rounded focus:ring-2 focus:ring-offset-1 focus:ring-gray-300">
                                <span class="text-md font-bold">Lifestyle</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="w-5 h-5 accent-black rounded focus:ring-2 focus:ring-offset-1 focus:ring-gray-300">
                                <span class="text-md font-bold">Lifestyle</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="w-5 h-5 accent-black rounded focus:ring-2 focus:ring-offset-1 focus:ring-gray-300">
                                <span class="text-md font-bold">Lifestyle</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="w-5 h-5 accent-black rounded focus:ring-2 focus:ring-offset-1 focus:ring-gray-300">
                                <span class="text-md font-bold">Lifestyle</span>
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Services Found -->
                <div class="flex-1">
                    <div class="flex flex-col">
                        <div class="flex justify-between mb-5">
                            <div class="font-bold text-2xl">Services</div>
                            <div class="font-bold text-lg my-auto">Sort by:
                                <span class="font-bold text-zinc-500 mr-2">Default</span>
                                <button>
                                    <i class="fa-solid fa-sliders text-[#6D6E6E]"></i>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-5">
                            <x-landing.service-card 
                                image="{{ asset('images/landing/gym_landing.jpg') }}" 
                                title="GymMaster Fitness" 
                                location="Barcelona, ESP" 
                                bookings="1892" 
                                price="50/month" 
                                badge="Fitness"
                                :keyPoints="['Transform Your Lifestyle', 'Revitalize Your Health', 'Join a Thriving Community']" 
                                businessName="Brito Consulting"
                            />
                            <x-landing.service-card 
                                image="{{ asset('images/landing/gym_landing.jpg') }}" 
                                title="GymMaster Fitness" 
                                location="Barcelona, ESP" 
                                bookings="1892" 
                                price="50/month" 
                                badge="Fitness"
                                :keyPoints="['Transform Your Lifestyle', 'Revitalize Your Health', 'Join a Thriving Community']"
                                businessName="Business 1"
                            />
                            <x-landing.service-card 
                                image="{{ asset('images/landing/gym_landing.jpg') }}" 
                                title="GymMaster Fitness" 
                                location="Barcelona, ESP" 
                                bookings="1892" 
                                price="50/month" 
                                badge="Fitness"
                                :keyPoints="['Transform Your Lifestyle', 'Revitalize Your Health', 'Join a Thriving Community']"
                                businessName="Business 1"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>