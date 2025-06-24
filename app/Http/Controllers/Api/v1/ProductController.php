<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        $defaultCategory = Category::where('name', 'like', '%maxi%')->first();

        $categories = Category::with(['groups' => function ($query) {
            $query->where('is_active', 1);
        }])->get();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Produk berhasil diambil',
            'data' => [
                'default_category' => $defaultCategory ? strtolower($defaultCategory->name) : null,
                'categories' => $categories->map(function ($category) {
                    return [
                        'id' => strtolower($category->name),
                        'category' => $category->name,
                        'products' => ProductResource::collection($category->groups)->resolve()
                    ];
                })->values()
            ]
        ]);
    }
}
