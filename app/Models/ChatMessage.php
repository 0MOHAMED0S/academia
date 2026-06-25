<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'sender_id',
        'sender_type',
        'receiver_id',
        'receiver_type',
        'message',
        'type',
        'media_path',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    protected $appends = ['time_formatted'];

    public function getTimeFormattedAttribute()
    {
        return $this->created_at ? $this->created_at->diffForHumans() : '';
    }

    public function sender()
    {
        if ($this->sender_type === 'instructor') {
            return $this->belongsTo(Instructor::class, 'sender_id');
        }
        if ($this->sender_type === 'student') {
            return $this->belongsTo(User::class, 'sender_id');
        }
        return $this->belongsTo(Admin::class, 'sender_id');
    }

    public function getMediaUrlAttribute()
    {
        if ($this->media_path) {
            return asset('storage/' . $this->media_path);
        }
        return null;
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeFromInstructor($query, $instructorId)
    {
        return $query->where('sender_type', 'instructor')->where('sender_id', $instructorId);
    }

    public function scopeAdminBroadcasts($query)
    {
        return $query->where('sender_type', 'admin')->where('receiver_type', 'all');
    }
}
