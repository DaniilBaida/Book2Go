<x-sidebar
    logoRoute="{{ route('client.dashboard') }}"
    :links="[
        [
            'route' => route('client.dashboard'),
            'icon' => 'fas fa-home',
            'label' => 'Dashboard',
            'isActive' => Request::is('client/dashboard')
        ],
        [
            'route' => route('client.services'),
            'icon' => 'fas fa-search',
            'label' => 'Services',
            'isActive' => Request::is('client/services')
        ],
        [
            'route' => route('client.bookings'),
            'icon' => 'fas fa-calendar',
            'label' => 'Bookings',
            'isActive' => Request::is('client/bookings')
        ],
    ]"
    :bottomLinks="[
        ['route' => route('client.settings.index'), 'icon' => 'fas fa-cog', 'label' => 'Settings'],
    ]"
/>
