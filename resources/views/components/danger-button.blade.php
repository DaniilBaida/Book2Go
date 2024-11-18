<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn bg-red-600 text-white hover:bg-red-500 whitespace-nowrap px-4 rounded-lg py-2 font-semibold border-transparent']) }}>
    {{ $slot }}
</button>