<?php

namespace App\Http\Controllers;

use App\Services\EcoProviderService;

class NewsController extends Controller
{
    protected $ecoProvider;

    public function __construct(EcoProviderService $ecoProvider)
    {
        $this->ecoProvider = $ecoProvider;
    }

    public function index()
    {
        $news = $this->ecoProvider->getNews();
        return view('eco-news.index', compact('news'));
    }
}
