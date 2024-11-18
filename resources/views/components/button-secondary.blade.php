<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn bg-white text-gray-800 hover:bg-gray-50 whitespace-nowrap px-4 rounded-lg py-2 font-semibold border border-gray-300']) }}>
    {{ $slot }}
</button>
