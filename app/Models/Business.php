<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = [
        'name',
        'description',
        'email',
        'phone_number',
        'address',
        'city',
        'country',
        'postal_code',
        'logo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
