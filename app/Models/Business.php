<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> Attributes that can be set via mass assignment.
     */
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

    /**
     * Define the relationship with the User model.
     *
     * A Business is owned by a specific User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship with the Service model.
     *
     * A Business can offer many Services.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
