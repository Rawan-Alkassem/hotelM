<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\BookingController; 
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
Route::get('/home', function () {
    return view('home');
})->name('home');

// route::get('/recp',[recep])


Route::middleware(['auth'])->group(function () {
    Route::get('/receptionist', [ReceptionistController::class, 'index'])
         ->name('receptionist.dashboard');
});


    Route::get('/report', [CalendarController::class, 'report'])->name('booking.report');

Route::resource('bookings', BookingController::class);

    Route::get('/calendar/{year?}/{month?}', [CalendarController::class, 'show'])
    ->where(['year' => '\d{4}', 'month' => '\d{1,2}'])
    ->name('calendar');