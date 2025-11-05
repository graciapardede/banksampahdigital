<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'points_per_unit',
    ];

    public function depositItems()
    {
        return $this->hasMany(DepositItem::class);
    }
}