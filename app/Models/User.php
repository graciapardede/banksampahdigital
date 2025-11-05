<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
=======

use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> b45da6f632a5529c62eb65d2f0b1c0754b8dcaee
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
<<<<<<< HEAD
    use HasFactory, Notifiable;

    // Role constants
    const ROLE_ADMIN = 'admin';
    const ROLE_WARGA = 'warga';

    protected $fillable = [
        'name', 'full_name', 'email', 'phone', 'address', 'password', 'role', 'branch_id', 'balance_points',
=======
    use HasFactory, Notifiable;  

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'branch',
>>>>>>> b45da6f632a5529c62eb65d2f0b1c0754b8dcaee
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relationships
    public function deposits()
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

    // Helper methods
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isWarga()
    {
        return $this->role === self::ROLE_WARGA;
    }
}