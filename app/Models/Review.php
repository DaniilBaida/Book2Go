<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'rating',
        'comment',
        'reviewer_type',
        'is_approved',
        'reported_at',
    ];

    /**
     * Get the booking associated with the review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the service through the booking.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function service()
    {
        return $this->hasOneThrough(
            Service::class,
            Booking::class,
            'id', // Foreign key on Bookings table
            'id', // Foreign key on Services table
            'booking_id', // Local key on Reviews table
            'service_id' // Local key on Bookings table
        );
    }

    /**
     * Get the user through the booking.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function user()
    {
        return $this->hasOneThrough(User::class, Booking::class, 'id', 'id', 'booking_id', 'user_id');
    }

    // Determine the reviewer through booking's user (client or business)
    public function reviewer()
    {
        if ($this->reviewer_type === 'client') {
            return $this->booking->user; // User associated with booking
        }

        return $this->booking->service->business; // Business owner via booking->service
    }

    // Simplified accessor for reviewing entity
    public function reviewedEntity()
    {
        if ($this->reviewer_type === 'client') {
            return $this->booking->service->business;
        }

        return $this->booking->user;
    }

    public function isReported()
    {
        return !is_null($this->reported_at);
    }

    public function markAsReported()
    {
        $this->update(['reported_at' => now()]);
    }


}
