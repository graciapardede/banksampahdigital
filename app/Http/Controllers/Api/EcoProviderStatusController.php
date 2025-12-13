<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EcoProviderService;
use Illuminate\Http\JsonResponse;

class EcoProviderStatusController extends Controller
{
    protected $ecoProviderService;

    public function __construct(EcoProviderService $ecoProviderService)
    {
        $this->ecoProviderService = $ecoProviderService;
    }

    /**
     * Check EcoProvider API Status
     */
    public function checkStatus(): JsonResponse
    {
        $status = $this->ecoProviderService->checkStatus();
        
        return response()->json([
            'status' => $status['status'] ?? 'unknown',
            'code' => $status['code'] ?? null,
            'error' => $status['error'] ?? null,
            'timestamp' => now()->toIso8601String(),
            'app_env' => config('app.env'),
        ], $status['status'] === 'ok' ? 200 : 503);
    }
}
