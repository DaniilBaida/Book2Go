<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Booking;

class BusinessNotificationController extends NotificationController
{
    /**
     * Display a list of notifications.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications;

        // Marcar as notificações com reviews já existentes
        $notifications->each(function ($notification) {
            if (
                isset($notification->data['type']) &&
                $notification->data['type'] === 'review_request' &&
                isset($notification->data['booking_id'])
            ) {
                // Verifica se o negócio já deixou uma review para o cliente associado à reserva
                $notification->already_reviewed = Review::where('booking_id', $notification->data['booking_id'])
                    ->where('reviewer_type', 'business')
                    ->exists();
            } else {
                $notification->already_reviewed = false;
            }
        });

        return view('business.notifications.index', [
            'notifications' => $notifications,
        ]);
    }

}
