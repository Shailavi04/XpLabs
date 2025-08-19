<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\testimonial_section;
use App\Models\testimonial_content;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonial_sections = testimonial_section::all();
        return view('admin.sections.testimonial.index', compact('testimonial_sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:success,trust',
            'label' => 'required|string',
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string',
            'button_url' => 'nullable|url',
            'background_image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('background_image') && $request->type === 'trust') {
            $image = $request->file('background_image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uplaods/testimonials'), $filename);
            $imagePath = $filename;
        }

        $testimonial_section = testimonial_section::create([
            'label'  => $request->label,
            'title'  => $request->title,
            'subtitle'  => $request->subtitle,
            'type'  => $request->type,
            'button_text'  => $request->button_text,
            'button_url'  => $request->button_url,
            'background_image'  => $imagePath
        ]);
        // dd($testimonial_section);

        $profileImageName = null;
        if ($request->hasFile('background_image')) {
            $image = $request->file('background_image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uplaods/testimonials/testimonials_profile_image'), $filename);
            $profileImageName = $filename;
        }

        testimonial_content::create([
            'testimonial_section_id' => $testimonial_section->id,
            'about'  => $request->about,
            'designation'  => $request->designation,
            'rating'  => $request->rating,
            'rating_text'  => $request->rating_text,
            'title'  => $request->title,
            'profile_image' => $profileImageName,
        ]);


        return back()->with('success', 'Testimonial section created.');
    }
    public function edit(Request $request, $id)
    {
        $testimonial_section = testimonial_section::find($id);

        if (!$testimonial_section) {
            return response()->json([
                'status' => false,
                'message' => 'Testimonial section not found',
            ], 404);
        }

        $testimonial_contents = testimonial_content::where('testimonial_section_id', $id)->get();

        return response()->json([
            'status' => true,
            'section' => $testimonial_section,
            'contents' => $testimonial_contents,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validation for main section and arrays of testimonial profiles
        $request->validate([
            'type' => 'required|in:success,trust',
            'label' => 'required|string',
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string',
            'button_url' => 'nullable|url',
            'background_image' => 'nullable|image|max:2048',

            // Arrays validation for testimonial profiles
            'name' => 'required|array',
            'name.*' => 'required|string',
            'designation' => 'required|array',
            'designation.*' => 'required|string',
            'rating' => 'required|array',
            'rating.*' => 'required|string',
            'rating_text' => 'nullable|array',
            'rating_text.*' => 'nullable|string',
            'about' => 'required|array',
            'about.*' => 'required|string',

            'profile_image' => 'nullable|array',
            'profile_image.*' => 'nullable|image|max:2048',
        ]);

        $testimonial_section = testimonial_section::findOrFail($id);

        // Handle background image update
        if ($request->hasFile('background_image')) {
            if ($testimonial_section->background_image && file_exists(public_path('uploads/testimonials/' . $testimonial_section->background_image))) {
                unlink(public_path('uploads/testimonials/' . $testimonial_section->background_image));
            }
            $image = $request->file('background_image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/testimonials'), $filename);
            $testimonial_section->background_image = $filename;
        }

        // Update testimonial_section fields
        $testimonial_section->label = $request->label;
        $testimonial_section->title = $request->title;
        $testimonial_section->subtitle = $request->subtitle;
        $testimonial_section->type = $request->type;
        $testimonial_section->button_text = $request->button_text;
        $testimonial_section->button_url = $request->button_url;
        $testimonial_section->save();

        // Delete old testimonial contents to refresh them (optional: or implement update logic if you have IDs)
        testimonial_content::where('testimonial_section_id', $testimonial_section->id)->delete();

        // Loop through each profile and save testimonial_content
        $names = $request->name;
        $designations = $request->designation;
        $ratings = $request->rating;
        $rating_texts = $request->rating_text ?? [];
        $abouts = $request->about;
        $profile_images = $request->file('profile_image') ?? [];

        foreach ($names as $index => $name) {
            $content = new testimonial_content();
            $content->testimonial_section_id = $testimonial_section->id;
            $content->name = $name;
            $content->designation = $designations[$index] ?? null;
            $content->rating = $ratings[$index] ?? null;
            $content->rating_text = $rating_texts[$index] ?? null;
            $content->about = $abouts[$index] ?? null;

            // Handle each profile image upload if exists
            if (isset($profile_images[$index]) && $profile_images[$index]->isValid()) {
                if ($content->profile_image && file_exists(public_path('uploads/testimonials/testimonials_profile_image/' . $content->profile_image))) {
                    unlink(public_path('uploads/testimonials/testimonials_profile_image/' . $content->profile_image));
                }

                $profileImage = $profile_images[$index];
                $profileFilename = uniqid() . '.' . $profileImage->getClientOriginalExtension();
                $profileImage->move(public_path('uploads/testimonials/testimonials_profile_image'), $profileFilename);
                $content->profile_image = $profileFilename;
            }
            $content->save();
        }

        return back()->with('success', 'Testimonial section updated successfully.');
    }
}
