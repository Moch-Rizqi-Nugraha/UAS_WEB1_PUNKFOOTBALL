<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Get user's event participations
     */
    public function eventParticipations()
    {
        return $this->hasMany(EventParticipant::class);
    }

    /**
     * Get user's confirmed events
     */
    public function confirmedEvents()
    {
        return $this->belongsToMany(Event::class, 'event_participants')
                    ->wherePivot('status', 'confirmed')
                    ->withPivot('registered_at');
    }

    /**
     * Get user's registered events (upcoming)
     */
    public function registeredEvents()
    {
        return $this->belongsToMany(Event::class, 'event_participants')
                    ->wherePivot('status', 'registered')
                    ->withPivot('registered_at')
                    ->whereHas('event', function($q) {
                        $q->where('event_date', '>=', now());
                    });
    }

    /**
     * Get user's transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get user's tickets
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
