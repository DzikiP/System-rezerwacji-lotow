@extends('layouts.app')

@section('content')

    <section class="min-h-screen bg-gray-950 text-white pt-20 pb-20">

        <div class="container mx-auto px-6 max-w-7xl">

            <h1 class="text-4xl font-bold mb-10">
                Best Available Flights
            </h1>

            <div id="flights-container" class="space-y-6">

                <div class="mb-8 flex flex-col md:flex-row gap-4">

                    <select
                        id="filter-price-range"
                        class="bg-gray-800 p-3 rounded-xl w-full md:w-1/3"
                    >
                        <option value="">All prices</option>
                        <option value="0-300">0 - 300 PLN</option>
                        <option value="300-600">300 - 600 PLN</option>
                        <option value="600-1000">600 - 1000 PLN</option>
                        <option value="1000-1500">1000 - 2000 PLN</option>
                        <option value="1500+">2000+ PLN</option>
                    </select>

                    <label class="flex items-center gap-2 bg-gray-800 p-3 rounded-xl w-full md:w-1/3">
                        <input type="checkbox" id="filter-direct">
                        <span>Direct flights only</span>
                    </label>

                    <select
                        id="sort-by"
                        class="bg-gray-800 p-3 rounded-xl w-full md:w-1/3"
                    >
                        <option value="price_asc">Price ↑</option>
                        <option value="price_desc">Price ↓</option>
                        <option value="departure_asc">Departure ↑</option>
                        <option value="departure_desc">Departure ↓</option>
                        <option value="duration_asc">Duration ↑</option>
                        <option value="duration_desc">Duration ↓</option>
                    </select>

                </div>

                @forelse($flights as $index => $flight)

                    <div class="flight-card bg-gray-900 border border-gray-800 rounded-3xl p-6"
                         data-price="{{ $flight['price'] }}"
                         data-departure="{{ \Carbon\Carbon::parse($flight['departure_time'])->timestamp }}"
                         data-duration="{{ $flight['duration'] }}"
                         data-stops="{{ $flight['stops'] }}">

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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const priceSelect = document.getElementById('filter-price-range');
            const sortSelect = document.getElementById('sort-by');
            const directOnly = document.getElementById('filter-direct');
            const container = document.getElementById('flights-container');

            function getCards() {
                return Array.from(document.querySelectorAll('.flight-card'));
            }

            function applyFilter(card) {

                const price = parseFloat(card.dataset.price);
                const stops = parseInt(card.dataset.stops);

                // PRICE RANGE
                const range = priceSelect.value;

                if (range) {

                    if (range.endsWith('+')) {
                        const min = parseInt(range);
                        if (price < min) return false;
                    }

                    else if (range.includes('-')) {
                        const [min, max] = range.split('-').map(Number);
                        if (price < min || price > max) return false;
                    }
                }

                // DIRECT ONLY
                if (directOnly.checked && stops > 0) {
                    return false;
                }

                return true;
            }

            function sortCards(cards) {

                const sortBy = sortSelect.value;

                return cards.sort((a, b) => {

                    const priceA = parseFloat(a.dataset.price);
                    const priceB = parseFloat(b.dataset.price);

                    const depA = parseInt(a.dataset.departure);
                    const depB = parseInt(b.dataset.departure);

                    const durA = parseInt(a.dataset.duration);
                    const durB = parseInt(b.dataset.duration);

                    switch (sortBy) {

                        case 'price_asc':
                            return priceA - priceB;

                        case 'price_desc':
                            return priceB - priceA;

                        case 'departure_asc':
                            return depA - depB;

                        case 'departure_desc':
                            return depB - depA;

                        case 'duration_asc':
                            return durA - durB;

                        case 'duration_desc':
                            return durB - durA;

                        default:
                            return 0;
                    }
                });
            }

            function render() {

                const cards = getCards();

                // FILTER
                cards.forEach(card => {
                    card.style.display = applyFilter(card) ? '' : 'none';
                });

                // SORT visible only
                const visibleCards = cards.filter(c => c.style.display !== 'none');
                const sorted = sortCards(visibleCards);

                // re-append sorted cards
                sorted.forEach(card => container.appendChild(card));
            }

            // EVENTS
            priceSelect.addEventListener('change', render);
            sortSelect.addEventListener('change', render);
            directOnly.addEventListener('change', render);

            // INIT
            render();
        });
    </script>
@endsection
