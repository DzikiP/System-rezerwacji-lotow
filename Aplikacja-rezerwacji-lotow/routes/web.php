<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
});

Route::get('/', [FlightController::class, 'home'])->name('home');

// AUTH
Route::middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// FLIGHTS (API SEARCH)
Route::get('/flights/search', [FlightController::class, 'search'])
    ->name('flights.search');

// BOOKINGS (SNAPSHOT SYSTEM)
Route::middleware('auth')->group(function () {

    Route::post('/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->name('bookings.show');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
