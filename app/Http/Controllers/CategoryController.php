<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::with([
            'subcategories.products' => function ($q) {
                $q->where('status', 'approved');
            }
        ])->where('slug', $slug)->firstOrFail();

        return view('category-page', compact('category'));
    }

    public function showAllCategories()
    {
        $categories = Category::paginate(6);
        return view('all', compact('categories'));
    }
}
