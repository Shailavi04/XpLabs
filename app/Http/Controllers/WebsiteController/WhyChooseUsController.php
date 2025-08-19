<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use App\Models\why_choose_us;
use Illuminate\Http\Request;

class WhyChooseUsController extends Controller
{
    public function index()
    {
        $items = why_choose_us::latest()->get();
        return view('admin.sections.why_choose_us.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'main_image'  => 'nullable|image|max:2048',
            'icon'        => 'nullable|image|max:1024',
            'list_items'  => 'nullable|string'
        ]);

        $data = $request->only('title', 'description', 'list_items');

        // Upload Main Image
        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $filename = time() . '_main_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/why_choose_us'), $filename);
            $data['main_image'] = 'uploads/why_choose_us/' . $filename;
        }

        // Upload Icon
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $filename = time() . '_icon_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/why_choose_us'), $filename);
            $data['icon'] = 'uploads/why_choose_us/' . $filename;
        }

        why_choose_us::create($data);

        return redirect()->back()->with('success', 'Entry added successfully.');
    }

    public function edit($id)
    {
        $item = why_choose_us::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'main_image'  => 'nullable|image|max:2048',
            'icon'        => 'nullable|image|max:1024',
            'list_items'  => 'nullable|string'
        ]);

        $item = why_choose_us::findOrFail($id);
        $item->title = $request->title;
        $item->description = $request->description;
        $item->list_items = $request->list_items;

        // Update Main Image
        if ($request->hasFile('main_image')) {
            if ($item->main_image && file_exists(public_path($item->main_image))) {
                unlink(public_path($item->main_image));
            }

            $file = $request->file('main_image');
            $filename = time() . '_main_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/why_choose_us'), $filename);
            $item->main_image = 'uploads/why_choose_us/' . $filename;
        }

        // Update Icon
        if ($request->hasFile('icon')) {
            if ($item->icon && file_exists(public_path($item->icon))) {
                unlink(public_path($item->icon));
            }

            $file = $request->file('icon');
            $filename = time() . '_icon_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/why_choose_us'), $filename);
            $item->icon = 'uploads/why_choose_us/' . $filename;
        }

        $item->save();

        return redirect()->back()->with('success', 'Entry updated successfully.');
    }

    public function destroy($id)
    {
        $item = why_choose_us::findOrFail($id);

        if ($item->main_image && file_exists(public_path($item->main_image))) {
            unlink(public_path($item->main_image));
        }

        if ($item->icon && file_exists(public_path($item->icon))) {
            unlink(public_path($item->icon));
        }

        $item->delete();

        return response()->json(['status' => true, 'message' => 'Entry deleted successfully.']);
    }
}
