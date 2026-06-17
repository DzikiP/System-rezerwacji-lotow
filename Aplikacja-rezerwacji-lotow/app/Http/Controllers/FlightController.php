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
        // 1. VALIDATION
        if (!$request->from || !$request->to || !$request->departure_date) {
            return redirect()->route('home')
                ->with('error', 'Please fill all fields');
        }

        // 2. INPUT
        $from = strtoupper($request->from);
        $to = strtoupper($request->to);
        $tripType = $request->trip_type ?? 'one_way';
        $returnDate = $request->return_date ?? null;

        $isAnywhere = $to === 'ANYWHERE';

        // 3. CACHE KEY
        $cacheKey = 'flights_' . md5(
                $from . $to . $request->departure_date . $tripType . $returnDate
            );

        // 4. CACHE CHECK
        if (cache()->has($cacheKey)) {
            $results = cache()->get($cacheKey);
        } else {

            // 5. AIRPORTS FOR ANYWHERE MODE
            $popularAirports = [
                'LHR' => 10,
                'AMS' => 9,
                'CDG' => 9,
                'BER' => 8,
                'BCN' => 8,
                'MAD' => 7,
                'ROM' => 7,
                'FCO' => 6,
                'STN' => 6,
                'LTN' => 6,
            ];

            $allFlights = [];

            // 6. FETCH LOGIC
            if ($isAnywhere) {

                $destinations = array_keys($popularAirports);

                shuffle($destinations);

                $destinations = array_slice($destinations, 0, 4);

                foreach ($destinations as $destination) {

                    if ($destination === $from) {
                        continue;
                    }

                    $data = $this->fetchFlights(
                        $from,
                        $destination,
                        $request->departure_date,
                        $tripType,
                        $returnDate
                    );

                    $data = array_slice($data, 0, 3);

                    $allFlights = array_merge($allFlights, $data);
                }

            } else {

                $allFlights = $this->fetchFlights(
                    $from,
                    $to,
                    $request->departure_date,
                    $tripType,
                    $returnDate
                );
            }

            // 7. LIMIT RESULTS
            $allFlights = array_slice($allFlights, 0, 40);

            // 8. NORMALIZE
            $results = collect($allFlights)
                ->map(function ($flight) {

                    if (!isset($flight['flights'][0])) {
                        return null;
                    }

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

                        'stops' => count($flight['flights'] ?? []) - 1,

                        'co2' => $flight['carbon_emissions']['this_flight'] ?? null,
                    ];
                })
                ->filter()
                ->values()
                ->toArray();

            // 9. SORT ANYWHERE
            if ($isAnywhere) {
                usort($results, fn($a, $b) => $a['price'] <=> $b['price']);
            }

            // 10. CACHE
            cache()->put($cacheKey, $results, now()->addMinutes(10));
            cache()->put('last_search_key', $cacheKey, now()->addMinutes(10));
        }

        // 11. FILTERS
        if ($request->stops !== null) {
            $results = array_values(array_filter($results, fn($f) =>
                $f['stops'] <= (int)$request->stops
            ));
        }

        if ($request->max_price) {
            $results = array_values(array_filter($results, fn($f) =>
                $f['price'] <= (int)$request->max_price
            ));
        }

        // 12. SORT OPTIONS
        if ($request->sort === 'price') {
            usort($results, fn($a, $b) => $a['price'] <=> $b['price']);
        }

        if ($request->sort === 'duration') {
            usort($results, fn($a, $b) => $a['duration'] <=> $b['duration']);
        }

        $results = array_values($results);

        // 13. VIEW
        return view('flights.results', [
            'flights' => $results
        ]);
    }

    /**
     * SAFE API WRAPPER (AUTO DETECT TYPE)
     */
    private function fetchFlights($from, $to, $date, $tripType = 'one_way', $returnDate = null)
    {
        // AUTO DETECT TYPE
        $type = 2; // one-way default

        if ($tripType === 'round_trip' && $returnDate) {
            $type = 1;
        }

        $params = [
            'engine' => 'google_flights',
            'departure_id' => $from,
            'arrival_id' => $to,
            'outbound_date' => $date,
            'currency' => 'PLN',
            'type' => $type,
            'api_key' => env('SERP_API_KEY'),
        ];

        if ($type === 1) {
            $params['return_date'] = $returnDate;
        }

        $response = Http::get('https://serpapi.com/search.json', $params);

        $data = $response->json();

        if (isset($data['error'])) {
            logger()->error('SerpAPI error', $data);
            return [];
        }

        return array_merge(
            $data['best_flights'] ?? [],
            $data['other_flights'] ?? []
        );
    }

    public function show($index)
    {
        $cacheKey = cache()->get('last_search_key');
        $flights = cache()->get($cacheKey, []);

        $flight = $flights[$index] ?? null;

        if (!$flight) {
            return redirect()->route('home')
                ->with('error', 'Flight not found');
        }

        return view('flights.show', [
            'flight' => $flight,
            'index' => $index
        ]);
    }
}
