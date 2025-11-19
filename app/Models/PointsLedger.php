<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsLedger extends Model
{
    protected $table = 'points_ledger';

    protected $fillable = [
        'user_id',
        'type',
        'points',
        'balance',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}