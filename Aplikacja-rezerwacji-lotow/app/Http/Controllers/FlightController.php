<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FlightController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function search(Request $request)
    {
        // 1. walidacja minimalna
        if (!$request->from || !$request->to || !$request->departure_date) {
            return redirect()->route('home')
                ->with('error', 'Please fill all fields');
        }

        // 2. trip type
        $tripType = $request->trip_type ?? 'one_way';

        $from = strtoupper($request->from);
        $to = strtoupper($request->to);

        // 3. cache
        $cacheKey = 'flights_' . md5($from . $to . $request->departure_date . $tripType);

        // 4. cache check
        if (cache()->has($cacheKey)) {
            $results = cache()->get($cacheKey);
        } else {

            // 5. API PARAMS
            $params = [
                'engine' => 'google_flights',
                'departure_id' => $from,
                'arrival_id' => $to,
                'outbound_date' => $request->departure_date,
                'currency' => 'PLN',
                'api_key' => env('SERP_API_KEY'),
            ];

            // LOGIKA ONE-WAY / ROUND-TRIP
            if ($tripType === 'round_trip') {
                $params['type'] = 1;

                if ($request->return_date) {
                    $params['return_date'] = $request->return_date;
                }
            } else {
                $params['type'] = 2;
            }

            // 6. REQUEST
            $response = Http::get('https://serpapi.com/search.json', $params);

            $data = $response->json();

            // 7. ERROR HANDLING
            if (isset($data['error'])) {
                return redirect()->route('home')
                    ->with('error', $data['error']);
            }

            // 8. NORMALIZE
            $flightsData = $data['best_flights'] ?? $data['other_flights'] ?? [];

            $flightsData = collect($flightsData)
                ->filter(function ($flight) use ($from, $to) {

                    $segment = $flight['flights'][0] ?? null;

                    if (!$segment) return false;

                    $dep = $segment['departure_airport']['id'] ?? null;
                    $arr = $segment['arrival_airport']['id'] ?? null;

                    return $dep === $from && $arr === $to;
                })
                ->values();

            $results = collect($flightsData)
                ->map(function ($flight) {

                    $segment = $flight['flights'][0];

                    return [
                        'price' => $flight['price'] ?? 0,
                        'duration' => $flight['total_duration'] ?? 0,
                        'type' => $flight['type'] ?? 'Flight',

                        'from' => $segment['departure_airport']['id'] ?? '',
                        'from_name' => $segment['departure_airport']['name'] ?? '',

                        'to' => $segment['arrival_airport']['id'] ?? '',
                        'to_name' => $segment['arrival_airport']['name'] ?? '',

                        'departure_time' => $segment['departure_airport']['time'] ?? '',
                        'arrival_time' => $segment['arrival_airport']['time'] ?? '',

                        'airline' => $segment['airline'] ?? '',
                        'airline_logo' => $segment['airline_logo'] ?? '',

                        'flight_number' => $segment['flight_number'] ?? '',

                        'airplane' => $segment['airplane'] ?? '',
                        'travel_class' => $segment['travel_class'] ?? '',

                        'stops' => count($flight['flights']) - 1,

                        'co2' => $flight['carbon_emissions']['this_flight'] ?? null,
                    ];
                })
                ->toArray();

            // 9. CACHE 10 MIN
            cache()->put($cacheKey, $results, now()->addMinutes(10));
            cache()->put('last_search_key', $cacheKey, now()->addMinutes(10));
        }

        // 10. FILTERS
        if ($request->stops !== null) {
            $results = array_filter($results, fn($f) =>
                $f['stops'] <= (int)$request->stops
            );
        }

        if ($request->max_price) {
            $results = array_filter($results, fn($f) =>
                $f['price'] <= (int)$request->max_price
            );
        }

        // 11. SORT
        if ($request->sort === 'price') {
            usort($results, fn($a, $b) => $a['price'] <=> $b['price']);
        }

        if ($request->sort === 'duration') {
            usort($results, fn($a, $b) => $a['duration'] <=> $b['duration']);
        }

        $results = array_values($results);

        // 12. VIEW
        return view('flights.results', [
            'flights' => $results
        ]);
    }

    public function show($index)
    {
        $cacheKey = cache()->get('last_search_key');
        $flights = cache()->get($cacheKey);

        $flight = $flights[$index] ?? null;

        if (!$flight) {
            return redirect()->route('home')->with('error', 'Flight not found');
        }

        return view('flights.show', [
            'flight' => $flight,
            'index' => $index
        ]);
    }
}
