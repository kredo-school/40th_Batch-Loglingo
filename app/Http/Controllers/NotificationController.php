<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            // 未読を上に
            ->orderByRaw('read_at IS NOT NULL')
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function read($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        // mark as read
        $notification->markAsRead();

        // redirect depending on notification types
        return redirect($notification->data['url']);
    }
}