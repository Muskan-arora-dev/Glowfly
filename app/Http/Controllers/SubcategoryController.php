<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    // Show create subcategory form
    public function create($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return view('subcategories.create', compact('category'));
    }

    // Store subcategory
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('subcategories', 'public');
        }

        // Create subcategory
        $sub = Subcategory::create($data);

        // Redirect to subcategory products page
        return redirect()->route('subcategory.show', $sub->slug)
                         ->with('success', 'Subcategory added successfully!');
    }

    // Show subcategory products page
    public function show($slug)
{
    $sub = Subcategory::where('slug', $slug)->firstOrFail();

    $products = $sub->products()
        ->where(function ($q) {
            $q->whereNull('supplier_id')   
              ->orWhere('status', 'approved'); 
        })
        ->get();

    return view('subcategory.show', compact('sub', 'products'));
}



public function getByCategory($id)
{
    $subcategories = Subcategory::where('category_id', $id)->get();
    return response()->json($subcategories);
}

    
}
