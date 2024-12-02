<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    const ROLE_CLIENT = 1;
    const ROLE_BUSINESS = 2;
    const ROLE_ADMIN = 3;
    const ROLE = [
        self::ROLE_CLIENT => 'Client',
        self::ROLE_BUSINESS => 'Business',
        self::ROLE_ADMIN => 'Admin',
    ];
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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'preferences' => 'array',
        'last_login_at' => 'datetime',
    ];

    /**
     * Get the role name by role ID.
     *
     * @param int $roleId
     * @return string
     */
    public static function getRoleName(int $roleId): string
    {
        return self::ROLE[$roleId] ?? 'Unknown Role';
    }

    public function getRedirectRouteName(): string
    {
        return match ((int) $this->role_id) {
            self::ROLE_CLIENT => 'client.dashboard',
            self::ROLE_BUSINESS => 'business.dashboard',
            self::ROLE_ADMIN => 'admin.dashboard',
        };
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->avatar_path)) {
                $user->avatar_path = 'storage/avatars/default-avatar.svg';
            }
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function business()
    {
        return $this->hasOne(Business::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Booking::class, 'user_id', 'booking_id');
    }
}
