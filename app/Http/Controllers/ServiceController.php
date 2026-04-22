<?php

namespace App\Http\Controllers;

use App\Models\Portfolio\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order', 'asc')->get();
        return response()->json(['success' => true, 'data' => $services]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer',
            'icon_image_path' => 'nullable|string'
        ]);

        $service = new Service();
        $service->title = $validated['title'];
        $service->description = $validated['description'] ?? null;
        $service->is_active = $validated['is_active'] ?? true;
        $service->order = $validated['order'] ?? 0;
        $service->icon_image_path = $validated['icon_image_path'] ?? null;

        $service->save();

        return response()->json(['success' => true, 'data' => $service, 'message' => 'Service created successfully.']);
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        return response()->json(['success' => true, 'data' => $service]);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer',
            'icon_image_path' => 'nullable|string'
        ]);

        if (isset($validated['title'])) $service->title = $validated['title'];
        if (array_key_exists('description', $validated)) $service->description = $validated['description'];
        if (isset($validated['is_active'])) $service->is_active = $validated['is_active'];
        if (isset($validated['order'])) $service->order = $validated['order'];
        if (array_key_exists('icon_image_path', $validated)) $service->icon_image_path = $validated['icon_image_path'];

        $service->save();

        return response()->json(['success' => true, 'data' => $service, 'message' => 'Service updated successfully.']);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['success' => true, 'message' => 'Service deleted successfully.']);
    }
}
