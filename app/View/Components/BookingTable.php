<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BookingTable extends Component
{
    public $bookings;
    public $role;

    /**
     * Create a new component instance.
     *
     * @param $bookings
     * @param string $role
     */
    public function __construct($bookings, $role)
    {
        $this->bookings = $bookings;
        $this->role = $role;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.booking-table');
    }
}
