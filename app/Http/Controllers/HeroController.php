<?php

namespace App\Http\Controllers;

use App\Models\Portfolio\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index()
    {
        $heroes = Hero::all();
        return response()->json(['success' => true, 'data' => $heroes]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image_path' => 'nullable|string'
        ]);

        $hero = new Hero();
        $hero->title = $validated['title'] ?? null;
        $hero->subtitle = $validated['subtitle'] ?? null;
        $hero->image_path = $validated['image_path'] ?? null;

        $hero->save();

        return response()->json(['success' => true, 'data' => $hero, 'message' => 'Hero section created successfully.']);
    }

    public function update(Request $request, $id)
    {
        $hero = Hero::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image_path' => 'nullable|string'
        ]);

        if (array_key_exists('title', $validated)) $hero->title = $validated['title'];
        if (array_key_exists('subtitle', $validated)) $hero->subtitle = $validated['subtitle'];
        if (array_key_exists('image_path', $validated)) $hero->image_path = $validated['image_path'];

        $hero->save();

        return response()->json(['success' => true, 'data' => $hero, 'message' => 'Hero section updated successfully.']);
    }

    public function destroy($id)
    {
        $hero = Hero::findOrFail($id);
        $hero->delete();

        return response()->json(['success' => true, 'message' => 'Hero section deleted successfully.']);
    }
}
