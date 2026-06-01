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

        // 2. trip type (NOWOŚĆ)
        $tripType = $request->trip_type ?? 'one_way';

        $from = strtoupper($request->from);
        $to = strtoupper($request->to);

        // 3. cache (lepszy klucz)
        $cacheKey = 'flights_' . md5($from . $to . $request->departure_date . $tripType);

        // 4. cache check
        if (cache()->has($cacheKey)) {
            $results = cache()->get($cacheKey);
        } else {

            // 5. API PARAMS (KLUCZOWA ZMIANA)
            $params = [
                'engine' => 'google_flights',
                'departure_id' => $from,
                'arrival_id' => $to,
                'outbound_date' => $request->departure_date,
                'currency' => 'USD',
                'api_key' => env('SERP_API_KEY'),
            ];

            // 🔥 LOGIKA ONE-WAY / ROUND-TRIP
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

            // 7. ERROR HANDLING (ważne)
            if (isset($data['error'])) {
                return redirect()->route('home')
                    ->with('error', $data['error']);
            }

            // 8. NORMALIZE
            $results = collect($data['best_flights'] ?? [])
                ->map(function ($flight) {
                    return [
                        'price' => $flight['price'] ?? null,
                        'duration' => $flight['total_duration'] ?? null,
                        'stops' => count($flight['flights'] ?? []) - 1,
                        'from' => $flight['flights'][0]['departure_airport']['id'] ?? null,
                        'to' => last($flight['flights'])['arrival_airport']['id'] ?? null,
                        'departure_time' => $flight['flights'][0]['departure_airport']['time'] ?? null,
                        'arrival_time' => last($flight['flights'])['arrival_airport']['time'] ?? null,
                        'raw' => $flight
                    ];
                })
                ->toArray();

            // 9. CACHE 10 MIN
            cache()->put($cacheKey, $results, now()->addMinutes(10));
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
}
