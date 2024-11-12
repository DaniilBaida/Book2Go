<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;



    protected $fillable = [
        'name',
        'price',
        'description',
        'original_price',
        'discount_price',
        'discount_start_date',
        'discount_end_date',
        'duration_minutes',
        'availability',
        'image_path',
        'video_path',
        'average_rating',
        'reviews_count',
        'max_capacity',
        'tags',
        'add_ons',
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

    protected $casts = [
        'discount_start_date' => 'datetime',
        'discount_end_date' => 'datetime',
        'tags' => 'array',
        'add_ons' => 'array',
    ];
}
