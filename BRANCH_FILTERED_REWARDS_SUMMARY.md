# Branch-Filtered Reward System - Implementation Summary

## Overview
Sistem Tukar Poin sekarang dilengkapi dengan filter cabang yang memungkinkan warga untuk melihat dan menukar reward berdasarkan cabang yang dipilih. Semua validasi dilakukan di server-side untuk keamanan maksimal.

## Fitur yang Telah Diimplementasikan

### 1. **Branch Filter Dropdown** ✅
- Dropdown pilihan cabang di halaman `/tukar-poin`
- Default: cabang user yang login
- Onchange: reload halaman dengan parameter `branch_id`
- Menampilkan semua cabang dari database (ordered by name)

**Lokasi:** `resources/views/tukar-poin.blade.php` (line ~125-145)

### 2. **Backend Branch Filtering** ✅
- Controller filter reward items berdasarkan `branch_id` yang dipilih
- Query: `WHERE branch_id = selected AND stock > 0`
- Return 3 data ke view: `$rewardItems`, `$branches`, `$selectedBranch`

**Lokasi:** `app/Http/Controllers/RedemptionController.php::create()`

```php
public function create(Request $request)
{
    $selectedBranch = $request->input('branch_id', Auth::user()->branch_id);
    
    $rewardItems = RewardItem::where('branch_id', $selectedBranch)
        ->where('stock', '>', 0)
        ->get();
        
    $branches = Branch::orderBy('name')->get();
    
    return view('tukar-poin', compact('rewardItems', 'branches', 'selectedBranch'));
}
```

### 3. **Server-Side Rendering** ✅
- Rewards di-render menggunakan `@foreach($rewardItems)` di Blade
- Tidak lagi menggunakan client-side fetch dari API
- Setiap item menampilkan: nama, deskripsi, gambar, poin, stok
- Button "Tukar Sekarang" dengan `onclick="selectReward({{ $item->id }})"`

**Lokasi:** `resources/views/tukar-poin.blade.php` (line ~165-215)

### 4. **Transaction Validation** ✅
Server-side validation di `RedemptionController::store()`:

#### a. Branch Validation
```php
if ($reward->branch_id != $request->branch_id) {
    return response()->json(['message' => 'Barang bukan dari cabang terpilih'], 400);
}
```

#### b. Points Validation
```php
if ($user->balance_points < $totalPoints) {
    return response()->json(['message' => 'Poin tidak cukup'], 400);
}
```

#### c. Stock Validation
```php
if ($reward->stock < $item['quantity']) {
    return response()->json(['message' => "Stok {$reward->name} tidak cukup"], 400);
}
```

**Lokasi:** `app/Http/Controllers/RedemptionController.php::store()`

### 5. **Automatic Stock Decrement** ✅
```php
$reward->decrement('stock', $item['quantity']);
```
Stok berkurang otomatis setelah redemption berhasil dibuat.

**Lokasi:** `app/Http/Controllers/RedemptionController.php::store()` (line ~95)

### 6. **Status Management** ✅
Status redemption diset ke `'MENUNGGU'` (bukan 'pending'):
```php
$redemption = Redemption::create([
    'user_id' => $userId,
    'branch_id' => $request->branch_id,
    'total_points' => $totalPoints,
    'status' => 'MENUNGGU',  // <-- Changed
    'redemption_date' => now(),
]);
```

**Lokasi:** `app/Http/Controllers/RedemptionController.php::store()` (line ~78)

### 7. **JavaScript Modal Integration** ✅
Updated JavaScript untuk menggunakan data dari backend:

```javascript
// Data dari backend (tidak perlu fetch lagi)
const allRewards = @json($rewardItems);
const selectedBranchId = {{ $selectedBranch }};
const currentPoints = {{ Auth::user()->balance_points ?? 0 }};

// Function selectReward menggunakan data backend
function selectReward(rewardId) {
    selectedReward = allRewards.find(r => r.id === rewardId);
    if (!selectedReward) return;
    openConfirmModal();
}

// API call dengan branch_id untuk validasi
async function confirmExchange() {
    const response = await fetch('/api/redemptions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        },
        body: JSON.stringify({
            branch_id: selectedBranchId, // <-- Include untuk validasi
            items: [{
                reward_item_id: selectedReward.id,
                quantity: 1
            }]
        })
    });
}
```

**Lokasi:** `resources/views/tukar-poin.blade.php` (line ~915-1010)

## Database Schema (Existing)
Table `reward_items` sudah memiliki kolom `branch_id`:
```sql
branch_id: foreignId()->constrained()->cascadeOnDelete()
```
Tidak ada migration yang perlu dijalankan.

## Flow Diagram

```
[User Login] → [/tukar-poin Page]
                    ↓
         [Select Branch from Dropdown]
                    ↓
         GET /tukar-poin?branch_id=X
                    ↓
    [RedemptionController::create()]
         - Filter: WHERE branch_id = X AND stock > 0
         - Return: $rewardItems, $branches, $selectedBranch
                    ↓
         [Blade Render Grid]
         @foreach($rewardItems)
                    ↓
         [Click "Tukar Sekarang"]
              onclick="selectReward(id)"
                    ↓
         [Modal Konfirmasi]
         - Display: nama, poin, stok
         - Calculate: sisa poin
                    ↓
         [Confirm Exchange]
              POST /api/redemptions
              Body: { branch_id, items: [...] }
                    ↓
    [RedemptionController::store()]
         ✓ Validate: branch match
         ✓ Validate: sufficient points
         ✓ Validate: stock availability
         ✓ Create: Redemption + RedemptionItems
         ✓ Decrement: reward stock
         ✓ Status: 'MENUNGGU'
                    ↓
         [Success Modal]
              Redirect to /riwayat
```

## Testing Checklist

### ✅ Completed
- [x] Branch dropdown di halaman tukar-poin berfungsi
- [x] Rewards filtered by selected branch
- [x] Rewards grid server-side rendered via Blade
- [x] Button "Tukar Sekarang" memanggil `selectReward()`
- [x] Modal konfirmasi menggunakan data backend
- [x] API call includes `branch_id` parameter
- [x] Backend validates branch_id match
- [x] Backend validates sufficient points
- [x] Backend validates stock availability
- [x] Stock decrements on redemption
- [x] Status set to 'MENUNGGU'
- [x] CSRF token included in requests

### ⚠️ Pending Tests (Manual)
- [ ] Test: User A cabang 1 tidak bisa tukar reward cabang 2
- [ ] Test: User dengan poin tidak cukup tidak bisa tukar
- [ ] Test: Reward dengan stok 0 tidak bisa ditukar
- [ ] Test: Stok berkurang setelah redemption berhasil
- [ ] Test: Success modal redirect ke /riwayat
- [ ] Test: Error message tampil saat validasi gagal

## Next Steps (Future)

### 1. Admin Branch-Scoped Access
```php
// Di Admin RewardItemController
public function index()
{
    $user = Auth::user();
    
    // Super Admin sees all
    if ($user->role === 'super_admin') {
        $items = RewardItem::all();
    } 
    // Branch Admin sees only their branch
    else {
        $items = RewardItem::where('branch_id', $user->branch_id)->get();
    }
    
    return view('admin.reward-items.index', compact('items'));
}
```

### 2. Points Deduction on Approval
Currently, points are NOT deducted when redemption is created (status: MENUNGGU).
Points should be deducted when admin approves:

```php
// Di Admin RedemptionController::approve()
public function approve($id)
{
    $redemption = Redemption::findOrFail($id);
    $user = $redemption->user;
    
    // Deduct points
    $user->decrement('balance_points', $redemption->total_points);
    
    // Update status
    $redemption->update(['status' => 'SELESAI']);
    
    return redirect()->back()->with('success', 'Penukaran disetujui');
}
```

### 3. Multi-Branch Reporting
- Dashboard admin menampilkan statistik per cabang
- Report redemption per cabang per periode
- Stock alerts per cabang (stok menipis)

### 4. Branch Transfer (Advanced)
Jika diperlukan, admin bisa transfer stok antar cabang:
```php
// Transfer stok dari Cabang A ke Cabang B
RewardItem::create([
    'name' => $item->name,
    'branch_id' => $targetBranchId,
    'stock' => $transferQty,
    // ... other fields
]);

$item->decrement('stock', $transferQty);
```

## Important Notes

### Security
- ✅ All validations done server-side
- ✅ Branch_id validated against reward's actual branch
- ✅ Points validated against user's current balance
- ✅ Stock validated against available quantity
- ✅ CSRF protection enabled

### Performance
- Server-side rendering eliminates extra API calls
- Data already filtered by SQL WHERE clause
- No unnecessary client-side filtering

### User Experience
- Instant branch switching (GET request reload)
- Clear stock visibility
- Disabled buttons for out-of-stock items
- Insufficient points warning in modal

## Files Modified

1. **app/Http/Controllers/RedemptionController.php**
   - `create()`: Added branch filtering logic
   - `store()`: Added branch validation, stock decrement, status change

2. **resources/views/tukar-poin.blade.php**
   - Added branch filter dropdown
   - Changed from hardcoded to `@foreach($rewardItems)`
   - Updated JavaScript to use backend data
   - Removed old fetchRewards() function
   - Added `onclick="selectReward()"` to buttons
   - Updated confirmExchange() to include branch_id

## API Endpoints

### GET /tukar-poin
**Parameters:**
- `branch_id` (optional): Filter rewards by branch

**Response:** HTML page with filtered rewards

### POST /api/redemptions
**Headers:**
- `X-CSRF-TOKEN`: Required
- `Content-Type`: application/json

**Body:**
```json
{
  "branch_id": 1,
  "items": [
    {
      "reward_item_id": 5,
      "quantity": 1
    }
  ]
}
```

**Success Response (200):**
```json
{
  "message": "Penukaran berhasil",
  "redemption": { ... }
}
```

**Error Responses:**
- 400: "Barang bukan dari cabang terpilih"
- 400: "Poin tidak cukup"
- 400: "Stok {item} tidak cukup"
- 404: "Barang tidak ditemukan"

## Conclusion

✅ **Branch-filtered reward system telah selesai diimplementasikan dengan lengkap:**
- Filter cabang berfungsi
- Server-side validation aktif
- Stock management otomatis
- User experience optimal
- Security terjaga

⚠️ **Yang masih pending:**
- Admin branch-scoped access (filter reward per admin branch)
- Points deduction on admin approval
- Manual testing complete flow

📝 **Dokumentasi ini dibuat pada:** 2024
