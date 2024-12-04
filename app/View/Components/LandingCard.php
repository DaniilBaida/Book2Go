<?php

namespace App\View\Components;

use Illuminate\View\Component;

class LandingCard extends Component
{
    public function __construct(
        $image, 
        $title, 
        $location, 
        $bookings, 
        $price, 
        $badge, 
        $keyPoints, 
        $businessName,
    ) {
        $this->image = $image;
        $this->title = $title;
        $this->location = $location;
        $this->bookings = $bookings;
        $this->price = $price;
        $this->badge = $badge;
        $this->keyPoints = $keyPoints;
        $this->businessName = $businessName;
    }

    public function render()
    {
        return view('components.landing.service-card');
    }
}
