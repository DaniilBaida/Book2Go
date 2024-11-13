<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn bg-gray-900 text-gray-100 hover:bg-gray-800 whitespace-nowrap px-4 rounded-lg py-2 font-semibold']) }}>
    {{ $slot }}
</button>
