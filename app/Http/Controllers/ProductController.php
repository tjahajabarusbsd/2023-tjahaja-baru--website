<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getData()
    {
        // Fetch data variant(unit) per category from the latest
        $categories = Category::with(['groups.variants' => function ($query) {
            $query->latest();
        }])->get();

        return view('home', compact('categories'));
    }
}
