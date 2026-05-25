<?php

namespace App\Http\Controllers;

class FlightController extends Controller
{
    public function index()
    {
        $flights = \App\Models\Flight::all();

        return view('flights.index', compact('flights'));
    }

    public function show(\App\Models\Flight $flight)
    {
        return view('flights.show', compact('flight'));
    }
}
