@extends('layouts.app')

@section('content')

    <div class="max-w-2xl mx-auto mt-10 text-white pt-20">

        <h1 class="text-2xl font-bold mb-6">Search flights</h1>

        <form method="POST" action="{{ route('flights.search') }}" class="space-y-4">
            @csrf

            <input class="w-full p-2 text-black" name="from" placeholder="From (WAW)" />
            <input class="w-full p-2 text-black" name="to" placeholder="To (LHR)" />
            <input class="w-full p-2 text-black" type="date" name="date" />

            <button class="bg-blue-600 px-4 py-2 rounded">
                Search
            </button>
        </form>

    </div>

@endsection
