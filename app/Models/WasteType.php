<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteType extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name',
        'category',
        'unit',
        'points_per_unit',
        'description',
        'image',
    ];

    public function depositItems()
    {
        return $this->hasMany(DepositItem::class);
    }
}