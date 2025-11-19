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
        $wasteTypes = WasteType::latest()->paginate(20);
        return view('admin.waste_types.index', compact('wasteTypes'));
    }

    // Form tambah data
    public function create()
    {
        return view('admin.waste_types.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:Plastik,Kertas,Logam,Kaca,Elektronik,Lainnya',
            'unit' => 'required|string|in:kg,liter,pcs',
            'points_per_unit' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ], [
            'name.required' => 'Nama jenis sampah wajib diisi',
            'category.required' => 'Kategori wajib dipilih',
            'category.in' => 'Kategori tidak valid',
            'unit.required' => 'Satuan wajib dipilih',
            'points_per_unit.required' => 'Harga poin wajib diisi',
            'points_per_unit.min' => 'Harga poin minimal 1',
        ]);

        // Set branch_id if admin has one
        if (auth()->user()->branch_id) {
            $validated['branch_id'] = auth()->user()->branch_id;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        WasteType::create($validated);

        return redirect()->route('admin.waste-types.index')
            ->with('success', 'Berhasil menambahkan jenis sampah');
    }

    // Form edit data
    public function edit(WasteType $wasteType)
    {
        return view('admin.waste_types.edit', compact('wasteType'));
    }

    // Update data
    public function update(Request $request, WasteType $wasteType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|in:Plastik,Kertas,Logam,Kaca,Elektronik,Lainnya',
            'unit' => 'required|string|in:kg,liter,pcs',
            'points_per_unit' => 'required|numeric|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ], [
            'name.required' => 'Nama jenis sampah wajib diisi',
            'category.required' => 'Kategori wajib dipilih',
            'category.in' => 'Kategori tidak valid',
            'unit.required' => 'Satuan wajib dipilih',
            'points_per_unit.required' => 'Harga poin wajib diisi',
            'points_per_unit.min' => 'Harga poin minimal 1',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($wasteType->image && file_exists(public_path('images/' . $wasteType->image))) {
                unlink(public_path('images/' . $wasteType->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

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