<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // Role constants used across the app
    public const ROLE_ADMIN = 'admin';
    public const ROLE_WARGA = 'warga';

    protected $fillable = [
        'name',
        'full_name',
        'email',
        'phone',
        'address',
        'profile_photo',
        'password',
        'role',
        'branch',
        'branch_id',
        'balance_points',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    public function pointLedgers()
    {
        return $this->hasMany(PointLedger::class);
    }

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // Compatibility helper required by the controllers
    public function isWarga(): bool
    {
        return $this->role === self::ROLE_WARGA || $this->role === 'user';
    }
}