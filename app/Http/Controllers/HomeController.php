<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Variant;
use App\Models\Banner;
use App\Models\Promo;

class HomeController extends Controller
{
    public function getData()
    {
        // Fetch data articles
        $articles = Article::select('title', 'image_thumbnail', 'uri')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $recommendedVariants = Variant::recommended()
            ->with('group.category')
            ->limit(10)
            ->get();

        $banners = Banner::where('is_active', 1)->orderBy('created_at', 'desc')->get();

        $promos = Promo::active()
            ->showOnPc()
            ->running()
            ->whereNotNull('image')
            ->latest('id')
            ->get();

        return view('home', compact('articles', 'recommendedVariants', 'banners', 'promos'));
    }
}
