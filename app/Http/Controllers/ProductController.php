<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Group;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getCategory($uri)
    {
        $category = Category::where('uri', $uri)->first();

        $groups = Group::where('category_id', $category->id)->get();

        return view('product/product', compact('groups'));
    }

    public function getMaxi()
    {
        $maxis = Group::where('category_id', 1)->get();

        return view('product/product', compact('maxis'));
    }
}
