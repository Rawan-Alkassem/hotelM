<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\EmployeeController;

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

// Route::resource('bookings', BookingController::class);

// عرض الحجوزات للجميع (أي مستخدم مسجّل دخول)
Route::get('/bookings', [BookingController::class, 'index'])->middleware('auth')->name('bookings.index');
//qf' hgwghpdhj fa;g htqg

// فقط Admin و Receptionist يمكنهم إنشاء وتعديل وحذف الحجوزات
Route::middleware(['auth', 'role:Admin|Receptionist'])->group(function () {
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});


    Route::get('/calendar/{year?}/{month?}', [CalendarController::class, 'show'])
    ->where(['year' => '\d{4}', 'month' => '\d{1,2}'])
    ->name('calendar');

//     Route::get('/employeesmanagement/index', [EmployeeController::class, 'index'])
//     ->name('employeesmanagement.index');

// Route::get('/employeesmanagement/create', [EmployeeController::class, 'create'])
//     ->name('employeesmanagement.create');

// Route::post('/employeesmanagement/index', [EmployeeController::class, 'store'])
//     ->name('employeesmanagement.store');

// Route::get('/employeesmanagement/{user}/edit-role', [EmployeeController::class, 'editRole'])
//     ->name('employeesmanagement.edit-role');

// Route::put('/employeesmanagement/{user}/update-role', [EmployeeController::class, 'updateRole'])
//     ->name('employeesmanagement.update-role');

//     Route::delete('/employeesmanagement/{user}', [EmployeeController::class, 'destroy'])
//     ->name('employeesmanagement.destroy');
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/employeesmanagement/index', [EmployeeController::class, 'index'])->name('employeesmanagement.index');
    Route::get('/employeesmanagement/create', [EmployeeController::class, 'create'])->name('employeesmanagement.create');
    Route::post('/employeesmanagement/index', [EmployeeController::class, 'store'])->name('employeesmanagement.store');
    Route::get('/employeesmanagement/{user}/edit-role', [EmployeeController::class, 'editRole'])->name('employeesmanagement.edit-role');
    Route::put('/employeesmanagement/{user}/update-role', [EmployeeController::class, 'updateRole'])->name('employeesmanagement.update-role');
    Route::delete('/employeesmanagement/{user}', [EmployeeController::class, 'destroy'])->name('employeesmanagement.destroy');
});
