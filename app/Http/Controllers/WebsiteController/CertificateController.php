<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use App\Models\certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{

    public function index()
    {
        $certificate = certificate::orderBy('id', 'desc')->get();
        return view('admin.sections.certificate.index', compact('certificate'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'about' => 'required',
            'description' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $image->move(public_path('uploads/certificate'), $imageName);
        }

        certificate::create([
            'title' => $request->title,
            'about' => $request->about,
            'description' => $request->description,
            'image' => $imageName ?? null,
        ]);

        return redirect()->route('web_pages.certificate.index')->with('success', 'Certificate Created Successfully!');
    }

    public function edit($id)
    {
        $certificate = certificate::findOrFail($id);
        return response()->json(['status' => true, 'data' => $certificate]);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'about' => 'required',
        //     'decription' => 'required',
        //     'image' => 'nullable|image|max:2048',
        // ]);
        // dd($request->all());


        $certificate = Certificate::findOrFail($id);

        $certificate->update($request->only('title', 'about', 'description'));

        // If image exists, handle separately
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $image->move(public_path('uploads/certificate'), $imageName);

            $certificate->update(['image' => $imageName]);

        }
        return redirect()->back()->with('success', 'Certificate Updated Successfully!');
    }

    public function destroy($id)
    {
        $company = certificate::findOrFail($id);
        $company->delete();
        return redirect()->route('web_pages.certificate.index')->with('success', 'Certificate Deleted Successfully!');
    }
}
