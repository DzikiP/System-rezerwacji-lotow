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

        <!-- Content -->
        <div class="relative z-10 container mx-auto px-6 py-24">

            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6">
                    Discover The World With Comfort
                </h1>

                <p class="text-lg text-gray-300 mb-10">
                    Find the best flights, compare prices and book your next journey in minutes.
                </p>
            </div>

            {{-- SEARCH FORM --}}
            <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl p-6 max-w-6xl mx-auto shadow-2xl">

                <form method="GET"
                      action="{{ route('flights.search') }}"
                      class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">

                    <!-- FROM -->
                    <div class="md:col-span-1">
                        <label class="text-sm text-gray-300 mb-2 block">From</label>
                        <input name="from"
                               type="text"
                               placeholder="CDG"
                               class="w-full bg-gray-900/80 text-white p-3 rounded-xl border border-gray-700
                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- TO -->
                    <div class="md:col-span-1">
                        <label class="text-sm text-gray-300 mb-2 block">To</label>
                        <input name="to"
                               type="text"
                               placeholder="WAW"
                               class="w-full bg-gray-900/80 text-white p-3 rounded-xl border border-gray-700
                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- TRIP TYPE -->
                    <div class="md:col-span-1">
                        <label class="text-sm text-gray-300 mb-2 block">Trip</label>
                        <select name="trip_type"
                                id="tripType"
                                class="w-full bg-gray-900/80 text-white p-3 rounded-xl border border-gray-700
                           focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="one_way">One way</option>
                            <option value="round_trip">Round trip</option>
                        </select>
                    </div>

                    <!-- DEPARTURE -->
                    <div class="md:col-span-1">
                        <label class="text-sm text-gray-300 mb-2 block">Departure</label>
                        <input name="departure_date"
                               type="date"
                               class="w-full bg-gray-900/80 text-white p-3 rounded-xl border border-gray-700
                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- RETURN -->
                    <div class="md:col-span-1">
                        <label class="text-sm text-gray-300 mb-2 block">Return</label>
                        <input name="return_date"
                               id="returnDate"
                               type="date"
                               class="w-full bg-gray-900/80 text-white p-3 rounded-xl border border-gray-700
                          focus:outline-none focus:ring-2 focus:ring-blue-500 opacity-50"
                               disabled>
                    </div>

                    <!-- BUTTON -->
                    <div class="md:col-span-1">
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 transition text-white font-semibold
                           p-3 rounded-xl shadow-lg">
                            Search
                        </button>
                    </div>

                </form>
            </div>



        </div>
    </section>

    <!-- POPULAR DESTINATIONS -->
    <section class="bg-gray-900 text-white py-24">
        <div class="container mx-auto px-6">

            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">
                    Popular Destinations
                </h2>

                <p class="text-gray-400">
                    Explore trending places around the world
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Card -->
                <div class="bg-gray-800 rounded-3xl overflow-hidden group hover:scale-105 transition duration-300">

                    <img
                        src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=2073&auto=format&fit=crop"
                        class="h-64 w-full object-cover group-hover:opacity-80 transition"
                        alt="Paris"
                    >

                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-semibold">Paris</h3>
                            <span class="text-blue-400 font-bold">from 299 PLN</span>
                        </div>
                    </div>
                </div>

                <!-- Card -->
                <div class="bg-gray-800 rounded-3xl overflow-hidden group hover:scale-105 transition duration-300">

                    <img
                        src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?q=80&w=2070&auto=format&fit=crop"
                        class="h-64 w-full object-cover group-hover:opacity-80 transition"
                        alt="Tokyo"
                    >

                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-semibold">Tokyo</h3>
                            <span class="text-blue-400 font-bold">from 899 PLN</span>
                        </div>
                    </div>
                </div>

                <!-- Card -->
                <div class="bg-gray-800 rounded-3xl overflow-hidden group hover:scale-105 transition duration-300">

                    <img
                        src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=2070&auto=format&fit=crop"
                        class="h-64 w-full object-cover group-hover:opacity-80 transition"
                        alt="Dubai"
                    >

                    <div class="p-6">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-semibold">Dubai</h3>
                            <span class="text-blue-400 font-bold">from 699 PLN</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- FEATURES -->
    <section class="bg-gray-950 text-white py-24">

        <div class="container mx-auto px-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8">
                    <div class="text-4xl mb-4">✈️</div>
                    <h3 class="text-2xl font-semibold mb-3">Fast Booking</h3>
                    <p class="text-gray-400">
                        Book flights in less than 2 minutes with our streamlined process.
                    </p>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8">
                    <div class="text-4xl mb-4">💳</div>
                    <h3 class="text-2xl font-semibold mb-3">Secure Payments</h3>
                    <p class="text-gray-400">
                        Your transactions are protected with industry-leading security.
                    </p>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8">
                    <div class="text-4xl mb-4">🌍</div>
                    <h3 class="text-2xl font-semibold mb-3">Worldwide Flights</h3>
                    <p class="text-gray-400">
                        Access destinations from all around the globe.
                    </p>
                </div>

            </div>

        </div>

    </section>

@endsection

@section('scripts')
    <!-- JS: toggle return date -->
    <script>
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
    </script>
@endsection
