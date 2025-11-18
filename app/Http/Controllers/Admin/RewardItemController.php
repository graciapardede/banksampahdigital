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
        $query = RewardItem::with('branch');

        // Filter by branch if admin has branch_id
        $adminBranchId = auth()->user()->branch_id;
        if ($adminBranchId) {
            $query->where('branch_id', $adminBranchId);
        }

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
        
        // Calculate statistics
        $allItems = RewardItem::when($adminBranchId, fn($q) => $q->where('branch_id', $adminBranchId));
        $stats = [
            'total' => $allItems->count(),
            'active' => $allItems->where('stock', '>', 0)->count(),
            'total_stock' => $allItems->sum('stock'),
            'low_stock' => $allItems->where('stock', '>', 0)->where('stock', '<', 10)->count(),
            'total_redeemed' => 0, // TODO: calculate from redemptions
        ];
        
        return view('admin.reward_items.index', compact('rewardItems', 'stats'));
    }

    /**
     * Form tambah barang reward
     */
    public function create()
    {
        return view('admin.reward_items.create');
    }

    /**
     * Simpan barang reward baru
     */
    public function store(Request $request)
    {
        try {
            // Log untuk debugging
            \Log::info('Store Reward Item - Request Data:', $request->all());
            \Log::info('Has Image File:', ['has_file' => $request->hasFile('image')]);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'points_cost' => 'required|numeric|min:1',
                'stock' => 'nullable|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            ]);

            // Set default stock if not provided
            if (!isset($validated['stock'])) {
                $validated['stock'] = 0;
            }

            // Set branch_id from authenticated admin
            $validated['branch_id'] = auth()->user()->branch_id ?? 1;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName);
                $validated['image'] = $imageName;
                \Log::info('Image uploaded:', ['filename' => $imageName]);
            }

            $item = RewardItem::create($validated);
            \Log::info('Reward Item created successfully:', [
                'id' => $item->id,
                'name' => $item->name,
                'image' => $item->image
            ]);

            return redirect()->route('admin.reward-items.index')
                ->with('success', 'Barang reward berhasil ditambahkan!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Failed to create reward item:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->back()
                ->with('error', 'Gagal menambahkan barang: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show detail barang reward
     */
    public function show(RewardItem $rewardItem)
    {
        return view('admin.reward_items.show', compact('rewardItem'));
    }

    /**
     * Form edit barang reward
     */
    public function edit(RewardItem $rewardItem)
    {
        return view('admin.reward_items.edit', compact('rewardItem'));
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
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($rewardItem->image && file_exists(public_path('images/' . $rewardItem->image))) {
                unlink(public_path('images/' . $rewardItem->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
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
        $rewardItem->delete();

        return redirect()->route('admin.reward-items.index')
            ->with('success', 'Barang reward berhasil dihapus!');
    }

    /**
     * Update stock (add or subtract)
     */
    public function updateStock(Request $request, RewardItem $rewardItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'action' => 'required|in:add,subtract',
        ]);

        if ($validated['action'] === 'add') {
            $rewardItem->stock += $validated['quantity'];
        } else {
            $rewardItem->stock = max(0, $rewardItem->stock - $validated['quantity']);
        }

        $rewardItem->save();

        return redirect()->route('admin.reward-items.index')
            ->with('success', 'Stok berhasil diupdate!');
    }
}
