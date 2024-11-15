<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

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
    ];

    /**
     * Retrieve the allowed durations for service booking.
     *
     * @return array<int> Allowed durations in minutes.
     */
    public static function allowedDurations()
    {
        return [30, 60, 90];
    }

    /**
     * Get the available time slots for a specific date.
     *
     * @param string $date The date for which to calculate available slots.
     * @return array<int, string> List of available slots formatted as 'H:i'.
     */
    public function getAvailableSlots($date)
    {
        $start = Carbon::parse('08:00'); // Example start of working day
        $end = Carbon::parse('17:00'); // Example end of working day
        $duration = $this->duration_minutes;

        $slots = [];
        // Generate slots by adding duration incrementally within the working hours
        while ($start->copy()->addMinutes($duration)->lte($end)) {
            $slots[] = $start->format('H:i');
            $start->addMinutes($duration);
        }

        // Filter out slots that overlap with existing bookings
        return $this->filterBookedSlots($slots, $date);
    }

    /**
     * Filter out slots that overlap with existing bookings.
     *
     * @param array<int, string> $slots Generated slots for the day.
     * @param string $date The date to check against existing bookings.
     * @return array<int, string> Filtered slots with no overlaps.
     */
    private function filterBookedSlots($slots, $date)
    {
        // Fetch existing bookings for the service on the given date
        $bookings = Booking::where('service_id', $this->id)
            ->where('date', $date)
            ->get(['start_time', 'end_time']);

        // Filter slots based on booking overlaps
        return array_filter($slots, function ($slot) use ($bookings) {
            $slotStart = Carbon::parse($slot);
            $slotEnd = $slotStart->copy()->addMinutes($this->duration_minutes);

            foreach ($bookings as $booking) {
                $bookingStart = Carbon::parse($booking->start_time);
                $bookingEnd = Carbon::parse($booking->end_time);

                // Check if slot overlaps with any existing booking
                if (
                    $slotStart->between($bookingStart, $bookingEnd, false) ||
                    $slotEnd->between($bookingStart, $bookingEnd, false)
                ) {
                    return false;
                }
            }
            return true;
        });
    }
}
