<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display bank sampah branch locations on Google Maps
     */
    public function index()
    {
        // Data cabang Bank Sampah di Toba Samosir
        $branches = [
            [
                'name' => 'Bank Sampah Sitoluama',
                'lat' => 2.383504625577555,
                'lng' => 99.14856842160157,
                'address' => 'Institut Teknologi Del, Sitoluama, Laguboti, Toba',
                'phone' => '0632-331234',
            ],
            [
                'name' => 'Bank Sampah Balige',
                'lat' => 2.3389718144967317,
                'lng' => 99.08154846392925,
                'address' => 'Hotel Labersa, Jl. Sisingamangaraja, Balige, Toba',
                'phone' => '0632-21234',
            ],
        ];

        // Get user points
        $saldoPoin = \App\Models\PointsLedger::where('user_id', \Auth::id())->sum('points');

        // Pass data to view
        return view('lokasi.index', compact('branches', 'saldoPoin'));
    }
}
