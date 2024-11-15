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
    ]"
/>
