<?php

use App\Models\WasteType;

function wastePoints($wasteTypeId)
{
    return WasteType::findOrFail($wasteTypeId)->points_per_unit;
}
