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
    Route::get('/me', [UserController::class, 'profile']);

    // Deposits (Setor Sampah)
    Route::get('/deposits', [DepositController::class, 'index']);
    Route::post('/deposits', [DepositController::class, 'store']);
    Route::get('/deposits/{id}', [DepositController::class, 'show']);

    // Waste Types
    Route::get('/waste-types', [WasteTypeController::class, 'index']);

    // Redemptions (Tukar Poin)
    Route::get('/redemptions', [RedemptionController::class, 'index']);
    Route::post('/redemptions', [RedemptionController::class, 'store']);
    Route::get('/redemptions/{id}', [RedemptionController::class, 'show']);

    // Reward Items (Barang Penukaran)
    Route::get('/reward-items', [RewardItemController::class, 'index']);

    // Branches
    Route::get('/branches', [BranchController::class, 'index']);
});

// Optional public routes
Route::get('/branches', [BranchController::class, 'index']);

