<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardItem extends Model
{
    protected $fillable = [
        'branch_id',
        'name',
        'stock',
        'points_cost',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function redemptionItems()
    {
        return $this->hasMany(RedemptionItem::class);
    }
}