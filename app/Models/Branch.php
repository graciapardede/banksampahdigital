<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function rewardItems()
    {
        return $this->hasMany(RewardItem::class);
    }
}