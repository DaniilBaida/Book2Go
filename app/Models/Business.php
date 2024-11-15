<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use hasFactory, softDeletes;
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

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
