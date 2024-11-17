<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountUse extends Model
{
    protected $fillable = [
        'discount_code_id',
        'user_id',
        'service_id',
        'amount_discounted',
    ];

    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class);
    }
}
