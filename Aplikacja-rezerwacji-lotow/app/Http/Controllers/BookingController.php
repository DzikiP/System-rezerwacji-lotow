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

    public function create(Flight $flight)
    {
        return view('bookings.create', compact('flight'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'passengers' => 'required|array|min:1',
            'passengers.*.first_name' => 'required',
            'passengers.*.last_name' => 'required',
            'passengers.*.birth_date' => 'required|date',
            'passengers.*.nationality' => 'required',
            'passengers.*.document_number' => 'required',
            'passengers.*.passenger_type' => 'required|in:adult,child,infant',
        ]);

        $flight = Flight::findOrFail($request->flight_id);

        $passengers = $request->input('passengers', []);

        if (empty($passengers)) {
            return back()->withErrors(['passengers' => 'Add at least one passenger']);
        }

        $booking = Booking::create([
            'user_id' => auth()->id() ?? 1,
            'flight_id' => $flight->id,
            'booking_reference' => strtoupper(Str::random(8)),
            'status' => BookingStatus::CONFIRMED,
            'currency' => $flight->currency,
            'passengers_count' => count($passengers),
            'total_price' => $flight->price * count($passengers),
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
     * Show booking summary
     */
    public function show(Booking $booking)
    {
        $booking->load(['passengers', 'flight']);

        return view('bookings.show', compact('booking'));
    }
}
