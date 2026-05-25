@extends('layouts.app')

@section('content')

    <section class="min-h-screen bg-gray-950 text-white pt-32 pb-20">

        <div class="container mx-auto px-6">

            <!-- PAGE HEADER -->
            <div class="mb-12">

                <a
                    href="/flights"
                    class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition mb-6"
                >
                    ← Back to flights
                </a>

                <h1 class="text-5xl font-bold mb-4">
                    Flight Details
                </h1>

                <p class="text-gray-400 text-lg">
                    Review your selected flight before booking.
                </p>

            </div>

            <!-- MAIN CARD -->
            <div class="max-w-5xl mx-auto bg-gray-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl">

                <!-- TOP -->
                <div class="p-10 border-b border-gray-800">

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">

                        <div>

                            <p class="text-gray-400 mb-2">
                                Airline
                            </p>

                            <h2 class="text-4xl font-bold">
                                {{ $flight->airline }}
                            </h2>

                        </div>

                        <div class="bg-blue-600/20 text-blue-400 px-6 py-4 rounded-2xl text-2xl font-bold">
                            {{ $flight->price }} {{ $flight->currency }}
                        </div>

                    </div>

                </div>

                <!-- ROUTE -->
                <div class="p-10 border-b border-gray-800">

                    <div class="flex flex-col md:flex-row items-center justify-between gap-10">

                        <!-- FROM -->
                        <div class="text-center">

                            <p class="text-gray-400 mb-2">
                                Departure Airport
                            </p>

                            <h3 class="text-4xl font-bold">
                                {{ $flight->origin_airport }}
                            </h3>

                        </div>

                        <!-- AIRPLANE -->
                        <div class="flex-1 flex items-center">

                            <div class="h-[2px] bg-gray-700 flex-1"></div>

                            <div class="mx-6 text-blue-400 text-4xl">
                                ✈
                            </div>

                            <div class="h-[2px] bg-gray-700 flex-1"></div>

                        </div>

                        <!-- TO -->
                        <div class="text-center">

                            <p class="text-gray-400 mb-2">
                                Arrival Airport
                            </p>

                            <h3 class="text-4xl font-bold">
                                {{ $flight->destination_airport }}
                            </h3>

                        </div>

                    </div>

                </div>

                <!-- DETAILS -->
                <div class="p-10">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">

                        <!-- DEPARTURE -->
                        <div class="bg-gray-800 rounded-3xl p-6">

                            <p class="text-gray-400 mb-3">
                                Departure Time
                            </p>

                            <p class="text-2xl font-semibold">
                                {{ $flight->departure_time }}
                            </p>

                        </div>

                        <!-- ARRIVAL -->
                        <div class="bg-gray-800 rounded-3xl p-6">

                            <p class="text-gray-400 mb-3">
                                Arrival Time
                            </p>

                            <p class="text-2xl font-semibold">
                                {{ $flight->arrival_time }}
                            </p>

                        </div>

                    </div>

                    <a href="/flights/{{ $flight->id }}/book"
                       class="block w-full text-center bg-green-600 hover:bg-green-700 transition py-5 rounded-2xl text-xl font-semibold shadow-lg">
                        Reserve Flight
                    </a>

                </div>

            </div>

        </div>

    </section>

@endsection
