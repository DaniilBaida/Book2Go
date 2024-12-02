<x-sidebar
    logoRoute="{{ route('business.dashboard') }}"
    :links="[
        ['route' => route('business.dashboard'), 'icon' => 'fas fa-home', 'label' => 'Dashboard'],
        ['route' => route('business.services.index'), 'icon' => 'fas fa-briefcase', 'label' => 'Services'],
        ['route' => route('business.bookings'), 'icon' => 'fas fa-calendar', 'label' => 'Bookings'],
        ['route' => route('business.details'), 'icon' => 'fas fa-info-circle', 'label' => 'Business Details'],
        ['route' => route('business.discounts.index'),'icon' => 'fas fa-tags','label' => 'Manage Discounts'],
        ['route' => route('business.reviews.index'), 'icon' => 'fas fa-star', 'label' => 'Reviews'],
    ]"
/>
