<x-sidebar 
    logoRoute="{{ route('admin.dashboard') }}"
    :links="[
        [
            'route' => route('admin.dashboard'),
            'icon' => 'fas fa-home',
            'label' => 'Dashboard',
            'isActive' => Request::is('admin/dashboard')
        ],
        [
            'route' => route('admin.users.index'),
            'icon' => 'fas fa-users',
            'label' => 'User Management',
            'isActive' => Route::is('admin.users.index')
        ],
        [
            'route' => route('admin.services.index'),
    'icon' => 'fas fa-briefcase',
    'label' => 'Service Management',
    'isActive' => Route::is('admin.services.index')
        ],
    ]"
/>