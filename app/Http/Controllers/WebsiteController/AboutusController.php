<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AboutusController extends Controller
{
    public function index()
    {
        $abouts = About::latest()->get();
        return view('admin.sections.about_us.index', compact('abouts'));
    }

    public function create()
    {
        return view('admin.sections.about_us.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'sub_heading' => 'required|string|max:255',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|max:2048',
            'cards' => 'nullable|array',
            'cards.*.icon_text' => 'nullable|string',
            'cards.*.icon_description' => 'nullable|string',
            'cards.*.icon' => 'nullable|image|max:2048',
        ]);

        // --- Handle cards ---
        $cardsData = [];
        if ($request->filled('cards')) {
            foreach ($request->cards as $card) {
                $cardData = [
                    'icon_text' => $card['icon_text'] ?? '',
                    'icon_description' => $card['icon_description'] ?? '',
                    'icon' => null,
                ];

                if (isset($card['icon']) && is_object($card['icon'])) {
                    $file = $card['icon'];
                    $filename = uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/about_us/icons'), $filename);
                    $cardData['icon'] = 'uploads/about_us/icons/' . $filename;
                }

                $cardsData[] = $cardData;
            }
        }

        // --- Handle main image ---
        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filename = uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/about_us'), $filename);
            $mainImagePath = 'uploads/about_us/' . $filename;
        }

        // --- Save record ---
        About::create([
            'heading' => $request->heading,
            'description' => $request->description,
            'sub_heading' => $request->sub_heading,
            'main_image' => $mainImagePath,
            'cards' => $cardsData,
        ]);

        return redirect()->route('web_pages.about_us.index')->with('success', 'About Us created successfully.');
    }

    public function edit($id)
    {
        $about = About::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $about,
        ]);
    }

    public function update(Request $request, $id)
    {
        $about = About::findOrFail($id);

        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'sub_heading' => 'required|string|max:255',
            'description' => 'nullable|string',
            'main_image' => 'nullable|image|max:2048',
            'cards' => 'nullable|array',
            'cards.*.icon_text' => 'nullable|string',
            'cards.*.icon_description' => 'nullable|string',
            'cards.*.icon' => 'nullable|image|max:2048',
        ]);

        // Handle cards
        $cardsData = [];

        if ($request->filled('cards') && is_array($request->cards)) {
            foreach ($request->cards as $index => $card) {
                $cardData = [
                    'icon_text' => $card['icon_text'] ?? '',
                    'icon_description' => $card['icon_description'] ?? '',
                    'icon' => isset($about->cards[$index]['icon']) ? $about->cards[$index]['icon'] : null,
                ];

                if (isset($card['icon']) && is_object($card['icon'])) {
                    // Delete old icon
                    if (!empty($cardData['icon']) && file_exists(public_path($cardData['icon']))) {
                        unlink(public_path($cardData['icon']));
                    }
                    $file = $card['icon'];
                    $filename = uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/about_us/icons'), $filename);
                    $cardData['icon'] = 'uploads/about_us/icons/' . $filename;
                }

                $cardsData[] = $cardData;
            }
        }

        // Handle main image
        $mainImagePath = $about->main_image;
        if ($request->hasFile('main_image')) {
            if ($mainImagePath && file_exists(public_path($mainImagePath))) {
                unlink(public_path($mainImagePath));
            }
            $file = $request->file('main_image');
            $filename = uniqid() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/about_us'), $filename);
            $mainImagePath = 'uploads/about_us/' . $filename;
        }

        // Update
        $about->update([
            'heading' => $request->heading,
            'description' => $request->description,
            'sub_heading' => $request->sub_heading,
            'main_image' => $mainImagePath,
            'cards' => $cardsData,
        ]);

        return redirect()->back()->with('success', 'About Us updated successfully.');
    }




    public function destroy($id)
    {
        $about = About::findOrFail($id);

        // Delete main image
        if (!empty($about->main_image) && file_exists(public_path($about->main_image))) {
            unlink(public_path($about->main_image));
        }

        // Delete card icons
        if (!empty($about->cards) && is_array($about->cards)) {
            foreach ($about->cards as $card) {
                if (!empty($card['icon']) && file_exists(public_path($card['icon']))) {
                    unlink(public_path($card['icon']));
                }
            }
        }

        $about->delete();

        return response()->json([
            'status' => true,
            'message' => 'About Us entry deleted successfully.',
        ]);
    }
}
