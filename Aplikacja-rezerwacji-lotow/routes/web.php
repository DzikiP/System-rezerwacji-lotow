<?php

use Illuminate\Support\Facades\Route;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return view('welcome');
});


//Flights routes
Route::get('/flights', [FlightController::class, 'index']);
Route::get('/flights/{flight}', [FlightController::class, 'show']);
Route::get('/flights/{flight}/book', [BookingController::class, 'create'])
    ->name('bookings.create');

//Booking routes
Route::post('/bookings', [BookingController::class, 'store'])
    ->name('bookings.store');

Route::get('/bookings/{booking}', [BookingController::class, 'show'])
    ->name('bookings.show');
