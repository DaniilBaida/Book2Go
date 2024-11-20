<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;

class ClientNotificationController extends NotificationController
{
    /**
     * Display a list of notifications.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10);

        return view('client.notifications.index', compact('notifications'));
    }
}
