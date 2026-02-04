<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'event_id',
        'price',
        'status',
        'purchase_date',
        'ticket_number',
        'used_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'purchase_date' => 'datetime',
        'used_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Scopes
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeUsed($query)
    {
        return $query->where('status', 'used');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Accessors & Mutators
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'available' => '<span class="badge bg-success">Available</span>',
            'used' => '<span class="badge bg-primary">Used</span>',
            'expired' => '<span class="badge bg-danger">Expired</span>',
            'cancelled' => '<span class="badge bg-secondary">Cancelled</span>',
            default => '<span class="badge bg-light">Unknown</span>',
        };
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function isUsed(): bool
    {
        return $this->status === 'used';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }

    public function markAsUsed()
    {
        $this->update([
            'status' => 'used',
            'used_at' => now(),
        ]);
        return $this;
    }

    public function markAsExpired()
    {
        $this->update(['status' => 'expired']);
        return $this;
    }

    public function markAsCancelled()
    {
        $this->update(['status' => 'cancelled']);
        return $this;
    }
}
