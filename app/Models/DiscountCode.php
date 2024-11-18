<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'status',
        'max_uses',
        'uses',
        'expires_at',
        'business_id',
        'admin_id',
        'description',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Escopo para códigos globais (criados pelo admin)
    public function scopeGlobal($query)
    {
        return $query->whereNull('business_id');
    }

    // Escopo para códigos específicos de um business
    public function scopeForBusiness($query, $businessId)
    {
        return $query->where('business_id', $businessId);
    }
}
