<?php

namespace App\Http\Controllers;

use App\Models\RewardItem;
use Illuminate\Http\Request;

class RewardItemController extends Controller
{
    /**
     * Get all reward items (for user tukar-poin page)
     */
    public function index()
    {
        $rewardItems = RewardItem::where('stock', '>', 0)
            ->orderBy('points_cost')
            ->get();
            
        return response()->json($rewardItems);
    }
    
    /**
     * Get single reward item detail
     */
    public function show($id)
    {
        $rewardItem = RewardItem::findOrFail($id);
        return response()->json($rewardItem);
    }
}
