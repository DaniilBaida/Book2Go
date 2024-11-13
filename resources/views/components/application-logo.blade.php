@props(['collapsed' => false])

<div>
    <img
        x-show="!{{ $collapsed ? 'true' : 'false' }}"
        src="{{ asset('images/squarelogo.png') }}"
        alt="Full Logo"
        class="w-[200px]"
        x-cloak
    >
    <img
        x-show="{{ $collapsed ? 'true' : 'false' }}"
        src="{{ asset('images/icon-logo.png') }}"
        alt="Icon Logo"
        class="h-10"
        x-cloak
    >
</div>
