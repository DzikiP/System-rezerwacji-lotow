<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreBookingRequest;

class BookingController extends Controller
{
    /**
     * CREATE (show booking form)
     */
    public function create(Request $request)
    {
        $cacheKey = cache()->get('last_search_key');

        if (!$cacheKey) {
            return redirect()->route('home')
                ->with('error', 'Search session expired');
        }

        $flights = cache()->get($cacheKey, []);

        $index = (int) $request->flight_index;

        $flight = $flights[$index] ?? null;

        if (!$flight || !is_array($flight)) {
            return redirect()->route('home')
                ->with('error', 'Flight not found');
        }

        return view('bookings.create', [
            'flight' => $flight,
            'index' => $index
        ]);
    }

    /**
     * STORE booking
     */
    public function store(StoreBookingRequest $request)
    {
        $request->validate([
            'flight_index' => 'required|integer',
            'passengers' => 'required|array|min:1',
            'passengers.*.first_name' => 'required|string',
            'passengers.*.last_name' => 'required|string',
            'passengers.*.birth_date' => 'required|date',
            'passengers.*.nationality' => 'required|string',
            'passengers.*.document_number' => 'required|string',
            'passengers.*.passenger_type' => 'required|in:adult,child,infant',
        ]);

        $cacheKey = cache()->get('last_search_key');

        if (!$cacheKey) {
            return back()->withErrors(['flight' => 'Search session expired']);
        }

        $flights = cache()->get($cacheKey, []);

        $flight = $flights[$request->flight_index] ?? null;

        if (!$flight || !is_array($flight)) {
            return back()->withErrors(['flight' => 'Flight not found']);
        }

        $passengers = $request->passengers;

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'booking_reference' => strtoupper(Str::random(8)),
            'status' => BookingStatus::CONFIRMED,

            'currency' => 'PLN',
            'passengers_count' => count($passengers),
            'total_price' => $flight['price'] * count($passengers),

            // 👉 LEPSZE: cast JSON (bez json_encode)
            'flight_data' => $flight,
        ]);

        foreach ($passengers as $p) {
            $booking->passengers()->create([
                'first_name' => $p['first_name'],
                'last_name' => $p['last_name'],
                'birth_date' => $p['birth_date'],
                'nationality' => $p['nationality'],
                'document_number' => $p['document_number'],
                'passenger_type' => $p['passenger_type'],
            ]);
        }

        return redirect()->route('bookings.show', $booking);
    }

    /**
     * SHOW booking
     */
    public function show(Booking $booking)
    {
        $booking->load('passengers');

        $flight = $booking->flight_data;

        if (!$flight) {
            abort(404, 'Flight data not found');
        }

        return view('bookings.show', [
            'booking' => $booking,
            'flight' => $flight,
        ]);
    }

    public function edit(Booking $booking)
    {
        $booking->load('passengers');

        $flight = $booking->flight_data;

        return view('bookings.edit', [
            'booking' => $booking,
            'flight' => $flight,
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'passengers' => 'required|array|min:1',
            'passengers.*.first_name' => 'required',
            'passengers.*.last_name' => 'required',
            'passengers.*.birth_date' => 'required|date',
            'passengers.*.nationality' => 'required',
            'passengers.*.document_number' => 'required',
            'passengers.*.passenger_type' => 'required|in:adult,child,infant',
        ]);

        // update passengers (najprościej: delete + recreate)
        $booking->passengers()->delete();

        foreach ($request->passengers as $p) {
            $booking->passengers()->create($p);
        }

        // aktualizacja price (opcjonalnie)
        $flight = $booking->flight_data;

        $booking->update([
            'passengers_count' => count($request->passengers),
            'total_price' => $flight['price'] * count($request->passengers),
        ]);

        return redirect()
            ->route('bookings.show', $booking)
            ->with('success', 'Booking updated');
    }
}
