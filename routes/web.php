<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingSearchController;
use App\Http\Controllers\RoomController;
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

    // Route::resource('bookings', BookingController::class)
    // ->middleware('check.booking.dates', ['only' => ['store']]);
    Route::resource('bookings', BookingController::class)
    ->except(['show'])
    ->middleware('check.booking.dates', ['only' => ['store']]);

    Route::put('/bookings/{booking}/finish', [BookingController::class, 'finish'])
    ->name('bookings.finish');




    Route::get('/calendar/{year?}/{month?}', [CalendarController::class, 'show'])
    ->where(['year' => '\d{4}', 'month' => '\d{1,2}'])
    ->name('calendar');
// Route::get('/bookings/check-availability', [BookingController::class, 'checkAvailability'])
//     ->name('bookings.checkAvailability');
// Route::get('/rooms/search', [BookingSearchController::class, 'searchAvailableRooms'])
//     ->name('rooms.search');
// Route::get('/rooms/search/results', [BookingController::class, 'searchResults'])
//     ->name('bookings.results');


Route::get('/rooms/availability', [RoomController::class, 'checkRoomAvailability'])
     ->name('rooms.availability');


Route::post('/bookings/confirm', [RoomController::class, 'showConfirmation'])
->name('bookings.confirm');
Route::post('/bookings/save-for-later', [RoomController::class, 'saveForLater'])
->name('bookings.saveForLater');




Route::get('/bookings/filter', [BookingSearchController::class, 'filter'])
->name('bookings.filter');

Route::get('/bookings/filter', [BookingSearchController::class, 'index'])
->name('bookings.filter');
// عل الحذف التلت رواتات
// Route::post('/bookings/filter', [BookingSearchController::class, 'filterByStatus'])
// ->name('bookings.filter');
// Route::post('/bookings/filter-by-room', [BookingSearchController::class, 'filterByRoomType'])
// ->name('bookings.filter.room');


//      Route::get('/bookings/filter', [BookingSearchController::class, 'filterBookings'])
// ->name('bookings.filter');
