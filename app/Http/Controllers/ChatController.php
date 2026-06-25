<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function instructorIndex()
    {
        $instructor = Auth::guard('instructor')->user();

        $messages = ChatMessage::where(function ($q) use ($instructor) {
            $q->where('sender_type', 'instructor')
              ->where('sender_id', $instructor->id)
              ->where('receiver_type', 'admin');
        })->orWhere(function ($q) {
            $q->where('sender_type', 'admin')
              ->where('receiver_type', 'all');
        })->orWhere(function ($q) use ($instructor) {
            $q->where('sender_type', 'admin')
              ->where('receiver_type', 'instructor')
              ->where('receiver_id', $instructor->id);
        })->orderBy('created_at', 'asc')->get();

        ChatMessage::where('sender_type', 'admin')
            ->where(function ($q) use ($instructor) {
                $q->where('receiver_type', 'all')
                  ->orWhere(function ($sub) use ($instructor) {
                      $sub->where('receiver_type', 'instructor')
                          ->where('receiver_id', $instructor->id);
                  });
            })
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('instructor_pages.instructor_chat', compact('messages', 'instructor'));
    }

    public function adminIndex()
    {
        $admin = Auth::guard('admin')->user();

        $instructors = Instructor::whereIn('id', function ($q) {
            $q->select('sender_id')
              ->from('chat_messages')
              ->where('sender_type', 'instructor');
        })->orWhereIn('id', function ($q) {
            $q->select('receiver_id')
              ->from('chat_messages')
              ->where('sender_type', 'admin')
              ->where('receiver_type', 'instructor');
        })->get();

        $broadcasts = ChatMessage::where('sender_type', 'admin')
            ->where('receiver_type', 'all')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin_pages.admin_chat', compact('instructors', 'broadcasts', 'admin'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $chat = new ChatMessage();
        $chat->message = $request->message;

        if (Auth::guard('instructor')->check()) {
            $chat->sender_id = Auth::guard('instructor')->id();
            $chat->sender_type = 'instructor';
            $chat->receiver_type = 'admin';
        } elseif (Auth::guard('admin')->check()) {
            $chat->sender_id = Auth::guard('admin')->id();
            $chat->sender_type = 'admin';
            $chat->receiver_type = $request->receiver_type ?? 'all';
            $chat->receiver_id = $request->receiver_type === 'instructor' ? $request->receiver_id : null;
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $chat->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $chat]);
        }

        return redirect()->back()->with('success', __('messages.chat_message_sent'));
    }

    public function fetchMessages(Request $request)
    {
        if (Auth::guard('instructor')->check()) {
            $instructor = Auth::guard('instructor')->user();

            $messages = ChatMessage::where(function ($q) use ($instructor) {
                $q->where('sender_type', 'instructor')
                  ->where('sender_id', $instructor->id)
                  ->where('receiver_type', 'admin');
            })->orWhere(function ($q) {
                $q->where('sender_type', 'admin')
                  ->where('receiver_type', 'all');
            })->orWhere(function ($q) use ($instructor) {
                $q->where('sender_type', 'admin')
                  ->where('receiver_type', 'instructor')
                  ->where('receiver_id', $instructor->id);
            })->orderBy('created_at', 'asc')->get();

            return response()->json(['messages' => $messages]);
        }

        if (Auth::guard('admin')->check()) {
            $instructorId = $request->instructor_id;

            if ($request->type === 'broadcast') {
                $messages = ChatMessage::where('sender_type', 'admin')
                    ->where('receiver_type', 'all')
                    ->orderBy('created_at', 'asc')
                    ->get();
            } elseif ($instructorId) {
                $messages = ChatMessage::where(function ($q) use ($instructorId) {
                    $q->where('sender_type', 'instructor')
                      ->where('sender_id', $instructorId)
                      ->where('receiver_type', 'admin');
                })->orWhere(function ($q) use ($instructorId) {
                    $q->where('sender_type', 'admin')
                      ->where('receiver_type', 'instructor')
                      ->where('receiver_id', $instructorId);
                })->orderBy('created_at', 'asc')->get();

                ChatMessage::where('sender_type', 'instructor')
                    ->where('sender_id', $instructorId)
                    ->where('receiver_type', 'admin')
                    ->where('is_read', false)
                    ->update(['is_read' => true, 'read_at' => now()]);
            } else {
                $messages = collect();
            }

            return response()->json(['messages' => $messages]);
        }

        return response()->json(['messages' => []]);
    }

    public function getConversations()
    {
        $instructors = Instructor::select('id', 'name', 'profile_photo')
            ->withCount(['chatMessages as unread_count' => function ($q) {
                $q->where('receiver_type', 'admin')->where('is_read', false);
            }])
            ->whereHas('chatMessages', function ($q) {
                $q->where('receiver_type', 'admin');
            })->orWhereHas('chatMessages', function ($q) {
                $q->where('receiver_type', 'admin');
            })->get();

        foreach ($instructors as $instructor) {
            $lastMsg = ChatMessage::where('sender_type', 'instructor')
                ->where('sender_id', $instructor->id)
                ->where('receiver_type', 'admin')
                ->orderBy('created_at', 'desc')
                ->first();
            $instructor->last_message = $lastMsg ? \Str::limit($lastMsg->message, 60) : null;
            $instructor->last_message_time = $lastMsg ? $lastMsg->created_at->diffForHumans() : null;
        }

        return response()->json(['instructors' => $instructors]);
    }

    public function markAsRead(Request $request)
    {
        if (Auth::guard('admin')->check() && $request->instructor_id) {
            ChatMessage::where('sender_type', 'instructor')
                ->where('sender_id', $request->instructor_id)
                ->where('receiver_type', 'admin')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
        }

        return response()->json(['success' => true]);
    }

    public function sendAudio(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:webm,ogg,wav,mp4|max:10240',
        ]);

        $chat = new ChatMessage();
        $chat->type = 'audio';
        $chat->message = '';

        $file = $request->file('audio');
        $senderType = 'text';
        $senderId = 0;

        if (Auth::guard('instructor')->check()) {
            $senderType = 'instructor';
            $senderId = Auth::guard('instructor')->id();
            $chat->sender_id = $senderId;
            $chat->sender_type = 'instructor';
            $chat->receiver_type = 'admin';
        } elseif (Auth::guard('admin')->check()) {
            $senderType = 'admin';
            $senderId = Auth::guard('admin')->id();
            $chat->sender_id = $senderId;
            $chat->sender_type = 'admin';
            $chat->receiver_type = $request->receiver_type ?? 'all';
            $chat->receiver_id = $request->receiver_type === 'instructor' ? $request->receiver_id : null;
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $filename = $senderType . '_' . $senderId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('chat_audio', $filename, 'public');
        $chat->media_path = $path;
        $chat->save();

        return response()->json(['success' => true, 'message' => $chat]);
    }

    public function unreadCount()
    {
        $count = 0;

        if (Auth::guard('instructor')->check()) {
            $instructor = Auth::guard('instructor')->user();
            $count = ChatMessage::where('sender_type', 'admin')
                ->where(function ($q) use ($instructor) {
                    $q->where('receiver_type', 'all')
                      ->orWhere(function ($sub) use ($instructor) {
                          $sub->where('receiver_type', 'instructor')
                              ->where('receiver_id', $instructor->id);
                      });
                })
                ->where('is_read', false)
                ->count();
        } elseif (Auth::guard('admin')->check()) {
            $count = ChatMessage::where('sender_type', 'instructor')
                ->where('receiver_type', 'admin')
                ->where('is_read', false)
                ->count();
        }

        return response()->json(['count' => $count]);
    }

    public function editMessage(Request $request, ChatMessage $message)
    {
        if ($message->type !== 'text') {
            return response()->json(['error' => 'Only text messages can be edited'], 422);
        }

        $request->validate(['message' => 'required|string|max:5000']);

        if (Auth::guard('instructor')->check()) {
            if ($message->sender_type !== 'instructor' || $message->sender_id !== Auth::guard('instructor')->id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } elseif (Auth::guard('admin')->check()) {
            if ($message->sender_type !== 'admin' || $message->sender_id !== Auth::guard('admin')->id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->message = $request->message;
        $message->save();

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function deleteMessage(ChatMessage $message)
    {
        if (Auth::guard('instructor')->check()) {
            if ($message->sender_type !== 'instructor' || $message->sender_id !== Auth::guard('instructor')->id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } elseif (Auth::guard('admin')->check()) {
            if ($message->sender_type !== 'admin' || $message->sender_id !== Auth::guard('admin')->id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($message->type === 'audio' && $message->media_path) {
            Storage::disk('public')->delete($message->media_path);
        }

        $message->delete();

        return response()->json(['success' => true]);
    }

    /* Student-Instructor Chat Methods */

    public function studentIndex(Request $request)
    {
        $student = Auth::guard('web')->user();
        $studentId = $student->id;

        $instructors = Instructor::all();

        foreach ($instructors as $instructor) {
            $lastMsg = ChatMessage::where(function ($q) use ($studentId, $instructor) {
                $q->where('sender_type', 'student')->where('sender_id', $studentId)
                  ->where('receiver_type', 'instructor')->where('receiver_id', $instructor->id);
            })->orWhere(function ($q) use ($studentId, $instructor) {
                $q->where('sender_type', 'instructor')->where('sender_id', $instructor->id)
                  ->where('receiver_type', 'student')->where('receiver_id', $studentId);
            })->orderBy('created_at', 'desc')->first();

            $instructor->last_message = $lastMsg ? \Str::limit($lastMsg->message, 60) : null;
            $instructor->last_message_time = $lastMsg ? $lastMsg->created_at->diffForHumans() : null;

            $instructor->unread_count = ChatMessage::where('sender_type', 'instructor')
                ->where('sender_id', $instructor->id)
                ->where('receiver_type', 'student')
                ->where('receiver_id', $studentId)
                ->where('is_read', false)
                ->count();
        }

        $activeInstructorId = $request->instructor_id;

        return view('student_pages.student_chat', compact('instructors', 'student', 'activeInstructorId'));
    }

    public function studentSendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
            'receiver_id' => 'required|integer',
        ]);

        $chat = new ChatMessage();
        $chat->message = $request->message;
        $chat->sender_id = Auth::guard('web')->id();
        $chat->sender_type = 'student';
        $chat->receiver_type = 'instructor';
        $chat->receiver_id = $request->receiver_id;
        $chat->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $chat]);
        }

        return redirect()->back();
    }

    public function studentSendAudio(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:webm,ogg,wav,mp4|max:10240',
            'receiver_id' => 'required|integer',
        ]);

        $chat = new ChatMessage();
        $chat->type = 'audio';
        $chat->message = '';
        $chat->sender_id = Auth::guard('web')->id();
        $chat->sender_type = 'student';
        $chat->receiver_type = 'instructor';
        $chat->receiver_id = $request->receiver_id;

        $file = $request->file('audio');
        $filename = 'student_' . $chat->sender_id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('chat_audio', $filename, 'public');
        $chat->media_path = $path;
        $chat->save();

        return response()->json(['success' => true, 'message' => $chat]);
    }

    public function studentFetchMessages(Request $request)
    {
        $studentId = Auth::guard('web')->id();
        $instructorId = $request->instructor_id;

        if (!$instructorId) {
            return response()->json(['messages' => []]);
        }

        $messages = ChatMessage::where(function ($q) use ($studentId, $instructorId) {
            $q->where('sender_type', 'student')->where('sender_id', $studentId)
              ->where('receiver_type', 'instructor')->where('receiver_id', $instructorId);
        })->orWhere(function ($q) use ($studentId, $instructorId) {
            $q->where('sender_type', 'instructor')->where('sender_id', $instructorId)
              ->where('receiver_type', 'student')->where('receiver_id', $studentId);
        })->orderBy('created_at', 'asc')->get();

        // Mark received messages as read
        ChatMessage::where('sender_type', 'instructor')
            ->where('sender_id', $instructorId)
            ->where('receiver_type', 'student')
            ->where('receiver_id', $studentId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['messages' => $messages]);
    }

    public function studentMarkAsRead(Request $request)
    {
        $studentId = Auth::guard('web')->id();
        if ($request->instructor_id) {
            ChatMessage::where('sender_type', 'instructor')
                ->where('sender_id', $request->instructor_id)
                ->where('receiver_type', 'student')
                ->where('receiver_id', $studentId)
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
        }

        return response()->json(['success' => true]);
    }

    public function studentUnreadCount()
    {
        $studentId = Auth::guard('web')->id();
        $count = ChatMessage::where('receiver_type', 'student')
            ->where('receiver_id', $studentId)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function studentEditMessage(Request $request, ChatMessage $message)
    {
        if ($message->type !== 'text') {
            return response()->json(['error' => 'Only text messages can be edited'], 422);
        }

        $request->validate(['message' => 'required|string|max:5000']);

        if ($message->sender_type !== 'student' || $message->sender_id !== Auth::guard('web')->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->message = $request->message;
        $message->save();

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function studentDeleteMessage(ChatMessage $message)
    {
        if ($message->sender_type !== 'student' || $message->sender_id !== Auth::guard('web')->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($message->type === 'audio' && $message->media_path) {
            Storage::disk('public')->delete($message->media_path);
        }

        $message->delete();

        return response()->json(['success' => true]);
    }

    /* Instructor-Student Chat Methods */

    public function instructorStudentIndex(Request $request)
    {
        $instructor = Auth::guard('instructor')->user();
        $instructorId = $instructor->id;

        // Fetch students who have a conversation history with this instructor
        $students = \App\Models\User::whereIn('id', function ($q) use ($instructorId) {
            $q->select('sender_id')
              ->from('chat_messages')
              ->where('sender_type', 'student')
              ->where('receiver_type', 'instructor')
              ->where('receiver_id', $instructorId);
        })->orWhereIn('id', function ($q) use ($instructorId) {
            $q->select('receiver_id')
              ->from('chat_messages')
              ->where('sender_type', 'instructor')
              ->where('sender_id', $instructorId)
              ->where('receiver_type', 'student');
        })->get();

        foreach ($students as $student) {
            $lastMsg = ChatMessage::where(function ($q) use ($instructorId, $student) {
                $q->where('sender_type', 'student')->where('sender_id', $student->id)
                  ->where('receiver_type', 'instructor')->where('receiver_id', $instructorId);
            })->orWhere(function ($q) use ($instructorId, $student) {
                $q->where('sender_type', 'instructor')->where('sender_id', $instructorId)
                  ->where('receiver_type', 'student')->where('receiver_id', $student->id);
            })->orderBy('created_at', 'desc')->first();

            $student->last_message = $lastMsg ? \Str::limit($lastMsg->message, 60) : null;
            $student->last_message_time = $lastMsg ? $lastMsg->created_at->diffForHumans() : null;

            $student->unread_count = ChatMessage::where('sender_type', 'student')
                ->where('sender_id', $student->id)
                ->where('receiver_type', 'instructor')
                ->where('receiver_id', $instructorId)
                ->where('is_read', false)
                ->count();
        }

        return view('instructor_pages.instructor_student_chat', compact('students', 'instructor'));
    }

    public function instructorStudentSendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
            'receiver_id' => 'required|integer',
        ]);

        $chat = new ChatMessage();
        $chat->message = $request->message;
        $chat->sender_id = Auth::guard('instructor')->id();
        $chat->sender_type = 'instructor';
        $chat->receiver_type = 'student';
        $chat->receiver_id = $request->receiver_id;
        $chat->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $chat]);
        }

        return redirect()->back();
    }

    public function instructorStudentSendAudio(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:webm,ogg,wav,mp4|max:10240',
            'receiver_id' => 'required|integer',
        ]);

        $chat = new ChatMessage();
        $chat->type = 'audio';
        $chat->message = '';
        $chat->sender_id = Auth::guard('instructor')->id();
        $chat->sender_type = 'instructor';
        $chat->receiver_type = 'student';
        $chat->receiver_id = $request->receiver_id;

        $file = $request->file('audio');
        $filename = 'instructor_' . $chat->sender_id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('chat_audio', $filename, 'public');
        $chat->media_path = $path;
        $chat->save();

        return response()->json(['success' => true, 'message' => $chat]);
    }

    public function instructorStudentFetchMessages(Request $request)
    {
        $instructorId = Auth::guard('instructor')->id();
        $studentId = $request->student_id;

        if (!$studentId) {
            return response()->json(['messages' => []]);
        }

        $messages = ChatMessage::where(function ($q) use ($studentId, $instructorId) {
            $q->where('sender_type', 'student')->where('sender_id', $studentId)
              ->where('receiver_type', 'instructor')->where('receiver_id', $instructorId);
        })->orWhere(function ($q) use ($studentId, $instructorId) {
            $q->where('sender_type', 'instructor')->where('sender_id', $instructorId)
              ->where('receiver_type', 'student')->where('receiver_id', $studentId);
        })->orderBy('created_at', 'asc')->get();

        // Mark received messages as read
        ChatMessage::where('sender_type', 'student')
            ->where('sender_id', $studentId)
            ->where('receiver_type', 'instructor')
            ->where('receiver_id', $instructorId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json(['messages' => $messages]);
    }

    public function instructorStudentMarkAsRead(Request $request)
    {
        $instructorId = Auth::guard('instructor')->id();
        if ($request->student_id) {
            ChatMessage::where('sender_type', 'student')
                ->where('sender_id', $request->student_id)
                ->where('receiver_type', 'instructor')
                ->where('receiver_id', $instructorId)
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
        }

        return response()->json(['success' => true]);
    }

    public function instructorStudentUnreadCount()
    {
        $instructorId = Auth::guard('instructor')->id();
        $count = ChatMessage::where('sender_type', 'student')
            ->where('receiver_type', 'instructor')
            ->where('receiver_id', $instructorId)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function instructorStudentEditMessage(Request $request, ChatMessage $message)
    {
        if ($message->type !== 'text') {
            return response()->json(['error' => 'Only text messages can be edited'], 422);
        }

        $request->validate(['message' => 'required|string|max:5000']);

        if ($message->sender_type !== 'instructor' || $message->sender_id !== Auth::guard('instructor')->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message->message = $request->message;
        $message->save();

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function instructorStudentDeleteMessage(ChatMessage $message)
    {
        if ($message->sender_type !== 'instructor' || $message->sender_id !== Auth::guard('instructor')->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($message->type === 'audio' && $message->media_path) {
            Storage::disk('public')->delete($message->media_path);
        }

        $message->delete();

        return response()->json(['success' => true]);
    }
}
