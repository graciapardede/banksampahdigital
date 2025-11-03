<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'branch_id',
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

    public function redemptions(): HasMany
    {
        return $this->hasMany(Redemption::class);
    }

    public function ledger(): HasMany
    {
        return $this->hasMany(PointLedger::class);
    }
}
