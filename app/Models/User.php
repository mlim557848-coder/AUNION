<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'student_id', 'master_alumni_id',
        'contact_email', 'phone', 'address', 'linkedin', 'current_position',
        'industry', 'skills', 'education_history', 'career_timeline',
        'batch_year', 'course', 'is_approved', 'is_archived', 'profile_photo'
    ];

    protected $hidden = ['password', 'remember_token'];   // Hide password too for safety

    protected $casts = [
        'skills' => 'array',
        'education_history' => 'array',
        'career_timeline' => 'array',
        'is_approved' => 'boolean',
    ];

    public function isAdmin() { return $this->role === 'admin'; }
    public function isAlumni() { return $this->role === 'alumni'; }

    // Relationships
    public function connections() { return $this->hasMany(Connection::class, 'requester_id'); }
    public function receivedConnections() { return $this->hasMany(Connection::class, 'target_id'); }
    public function attendedEvents() { return $this->belongsToMany(Event::class, 'event_attendees'); }
    public function profileViews() { return $this->hasMany(ProfileView::class, 'viewed_id'); }

    // IMPORTANT: Add this relationship
    public function masterAlumni()
    {
        return $this->belongsTo(MasterAlumni::class);
    }

    public function attendees()
{
    return $this->hasMany(\App\Models\EventAttendee::class, 'user_id');
}
}