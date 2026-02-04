<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'event_date',
        'location',
        'category',
        'poster',
        'status',
        'price',
        'max_participants',
        'current_participants',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'price' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function participants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function confirmedParticipants()
    {
        return $this->hasMany(EventParticipant::class)->where('status', 'confirmed');
    }

    public function registeredParticipants()
    {
        return $this->hasMany(EventParticipant::class)->where('status', 'registered');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now())->orderBy('event_date', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now());
    }

    /**
     * Accessors & Mutators
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'active' => '<span class="badge bg-success">Active</span>',
            'inactive' => '<span class="badge bg-danger">Inactive</span>',
            default => '<span class="badge bg-light">Unknown</span>',
        };
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isUpcoming(): bool
    {
        return $this->event_date >= now();
    }

    public function isPast(): bool
    {
        return $this->event_date < now();
    }

    public function hasAvailableSpots(): bool
    {
        return $this->current_participants < $this->max_participants;
    }

    public function getAvailableSpots(): int
    {
        return max(0, $this->max_participants - $this->current_participants);
    }

    public function getCategoryLabel(): string
    {
        return match($this->category) {
            'turnamen' => 'Turnamen',
            'pelatihan' => 'Pelatihan',
            'friendly_match' => 'Friendly Match',
            default => 'Unknown'
        };
    }

    public function getPosterUrl(): string
    {
        return $this->poster ? asset('storage/' . $this->poster) : asset('images/default-event.jpg');
    }
}
