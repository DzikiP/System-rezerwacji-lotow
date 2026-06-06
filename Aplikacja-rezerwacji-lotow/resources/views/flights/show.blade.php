@extends('layouts.app')

@section('content')

    <section class="min-h-screen bg-gray-950 text-white pt-32 pb-20">

        <div class="container mx-auto max-w-3xl px-6">

            <h1 class="text-3xl font-bold mb-8">Flight details</h1>

            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6">

                <div class="text-xl font-semibold mb-4">
                    {{ $flight['airline'] }}
                </div>

                <div class="text-gray-400 mb-6">
                    {{ $flight['from'] }} → {{ $flight['to'] }}
                </div>

                <div class="text-2xl font-bold text-blue-400 mb-6">
                    {{ number_format($flight['price']) }} PLN
                </div>

                <a href="{{ route('bookings.create', ['index' => $index]) }}">
                    Book flight
                </a>

            </div>

        </div>

    </section>

@endsection
