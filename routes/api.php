<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\ServicePublicController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//إنشاء وتسجيل دخول
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// عرض انواع الغرف
Route::get('/room-types', [RoomController::class, 'types']);
// كل الغرف المتاحة
Route::get('/rooms', [RoomController::class, 'index']);
// عرض تفاصيل الغرفة المستخدم اختارها
Route::get('/rooms/{id}', [RoomController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
    Route::post('/bookings/{id}/review', [BookingController::class, 'addReview']);
});
