<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EcoNewsService
{
    protected $baseUrl;
    protected $timeout;

    public function __construct()
    {
        // EcoProvider berjalan di port 8001
        $this->baseUrl = config('services.eco_provider.url', 'http://localhost:8001/api');
        $this->timeout = config('services.eco_provider.timeout', 10);
    }

    /**
     * Get all news from EcoProvider
     */
    public function getAllNews()
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl . '/news');

            if ($response->successful()) {
                $result = $response->json();
                // API return format: { success: true, data: [...] }
                return $result['data'] ?? [];
            }

            Log::error('EcoProvider API Error: ' . $response->status());
            return [];
        } catch (\Exception $e) {
            Log::error('EcoProvider Connection Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all news and categories from EcoProvider (combined endpoint)
     */
    public function getNewsWithCategories()
    {
        try {
            // Use base URL without /api for eco-news-data endpoint
            $url = 'http://127.0.0.1:8001/eco-news-data';
            $response = Http::timeout($this->timeout)->get($url);

            if ($response->successful()) {
                $result = $response->json();
                return [
                    'news' => $result['data'] ?? [],
                    'categories' => $result['categories'] ?? []
                ];
            }

            Log::error('EcoProvider eco-news-data API Error: ' . $response->status());
            return ['news' => [], 'categories' => []];
        } catch (\Exception $e) {
            Log::error('EcoProvider eco-news-data Connection Error: ' . $e->getMessage());
            return ['news' => [], 'categories' => []];
        }
    }

    /**
     * Get single news by ID
     */
    public function getNews($id)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl . '/news/' . $id);

            if ($response->successful()) {
                $result = $response->json();
                // API return format: { success: true, data: {...} }
                return $result['data'] ?? null;
            }

            Log::error('EcoProvider API Error: ' . $response->status());
            return null;
        } catch (\Exception $e) {
            Log::error('EcoProvider Connection Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Search news by keyword
     */
    public function searchNews($q)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl . '/news-search', [
                    'q' => $q
                ]);

            if ($response->successful()) {
                $result = $response->json();
                // API return format: { success: true, data: [...], query: "...", count: X }
                return $result['data'] ?? [];
            }

            Log::error('EcoProvider API Error: ' . $response->status());
            return [];
        } catch (\Exception $e) {
            Log::error('EcoProvider Connection Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Check if EcoProvider is available
     */
    public function isAvailable()
    {
        try {
            $response = Http::timeout(5)->get($this->baseUrl . '/health');
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get all categories from EcoProvider
     */
    public function getCategories()
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get($this->baseUrl . '/categories');

            if ($response->successful()) {
                $result = $response->json();
                return $result['data'] ?? [];
            }

            Log::error('EcoProvider Categories API Error: ' . $response->status());
            return [];
        } catch (\Exception $e) {
            Log::error('EcoProvider Categories Connection Error: ' . $e->getMessage());
            return [];
        }
    }
}
