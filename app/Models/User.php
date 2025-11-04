<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory;

    // Role constants
    const ROLE_WARGA = 'warga';
    const ROLE_ADMIN = 'admin';

    protected $fillable = [
        'name', 'full_name', 'email', 'phone', 'address', 'password', 'role', 'branch_id', 'balance_points',
    ];

    protected $hidden = ['password'];

    /**
     * Check if user is a warga (citizen)
     */
    public function isWarga(): bool
    {
        return $this->role === self::ROLE_WARGA;
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(Redemption::class);
    }

    public function ledger(): HasMany
    {
        return $this->hasMany(PointLedger::class);
    }
}
