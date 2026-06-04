@extends('layouts.app')

@section('content')

    <!-- HERO -->
    <section class="relative min-h-screen bg-gray-950 text-white overflow-hidden">

        <!-- Background -->
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=2074&auto=format&fit=crop"
                class="w-full h-full object-cover opacity-30"
                alt="Airplane"
            >
            <div class="absolute inset-0 bg-black/60"></div>
        </div>

        <!-- CONTENT -->
        <div class="relative z-10 container mx-auto px-6 py-24">

            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                    Discover The World With Comfort
                </h1>

                <p class="text-lg text-gray-300 mb-10">
                    Find the best flights, compare prices and book your next journey in minutes.
                </p>
            </div>

            <!-- SEARCH -->
            <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl p-6 max-w-6xl mx-auto shadow-2xl">

                <form method="GET"
                      action="{{ route('flights.search') }}"
                      class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">

                    <!-- FROM -->
                    <div class="relative md:col-span-1">

                        <label class="text-sm text-gray-300 mb-2 block">
                            From
                        </label>

                        <input
                            name="from"
                            id="fromInput"
                            autocomplete="off"
                            placeholder="City, country or airport"
                            class="w-full bg-gray-900/80 text-white p-3 rounded-xl border border-gray-700
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >

                        <div
                            id="fromResults"
                            class="absolute top-full left-0 w-full bg-gray-900 border border-gray-700 rounded-xl mt-1
                       hidden z-50 overflow-y-auto max-h-80 shadow-2xl">
                        </div>

                    </div>

                    <!-- TO -->
                    <div class="relative md:col-span-1">

                        <label class="text-sm text-gray-300 mb-2 block">
                            To
                        </label>

                        <input
                            name="to"
                            id="toInput"
                            autocomplete="off"
                            placeholder="City, country or airport"
                            class="w-full bg-gray-900/80 text-white p-3 rounded-xl border border-gray-700
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >

                        <div
                            id="toResults"
                            class="absolute top-full left-0 w-full bg-gray-900 border border-gray-700 rounded-xl mt-1
                       hidden z-50 overflow-y-auto max-h-80 shadow-2xl">
                        </div>

                    </div>

                    <!-- TRIP TYPE -->
                    <div>

                        <label class="text-sm text-gray-300 mb-2 block">
                            Trip
                        </label>

                        <select
                            name="trip_type"
                            id="tripType"
                            class="w-full bg-gray-900/80 text-white p-3 rounded-xl border border-gray-700
                       focus:outline-none focus:ring-2 focus:ring-blue-500">

                            <option value="one_way">
                                One way
                            </option>

                            <option value="round_trip">
                                Round trip
                            </option>

                        </select>

                    </div>

                    <!-- DEPARTURE -->
                    <div>

                        <label class="text-sm text-gray-300 mb-2 block">
                            Departure
                        </label>

                        <input
                            name="departure_date"
                            type="date"
                            class="w-full bg-gray-900/80 text-white p-3 rounded-xl border border-gray-700
                       focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >

                    </div>

                    <!-- RETURN -->
                    <div>

                        <label class="text-sm text-gray-300 mb-2 block">
                            Return
                        </label>

                        <input
                            name="return_date"
                            id="returnDate"
                            type="date"
                            disabled
                            class="w-full bg-gray-900/80 text-white p-3 rounded-xl border border-gray-700
                       focus:outline-none focus:ring-2 focus:ring-blue-500 opacity-50"
                        >

                    </div>

                    <!-- BUTTON -->
                    <div>

                        <button
                            type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 transition text-white font-semibold
                       p-3 rounded-xl shadow-lg">

                            Search

                        </button>

                    </div>

                </form>

            </div>
        </div>
    </section>

    <!-- DESTINATIONS -->
    <section class="bg-gray-900 text-white py-24">
        <div class="container mx-auto px-6">

            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">Popular Destinations</h2>
                <p class="text-gray-400">Explore trending places around the world</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                @foreach([
                    ['Paris','299 PLN','https://images.unsplash.com/photo-1502602898657-3e91760cbb34'],
                    ['Tokyo','899 PLN','https://images.unsplash.com/photo-1540959733332-eab4deabeeaf'],
                    ['Dubai','699 PLN','https://images.unsplash.com/photo-1512453979798-5ea266f8880c']
                ] as [$city,$price,$img])

                    <div class="bg-gray-800 rounded-3xl overflow-hidden group hover:scale-105 transition">
                        <img src="{{ $img }}?q=80&w=2070&auto=format&fit=crop"
                             class="h-64 w-full object-cover group-hover:opacity-80 transition">

                        <div class="p-6 flex justify-between">
                            <h3 class="text-2xl font-semibold">{{ $city }}</h3>
                            <span class="text-blue-400 font-bold">from {{ $price }}</span>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="bg-gray-950 text-white py-24">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8">
                <div class="text-4xl mb-4">✈️</div>
                <h3 class="text-2xl font-semibold mb-3">Fast Booking</h3>
                <p class="text-gray-400">Book flights in less than 2 minutes.</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8">
                <div class="text-4xl mb-4">💳</div>
                <h3 class="text-2xl font-semibold mb-3">Secure Payments</h3>
                <p class="text-gray-400">Safe and encrypted transactions.</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8">
                <div class="text-4xl mb-4">🌍</div>
                <h3 class="text-2xl font-semibold mb-3">Worldwide Flights</h3>
                <p class="text-gray-400">Access global destinations.</p>
            </div>

        </div>
    </section>

@endsection


@section('scripts')
    <script>

        /*
        |--------------------------------------------------------------------------
        | TRIP TYPE
        |--------------------------------------------------------------------------
        */

        const tripType = document.getElementById('tripType');
        const returnDate = document.getElementById('returnDate');

        function toggleReturn() {

            if (tripType.value === 'round_trip') {

                returnDate.disabled = false;
                returnDate.classList.remove('opacity-50');

            } else {

                returnDate.disabled = true;
                returnDate.value = '';
                returnDate.classList.add('opacity-50');
            }
        }

        tripType.addEventListener('change', toggleReturn);
        toggleReturn();


        /*
        |--------------------------------------------------------------------------
        | AIRPORT AUTOCOMPLETE
        |--------------------------------------------------------------------------
        */

        async function setupAutocomplete(inputId, boxId) {

            const input = document.getElementById(inputId);
            const box = document.getElementById(boxId);

            let timeout;

            input.addEventListener('input', () => {

                clearTimeout(timeout);

                const q = input.value.trim();

                if (q.length < 2) {

                    box.classList.add('hidden');
                    return;
                }

                timeout = setTimeout(async () => {

                    try {

                        const response = await fetch(
                            `/api/airports/search?q=${encodeURIComponent(q)}`
                        );

                        const data = await response.json();

                        box.innerHTML = '';

                        if (!data.length) {

                            box.innerHTML = `
                            <div class="p-3 text-gray-400 text-sm">
                                No airports found
                            </div>
                        `;

                            box.classList.remove('hidden');
                            return;
                        }

                        data.forEach(airport => {

                            const item = document.createElement('div');

                            item.className =
                                'p-3 border-b border-gray-800 hover:bg-gray-800 cursor-pointer transition';

                            item.innerHTML = `
                            <div class="font-medium text-white">
                                ✈ ${airport.city ?? 'Unknown city'}
                            </div>

                            <div class="text-xs text-gray-400">
                                ${airport.country ?? ''} • ${airport.iata}
                            </div>

                            <div class="text-xs text-gray-500 mt-1">
                                ${airport.label}
                            </div>
                        `;

                            item.addEventListener('click', () => {

                                input.value = airport.iata;

                                box.classList.add('hidden');
                            });

                            box.appendChild(item);
                        });

                        box.classList.remove('hidden');

                    } catch (e) {

                        console.error(e);
                    }

                }, 300);
            });

            document.addEventListener('click', (e) => {

                if (
                    !input.contains(e.target) &&
                    !box.contains(e.target)
                ) {
                    box.classList.add('hidden');
                }
            });
        }

        setupAutocomplete('fromInput', 'fromResults');
        setupAutocomplete('toInput', 'toResults');

    </script>
@endsection
