<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deposit extends Model
{
    protected $fillable = [
        'user_id', 'branch_id', 'status', 'total_weight', 'total_points'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(DepositItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
