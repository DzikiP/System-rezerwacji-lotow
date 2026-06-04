<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $airports = Airport::query()
            ->where(function ($query) use ($q) {
                $query->where('iata', 'ILIKE', "%{$q}%")
                    ->orWhere('city', 'ILIKE', "%{$q}%")
                    ->orWhere('name', 'ILIKE', "%{$q}%")
                    ->orWhere('country', 'ILIKE', "%{$q}%");
            })
            ->orderBy('country')
            ->orderBy('city')
            ->limit(15)
            ->get([
                'iata',
                'name',
                'city',
                'country'
            ])
            ->map(fn ($airport) => [
                'label' => "{$airport->city} ({$airport->iata}) - {$airport->name}",
                'iata' => $airport->iata,
                'city' => $airport->city,
                'country' => $airport->country,
            ]);

        return response()->json($airports);
    }
}
