@extends('layouts.app')

@section('content')

    <div class="max-w-3xl mx-auto mt-20 text-white">

        <h1 class="text-3xl font-bold mb-6">Search flights</h1>

        <form method="GET" action="{{ route('flights.search') }}"
              class="bg-gray-900 p-6 rounded-xl space-y-4">

            <div>
                <label class="text-sm text-gray-400">From</label>
                <input type="text" name="from"
                       class="w-full bg-gray-800 p-2 rounded"
                       placeholder="CDG">
            </div>

            <div>
                <label class="text-sm text-gray-400">To</label>
                <input type="text" name="to"
                       class="w-full bg-gray-800 p-2 rounded"
                       placeholder="AUS">
            </div>

            <div>
                <label class="text-sm text-gray-400">Date</label>
                <input type="date" name="date"
                       class="w-full bg-gray-800 p-2 rounded">
            </div>

            <button class="w-full bg-blue-600 py-2 rounded">
                Search flights
            </button>

        </form>

    </div>

@endsection
