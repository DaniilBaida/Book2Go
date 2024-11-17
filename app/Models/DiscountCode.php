<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    protected $fillable = [
        'code',
        'description',
        'discount',
        'business_id',
        'admin_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
