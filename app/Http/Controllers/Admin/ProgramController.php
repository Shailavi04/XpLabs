<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index() {
        $programs = Program::latest()->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function create() {
        return view('admin.programs.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'mode' => 'required|in:Offline,Online,Hybrid',
        ]);

        Program::create($request->all());
        return redirect()->route('programs.index')->with('success', 'Program created successfully.');
    }

    public function edit($id) {
        $program = Program::findOrFail($id);
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required',
            'mode' => 'required|in:Offline,Online,Hybrid',
        ]);

        $program = Program::findOrFail($id);
        $program->update($request->all());

        return redirect()->route('programs.index')->with('success', 'Program updated successfully.');
    }

    public function destroy($id) {
        $program = Program::findOrFail($id);
        $program->delete();

        return redirect()->route('programs.index')->with('success', 'Program deleted successfully.');
    }
}
