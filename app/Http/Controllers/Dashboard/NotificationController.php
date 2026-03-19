<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = getActiveUser()->notifications()->paginate(20);
        getActiveUser()->unreadNotifications->markAsRead();

        return view('dashboard.notifications.index', compact('notifications'));
    }

    public function markRead($id)
    {
        $notification = getActiveUser()->notifications()->findOrFail($id);
        $notification->markAsRead();

        $url = $notification->data['url'] ?? route('dashboard.index');
        return redirect($url);
    }

    public function markAllRead()
    {
        getActiveUser()->unreadNotifications->markAsRead();
        return redirect()->back()->withSuccess(__('messages.all_notifications_marked_read'));
    }
}
