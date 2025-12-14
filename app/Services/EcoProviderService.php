<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class EcoProviderService
{
    protected $timeout;
    protected $maxRetries;
    protected $cacheExpire;
    protected $apiKey;
    protected $apiSecret;

    public function __construct()
    {
        $this->timeout = (int) env('ECO_API_TIMEOUT', 10);
        $this->maxRetries = 3;
        $this->cacheExpire = (int) env('ECO_API_CACHE', 30);
        $this->apiKey = env('ECO_API_KEY', '');
        $this->apiSecret = env('ECO_API_SECRET', '');
    }

    /**
     * Get News from EcoProvider API with caching and error handling
     */
    public function getNews()
    {
        $cacheKey = 'eco_provider_news';

        if ($this->cacheExpire > 0 && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $data = $this->fetchWithRetry(env('ECO_NEWS_API', 'http://services.bsdgs.fun/api/news'), 'news');

        if (!empty($data) && $this->cacheExpire > 0) {
            Cache::put($cacheKey, $data, now()->addMinutes($this->cacheExpire));
        }

        return $data;
    }

    /**
     * Get Events from EcoProvider API with caching and error handling
     */
    public function getEvents()
    {
        $cacheKey = 'eco_provider_events';

        if ($this->cacheExpire > 0 && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $data = $this->fetchWithRetry(env('ECO_EVENTS_API', 'http://services.bsdgs.fun/api/events'), 'events');

        if (!empty($data) && $this->cacheExpire > 0) {
            Cache::put($cacheKey, $data, now()->addMinutes($this->cacheExpire));
        }

        return $data;
    }

    /**
     * Get Tips from EcoProvider API with caching and error handling
     */
    public function getTips()
    {
        $cacheKey = 'eco_provider_tips';

        if ($this->cacheExpire > 0 && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $data = $this->fetchWithRetry(env('ECO_TIPS_API', 'http://services.bsdgs.fun/api/tips'), 'tips');

        if (!empty($data) && $this->cacheExpire > 0) {
            Cache::put($cacheKey, $data, now()->addMinutes($this->cacheExpire));
        }

        return $data;
    }

    /**
     * Check API Status
     */
    public function checkStatus()
    {
        try {
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            if (!empty($this->apiKey)) {
                $headers['X-API-Key'] = $this->apiKey;
            }

            $response = Http::timeout($this->timeout)
                ->withHeaders($headers)
                ->withOptions(['verify' => app()->environment('production')])
                ->get(env('ECO_STATUS_API', 'http://127.0.0.1:8001/api/status'));

            if ($response->successful()) {
                return [
                    'status' => 'ok',
                    'code' => $response->status(),
                    'timestamp' => now(),
                ];
            }

            return [
                'status' => 'error',
                'code' => $response->status(),
                'timestamp' => now(),
            ];
        } catch (\Exception $e) {
            Log::error('EcoProvider Status Check Error', [
                'error' => $e->getMessage(),
            ]);
            
            return [
                'status' => 'unreachable',
                'error' => $e->getMessage(),
                'timestamp' => now(),
            ];
        }
    }

    /**
     * Fetch data with retry mechanism and error handling
     */
    private function fetchWithRetry(string $url, string $type, int $attempt = 1)
    {
        try {
            if (empty($url)) {
                Log::error("EcoProvider API Error: Empty URL for {$type}");
                return [];
            }

            // Build headers with authentication if available
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];

            if (!empty($this->apiKey)) {
                $headers['X-API-Key'] = $this->apiKey;
            }

            if (!empty($this->apiSecret)) {
                $headers['X-API-Secret'] = $this->apiSecret;
            }

            $response = Http::timeout($this->timeout)
                ->withHeaders($headers)
                ->withOptions(['verify' => app()->environment('production')])
                ->get($url);

            if ($response->successful()) {
                $result = $response->json();
                $data = $result['data'] ?? $result ?? [];
                
                Log::info("EcoProvider API Success: {$type} retrieved successfully", [
                    'url' => $url,
                    'items_count' => count($data),
                ]);
                return $data;
            }

            Log::error("EcoProvider API Error for {$type}", [
                'url' => $url,
                'status' => $response->status(),
                'body' => $response->body(),
                'attempt' => $attempt,
            ]);

            if ($attempt < $this->maxRetries) {
                Log::info("EcoProvider API Retry: {$type} (attempt {$attempt}/{$this->maxRetries})");
                sleep(2);
                return $this->fetchWithRetry($url, $type, $attempt + 1);
            }

            return [];
        } catch (\Exception $e) {
            Log::error("EcoProvider API Connection Error for {$type}", [
                'url' => $url,
                'error' => $e->getMessage(),
                'attempt' => $attempt,
            ]);

            if ($attempt < $this->maxRetries) {
                Log::info("EcoProvider API Retry: {$type} (attempt {$attempt}/{$this->maxRetries})");
                sleep(2);
                return $this->fetchWithRetry($url, $type, $attempt + 1);
            }

            return [];
        }
    }

    /**
     * Clear all cached data from EcoProvider
     */
    public function clearCache()
    {
        Cache::forget('eco_provider_news');
        Cache::forget('eco_provider_events');
        Cache::forget('eco_provider_tips');
        Log::info('EcoProvider cache cleared');
    }
}
