<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $notification = getActiveUser()->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            $url = $notification->data['url'] ?? route('dashboard.index');
            return redirect($url);
        }
        return redirect()->back()->withError(__('messages.notification_not_found'));
    }

    public function markAllRead()
    {
        getActiveUser()->unreadNotifications->markAsRead();
        return redirect()->back()->withSuccess(__('messages.all_notifications_marked_read'));
    }

    public function destroy($id)
    {
        $notification = getActiveUser()->notifications()->find($id);
        if ($notification) {
            $notification->delete();
            return redirect()->back()->withSuccess(__('messages.type_deleted', ['type' => __('main.notification')]));
        }
        return redirect()->back()->withError(__('messages.notification_not_found'));
    }

    public function destroyAll(Request $request)
    {
        $ids = $request->input('selected_notifications');
        if (empty($ids) || (is_array($ids) && count($ids) === 1 && $ids[0] == 0)) {
            getActiveUser()->notifications()->delete();
            return redirect()->back()->withSuccess(__('messages.all_notifications_deleted'));
        } elseif (is_array($ids)) {
            getActiveUser()->notifications()->whereIn('id', $ids)->delete();
            return redirect()->back()->withSuccess(__('messages.selected_notifications_deleted'));
        } else {
            return redirect()->back()->withError(__('messages.no_notifications_selected'));
        }
    }
}
