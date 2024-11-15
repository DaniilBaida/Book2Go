<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReviewCard extends Component
{
    /**
     * The review data passed to the component.
     *
     * @var mixed $review The review object or array containing review details.
     */
    public function __construct(public $review) {}

    /**
     * Get the view that represents the component.
     *
     * @return View|Closure|string The blade view for the review card component.
     */
    public function render(): View|Closure|string
    {
        return view('components.review-card');
    }
}
