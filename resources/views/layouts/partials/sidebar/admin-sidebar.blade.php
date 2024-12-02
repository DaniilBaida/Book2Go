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
            'route' => route('admin.businesses.index'),
            'icon' => 'fas fa-building',
            'label' => 'Business Management',
            'isActive' => Route::is('admin.businesses.index')
        ],
        [
            'route' => route('admin.services.index'),
            'icon' => 'fas fa-briefcase',
            'label' => 'Service Management',
            'isActive' => Route::is('admin.services.index')
        ],
        [
            'route' => route('admin.reviews.index'),
            'icon' => 'fa-solid fa-list-check',
            'label' => 'Reviews Management',
            'isActive' => Route::is('admin.reviews.index')
        ],
        [
            'route' => route('admin.discounts.index'),
            'icon' => 'fas fa-tags',
            'label' => 'Manage Discounts',
            'isActive' => Request::is('admin/discounts*'),
        ],
    ]"
    :bottomLinks="[]"
/>
