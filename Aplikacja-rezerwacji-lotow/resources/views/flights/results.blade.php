@extends('layouts.app')

@section('content')

    <section class="min-h-screen bg-gray-950 text-white pt-20 pb-20">

        <div class="container mx-auto px-6 max-w-7xl">

            <h1 class="text-4xl font-bold mb-10">
                Best Available Flights
            </h1>

            <div class="space-y-6">

                @forelse($flights as $index => $flight)

                    <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6">

                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                            <!-- LEFT -->
                            <div class="flex items-center gap-4">

                                @if($flight['airline_logo'])
                                    <img
                                        src="{{ $flight['airline_logo'] }}"
                                        class="w-12 h-12 object-contain bg-white rounded-full p-1"
                                    >
                                @endif

                                <div>
                                    <h3 class="font-semibold text-lg">
                                        {{ $flight['airline'] }}
                                    </h3>

                                    <p class="text-gray-400 text-sm">
                                        Numer lotu:
                                        {{ $flight['flight_number'] }}
                                    </p>
                                </div>

                                    <div class="text-2xl font-bold">
                                        {{ \Carbon\Carbon::parse($flight['departure_time'])->format('d M Y') }}
                                    </div>

                            </div>

                            <!-- CENTER -->
                            <div class="flex-1">

                                <div class="flex items-center justify-center gap-8">

                                    <div class="text-center">
                                        <div class="text-2xl font-bold">
                                            {{ \Carbon\Carbon::parse($flight['departure_time'])->format('H:i') }}
                                        </div>

                                        <div class="text-gray-400">
                                            {{ $flight['from_name'] }} ({{ $flight['from'] }})
                                        </div>
                                    </div>

                                    <div class="text-center">

                                        <div class="text-gray-400 text-sm">
                                            {{ floor($flight['duration']/60) }}h {{ $flight['duration']%60 }}m
                                        </div>

                                        <div class="w-32 border-t border-gray-600 my-2"></div>

                                        <div class="text-xs text-gray-500">
                                            {{ $flight['stops'] == 0 ? 'Direct' : $flight['stops'].' stop(s)' }}
                                        </div>

                                    </div>

                                    <div class="text-center">
                                        <div class="text-2xl font-bold">
                                            {{ \Carbon\Carbon::parse($flight['arrival_time'])->format('H:i') }}
                                        </div>

                                        <div class="text-gray-400">
                                            {{ $flight['to_name'] }} ({{ $flight['to'] }})
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- RIGHT -->
                            <div class="text-right">

                                <div class="text-3xl font-bold text-blue-400">
                                    {{ number_format($flight['price']) }} PLN
                                </div>

                                <div class="text-gray-400 text-sm mb-4">
                                    {{ $flight['travel_class'] }}
                                </div>

                                <form method="GET" action="{{ route('bookings.create') }}">

                                    <input type="hidden" name="flight_index" value="{{ $index }}">

                                    <button class="w-full bg-blue-600 py-3 rounded-xl">
                                        Select
                                    </button>
                                </form>

                            </div>

                        </div>

                        <!-- DETAILS -->
                        <div class="mt-6 pt-6 border-t border-gray-800 text-sm text-gray-400">

                            Aircraft:
                            <span class="text-white">
                            {{ $flight['airplane'] }}
                        </span>

                            @if($flight['co2'])
                                <span class="mx-3">•</span>

                                CO₂:
                                <span class="text-green-400">
                                {{ round($flight['co2']/1000) }} kg
                            </span>
                            @endif

                        </div>

                    </div>

                @empty

                    <div class="bg-gray-900 rounded-3xl p-12 text-center">

                        <h2 class="text-2xl font-semibold mb-3">
                            No flights found
                        </h2>

                        <p class="text-gray-400">
                            Try different dates or airports.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </section>

@endsection
