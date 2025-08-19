<?php

namespace App\Http\Controllers\WebsiteController;

use App\Http\Controllers\Controller;
use App\Models\contact;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{

    public function index()
    {
        $contacts = contact::all();
        return view('admin.sections.contact.index', compact('contacts'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'heading' => 'required',
            'decription' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email_address' => 'required|email',
        ]);

        Contact::create($request->all());

        return redirect()->route('web_pages.contact.index')->with('success', 'Contact created successfully.');
    }

    public function edit($id)
    {
        $contact = contact::where('id', $id)->first();

        if (!$contact) {
            return response()->json(['error' => 'Contact not found'], 404);
        }

        return response()->json(['contact' => $contact]);
    }


    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'title' => 'required',
            'heading' => 'required',
            'decription' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email_address' => 'required|email',
        ]);

        $contact->update($request->all());

        return redirect()->route('web_pages.contact.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy($id)
    {
        $contact = contact::where('id', $id)->first();

        $contact->delete();
        return redirect()->route('web_pages.contact.index')->with('success', 'Contact deleted successfully.');
    }
}
