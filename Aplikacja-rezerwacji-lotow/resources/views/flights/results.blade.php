@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto p-6 text-white">

        <h2 class="text-2xl font-bold mb-6">
            Flight results
        </h2>

        <div class="grid gap-4">

            @foreach($flights as $flight)

                <div class="bg-gray-900 p-5 rounded-xl flex justify-between">

                    <div>
                        <div class="font-bold text-lg">
                            {{ $flight['from'] }} → {{ $flight['to'] }}
                        </div>

                        <div class="text-gray-400 text-sm">
                            {{ $flight['departure_time'] }} → {{ $flight['arrival_time'] }}
                        </div>

                        <div class="text-gray-500 text-sm">
                            {{ $flight['stops'] }} stops • {{ $flight['duration'] }} min
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="text-2xl text-green-400 font-bold">
                            ${{ $flight['price'] }}
                        </div>

                        <form method="POST" action="{{ route('bookings.store') }}">
                            @csrf

                            <input type="hidden" name="flight" value='@json($flight["raw"])'>

                            <button class="mt-2 bg-blue-600 px-4 py-2 rounded">
                                Book
                            </button>
                        </form>
                    </div>

                </div>

            @endforeach

        </div>

    </div>

@endsection
