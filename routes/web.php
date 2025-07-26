<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

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
    //ادارة الغرفة
    Route::resource('rooms',RoomController::class);

     Route::get('room-types/view', [RoomTypeController::class, 'view'])->name('room-types.view');

    //ادراة انواع الغرف
    Route::resource('room-types',RoomTypeController::class);
   
    //الخدمات
    Route::resource('services', ServiceController::class);


//     Route::middleware(['auth', 'role:Admin|Receptionist'])->group(function () {
//     Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
//     Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
//     Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
//     Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
//     Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
// });

});


require __DIR__.'/auth.php';
Route::get('/home', function () {
    return view('home');
})->name('home');


// route::middleware(['auth'])->group(function(){

//     Route::resource('rooms',RoomController::class);
// });