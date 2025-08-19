<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use App\Models\instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {


        $instructors = instructor::get();

        return view('admin.sections.Instructor.index', compact('instructors'));
    }

    public function store(Request $request)
    {



        $request->validate([
            'name'  => 'required',
            'description'  => 'required',
            'button_text'  => 'required',
            'button_url'  => 'required',
        ]);


        Instructor::create([
            'title' => $request->name,
            'description' => $request->description,
            'button' => $request->button_text,
            'button_url' => $request->button_url,
        ]);

        return redirect()->route('web_pages.Instructor.index')->with('success', 'Instructor Created Sucessfully!');
    }

    public function edit($id)
    {
        $instructor = Instructor::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $instructor
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'button'      => 'nullable|string|max:255',
            'button_url'  => 'nullable|url|max:255',
        ]);

        $instructor = Instructor::findOrFail($id);
        $instructor->update($request->only('title', 'description', 'button', 'button_url'));

        return redirect()->back()->with('success', 'Instructor updated successfully.');
    }

    public function destroy($id)
    {
        $instructor = instructor::findOrFail($id);

       

        $instructor->delete();

        return redirect()->route('web_pages.Instructor.index')->with('success', 'instructor deleted successfully.');
    }
}
