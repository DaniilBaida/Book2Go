<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_logo',
        'location',
        'operating_hours',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
