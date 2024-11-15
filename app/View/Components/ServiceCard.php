<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ServiceCard extends Component
{
    /**
     * Public properties to be passed into the component.
     *
     * @param object $service The service object containing service details.
     * @param string $role The user's role (e.g., admin, client).
     */
    public function __construct(
        public object $service,
        public string $role,
    ) {}

    /**
     * Get the view that represents the component.
     *
     * @return View The blade view for the service card component.
     */
    public function render(): View
    {
        return view('components.service-card');
    }
}
