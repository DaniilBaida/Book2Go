<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /**
     * Enable the HasFactory and Notifiable traits.
     */
    use HasFactory, Notifiable;

    /**
     * @var string Default path for user avatars.
     */
    protected string $avatar_path;

    // Role constants for user types
    const ROLE_CLIENT = 1;
    const ROLE_BUSINESS = 2;
    const ROLE_ADMIN = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> Attributes that can be mass-assigned.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'role_id',
        'avatar_path',
        'is_active',
        'is_verified',
        'preferences',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string> Attributes that should not be exposed.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Define attributes that should be cast to specific types.
     *
     * @return array<string, string> Attribute casting rules.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'preferences' => 'array',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the redirect route name based on user role.
     *
     * @return string The route name for user redirection.
     */
    public function getRedirectRouteName(): string
    {
        return match ((int) $this->role_id) {
            self::ROLE_CLIENT => 'client.dashboard',
            self::ROLE_BUSINESS => 'business.dashboard',
            self::ROLE_ADMIN => 'admin.dashboard',
        };
    }

    /**
     * Boot method for the model.
     *
     * Automatically assigns a default avatar if none is set during user creation.
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->avatar_path)) {
                $user->avatar_path = 'storage/avatars/default-avatar.svg';
            }
        });
    }

    /**
     * Define the relationship with the Role model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Define the relationship with the Review model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Define the relationship with the Business model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function business()
    {
        return $this->hasOne(Business::class);
    }

    /**
     * Define the relationship with the Booking model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
