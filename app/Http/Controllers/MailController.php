<?php

namespace App\Http\Controllers;

use Exception;
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
        try {
            // Haal de data op uit de request
            $email = auth()->user()->email;
            $subject = "Let's Connect";
            $body = "test";

            // Verstuur de e-mail
            Mail::to($email)->send(new SendMail($subject, $body));

            // Redirect naar een succespagina na het versturen van de e-mail
            return redirect('/success');
        } catch (Exception $e) {
            // Als er iets misgaat, toon een foutmelding
            return redirect('/success');
        }
    }
}
