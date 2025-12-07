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
    public function index()
    {
        try {
            $news = $this->ecoNewsService->getAllNews();
            $isAvailable = !empty($news);
            $saldoPoin = \App\Models\PointsLedger::where('user_id', \Auth::id())->sum('points');

            return view('eco-news.index', [
                'news' => $news,
                'isAvailable' => $isAvailable,
                'saldoPoin' => $saldoPoin
            ]);
        } catch (\Exception $e) {
            $saldoPoin = \App\Models\PointsLedger::where('user_id', \Auth::id())->sum('points');
            return view('eco-news.index', [
                'news' => [],
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
     * Search news
     */
    public function search(Request $request)
    {
        $keyword = $request->input('q', '');
        $news = [];

        if (!empty($keyword)) {
            try {
                $news = $this->ecoNewsService->searchNews($keyword);
            } catch (\Exception $e) {
                return view('eco-news.search', [
                    'keyword' => $keyword,
                    'news' => [],
                    'error' => 'Terjadi kesalahan saat mencari berita.'
                ]);
            }
        }

        return view('eco-news.search', [
            'keyword' => $keyword,
            'news' => $news
        ]);
    }
}
