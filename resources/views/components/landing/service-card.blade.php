<div class="bg-white rounded-3xl flex-col flex p-5">
    <div class="rounded-xl">
        <!-- Image -->
        <img src="{{ $image }}" class="rounded-xl mb-5 object-cover w-full h-[300px]">
        <!-- Title / Location / Bookings -->
        <div class="flex justify-between">
            <div class="flex flex-col">
                <p class="text-2xl font-bold flex-auto">{{ $title }}</p>
                <p class="text-lg font-bold flex-auto text-zinc-600 mb-2">{{ $location }}</p>
                <p class="hover:text-zinc-900 text-zinc-600 duration-300 hover:cursor-pointer bg-zinc-100 rounded-full w-fit pr-5 font-medium">
                    <i class="fa-solid fa-building text-blue-500 text-sm my-auto rounded-full bg-blue-300 mr-2 py-1 px-2"></i>
                    {{ $businessName }}
                </p>

            </div>
            <div class="flex flex-col my-auto">
                <p class="text-2xl font-bold flex justify-center">{{ $bookings }}</p>
                <p class="text-lg font-bold flex-auto text-zinc-600">Bookings</p>
            </div>
        </div>
        <!-- Break Line -->
        <div class="h-0.5 w-full rounded-full bg-zinc-200 my-5"></div>
        <!-- Price and Badge -->
        <div class="flex text-center gap-3 justify-between mb-5">
            <div class="text-center my-auto flex">
                <i class="fa-solid fa-dollar-sign text-[#6EC85E] text-sm my-auto rounded-full bg-[#EAF7E8] mr-2 py-1 px-3"></i>
                <p class="text-xl font-bold text-zinc-700">{{ $price }}</p>
            </div>
            <div class="bg-[#EAF7E8] px-3 rounded-full my-auto">
                <p class="flex text-md font-medium text-[#6EC85E]">{{ $badge }}</p>
            </div>
        </div>
        <!-- Key Points -->
        <div class="flex flex-col gap-2 mb-5">
            @foreach ($keyPoints as $point)
                <div class="flex text-center gap-3">
                    <i class="fa-solid fa-check text-blue-700 text-sm my-auto rounded-full bg-blue-300 py-1 px-2"></i>
                    <p class="text-center text-lg font-medium">{{ $point }}</p>
                </div>
            @endforeach
        </div>
        <!-- Book Now Button -->
        <div class="flex gap-3">
            <button class="flex px-3 py-1 rounded-xl border-2 border-neutral-300 hover:border-zinc-700 duration-300">
                <i class="fa-regular fa-bookmark text-xl flex my-auto"></i>
            </button>
            <div class="flex-1">
                <button class="w-full bg-blue-300 hover:bg-blue-200 duration-300 rounded-xl py-2 text-xl font-bold text-zinc-700">Book Now</button>
            </div>
        </div>
    </div>
</div>
