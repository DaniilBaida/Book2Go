    <!-- Main Content -->
    <section id="home">
        <section class="mb-10 max-w-9xl container mx-auto mt-8 px-4 sm:px-6 lg:px-8 flex gap-10 items-stretch max-2xl:flex-col max-2xl:text-center">
            <!-- Left Section -->
            <div class="flex-1 text-2xl lg:text-5xl 2xl:text-8xl w-full 2xl:w-3/5 2xl:leading-[90px]">
                <!-- Heading Section -->
                <div class="flex max-2xl:justify-center items-center">
                    <h1 class="font-black text-white whitespace-nowrap">Find</h1>
                    <div class="mx-5 flex items-center justify-center">
                        <i class="text-sm xl:text-4xl fa-solid fa-magnifying-glass text-blue-300 text-center py-2 px-5 xl:px-10 rounded-full border-2 border-blue-300"></i>
                    </div>
                    <h1 class="font-black text-white whitespace-nowrap">the Perfect</h1>
                </div>
                <!-- Subheading Section -->
                <div class="grid text-justify font-black text-white">
                    <div class="2xl:justify-between flex gap-5 max-2xl:justify-center">
                        <h1>Services</h1>
                        <h1>for</h1>
                        <h1>Your</h1>
                    </div>
                    <div class="flex gap-10 items-center max-2xl:justify-center">
                        <h1>Needs</h1>
                        <div class="relative w-full max-w-lg items-center hidden 2xl:flex">
                            <!-- Input Field -->
                            <input
                                type="text"
                                placeholder="Search"
                                class="w-full px-4 py-3 text-lg text-white bg-[#202022] rounded-lg 2xl:rounded-2xl placeholder-[#2D2D2F] h-6 2xl:h-16
                                focus:outline-none focus:ring-2 focus:ring-blue-300"
                            />
                            <!-- Search Icon -->
                            <button
                                class="absolute top-8 right-4 transform -translate-y-1/2 bg-blue-300 text-black p-2 rounded-lg
                                inset-y-0 flex items-center"
                            >
                                <i class="fa-solid fa-magnifying-glass text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="w-full 2xl:w-2/5 flex items-center max-2xl:h-32">
                <div class="w-full h-full bg-blue-300 rounded-xl flex items-center justify-center">
                    <p class="font-bold text-white text-lg md:text-6xl">See how it’s done</p>
                </div>
            </div>
        </section>

        <section class="bg-[#D8DAD7] rounded-t-3xl">
            <div class="max-w-9xl container mx-auto p-5 lg:px-8 grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-10 items-center">
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
                    image="{{ asset('images/landing/barber_landing.jpg') }}" 
                    title="The Gentleman's Cut" 
                    location="London, UK" 
                    bookings="728" 
                    price="20/session" 
                    badge="Wellness"
                    :keyPoints="['Signature Haircuts', 'Luxury Shaving Experience', 'Exclusive Beard Care']"
                    businessName="Business 1"
                />

                <x-landing.service-card 
                    image="{{ asset('images/landing/dentist_landing.jpg') }}" 
                    title="BrightSmile Dental Clinic" 
                    location="Lisbon, PT" 
                    bookings="92" 
                    price="30/session" 
                    badge="Care"
                    :keyPoints="['General Dentistry', 'Cosmetic Treatments', 'Specialized Care']"
                    businessName="Business 1"
                />
            </div>
        </section>
    </section>