<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;

class BusinessNotificationController extends NotificationController
{
    /**
     * Display a list of notifications.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10);
        return view('business.notifications.index', compact('notifications'));
    }

}
