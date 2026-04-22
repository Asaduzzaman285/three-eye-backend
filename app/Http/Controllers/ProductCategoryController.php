<?php

namespace App\Http\Controllers;

use App\Models\Portfolio\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::all();
        return response()->json(['success' => true, 'data' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'intro_text' => 'nullable|string',
            'email' => 'nullable|email',
            'image_path' => 'nullable|string'
        ]);

        $category = new ProductCategory();
        $category->name = $validated['name'];
        $category->intro_text = $validated['intro_text'] ?? null;
        $category->email = $validated['email'] ?? null;
        $category->image_path = $validated['image_path'] ?? null;
        $category->save();

        return response()->json(['success' => true, 'data' => $category, 'message' => 'Product Category created successfully.']);
    }

    public function show($id)
    {
        $category = ProductCategory::findOrFail($id);
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'intro_text' => 'nullable|string',
            'email' => 'nullable|email',
            'image_path' => 'nullable|string'
        ]);

        if (isset($validated['name'])) $category->name = $validated['name'];
        if (array_key_exists('intro_text', $validated)) $category->intro_text = $validated['intro_text'];
        if (array_key_exists('email', $validated)) $category->email = $validated['email'];
        if (array_key_exists('image_path', $validated)) $category->image_path = $validated['image_path'];

        $category->save();

        return response()->json(['success' => true, 'data' => $category, 'message' => 'Product Category updated successfully.']);
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Product Category deleted successfully.']);
    }
}
