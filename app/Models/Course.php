<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'instructor_id',
        'track_id',
        'type',
        'roadmap',
        'unique_course_id',
        'image_path',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order')->orderBy('id');
    }

    public function savedBy()
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->withPivot(['payment_cash_id', 'payment_verified_at', 'completed_at', 'grade'])
            ->withTimestamps();
    }

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function isPaid(): bool
    {
        return $this->type === 'paid';
    }
}
