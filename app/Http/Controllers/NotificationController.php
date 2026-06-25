<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = $this->getUser();
        if (! $user) {
            return response()->json(['notifications' => [], 'unread_count' => 0]);
        }

        $notifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->latest()
            ->take(20)
            ->get();

        $unreadCount = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->where('is_read', false)
            ->count();

        return response()->json([
            'notifications' => $notifications->map(function ($n) {
                return [
                    'id' => $n->id,
                    'type' => $n->type,
                    'message' => $n->message,
                    'data' => $n->data,
                    'is_read' => $n->is_read,
                    'created_at' => $n->created_at->diffForHumans(),
                    'created_raw' => $n->created_at->toIso8601String(),
                ];
            }),
            'unread_count' => $unreadCount,
        ]);
    }

    public function markAsRead(Notification $notification)
    {
        $user = $this->getUser();
        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($notification->notifiable_id !== $user->id || $notification->notifiable_type !== get_class($user)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $notification->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديد الإشعار كمقروء.'
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        $user = $this->getUser();
        if (! $user) {
            return $request->expectsJson() 
                ? response()->json(['error' => 'Unauthorized'], 401)
                : redirect()->route('student_login_page');
        }

        Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->where('is_read', false)
            ->update(['is_read' => true]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديد جميع الإشعارات كمقروءة بنجاح.'
            ]);
        }

        return back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة بنجاح.');
    }

    public function all(Request $request)
    {
        $user = $this->getUser();
        if (! $user) {
            return redirect()->route('student_login_page');
        }

        $notifications = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('notifications.index', compact('notifications', 'user'));
    }

    public function unreadCount()
    {
        $user = $this->getUser();
        if (! $user) {
            return response()->json(['count' => 0]);
        }

        $count = Notification::where('notifiable_id', $user->id)
            ->where('notifiable_type', get_class($user))
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    private function getUser()
    {
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->user();
        }
        if (Auth::guard('instructor')->check()) {
            return Auth::guard('instructor')->user();
        }
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        }
        return null;
    }
}
