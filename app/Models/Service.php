<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;



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

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    protected $casts = [
        'discount_start_date' => 'datetime',
        'discount_end_date' => 'datetime',
        'tags' => 'array',
        'add_ons' => 'array',
    ];

    public function getAvailableSlots($date)
    {
        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);
        $duration = $this->duration_minutes;

        // Fetch all bookings for the given date
        $bookings = $this->bookings()
            ->where('date', $date)
            ->get(['start_time', 'end_time']);

        $availableSlots = [];

        while ($startTime->lt($endTime)) {
            $slotStart = $startTime->copy();
            $slotEnd = $slotStart->copy()->addMinutes($duration);

            // Check if the slot overlaps with any booking
            $isBooked = $bookings->contains(function ($booking) use ($slotStart, $slotEnd) {
                $bookingStart = Carbon::parse($booking->start_time);
                $bookingEnd = Carbon::parse($booking->end_time);

                // Overlap check
                return $slotStart->lt($bookingEnd) && $slotEnd->gt($bookingStart);
            });

            if (!$isBooked) {
                $availableSlots[] = $slotStart->format('H:i');
            }

            $startTime->addMinutes($duration);
        }

        return $availableSlots;
    }

}
