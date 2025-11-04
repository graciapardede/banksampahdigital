<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedemptionItem extends Model
{
    protected $fillable = [
        'redemption_id',
        'reward_item_id',
        'quantity',
        'points',
    ];

    public function redemption()
    {
        return $this->belongsTo(Redemption::class);
    }

    public function rewardItem()
    {
        return $this->belongsTo(RewardItem::class);
    }
}