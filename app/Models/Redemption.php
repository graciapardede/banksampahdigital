<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
    protected $fillable = [
        'user_id',
        'branch_id',
        'total_points',
        'status',
        'rejection_reason',
        'expires_at',
        'processed_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function items()
    {
        return $this->hasMany(RedemptionItem::class);
    }

    public function redemptionItems()
    {
        return $this->hasMany(RedemptionItem::class);
    }

    /**
     * Get total points (calculate from items if not set)
     */
    public function getTotalPointsAttribute($value)
    {
        // If value exists in database, return it
        if (isset($this->attributes['total_points']) && $this->attributes['total_points'] > 0) {
            return $this->attributes['total_points'];
        }
        
        // Otherwise calculate from items
        return $this->redemptionItems->sum(function($item) {
            return $item->quantity * ($item->rewardItem->points_required ?? 0);
        });
    }
}