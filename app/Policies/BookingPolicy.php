<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Determine if the client can leave a review for the service.
     */
    public function leaveServiceReview(User $user, Booking $booking)
    {
        return $user->id === $booking->user_id && $booking->status === 'completed'
            ? Response::allow()
            : Response::deny('You can only leave a review after the service is completed.');
    }

    /**
     * Determine if the business can leave a review for the client.
     */
    public function leaveClientReview(User $user, Booking $booking)
    {
        return $user->id === $booking->service->business->user_id && $booking->status === 'completed'
            ? Response::allow()
            : Response::deny('You can only leave a review for the client after the service is completed.');
    }
}
