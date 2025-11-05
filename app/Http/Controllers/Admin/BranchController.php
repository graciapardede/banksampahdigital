<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    // Tampilkan semua cabang
    public function index()
    {
        $branches = Branch::latest()->paginate(10);
        return view('admin.branches.index', compact('branches'));
    }

    // Form tambah cabang
    public function create()
    {
        return view('admin.branches.create');
    }

    // Simpan cabang baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        Branch::create($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Cabang berhasil ditambahkan!');
    }

    // Form edit cabang
    public function edit(Branch $branch)
    {
        return view('admin.branches.edit', compact('branch'));
    }

    // Update cabang
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
        ]);

        $branch->update($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Cabang berhasil diupdate!');
    }

    // Hapus cabang
    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()->route('admin.branches.index')
            ->with('success', 'Cabang berhasil dihapus!');
    }
}