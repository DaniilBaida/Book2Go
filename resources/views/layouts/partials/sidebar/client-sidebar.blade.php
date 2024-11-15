<x-sidebar 
    logoRoute="{{ route('client.dashboard') }}" 
    :links="[
        [
            'route' => route('client.dashboard'), 
            'icon' => 'fas fa-home', 
            'label' => 'Dashboard', 
            'isActive' => Request::is('client/dashboard')
        ],
    ]"
/>
