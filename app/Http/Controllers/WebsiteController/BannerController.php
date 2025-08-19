<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.sections.banner.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'review_title' => 'nullable|string|max:255',
            'rating' => 'nullable|string|max:10',
            'review_text' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|url',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $uploadedImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . $index . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/banners'), $filename);
                // Yahan explicitly key = $index 0 ,1 assign
                $uploadedImages[(string)$index] = 'uploads/banners/' . $filename;
            }
        }

        Banner::create([
            'type' => $request->type,
            'heading' => $request->heading,
            'subheading' => $request->subheading,
            'description' => $request->description,
            'review_title' => $request->review_title,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'images' => json_encode($uploadedImages, JSON_FORCE_OBJECT),
            // JSON_FORCE_OBJECT se JSON me hamesha object (key:value) banega, array nahi
        ]);

        return back()->with('success', 'Banner created successfully.');
    }





    public function edit($id)
{
    $banner = Banner::findOrFail($id);
    $banner->images = json_decode($banner->images, true); // decode to associative array
    return response()->json($banner);
}


    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $data = $this->validateData($request);

        $existingImages = is_array($banner->images) ? $banner->images : json_decode($banner->images, true);
        $images = $this->handleImages($request, $existingImages);

        if (!empty($images)) {
            $data['images'] = json_encode($images);
        }

        if ($request->has('course_cards')) {
            $data['course_cards'] = json_encode($request->course_cards);
        }

        $banner->update($data);

        return back()->with('success', 'Banner updated successfully.');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return back()->with('success', 'Banner deleted successfully.');
    }

    protected function handleImages(Request $request, $existingImages = [])
    {
        $images = is_array($existingImages) ? $existingImages : [];

        foreach ($request->file('images', []) as $key => $file) {
            if (is_file($file)) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/banners'), $filename);
                $images[$key] = 'uploads/banners/' . $filename;  // relative path for DB
            }
        }

        return $images;
    }

    protected function validateData(Request $request)
    {
        return $request->validate([
            'type' => 'required|string|in:home,course,success',
            'heading' => 'nullable|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'review_title' => 'nullable|string|max:255',
            'rating' => 'nullable|string|max:10',
            'rating_text' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|url|max:255',
            'course_cards' => 'nullable|array',
            'course_cards.*.icon' => 'nullable|string|max:255',
            'course_cards.*.title' => 'nullable|string|max:255',
            'course_cards.*.description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|image|max:5120',
        ]);
    }
}
