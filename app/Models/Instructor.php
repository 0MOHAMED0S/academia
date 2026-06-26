<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Instructor extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'password',
        'bio',
        'job_title',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    use HasFactory, Notifiable;

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id')
            ->where('sender_type', 'instructor');
    }
}
