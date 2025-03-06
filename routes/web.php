<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomePageController;
use App\Http\Middleware\Success;
use Illuminate\Support\Facades\Route;
use App\Models\Workshop;

Route::get('/', function () {
    return redirect()->route('register');
});

Route::get('/dashboard', function () {
    return view('dashboard')->with("workshops", Workshop::all());
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/save', [ScheduleController::class, 'save'])->middleware(['auth', 'verified']);
Route::get('/save2', [BookingController::class, 'save'])->middleware(['auth', 'verified']);
Route::get('/dbtest', [BookingController::class, 'getBookings'])->middleware(['auth', 'verified']);

Route::get('/overzicht', function () {
    return view('overzicht');
});

Route::middleware([Success::class])->get('/success', function () {
    return view('success');
});

require __DIR__.'/auth.php';
