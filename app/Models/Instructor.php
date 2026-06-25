<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'google_id', 'password', 'bio', 'job_title', 'profile_photo'])]
#[Hidden(['password', 'remember_token'])]
class Instructor extends Authenticatable
{
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
