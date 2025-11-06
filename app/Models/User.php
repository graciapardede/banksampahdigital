<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Relations\HasMany;
>>>>>>> 0742658938ebbdd2973ae8919b335d0a55ca6495
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
<<<<<<< HEAD
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
        'password',
        'role',
        'branch',
        'branch_id',
        'balance_points',
=======
    use HasFactory, Notifiable; 

    // Role constants
    const ROLE_ADMIN = 'admin';
    const ROLE_WARGA = 'warga';

    protected $fillable = [
        'name', 'full_name', 'email', 'phone', 'address', 'password', 'role', 'branch_id', 'balance_points',
>>>>>>> 0742658938ebbdd2973ae8919b335d0a55ca6495
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
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    // Compatibility helper required by the controllers
    public function isWarga()
    {
        return $this->role === self::ROLE_WARGA || $this->role === 'user';
    }
}