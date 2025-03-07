<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class MailController extends Controller
{
    /**
     * Show the email form
     */
    public function index()
    {
        return view('send-mail');
    }

    /**
     * Handle email sending
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        try {
            // Haal de data op uit de request
            $email = $request->input('email');
            $subject = $request->input('subject');
            $body = $request->input('body');

            // Verstuur de e-mail
            Mail::to($email)->send(new SendMail($subject, $body));

            // Redirect naar een succespagina na het versturen van de e-mail
            return redirect('/success')->with(['status' => 'success', 'title' => 'Bedankt voor je aanmelding', 'message' => 'Je planning is succesvol opgeslagen. Je ontvangt zo snel mogelijk een mail ter bevestiging van je gekozen planning. Je kan dit scherm nu sluiten.']);
        } catch (\Exception $e) {
            // Als er iets misgaat, toon een foutmelding
            return redirect('/dashboard')->with('message', 'Er is een fout opgetreden bij het verzenden van de e-mail: ' . $e->getMessage());
        }
    }
}
