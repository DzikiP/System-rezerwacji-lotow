@extends('layouts.app')

@section('content')

    <section class="min-h-screen bg-gray-950 text-white pt-32 pb-20">

        <div class="container mx-auto px-6 max-w-4xl">

            <!-- HEADER -->
            <div class="flex justify-between items-start mb-10">

                <div>
                    <h1 class="text-4xl font-bold mb-2">
                        Booking Confirmed
                    </h1>

                    <p class="text-gray-400">
                        Reference:
                        <span class="text-white font-semibold">
                        {{ $booking->booking_reference }}
                    </span>
                    </p>
                </div>

                <!-- STATUS -->
                <div class="text-right">
                    <p class="text-gray-400">Status</p>

                    <span class="inline-block px-4 py-2 rounded-xl text-sm font-semibold {{ $booking->status->color() }}">
                    {{ $booking->status->label() }}
                </span>
                </div>

            </div>

            <!-- FLIGHT INFO -->
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8 mb-8">

                <h2 class="text-2xl font-bold mb-6">Flight details</h2>

                <div class="grid grid-cols-2 gap-6 text-gray-300">

                    <div>
                        <p class="text-gray-400">Airline</p>
                        <p class="text-xl font-semibold">
                            {{ $booking->flight?->airline }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Route</p>
                        <p class="text-xl font-semibold">
                            {{ $booking->flight?->origin_airport }}
                            →
                            {{ $booking->flight?->destination_airport }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Departure</p>
                        <p class="text-xl font-semibold">
                            {{ \Carbon\Carbon::parse($booking->flight?->departure_time)->format('Y-m-d H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-400">Arrival</p>
                        <p class="text-xl font-semibold">
                            {{ \Carbon\Carbon::parse($booking->flight?->arrival_time)->format('Y-m-d H:i') }}
                        </p>
                    </div>

                </div>

            </div>

            <!-- PASSENGERS -->
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8 mb-8">

                <h2 class="text-2xl font-bold mb-6">Passengers</h2>

                <div class="space-y-4">

                    @forelse($booking->passengers as $passenger)
                        <div class="bg-gray-800 p-5 rounded-2xl flex justify-between items-center">

                            <div>
                                <p class="font-semibold text-lg">
                                    {{ $passenger->first_name }} {{ $passenger->last_name }}
                                </p>

                                <p class="text-gray-400 text-sm">
                                    {{ $passenger->passenger_type }}
                                    • {{ $passenger->nationality }}
                                </p>
                            </div>

                            <div class="text-right text-sm text-gray-400">
                                <p>Document:</p>
                                <p class="text-white">{{ $passenger->document_number }}</p>
                            </div>

                        </div>
                    @empty
                        <p class="text-gray-400">No passengers found</p>
                    @endforelse

                </div>

            </div>

            <!-- SUMMARY -->
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8">

                <div class="flex justify-between items-center">

                    <div>
                        <p class="text-gray-400">Total price</p>
                        <p class="text-3xl font-bold">
                            {{ number_format($booking->total_price, 2) }}
                            {{ $booking->currency }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-gray-400">Passengers</p>
                        <p class="text-xl font-semibold">
                            {{ $booking->passengers_count }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
