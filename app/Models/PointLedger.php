<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointLedger extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deposit_id',
        'redemption_id',
        'type',
        'amount',
        'balance_after',
        'description',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deposit()
    {
        return $this->belongsTo(Deposit::class);
    }

    public function redemption()
    {
        return $this->belongsTo(Redemption::class);
    }
}
