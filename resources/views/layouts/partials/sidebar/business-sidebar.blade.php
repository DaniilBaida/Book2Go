<x-sidebar 
    logoRoute="{{ route('business.dashboard') }}"
    :links="[

        [
            'route' => route('business.dashboard'), 
            'icon' => 'fas fa-home', 
            'label' => 'Dashboard', 
            'isActive' => Request::is('business/dashboard')
        ],
        [
            'route' => route('business.services.index'), 
            'icon' => 'fas fa-briefcase', 
            'label' => 'Services', 
            'isActive' => Request::is('business/services*')
        ],
        [
            'route' => route('business.details.index'), 
            'icon' => 'fas fa-info-circle', 
            'label' => 'Business Details', 
            'isActive' => Request::is('business.details.index')
        ],

    ]"
/>
