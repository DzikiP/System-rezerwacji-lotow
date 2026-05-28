@extends('layouts.app')

@section('content')

    <section class="min-h-screen bg-gray-950 text-white pt-10 pb-20">

        <div class="container mx-auto px-6">

            <!-- HEADER -->
            <div class="mb-12">

                <h1 class="text-5xl font-bold mb-4">
                    Available Flights
                </h1>

                <p class="text-gray-400 text-lg">
                    Choose the perfect flight for your next journey.
                </p>

            </div>

            <!-- FLIGHTS GRID -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                @foreach($flights as $flight)

                    <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8 hover:border-blue-500/40 hover:shadow-2xl hover:shadow-blue-500/10 transition duration-300">

                        <!-- TOP -->
                        <div class="flex items-start justify-between mb-8">

                            <div>

                                <p class="text-sm text-gray-400 mb-2">
                                    Airline
                                </p>

                                <h2 class="text-3xl font-bold">
                                    {{ $flight->airline }}
                                </h2>

                            </div>

                            <div class="bg-blue-600/20 text-blue-400 px-4 py-2 rounded-xl font-semibold">
                                {{ $flight->price }} {{ $flight->currency }}
                            </div>

                        </div>

                        <!-- ROUTE -->
                        <div class="flex items-center justify-between mb-8">

                            <div>

                                <p class="text-gray-400 text-sm mb-1">
                                    From
                                </p>

                                <h3 class="text-2xl font-semibold">
                                    {{ $flight->origin_airport }}
                                </h3>

                            </div>

                            <div class="text-blue-400 text-3xl">
                                ✈
                            </div>

                            <div class="text-right">

                                <p class="text-gray-400 text-sm mb-1">
                                    To
                                </p>

                                <h3 class="text-2xl font-semibold">
                                    {{ $flight->destination_airport }}
                                </h3>

                            </div>

                        </div>

                        <!-- TIMES -->
                        <div class="grid grid-cols-2 gap-6 mb-8">

                            <div class="bg-gray-800 rounded-2xl p-4">

                                <p class="text-gray-400 text-sm mb-2">
                                    Departure
                                </p>

                                <p class="font-semibold">
                                    {{ $flight->departure_time }}
                                </p>

                            </div>

                            <div class="bg-gray-800 rounded-2xl p-4">

                                <p class="text-gray-400 text-sm mb-2">
                                    Arrival
                                </p>

                                <p class="font-semibold">
                                    {{ $flight->arrival_time }}
                                </p>

                            </div>

                        </div>

                        <!-- BUTTON -->
                        <a
                            href="/flights/{{ $flight->id }}"
                            class="block text-center bg-blue-600 hover:bg-blue-700 transition py-4 rounded-2xl font-semibold shadow-lg"
                        >
                            View Details
                        </a>

                    </div>

                @endforeach

            </div>

        </div>

    </section>

@endsection
