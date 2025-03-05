<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Middleware\Success;
use App\Http\Controllers\MailController;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('register');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/send-mail', function () {
    Mail::to('manoncristel37@gmail.com')->send(new SendMail("Test Subject", "This is a test email body"));
    return view('success');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/save', [ScheduleController::class, 'save'])->middleware(['auth', 'verified']);

Route::get('/overzicht', function () {
    return view('overzicht');
});

Route::middleware([Success::class])->get('/success', function () {
    return view('success');
});

require __DIR__.'/auth.php';
