<?php

namespace App\Http\Controllers;

use App\Models\RewardItem;
use App\Models\Redemption;
use App\Models\RedemptionItem;
use App\Models\PointLedger;
use App\Models\User;
use App\Notifications\NewRedemptionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Tampilkan detail item sebelum add to cart
     */
    public function detail(RewardItem $rewardItem)
    {
        // Load branch relation
        $rewardItem->load('branch');
        
        // Get user untuk cek saldo
        $user = Auth::user();
        
        return view('tukar.detail', compact('rewardItem', 'user'));
    }

    /**
     * Tambahkan item ke keranjang (Session-based)
     */
    public function add(Request $request, RewardItem $rewardItem)
    {
        // Validasi quantity
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ], [
            'quantity.required' => 'Kuantitas harus diisi',
            'quantity.min' => 'Kuantitas minimal 1',
        ]);

        $quantity = (int) $request->quantity;

        // Cek stok
        if ($rewardItem->stock < $quantity) {
            return back()->with('error', "⚠️ Stok tidak cukup! Stok tersedia: {$rewardItem->stock}");
        }

        // Ambil cart dari session (array of items)
        $cart = session()->get('cart', []);

        // Jika item sudah ada di cart, tambah quantity
        if (isset($cart[$rewardItem->id])) {
            $newQuantity = $cart[$rewardItem->id]['quantity'] + $quantity;
            
            // Cek total quantity vs stock
            if ($newQuantity > $rewardItem->stock) {
                return back()->with('error', "⚠️ Total kuantitas ({$newQuantity}) melebihi stok ({$rewardItem->stock})");
            }
            
            $cart[$rewardItem->id]['quantity'] = $newQuantity;
        } else {
            // Item baru, tambahkan ke cart
            $cart[$rewardItem->id] = [
                'id' => $rewardItem->id,
                'name' => $rewardItem->name,
                'points_required' => $rewardItem->points_cost,
                'quantity' => $quantity,
                'image' => $rewardItem->image,
                'stock' => $rewardItem->stock,
                'branch_id' => $rewardItem->branch_id,
            ];
        }

        // Simpan cart ke session
        session()->put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', "✅ {$rewardItem->name} berhasil ditambahkan ke keranjang!");
    }

    /**
     * Tampilkan halaman keranjang
     */
    public function index()
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);
        
        // Hitung total poin yang dibutuhkan
        $totalPoints = 0;
        foreach ($cart as $item) {
            $totalPoints += $item['points_required'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'user', 'totalPoints'));
    }

    /**
     * Update quantity item di keranjang
     */
    public function update(Request $request, RewardItem $rewardItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = (int) $request->quantity;
        $cart = session()->get('cart', []);

        // Cek stok
        if ($quantity > $rewardItem->stock) {
            return back()->with('error', "⚠️ Stok tidak cukup! Stok tersedia: {$rewardItem->stock}");
        }

        if (isset($cart[$rewardItem->id])) {
            $cart[$rewardItem->id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            
            return back()->with('success', '✅ Kuantitas berhasil diupdate!');
        }

        return back()->with('error', 'Item tidak ditemukan di keranjang');
    }

    /**
     * Hapus item dari keranjang
     */
    public function remove(RewardItem $rewardItem)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$rewardItem->id])) {
            unset($cart[$rewardItem->id]);
            session()->put('cart', $cart);
            
            return back()->with('success', '✅ Item berhasil dihapus dari keranjang!');
        }

        return back()->with('error', 'Item tidak ditemukan di keranjang');
    }

    /**
     * Kosongkan keranjang
     */
    public function clear()
    {
        session()->forget('cart');
        
        return back()->with('success', '✅ Keranjang berhasil dikosongkan!');
    }

    /**
     * Checkout - Proses redemption dari semua item di cart
     * 
     * ATOMIC TRANSACTION:
     * 1. Validasi saldo user
     * 2. Validasi stok semua item
     * 3. Create Redemption header
     * 4. Create RedemptionItems
     * 5. Kurangi stok reward items
     * 6. Deduct poin dari user
     * 7. Create PointLedger entry
     * 8. Clear cart
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);

        // Validasi cart tidak kosong
        if (empty($cart)) {
            return back()->with('error', '⚠️ Keranjang kosong! Tambahkan item terlebih dahulu.');
        }

        DB::beginTransaction();
        try {
            // ============================================================
            // STEP 1: VALIDASI SALDO & STOK
            // ============================================================
            $totalPoints = 0;
            $items = [];

            foreach ($cart as $cartItem) {
                // Re-fetch dari database untuk data terbaru
                $rewardItem = RewardItem::findOrFail($cartItem['id']);

                // Validasi stok
                if ($rewardItem->stock < $cartItem['quantity']) {
                    throw new \Exception("Stok {$rewardItem->name} tidak cukup! Tersedia: {$rewardItem->stock}, Diminta: {$cartItem['quantity']}");
                }

                $subtotal = $rewardItem->points_cost * $cartItem['quantity'];
                $totalPoints += $subtotal;

                $items[] = [
                    'rewardItem' => $rewardItem,
                    'quantity' => $cartItem['quantity'],
                    'subtotal' => $subtotal,
                ];
            }

            // Validasi saldo user
            if ($user->balance_points < $totalPoints) {
                throw new \Exception("Poin tidak cukup! Saldo: " . number_format($user->balance_points) . ", Dibutuhkan: " . number_format($totalPoints));
            }

            // ============================================================
            // STEP 2: CREATE REDEMPTION HEADER
            // ============================================================
            // Ambil branch_id dari item pertama di cart (semua item di cart pasti dari cabang yang sama)
            $firstItem = reset($items);
            $branchId = $firstItem['rewardItem']->branch_id;
            
            $redemption = Redemption::create([
                'user_id' => $user->id,
                'branch_id' => $branchId,
                'status' => 'pending', // Pending approval dari admin
                'total_points' => $totalPoints,
                'notes' => $request->notes ?? null,
            ]);

            // ============================================================
            // STEP 3: CREATE REDEMPTION ITEMS (JANGAN KURANGI STOK DULU)
            // ============================================================
            foreach ($items as $item) {
                // Create redemption item
                RedemptionItem::create([
                    'redemption_id' => $redemption->id,
                    'reward_item_id' => $item['rewardItem']->id,
                    'quantity' => $item['quantity'],
                    'points' => $item['rewardItem']->points_cost,
                ]);

                // STOK TIDAK DIKURANGI DI SINI
                // Stok akan dikurangi saat admin approve/confirm
            }

            // ============================================================
            // STEP 4: JANGAN KURANGI POIN DULU (pending approval)
            // ============================================================
            // Poin TIDAK dikurangi di sini
            // Poin akan dikurangi saat admin approve/confirm

            // ============================================================
            // STEP 5: TIDAK BUAT POINT LEDGER DULU
            // ============================================================
            // Point ledger akan dibuat saat admin approve/confirm

            // ============================================================
            // STEP 6: CLEAR CART
            // ============================================================
            session()->forget('cart');

            // ============================================================
            // STEP 7: KIRIM NOTIFIKASI KE ADMIN CABANG
            // ============================================================
            // Kirim notifikasi ke admin yang cabangnya sama dengan redemption
            $admins = User::where('role', 'admin')
                ->where('branch_id', $redemption->branch_id)
                ->get();
            
            if ($admins->isEmpty()) {
                // Fallback: jika tidak ada admin di cabang tersebut, kirim ke semua admin
                $admins = User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new NewRedemptionRequest($redemption));
                }
            }

            DB::commit();

            return redirect()->route('riwayat')
                ->with('success', "✅ Permintaan penukaran berhasil dikirim! Total {$totalPoints} poin akan dikurangi setelah admin menyetujui.");

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error
            \Log::error('Checkout error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'cart' => $cart,
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', '❌ Checkout gagal: ' . $e->getMessage());
        }
    }

    /**
     * Instant Redeem - Tukar langsung tanpa cart (single item)
     * 
     * FLOW:
     * 1. Validasi saldo & stok
     * 2. Create Redemption dengan 1 item
     * 3. Kurangi stok
     * 4. Deduct poin
     * 5. Create PointLedger
     * 6. Return JSON response
     * 
     * ATOMIC TRANSACTION - All or nothing
     */
    public function instantRedeem(Request $request, RewardItem $rewardItem)
    {
        // Validasi quantity
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ], [
            'quantity.required' => 'Kuantitas harus diisi',
            'quantity.min' => 'Kuantitas minimal 1',
        ]);

        $user = Auth::user();
        $quantity = (int) $request->quantity;

        DB::beginTransaction();
        try {
            // ============================================================
            // STEP 1: VALIDASI STOK
            // ============================================================
            if ($rewardItem->stock < $quantity) {
                throw new \Exception("Stok tidak cukup! Tersedia: {$rewardItem->stock}, Diminta: {$quantity}");
            }

            // ============================================================
            // STEP 2: VALIDASI SALDO
            // ============================================================
            $totalPoints = $rewardItem->points_cost * $quantity;
            
            if ($user->balance_points < $totalPoints) {
                throw new \Exception("Poin tidak cukup! Saldo: " . number_format($user->balance_points) . ", Dibutuhkan: " . number_format($totalPoints));
            }

            // ============================================================
            // STEP 3: CREATE REDEMPTION HEADER
            // ============================================================
            $redemption = Redemption::create([
                'user_id' => $user->id,
                'branch_id' => $user->branch_id,
                'status' => 'pending', // Pending approval dari admin
                'total_points' => $totalPoints,
                'notes' => 'Instant Redeem (tanpa cart)',
            ]);

            // ============================================================
            // STEP 4: CREATE REDEMPTION ITEM (JANGAN KURANGI STOK DULU)
            // ============================================================
            RedemptionItem::create([
                'redemption_id' => $redemption->id,
                'reward_item_id' => $rewardItem->id,
                'quantity' => $quantity,
                'points' => $rewardItem->points_cost,
            ]);

            // STOK TIDAK DIKURANGI DI SINI
            // Stok akan dikurangi saat admin approve/confirm

            // ============================================================
            // STEP 5: JANGAN KURANGI POIN DULU (pending approval)
            // ============================================================
            // Poin TIDAK dikurangi di sini
            // Poin akan dikurangi saat admin approve/confirm

            // ============================================================
            // STEP 6: TIDAK BUAT POINT LEDGER DULU
            // ============================================================
            // Point ledger akan dibuat saat admin approve/confirm


            // ============================================================
            // STEP 7: KIRIM NOTIFIKASI KE ADMIN CABANG
            // ============================================================
            // Ambil branch_id dari reward item yang ditukar
            $branchId = $rewardItem->branch_id ?? null;
            
            if ($branchId) {
                // Cari admin yang branch_id-nya sama dengan barang yang ditukar
                $admins = User::where('role', 'admin')
                    ->where('branch_id', $branchId)
                    ->get();
                
                foreach ($admins as $admin) {
                    $admin->notify(new NewRedemptionRequest($redemption));
                }
            }

            DB::commit();

            // Return JSON response untuk AJAX
            return response()->json([
                'success' => true,
                'message' => "✅ Permintaan penukaran {$quantity}x {$rewardItem->name} berhasil dikirim! Poin ({$totalPoints}) akan dikurangi setelah admin menyetujui.",
                'data' => [
                    'redemption_id' => $redemption->id,
                    'total_points' => $totalPoints,
                    'balance_after' => $user->balance_points, // Masih balance awal karena belum dikurangi
                ]
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log error
            \Log::error('Instant redeem error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'reward_item_id' => $rewardItem->id,
                'quantity' => $quantity,
                'trace' => $e->getTraceAsString()
            ]);

            // Return JSON error response
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
