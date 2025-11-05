<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Role constants
    const ROLE_ADMIN = 'admin';
    const ROLE_WARGA = 'warga';

    protected $fillable = [
        'name', 'full_name', 'email', 'phone', 'address', 'password', 'role', 'branch_id', 'balance_points',
    ];

    protected $hidden = ['password'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    public function pointsLedger()
    {
        return $this->hasMany(PointsLedger::class);
    }

    // Helper method untuk cek role
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isWarga()
    {
        return $this->role === self::ROLE_WARGA;
    }
}