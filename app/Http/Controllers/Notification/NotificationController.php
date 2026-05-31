<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
}
