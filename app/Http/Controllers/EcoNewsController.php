<?php

namespace App\Http\Controllers;

use App\Services\EcoNewsService;
use Illuminate\Http\Request;

class EcoNewsController extends Controller
{
    protected $ecoNewsService;

    public function __construct(EcoNewsService $ecoNewsService)
    {
        $this->ecoNewsService = $ecoNewsService;
    }

    /**
     * Display all news from EcoProvider
     */
    public function index(Request $request)
    {
        try {
            $keyword = $request->input('q', '');
            $category = $request->input('category', '');
            
            // Get news and categories from EcoProvider combined endpoint
            $data = $this->ecoNewsService->getNewsWithCategories();
            $allNews = $data['news'];
            $categories = $data['categories'];
            
            // Apply filters
            $news = $allNews;
            
            // Filter by keyword if provided
            if (!empty($keyword)) {
                $news = $this->ecoNewsService->searchNews($keyword);
            }
            
            // Filter by category if provided
            if (!empty($category)) {
                $news = array_filter($news, function($item) use ($category) {
                    return isset($item['category']) && $item['category'] === $category;
                });
                // Re-index array after filter
                $news = array_values($news);
            }
            
            $isAvailable = !empty($allNews);
            $saldoPoin = \Auth::check() ? \App\Models\PointsLedger::where('user_id', \Auth::id())->sum('points') : 0;

            return view('eco-news.index', [
                'news' => $news,
                'categories' => $categories,
                'isAvailable' => $isAvailable,
                'saldoPoin' => $saldoPoin
            ]);
        } catch (\Exception $e) {
            $saldoPoin = \Auth::check() ? \App\Models\PointsLedger::where('user_id', \Auth::id())->sum('points') : 0;
            return view('eco-news.index', [
                'news' => [],
                'categories' => [],
                'isAvailable' => false,
                'error' => 'Tidak dapat terhubung ke EcoProvider. Silakan coba lagi nanti.',
                'saldoPoin' => $saldoPoin
            ]);
        }
    }

    /**
     * Display single news detail
     */
    public function show($id)
    {
        try {
            $news = $this->ecoNewsService->getNews($id);

            if (!$news) {
                return redirect()->route('eco.news.index')
                    ->with('error', 'Berita tidak ditemukan.');
            }

            return view('eco-news.show', [
                'news' => $news
            ]);
        } catch (\Exception $e) {
            return redirect()->route('eco.news.index')
                ->with('error', 'Tidak dapat memuat detail berita.');
        }
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
