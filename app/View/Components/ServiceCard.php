<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ServiceCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public object $service,
        public string $role,
        public array $tags = [],
        public array $add_ons = []
    ) {}


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.service-card');
    }
}
