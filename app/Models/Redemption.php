<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Redemption extends Model
{
    protected $fillable = [
        'user_id', 'branch_id', 'status', 'total_points'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(RedemptionItem::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
