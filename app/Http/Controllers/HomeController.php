<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
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

        // Fetch data variant(unit) per category from the latest
        $categories = Category::with(['groups.variants' => function ($query) {
            $query->latest();
        }])->get();

        $latestVariants = collect();

        foreach ($categories as $category) {
            $latestVariant = null;

            foreach ($category->groups as $group) {
                if ($group->variants->isNotEmpty()) {
                    $latestVariant = $group->variants->first();
                    break;
                }
            }

            if ($latestVariant) {
                $latestVariants->push($latestVariant);
            }
        }

        $latestVariants = $latestVariants->all();

        // Fetch data banners
        $banners = Banner::where('is_active', 1)->get();

        // Fetch data promos
        $promos = Promo::where('is_active', 1)->get();

        return view('home', compact('articles', 'latestVariants', 'banners', 'promos'));
    }
}
