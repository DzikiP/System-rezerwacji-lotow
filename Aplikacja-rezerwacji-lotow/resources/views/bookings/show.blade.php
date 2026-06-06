@extends('layouts.app')

@section('content')

    <section class="min-h-screen bg-gray-950 text-white pt-32 pb-20">

        <div class="container mx-auto max-w-5xl px-6">

            <!-- HEADER -->
            <div class="flex justify-between items-start mb-10">

                <div>
                    <h1 class="text-4xl font-bold">
                        Booking {{ $booking->booking_reference }}
                    </h1>

                    <div class="mt-3">
                    <span class="px-4 py-1 rounded-full text-sm bg-gray-800 {{ $booking->status->color() }}">
                        {{ $booking->status->label() }}
                    </span>
                    </div>
                </div>

                <div class="text-right">
                    <div class="text-3xl font-bold text-blue-400">
                        {{ number_format($booking->total_price, 2) }} {{ $booking->currency }}
                    </div>

                    <div class="text-gray-400 text-sm">
                        {{ $booking->passengers_count }} passenger(s)
                    </div>
                </div>

            </div>

            @php
                $flight = json_decode($booking->flight_data, true);
                $segment = $flight['flights'][0] ?? null;
            @endphp

                <!-- FLIGHT CARD -->
            @php
                $flight = json_decode($booking->flight_data, true);
            @endphp

            @if($flight)

                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 mb-10">

                    <h2 class="text-xl font-semibold mb-6">
                        Flight details
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <!-- AIRLINE -->
                        <div class="flex items-start gap-4">

                            @if(!empty($flight['airline_logo']))
                                <img src="{{ $flight['airline_logo'] }}"
                                     class="w-12 h-12 bg-white rounded-full p-1">
                            @endif

                            <div>
                                <div class="font-semibold text-lg">
                                    {{ $flight['airline'] ?? 'Unknown airline' }}
                                </div>

                                <div class="text-gray-400 text-sm">
                                    {{ $flight['flight_number'] ?? '' }}
                                </div>

                                <div class="text-gray-400 text-sm mt-2">
                                    Aircraft:
                                    <span class="text-white">
                        {{ $flight['airplane'] ?? 'N/A' }}
                    </span>
                                </div>
                            </div>

                        </div>

                        <!-- ROUTE -->
                        <div class="text-center">

                            <div class="text-xl font-bold">
                                {{ $flight['from'] ?? '' }} → {{ $flight['to'] ?? '' }}
                            </div>

                            <div class="text-gray-400 mt-2 text-sm">
                                <div>
                                    Departure:
                                    {{ \Carbon\Carbon::parse($flight['departure_time'] ?? now())->format('d M Y H:i') }}
                                </div>

                                <div>
                                    Arrival:
                                    {{ \Carbon\Carbon::parse($flight['arrival_time'] ?? now())->format('d M Y H:i') }}
                                </div>
                            </div>

                            <div class="mt-3 text-gray-400 text-sm">
                                Duration:
                                {{ floor(($flight['duration'] ?? 0) / 60) }}h
                                {{ ($flight['duration'] ?? 0) % 60 }}m
                            </div>

                        </div>

                        <!-- PRICE -->
                        <div class="text-right">

                            <div class="text-2xl font-bold text-blue-400">
                                {{ number_format($flight['price'] ?? 0) }} PLN
                            </div>

                            <div class="text-gray-400 text-sm mt-2">
                                {{ $flight['travel_class'] ?? 'Economy' }}
                            </div>

                            @if(!empty($flight['co2']))
                                <div class="text-green-400 text-sm mt-4">
                                    CO₂: {{ round($flight['co2'] / 1000) }} kg
                                </div>
                            @endif

                        </div>

                    </div>
                </div>

            @else

                <p class="text-gray-400">Flight data unavailable</p>

            @endif

            <!-- PASSENGERS -->
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6">

                <h2 class="text-xl font-semibold mb-6">
                    Passengers
                </h2>

                @if($booking->passengers->count())

                    <div class="space-y-4">

                        @foreach($booking->passengers as $p)

                            <div class="flex justify-between items-center border-b border-gray-800 pb-3">

                                <div>
                                    <div class="font-semibold">
                                        {{ $p->first_name }} {{ $p->last_name }}
                                    </div>

                                    <div class="text-gray-400 text-sm">
                                        {{ ucfirst($p->passenger_type) }}
                                    </div>
                                </div>

                                <div class="text-gray-400 text-sm">
                                    {{ $p->nationality }}
                                </div>

                            </div>

                        @endforeach

                    </div>

                @else
                    <p class="text-gray-400">No passengers found</p>
                @endif

            </div>

        </div>

    </section>

@endsection
