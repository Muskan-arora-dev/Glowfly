<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        $products = Product::latest()->paginate(20); // Latest first, 20 per page
        return view('admin.products.index', compact('products'));
    }

    // Show form to create new product
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.products.create', compact('categories', 'subcategories'));
    }

    // Store new product
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image'
        ]);

        // Handle image upload
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads'), $imageName);

        // Create product
        Product::create([
            'name' => $request->name,
            'slug' => strtolower(str_replace(' ', '-', $request->name)),
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'price' => $request->price,
            'description' => $request->description,
            'image' => 'uploads/' . $imageName,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    // Show single product
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    // Show edit form
   public function edit($id)
{
    $product = Product::findOrFail($id);

    // Fetch only subcategories of the product's category for autofill
    $categories = Category::all();
    $subcategories = Subcategory::where('category_id', $product->category_id)->get();

    return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
}


   // Update product
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    // Validation
    $request->validate([
        'name' => 'required',
        'category_id' => 'required',
        'subcategory_id' => 'required',
        'price' => 'required|numeric',
        'image' => 'nullable|image'
    ]);

    // Update fields
    $product->name = $request->name;

    // Generate unique slug
    $slug = strtolower(str_replace(' ', '-', $request->name));
    $existing = Product::where('slug', $slug)->where('id', '!=', $product->id)->first();
    if ($existing) {
        $slug .= '-' . time();
    }
    $product->slug = $slug;

    $product->category_id = $request->category_id;
    $product->subcategory_id = $request->subcategory_id;
    $product->price = $request->price;
    $product->description = $request->description;

    // Handle new image upload
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads'), $imageName);
        $product->image = 'uploads/' . $imageName;
    }

    $product->save();

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
}


    // Delete product
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
