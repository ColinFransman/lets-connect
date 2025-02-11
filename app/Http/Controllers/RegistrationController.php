<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserChoice;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
  
    public function store(Request $request)
    {
       
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Je moet ingelogd zijn om je keuzes op te slaan.');
        }

        dd($request);

        $validated = $request->validate([
            'round_1' => 'required|string|max:255',
            'round_2' => 'required|string|max:255',
            'round_3' => 'required|string|max:255',
        ]);

        try {
            
            $userChoice = UserChoice::where('email', Auth::user()->email)->first();

            if ($userChoice) {
           
                $userChoice->update([
                    'round_1' => $validated['round_1'],
                    'round_2' => $validated['round_2'],
                    'round_3' => $validated['round_3'],
                ]);
            } else {
               
                UserChoice::create([
                    'email' => Auth::user()->email,
                    'round_1' => $validated['round_1'],
                    'round_2' => $validated['round_2'],
                    'round_3' => $validated['round_3'],
                ]);
            }

        
            return redirect()->route('dashboard')->with('success', 'Je keuzes zijn opgeslagen!');
        } catch (\Exception $e) {
            
            return back()->withErrors(['error' => 'Er is iets misgegaan bij het opslaan van je keuzes. Probeer het opnieuw.']);
        }
    }
}
