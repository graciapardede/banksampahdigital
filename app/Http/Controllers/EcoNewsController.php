<?php

namespace App\Http\Controllers;

use App\Services\EcoProviderService;
use Illuminate\Http\Request;

class EcoNewsController extends Controller
{
    protected $ecoProviderService;

    public function __construct(EcoProviderService $ecoProviderService)
    {
        $this->ecoProviderService = $ecoProviderService;
    }

    /**
     * Display all news from EcoProvider
     */
    public function index(Request $request)
    {
        $keyword = $request->input('q', '');
        $category = $request->input('category', '');
        
        // Get news from EcoProvider
        $allNews = $this->ecoProviderService->getNews();
        
        // Apply filters
        $news = $allNews;
        
        // Filter by keyword if provided
        if (!empty($keyword)) {
            $news = array_filter($news, function($item) use ($keyword) {
                $title = $item['title'] ?? '';
                $content = $item['content'] ?? '';
                return stripos($title, $keyword) !== false || stripos($content, $keyword) !== false;
            });
            $news = array_values($news);
        }
        
        // Filter by category if provided
        if (!empty($category)) {
            $news = array_filter($news, function($item) use ($category) {
                return isset($item['category']) && $item['category'] === $category;
            });
            $news = array_values($news);
        }
        
        $isAvailable = !empty($allNews);
        $saldoPoin = \Auth::check() ? \App\Models\PointsLedger::where('user_id', \Auth::id())->sum('points') : 0;

        return view('eco-news.index', [
            'news' => $news,
            'isAvailable' => $isAvailable,
            'saldoPoin' => $saldoPoin
        ]);
    }

    /**
     * Display single news detail
     */
    public function show($id)
    {
        // For now, since EcoProvider doesn't have individual ID endpoint,
        // we'll redirect to index
        return redirect()->route('eco.news.index');
    }

    /**
     * Search news - redirect to index with search parameter
     */
    public function search(Request $request)
    {
        $keyword = $request->input('q', '');
        
        // Redirect to index with search parameter to maintain consistent UI
        return redirect()->route('eco.news.index', ['q' => $keyword]);
    }
}
