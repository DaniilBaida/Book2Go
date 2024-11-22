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
        // Verificar se o cliente está associado ao booking
        if ($user->id !== $booking->user_id) {
            return Response::deny('You are not authorized to review this booking.');
        }

        // Verificar se o booking está concluído
        if ($booking->status !== 'completed') {
            return Response::deny('You can only leave a review after the service is completed.');
        }

        return Response::allow();
    }


    /**
     * Determine if the business can leave a review for the client.
     */
    public function leaveClientReview(User $user, Booking $booking)
    {
        // Verificar se o negócio está associado ao booking
        if ($user->id !== $booking->service->business->user_id) {
            return Response::deny('You are not authorized to review this booking.');
        }

        // Verificar se o booking está concluído
        if ($booking->status !== 'completed') {
            return Response::deny('You can only leave a review after the service is completed.');
        }

        return Response::allow();
    }
}
