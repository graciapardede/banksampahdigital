use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    DepositController,
    RedemptionController,
    WasteTypeController,
    RewardItemController,
    BranchController
};

// Auth protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Profile & User Info
    Route::get('/me', [\App\Http\Controllers\Api\ProfileController::class, 'show']);

    // Deposits (Setor Sampah) - User hanya bisa lihat riwayat
    Route::get('/deposits', [DepositController::class, 'index']);
    Route::get('/deposits/{id}', [DepositController::class, 'show']);

    // Waste Types
    Route::get('/waste-types', [WasteTypeController::class, 'index']);

    // Redemptions (Tukar Poin) - User bisa submit
    Route::get('/redemptions', [RedemptionController::class, 'index']);
    Route::post('/redemptions', [RedemptionController::class, 'store']);
    Route::get('/redemptions/{id}', [RedemptionController::class, 'show']);

    // Reward Items (Barang Penukaran)
    Route::get('/reward-items', [RewardItemController::class, 'index']);
    Route::get('/reward-items/{id}', [RewardItemController::class, 'show']);

    // Branches
    Route::get('/branches', [BranchController::class, 'index']);
});

// Optional public routes
Route::get('/branches', [BranchController::class, 'index']);

