<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WasteType;
use Illuminate\Http\Request;

class WasteTypeController extends Controller
{
    // Tampilkan semua data
    public function index()
    {
        $wasteTypes = WasteType::latest()->paginate(10);
        return view('admin.waste-types.index', compact('wasteTypes'));
    }

    // Form tambah data
    public function create()
    {
        return view('admin.waste-types.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'points_per_unit' => 'required|numeric|min:0',
        ]);

        WasteType::create($validated);

        return redirect()->route('admin.waste-types.index')
            ->with('success', 'Jenis sampah berhasil ditambahkan!');
    }

    // Form edit data
    public function edit(WasteType $wasteType)
    {
        return view('admin.waste-types.edit', compact('wasteType'));
    }

    // Update data
    public function update(Request $request, WasteType $wasteType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'points_per_unit' => 'required|numeric|min:0',
        ]);

        $wasteType->update($validated);

        return redirect()->route('admin.waste-types.index')
            ->with('success', 'Jenis sampah berhasil diupdate!');
    }

    // Hapus data
    public function destroy(WasteType $wasteType)
    {
        $wasteType->delete();

        return redirect()->route('admin.waste-types.index')
            ->with('success', 'Jenis sampah berhasil dihapus!');
    }
}