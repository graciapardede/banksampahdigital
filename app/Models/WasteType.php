<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    use HasFactory;

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