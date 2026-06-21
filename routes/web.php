<?php

use App\Http\Controllers\AirportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;


Route::get('/', [FlightController::class, 'home'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

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

// FLIGHTS
Route::get('/flights/search', [FlightController::class, 'search'])
    ->name('flights.search');

Route::get('/flights/{index}', [FlightController::class, 'show'])
    ->name('flights.show');

Route::get('/api/airports/search', [AirportController::class, 'search']);

// BOOKINGS
Route::middleware('auth')->group(function () {

    Route::get('/bookings/create', [BookingController::class, 'create'])
        ->name('bookings.create');

    Route::post('/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');

    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])
        ->name('bookings.edit');

    Route::put('/bookings/{booking}', [BookingController::class, 'update'])
        ->name('bookings.update');

    Route::get('/bookings/{booking}', [BookingController::class, 'show'])
        ->name('bookings.show');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Payments

Route::get('/bookings/{booking}/checkout', [PaymentController::class, 'checkout'])->name('checkout');
Route::post('/bookings/{booking}/pay', [PaymentController::class, 'pay'])->name('pay');

Route::get('/payment/success/{booking}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/fail/{booking}', [PaymentController::class, 'fail'])->name('payment.fail');

//Ticket
Route::get('/bookings/{booking}/ticket', [TicketController::class, 'generate'])
    ->name('ticket.generate');
