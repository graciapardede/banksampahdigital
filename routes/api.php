use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Simple API Register (No Request class)
Route::post('/register', function (Request $request) {
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'nullable|string|max:30',
        'address' => 'nullable|string|max:1000',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $request->full_name,
        'full_name' => $request->full_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'password' => Hash::make($request->password),
        'role' => User::ROLE_WARGA,
        'balance_points' => 0,
    ]);

    $token = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Registration successful',
        'data' => [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'role' => $user->role,
                'balance_points' => $user->balance_points,
            ],
            'token' => $token,
            'token_type' => 'Bearer'
        ]
    ], 201);
});

// Simple API Login
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'The provided credentials are incorrect.'
        ], 401);
    }

    // Delete old tokens
    $user->tokens()->delete();

    // Generate new token
    $token = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'Login successful',
        'data' => [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
                'role' => $user->role,
                'balance_points' => $user->balance_points,
            ],
            'token' => $token,
            'token_type' => 'Bearer'
        ]
    ], 200);
});
Route::get('/branches', [BranchController::class, 'index']);

// Auth protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth endpoints
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

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
});

