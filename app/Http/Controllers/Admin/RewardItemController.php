<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RewardItem;
use Illuminate\Http\Request;

class RewardItemController extends Controller
{
    /**
     * Tampilkan semua barang reward
     */
    public function index(Request $request)
    {
        $query = RewardItem::query();

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by status (stock)
        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'aktif') {
                $query->where('stock', '>', 0);
            } elseif ($request->status === 'habis') {
                $query->where('stock', '=', 0);
            }
        }

        $rewardItems = $query->latest()->paginate(20);
        
        return view('admin.tukar_barang.index', compact('rewardItems'));
    }

    /**
     * Form tambah barang reward
     */
    public function create()
    {
        return view('admin.tukar_barang.create');
    }

    /**
     * Simpan barang reward baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_cost' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reward_items', 'public');
            $validated['image'] = $imagePath;
        }

        RewardItem::create($validated);

        return redirect()->route('admin.reward-items.index')
            ->with('success', 'Barang reward berhasil ditambahkan!');
    }

    /**
     * Form edit barang reward
     */
    public function edit(RewardItem $rewardItem)
    {
        return view('admin.tukar_barang.edit', compact('rewardItem'));
    }

    /**
     * Update barang reward
     */
    public function update(Request $request, RewardItem $rewardItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_cost' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($rewardItem->image && \Storage::disk('public')->exists($rewardItem->image)) {
                \Storage::disk('public')->delete($rewardItem->image);
            }

            $imagePath = $request->file('image')->store('reward_items', 'public');
            $validated['image'] = $imagePath;
        }

        $rewardItem->update($validated);

        return redirect()->route('admin.reward-items.index')
            ->with('success', 'Barang reward berhasil diupdate!');
    }

    /**
     * Hapus barang reward
     */
    public function destroy(RewardItem $rewardItem)
    {
        // Hapus gambar jika ada
        if ($rewardItem->image && \Storage::disk('public')->exists($rewardItem->image)) {
            \Storage::disk('public')->delete($rewardItem->image);
        }

        $rewardItem->delete();

        return redirect()->route('admin.reward-items.index')
            ->with('success', 'Barang reward berhasil dihapus!');
    }
}
