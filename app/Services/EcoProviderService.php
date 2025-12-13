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

    public function __construct()
    {
        $this->timeout = (int) env('ECO_API_TIMEOUT', 10);
        $this->maxRetries = 3;
        $this->cacheExpire = (int) env('ECO_API_CACHE', 30); 
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

        $data = $this->fetchWithRetry(env('ECO_NEWS_API', 'http://localhost:8001/api/news'), 'news');

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

        $data = $this->fetchWithRetry(env('ECO_EVENTS_API', 'http://localhost:8001/api/events'), 'events');

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

        $data = $this->fetchWithRetry(env('ECO_TIPS_API', 'http://localhost:8001/api/tips'), 'tips');

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
            $response = Http::timeout($this->timeout)
                ->get(env('ECO_STATUS_API', 'http://localhost:8001/api/status'));

            if ($response->successful()) {
                return [
                    'status' => 'ok',
                    'code' => $response->status(),
                ];
            }

            return [
                'status' => 'error',
                'code' => $response->status(),
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unreachable',
                'error' => $e->getMessage(),
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

            $response = Http::timeout($this->timeout)
                ->withOptions(['verify' => app()->environment('production')])
                ->get($url);

            if ($response->successful()) {
                $result = $response->json();
                $data = $result['data'] ?? $result ?? [];
                
                Log::info("EcoProvider API Success: {$type} retrieved successfully");
                return $data;
            }

            Log::error("EcoProvider API Error for {$type}", [
                'url' => $url,
                'status' => $response->status(),
                'attempt' => $attempt,
            ]);

            if ($attempt < $this->maxRetries) {
                Log::info("EcoProvider API Retry: {$type} (attempt {$attempt}/{$this->maxRetries})");
                sleep(1);
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
                sleep(1);
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
