<?php

namespace App\Http\Controllers;

use App\Models\Portfolio\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Optional: eager load category name
        $products = Product::with('category')->get();
        return response()->json(['success' => true, 'data' => $products]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|string'
        ]);

        $product = new Product();
        $product->product_category_id = $validated['product_category_id'];
        $product->title = $validated['title'];
        $product->description = $validated['description'] ?? null;
        $product->image_path = $validated['image_path'] ?? null;
        $product->save();

        return response()->json(['success' => true, 'data' => $product, 'message' => 'Product created successfully.']);
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json(['success' => true, 'data' => $product]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'product_category_id' => 'sometimes|required|exists:product_categories,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|string'
        ]);

        if (isset($validated['product_category_id'])) $product->product_category_id = $validated['product_category_id'];
        if (isset($validated['title'])) $product->title = $validated['title'];
        if (array_key_exists('description', $validated)) $product->description = $validated['description'];
        if (array_key_exists('image_path', $validated)) $product->image_path = $validated['image_path'];

        $product->save();

        return response()->json(['success' => true, 'data' => $product, 'message' => 'Product updated successfully.']);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Product deleted successfully.']);
    }
}
