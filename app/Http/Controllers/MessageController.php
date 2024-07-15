<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->get();
        return view('contact.index', compact('contacts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $contact = Contact::findOrFail($id);
        return view('contact.show', compact('contact'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')
                         ->with('success', 'Contact deleted successfully.');
    }
}