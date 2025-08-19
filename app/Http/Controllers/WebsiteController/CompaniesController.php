<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use App\Models\companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
    {
        $companies = companies::orderBy('id', 'desc')->get();
        return view('admin.sections.companies.index', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company_images.*' => 'required|image|max:2048',
        ]);

        $imageNames = [];

        if ($request->hasFile('company_images')) {
            foreach ($request->file('company_images') as $image) {
                $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                $image->move(public_path('uploads/companies'), $imageName);
                $imageNames[] = $imageName;
            }
        }

        // dd($request->page);

        companies::create([
            'page' => $request->page,
            'title' => $request->title,
            'company_images' => json_encode($imageNames),
        ]);

        return redirect()->route('web_pages.companies.index')->with('success', 'Company Created Successfully!');
    }


    public function edit($id)
    {
        $company = companies::findOrFail($id);
        return response()->json(['status' => true, 'data' => $company]);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'company_images.*' => 'nullable|image|max:2048',
        ]);

        $company = companies::findOrFail($id);
        $existingImages = json_decode($company->company_images, true) ?? [];

        // Handle new uploads if any
        if ($request->hasFile('company_images')) {
            foreach ($request->file('company_images') as $image) {
                $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                $image->move(public_path('uploads/companies'), $imageName);
                $existingImages[] = $imageName;
            }
        }

        $company->update([
            'title' => $request->title,
            'page'  => $request->page,
            'company_images' => json_encode($existingImages),
        ]);

        return redirect()->route('web_pages.companies.index')->with('success', 'Company Updated Successfully!');
    }


    public function destroy($id)
    {
        $company = companies::findOrFail($id);
        $company->delete();
        return redirect()->route('web_pages.companies.index')->with('success', 'Company Deleted Successfully!');
    }
}
