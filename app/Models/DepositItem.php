<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepositItem extends Model
{
    protected $fillable = [
        'deposit_id',
        'waste_type_id',
        'weight',
        'points',
    ];

    public function deposit()
    {
        return $this->belongsTo(Deposit::class);
    }

    public function wasteType()
    {
        return $this->belongsTo(WasteType::class);
    }
}