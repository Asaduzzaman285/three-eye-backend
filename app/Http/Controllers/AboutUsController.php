<?php

namespace App\Http\Controllers;

use App\Models\Portfolio\AboutUs;
use App\Models\Portfolio\AboutUsSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        // Typically there's only one "About Us" section in a portfolio
        $aboutUs = AboutUs::with('slides')->first();
        return response()->json(['success' => true, 'data' => $aboutUs]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'right_title' => 'nullable|string',
            'right_description' => 'nullable|string',
            'image_path' => 'nullable|string'
        ]);

        $aboutUs = AboutUs::first();
        
        if (!$aboutUs) {
            $aboutUs = new AboutUs();
        }

        if (array_key_exists('image_path', $validated)) {
            $aboutUs->left_image_path = $validated['image_path'];
        }

        $aboutUs->right_title = $validated['right_title'] ?? $aboutUs->right_title;
        $aboutUs->right_description = $validated['right_description'] ?? $aboutUs->right_description;
        
        $aboutUs->save();

        return response()->json(['success' => true, 'data' => $aboutUs, 'message' => 'About Us section updated successfully.']);
    }

    public function storeSlide(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'order' => 'integer',
        ]);

        $aboutUs = AboutUs::first();
        if (!$aboutUs) {
            $aboutUs = AboutUs::create([]);
        }

        $slide = new AboutUsSlide();
        $slide->about_us_id = $aboutUs->id;
        $slide->title = $validated['title'];
        $slide->content = $validated['content'];
        $slide->order = $validated['order'] ?? 0;
        $slide->is_active = true;
        $slide->save();

        return response()->json(['success' => true, 'data' => $slide, 'message' => 'Slide added successfully.']);
    }

    public function updateSlide(Request $request, $id)
    {
        $slide = AboutUsSlide::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'order' => 'integer',
        ]);

        if (array_key_exists('title', $validated)) $slide->title = $validated['title'];
        if (array_key_exists('content', $validated)) $slide->content = $validated['content'];
        if (isset($validated['order'])) $slide->order = $validated['order'];
        
        $slide->save();

        return response()->json(['success' => true, 'data' => $slide, 'message' => 'Slide updated successfully.']);
    }

    public function destroySlide($id)
    {
        $slide = AboutUsSlide::findOrFail($id);
        $slide->delete();

        return response()->json(['success' => true, 'message' => 'Slide deleted successfully.']);
    }
}
