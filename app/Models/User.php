<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected string $avatar_path;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
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
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
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
    public function getRedirectRouteName(): string
    {
        return match ((int) $this->role_id) {
            1 => 'client.dashboard',
            2 => 'business.dashboard',
            3 => 'admin.dashboard',
        };
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            // If the avatar_path is not set, assign the default avatar
            if (empty($user->avatar_path)) {

                $user->avatar_path = 'storage/avatars/default-avatar.svg';
            }
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
