<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use App\Models\joincommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JoinCommunityController extends Controller
{
    public function index()
    {

        $join_our_community = joincommunity::get();

        return view('admin.sections.community.index', compact('join_our_community'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cards' => 'nullable|array',
            'cards.*.title' => 'required|string|max:255',
            'cards.*.count' => 'required|numeric|min:0',
        ]);



        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/community'), $filename);
            $imagePath = 'uploads/community/' . $filename;
        }



        $join_our_community = JoinCommunity::create([
            'title' => $request->title,
            'description' => $request->description,
            'background_image' => $imagePath,
            'card' => json_encode($request->cards),
        ]);



        return redirect()->back()->with('success', 'Community added successfully.');
    }

    public function edit($id)
    {

        $community = joincommunity::findOrFail($id);

        // Decode JSON cards safely
        $cards = json_decode($community->card, true) ?: [];

        return response()->json([
            'cards' => $cards,
            'title' => $community->title,
            'description' => $community->description,
        ]);
    }



    public function update(Request $request, $id)
    {
        $community = JoinCommunity::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'edit_cards' => 'nullable|array',
            'edit_cards.*.title' => 'required|string|max:255',
            'edit_cards.*.count' => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/community'), $filename);
            $community->background_image = $filename;
        }

        $community->title = $request->title;
        $community->description = $request->description;

        // ✅ Handle edit cards if present
        if ($request->has('edit_cards')) {
            $community->card = json_encode($request->edit_cards);
        }

        $community->save();

        return redirect()->back()->with('success', 'Community updated successfully.');
    }

    public function destroy($id)
    {
        $community = joincommunity::findOrFail($id);

       

        $community->delete();

        return redirect()->route('web_pages.community.index')->with('success', 'community deleted successfully.');
    }
}
