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

    /**
     * Hitung sisa waktu pengambilan (dalam detik)
     * Return: sisa detik, atau 0 jika sudah expired
     */
    public function getRemainingTimeInSeconds()
    {
        if (!$this->expires_at || $this->status !== 'confirmed') {
            return 0;
        }

        $remaining = $this->expires_at->diffInSeconds(now(), false);
        return max(0, $remaining);
    }

    /**
     * Format sisa waktu untuk display (HH:MM:SS)
     */
    public function getFormattedRemainingTime()
    {
        $seconds = $this->getRemainingTimeInSeconds();
        
        if ($seconds <= 0) {
            return 'Waktu habis';
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
    }

    /**
     * Check apakah sudah expired
     */
    public function isExpired()
    {
        return $this->status === 'confirmed' && now()->isAfter($this->expires_at);
    }
}
