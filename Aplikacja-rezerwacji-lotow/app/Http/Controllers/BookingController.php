<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flight;
use App\Models\Passenger;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{

    public function create(Request $request)
    {
        $index = $request->query('index');

        $cacheKey = cache()->get('last_search_key');
        $flights = cache()->get($cacheKey);

        $flight = $flights[$index] ?? null;

        if (!$flight) {
            return redirect()->route('home')->with('error', 'Flight not found');
        }

        return view('bookings.create', [
            'flight' => $flight,
            'index' => $index
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'flight_index' => 'required|integer',
            'passengers' => 'required|array|min:1',
            'passengers.*.first_name' => 'required',
            'passengers.*.last_name' => 'required',
            'passengers.*.birth_date' => 'required|date',
            'passengers.*.nationality' => 'required',
            'passengers.*.document_number' => 'required',
            'passengers.*.passenger_type' => 'required|in:adult,child,infant',
        ]);

        $cacheKey = cache()->get('last_search_key');
        $flights = cache()->get($cacheKey);

        $flight = $flights[$request->flight_index] ?? null;

        if (!$flight) {
            return back()->withErrors(['flight' => 'Flight not found']);
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'booking_reference' => strtoupper(Str::random(8)),
            'status' => BookingStatus::CONFIRMED,
            'currency' => 'PLN',
            'passengers_count' => count($request->passengers),
            'total_price' => $flight['price'] * count($request->passengers),

            'flight_data' => json_encode($flight),
        ]);

        foreach ($request->passengers as $p) {
            $booking->passengers()->create($p);
        }

        return redirect()->route('bookings.show', $booking);
    }

    /**
     * Show booking summary
     */
    public function show(Booking $booking)
    {
        $booking->load('passengers');

        $flight = json_decode($booking->flight_data, true);

        if (!$flight) {
            abort(404, 'Flight data not found');
        }

        return view('bookings.show', [
            'booking' => $booking,
            'flight' => $flight,
        ]);
    }
}
