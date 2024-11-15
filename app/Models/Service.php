<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> Attributes that can be set via mass assignment.
     */
    protected $fillable = [
        'name',
        'price',
        'description',
        'start_time',
        'end_time',
        'duration_minutes',
        'image_path',
        'tags',
        'bookings_count',
        'status',
        'business_id',
        'service_category_id',
    ];

    /**
     * Define the relationship with the Business model.
     *
     * A Service belongs to a Business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * Define the relationship with the ServiceCategory model.
     *
     * A Service belongs to a ServiceCategory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    /**
     * Define the relationship with the Review model.
     *
     * A Service can have many Reviews.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Define the relationship with the Booking model.
     *
     * A Service can have many Bookings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Attribute casting rules for specific fields.
     *
     * @var array<string, string> Casts attributes to specific types.
     */
    protected $casts = [
        'discount_start_date' => 'datetime',
        'discount_end_date' => 'datetime',
        'tags' => 'array',
        'add_ons' => 'array',
    ];

    /**
     * Get the available time slots for a specific date.
     *
     * @param string $date The date for which to calculate available slots.
     * @return array<int, string> List of available slots formatted as 'H:i'.
     */
    public function getAvailableSlots($date)
    {
        $startTime = Carbon::parse($this->start_time); // Start time for the service
        $endTime = Carbon::parse($this->end_time);     // End time for the service
        $duration = $this->duration_minutes;           // Duration of each slot

        // Fetch all bookings for the specified date
        $bookings = $this->bookings()
            ->where('date', $date)
            ->get(['start_time', 'end_time']);

        $availableSlots = [];

        // Iterate through the time range to find available slots
        while ($startTime->lt($endTime)) {
            $slotStart = $startTime->copy();
            $slotEnd = $slotStart->copy()->addMinutes($duration);

            // Check if the slot overlaps with any existing booking
            $isBooked = $bookings->contains(function ($booking) use ($slotStart, $slotEnd) {
                $bookingStart = Carbon::parse($booking->start_time);
                $bookingEnd = Carbon::parse($booking->end_time);

                // Overlap check
                return $slotStart->lt($bookingEnd) && $slotEnd->gt($bookingStart);
            });

            // If the slot is not booked, add it to the available slots
            if (!$isBooked) {
                $availableSlots[] = $slotStart->format('H:i');
            }

            // Move to the next potential slot
            $startTime->addMinutes($duration);
        }

        return $availableSlots;
    }
}
