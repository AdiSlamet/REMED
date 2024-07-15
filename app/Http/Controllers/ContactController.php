<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'guest_message' => 'required'
        ]);

        try {
            DB::beginTransaction();

            // Simpan data ke dalam database
            $contact = new contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone_number = $request->phone_number;
            $contact->guest_message = $request->guest_message;
            $contact->save();

            // Kirim email
            $this->sendEmail($request->all());

            DB::commit();
            return redirect()->route('contact')->with('success', 'Thank you for your message');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('contact')->with('error', 'Failed to send message');
        }
    }

    private function sendEmail($data)
    {
        Mail::send('email.guest', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name'])
                ->subject('Email from Guest Book');
        });
    }
}
