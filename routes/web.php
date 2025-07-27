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

// ملف web.php

Route::middleware('auth')->group(function () {
    // ✏️ المسارات العامة للمستخدم المسجل الدخول
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route::middleware(['auth', 'role:Admin'])->group(function () {
Route::middleware('auth')->group(function () {
    //  فقط Admin أو Receptionist المسجلين دخول يمكنهم الوصول إلى ما يلي:

    // إدارة الغرف
    Route::resource('rooms', RoomController::class);

    // عرض إضافي لأنواع الغرف (ممكن يكون للعرض فقط أو مخصص للجدول)
    Route::get('room-types/view', [RoomTypeController::class, 'view'])->name('room-types.view');

    // إدارة أنواع الغرف
    Route::resource('room-types', RoomTypeController::class);

    // إدارة الخدمات
    Route::resource('services', ServiceController::class);
});



require __DIR__.'/auth.php';
Route::get('/home', function () {
    return view('home');
})->name('home');


// route::middleware(['auth'])->group(function(){

//     Route::resource('rooms',RoomController::class);
// });