<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use App\Models\Vision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VisionController extends Controller
{
    // List all visions
    public function index()
    {
        $visions = Vision::all();
        return view('admin.sections.vision.index', compact('visions'));
    }

    // Show create form
    public function create()
    {
        return view('admin.sections.vision.create');
    }

    // Store new vision
    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'heading' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['heading', 'description']);

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $iconFile = $request->file('icon');
            $iconName = time() . '_' . preg_replace('/\s+/', '_', $iconFile->getClientOriginalName());
            $destinationPath = public_path('uploads/vision_icons');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $iconFile->move($destinationPath, $iconName);
            $data['icon'] = 'uploads/vision_icons/' . $iconName;
        }

        Vision::create($data);

        return redirect()->route('web_pages.vision.index')->with('success', 'Vision created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $vision = Vision::findOrFail($id);
        return view('admin.sections.vision.edit', compact('vision'));
    }

    // Update vision
    public function update(Request $request, $id)
    {
        $vision = Vision::findOrFail($id);

        $validated = $request->validate([
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'heading' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['heading', 'description']);

        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($vision->icon && File::exists(public_path($vision->icon))) {
                File::delete(public_path($vision->icon));
            }

            $iconFile = $request->file('icon');
            $iconName = time() . '_' . preg_replace('/\s+/', '_', $iconFile->getClientOriginalName());
            $destinationPath = public_path('uploads/vision_icons');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $iconFile->move($destinationPath, $iconName);
            $data['icon'] = 'uploads/vision_icons/' . $iconName;
        }

        $vision->update($data);

        return redirect()->route('web_pages.vision.index')->with('success', 'Vision updated successfully.');
    }

    // Delete vision
    public function destroy($id)
    {
        $vision = Vision::findOrFail($id);

        if ($vision->icon && File::exists(public_path($vision->icon))) {
            File::delete(public_path($vision->icon));
        }

        $vision->delete();

        return redirect()->route('web_pages.vision.index')->with('success', 'Vision deleted successfully.');
    }
}
