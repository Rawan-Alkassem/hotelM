<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\RoomTypeController;

use App\Http\Controllers\HotelManagerController;
use App\Http\Controllers\ReceptionistController;

use App\Http\Controllers\BookingSearchController;
use App\Http\Controllers\Admin\EmployeeController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/home', function () {
    return view('home');
})->name('home');



// ✏️ المسارات العامة للمستخدم المسجل الدخول
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🛏️ إدارة الغرف، أنواع الغرف، والخدمات (Admin فقط)
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('rooms', RoomController::class);

    Route::get('room-types/view', [RoomTypeController::class, 'view'])->name('room-types.view');
    Route::resource('room-types', RoomTypeController::class);

    Route::resource('services', ServiceController::class);

    // إدارة الموظفين
    Route::get('/employeesmanagement/index', [EmployeeController::class, 'index'])->name('employeesmanagement.index');
    Route::get('/employeesmanagement/create', [EmployeeController::class, 'create'])->name('employeesmanagement.create');
    Route::post('/employeesmanagement/index', [EmployeeController::class, 'store'])->name('employeesmanagement.store');
    Route::get('/employeesmanagement/{user}/edit-role', [EmployeeController::class, 'editRole'])->name('employeesmanagement.edit-role');
    Route::put('/employeesmanagement/{user}/update-role', [EmployeeController::class, 'updateRole'])->name('employeesmanagement.update-role');
    Route::delete('/employeesmanagement/{user}', [EmployeeController::class, 'destroy'])->name('employeesmanagement.destroy');
});

// 👨‍💼 لوحة استقبال للموظف (Receptionist)
Route::middleware(['auth'])->group(function () {
    Route::get('/receptionist', action: [ReceptionistController::class, 'index'])->name('receptionist.dashboard');

    // تقارير الحجز
    Route::get('/report', [CalendarController::class, 'report'])->name('booking.report');


    // Route::resource('bookings', BookingController::class)
    // ->middleware('check.booking.dates', ['only' => ['store']]);
  //  Route::resource('bookings', BookingController::class)
  //  ->except(['show'])
   // ->middleware('check.booking.dates', ['only' => ['store']]);

 //   Route::put('/bookings/{booking}/finish', [BookingController::class, 'finish'])
  //  ->name('bookings.finish');

//الحجوزات
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

    // إنشاء وتعديل وحذف الحجوزات (Admin وReceptionist فقط)
    Route::middleware(['role:Admin|Receptionist'])->group(function () {
        Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store')
         ->middleware('check.booking.dates');
        Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit')
        ->middleware('check.booking.dates');
        Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
  Route::get('/bookings/{booking}/info', [BookingController::class, 'info'])
    ->name('bookings.info');
Route::get('/bookings/{booking}/edit-log', [BookingController::class, 'editLog'])
    ->name('bookings.editLog');

Route::put('/bookings/{booking}/update-log', [BookingController::class, 'updateLog'])
    ->name('bookings.updateLog');

Route::post('/bookings/confirm', [RoomController::class, 'showConfirmation'])
->name('bookings.confirm');
Route::post('/bookings/confirmBooking', [BookingController::class, 'confirmBooking'])
->name('booking.confirm')->middleware(['auth', 'check.booking.dates']);

    });



    // التقويم
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
// Route::post('/bookings/confirm', [RoomController::class, 'showConfirmation'])
// ->name('bookings.confirm');
Route::post('/bookings/save-for-later', [RoomController::class, 'saveForLater'])
->name('bookings.saveForLater');



//للمراجعة لاحقا 29/7/2025
// Route::get('/bookings/filter', [BookingSearchController::class, 'filter'])
// ->name('bookings.filter');

Route::get('/bookings/filter', [BookingSearchController::class, 'index'])
->name('bookings.filter');
// عل الحذف التلت رواتات
// Route::post('/bookings/filter', [BookingSearchController::class, 'filterByStatus'])
// ->name('bookings.filter');
// Route::post('/bookings/filter-by-room', [BookingSearchController::class, 'filterByRoomType'])
// ->name('bookings.filter.room');


//      Route::get('/bookings/filter', [BookingSearchController::class, 'filterBookings'])
// ->name('bookings.filter');

});

Route::get('/bookings/filter', [BookingSearchController::class, 'index'])
->name('bookings.filter');
Route::prefix('hotel-manager')->middleware('auth')->group(function () {
    Route::get('/', [HotelManagerController::class, 'index'])->name('hotelManager.index');
    Route::get('/yearly-occupancy', [HotelManagerController::class, 'yearlyOccupancyReport'])
        ->name('hotelManager.yearlyOccupancy');
    Route::get('/monthly-occupancy', [HotelManagerController::class, 'monthlyOccupancy'])
        ->name('hotelManager.monthlyOccupancy');
    Route::get('/occupancy/by-type', [HotelManagerController::class, 'yearlyOccupancyByType'])
        ->name('hotelManager.occupancy.by-type');
});


Route::middleware(['role:Hotel Manager||Admin'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});


Route::middleware(['role:Hotel Manager||Admin'])->group(function () {
    Route::get('/reports/profitReport', [ReportController::class, 'profitReport'])->name('reports.profitReport');
});
