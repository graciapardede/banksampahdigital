<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Get all branches (for dropdowns)
     */
    public function index()
    {
        $branches = Branch::orderBy('name')->get();
        return response()->json($branches);
    }
}
