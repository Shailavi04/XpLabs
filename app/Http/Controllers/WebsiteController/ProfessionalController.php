<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use App\Models\frontend_elements;
use App\Models\professional;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    protected $sectionKey = 'professional';

    // Show the professional data (only one record)
    public function index()
    {
        $professionals = professional::latest()->get();

        return view('admin.sections.professional.index', compact('professionals'));
    }

    public function edit()
    {
        return redirect()->route('web_pages.professional.index');
    }

    // Store or update professional (singleton row)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|url|max:255',
        ]);

      
        professional::create([
            'title'  => $request->name,
            'description'  => $request->description,
            'button'  => $request->button_text,
            'button_url'  => $request->button_url,
        ]);


        return redirect()->route('web_pages.professional.index')->with('success', 'Professional created  successfully.');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|url|max:255',
        ]);

        $professional = Professional::findOrFail($id);

        $professional->update([
            'title'        => $request->name,
            'description'  => $request->description,
            'button'  => $request->button_text,
            'button_url'   => $request->button_url,
        ]);

        return redirect()->route('web_pages.professional.index')
            ->with('success', 'Professional updated successfully.');
    }




    public function destroy($id)
    {
        $professional = professional::where('id', $id)->findOrFail($id);
        $professional->delete();

        return redirect()->route('web_pages.professional.index')->with('success', 'Deleted successfully.');
    }
}
