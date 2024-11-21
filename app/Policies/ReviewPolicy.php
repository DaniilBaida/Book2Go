<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use App\Models\Review;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    /**
     * Verificar se o cliente pode fazer uma review.
     */
    public function leaveServiceReview(User $user, Booking $booking)
    {
        // Apenas o cliente pode fazer a review
        if ($user->id !== $booking->user_id) {
            return false;
        }

        // Verificar se já existe uma review para este booking pelo cliente
        return !Review::where('booking_id', $booking->id)
            ->where('reviewer_type', 'client')
            ->exists();
    }

    /**
     * Verificar se o negócio pode fazer uma review.
     */
    public function leaveClientReview(User $user, Booking $booking)
    {
        // Apenas o dono do negócio pode fazer a review
        if ($user->id !== $booking->service->business->user_id) {
            return false;
        }

        // Verificar se já existe uma review para este booking pelo negócio
        return !Review::where('booking_id', $booking->id)
            ->where('reviewer_type', 'business')
            ->exists();
    }
}
