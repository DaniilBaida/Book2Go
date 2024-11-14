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

        $bookings = $this->bookings()
            ->where('booking_date', $date)
            ->get(['start_time', 'end_time']);

        $availableSlots = [];

        while ($startTime->addMinutes($duration)->lte($endTime)) {
            $slotStart = $startTime->copy();
            $slotEnd = $slotStart->copy()->addMinutes($duration);

            // Check if the slot overlaps with any existing bookings
            $isBooked = $bookings->contains(function ($booking) use ($slotStart, $slotEnd) {
                $bookingStart = Carbon::parse($booking->start_time);
                $bookingEnd = Carbon::parse($booking->end_time);

                return $slotStart->between($bookingStart, $bookingEnd) ||
                    $slotEnd->between($bookingStart, $bookingEnd) ||
                    ($slotStart->lte($bookingStart) && $slotEnd->gte($bookingEnd));
            });

            if (!$isBooked) {
                $availableSlots[] = $slotStart->format('H:i');
            }
        }

        return $availableSlots;
    }
}
