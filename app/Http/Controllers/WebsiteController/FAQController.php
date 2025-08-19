<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use App\Models\faq;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {

        $faqs = faq::get();

        return view('admin.sections.faq.index', compact('faqs'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'title'   => 'required|string',
            'heading' => 'required|string',
        ]);


        faq::create([
            'question' => $request->title,
            'answer' => $request->heading,
        ]);

        return redirect()->back()->with('success', 'FAQ added sucessfully!');
    }

    public function edit(Request $request, $id)
    {

        $faq = faq::where('id', $id)->first();

        return response()->json(['faq' => $faq]);
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'title'   => 'required|string',
            'heading' => 'required|string',
        ]);


        faq::where('id', $id)->update([
            'question' => $request->title,
            'answer' => $request->heading,
        ]);

        return redirect()->back()->with('success', 'FAQ updated sucessfully!');
    }
}
