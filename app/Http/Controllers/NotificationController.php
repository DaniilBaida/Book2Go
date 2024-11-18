<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a list of notifications.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return redirect()->route('notifications.index')->with('success', 'All notifications marked as read.');
    }

    /**
     * Mark a specific notification as read.
     *
     * @param string $id
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        if ($notification) {
            $notification->markAsRead();
            return back()->with('success', 'Notification marked as read.');
        }

        return back()->with('error', 'Notification not found.');
    }
}
