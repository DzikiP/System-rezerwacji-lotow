@extends('layouts.app')

@section('content')
    <section class="min-h-screen bg-gray-950 text-white pt-32 pb-20">

        <div class="container mx-auto max-w-6xl px-6">

            {{-- HERO --}}
            <div class="text-center mb-16">
                <h1 class="text-5xl font-bold mb-4">
                    About This Project
                </h1>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    A modern flight booking system built in Laravel.
                    Designed to simulate real-world airline reservation flows with clean UX and scalable backend.
                </p>

                <div class="mt-6 flex justify-center gap-4">
                    <a href="{{ url('/') }}"
                       class="px-6 py-3 bg-blue-600 hover:bg-blue-500 rounded-lg font-medium transition">
                        Explore Flights
                    </a>

                    <a href="https://github.com/DzikiP/System-rezerwacji-lotow"
                       class="px-6 py-3 bg-gray-800 hover:bg-gray-700 rounded-lg font-medium transition">
                        View Code
                    </a>
                </div>
            </div>

            {{-- GRID SECTION --}}
            <div class="grid md:grid-cols-3 gap-6">

                <div class="bg-gray-900/60 border border-gray-800 p-6 rounded-2xl hover:border-gray-700 transition">
                    <h2 class="text-xl font-semibold mb-3">What is this?</h2>
                    <p class="text-gray-400 leading-relaxed">
                        This application allows users to search flights, manage passengers,
                        and generate booking confirmations with PDF tickets.
                    </p>
                </div>

                <div class="bg-gray-900/60 border border-gray-800 p-6 rounded-2xl hover:border-gray-700 transition">
                    <h2 class="text-xl font-semibold mb-3">Tech Stack</h2>
                    <ul class="text-gray-400 space-y-1">
                        <li>Laravel (Backend)</li>
                        <li>Blade + Tailwind CSS</li>
                        <li>PostgreSQL</li>
                        <li>External Flight API</li>
                        <li>PDF tickets</li>
                    </ul>
                </div>

                <div class="bg-gray-900/60 border border-gray-800 p-6 rounded-2xl hover:border-gray-700 transition">
                    <h2 class="text-xl font-semibold mb-3">Key Features</h2>
                    <ul class="text-gray-400 space-y-1">
                        <li>Flight search engine</li>
                        <li>Dynamic passenger forms</li>
                        <li>Booking system</li>
                        <li>PDF ticket generation</li>
                        <li>Session-based flow</li>
                    </ul>
                </div>

            </div>

            {{-- BOTTOM SECTION --}}
            <div class="mt-16 bg-gradient-to-r from-blue-900/30 to-purple-900/20 border border-gray-800 rounded-2xl p-10 text-center">
                <h3 class="text-2xl font-semibold mb-3">
                    Built as a Academic Laravel project
                </h3>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Focused on real-world architecture: clean controllers, service separation,
                    external API integration and scalable booking logic.
                </p>
            </div>

        </div>
    </section>
@endsection
