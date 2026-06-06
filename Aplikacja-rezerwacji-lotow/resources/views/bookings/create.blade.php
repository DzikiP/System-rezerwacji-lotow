@extends('layouts.app')

@section('content')

    <section class="min-h-screen bg-gray-950 text-white pt-32 pb-20">

        <div class="container mx-auto px-6 max-w-4xl">

            <!-- FLIGHT INFO -->
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8 mb-10">

                <h1 class="text-4xl font-bold mb-6">Confirm Booking</h1>

                @php
                    $segment = $flight['flights'][0] ?? null;
                @endphp

                @if($segment)

                    <div class="grid grid-cols-2 gap-6 text-gray-300">

                        <div>
                            <p class="text-gray-400">Airline</p>
                            <p class="text-xl font-semibold">
                                {{ $segment['airline'] ?? 'Unknown' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400">Route</p>
                            <p class="text-xl font-semibold">
                                {{ $segment['departure_airport']['id'] ?? '' }}
                                →
                                {{ $segment['arrival_airport']['id'] ?? '' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400">Departure</p>
                            <p class="text-xl font-semibold">
                                {{ \Carbon\Carbon::parse($segment['departure_airport']['time'] ?? now())->format('d M Y H:i') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-400">Price per passenger</p>
                            <p class="text-xl font-semibold">
                                {{ number_format($flight['price'] ?? 0) }} PLN
                            </p>
                        </div>

                    </div>

                @else
                    <p class="text-gray-400">Flight data not available</p>
                @endif

            </div>

            <!-- FORM -->
            <form method="POST" action="{{ route('bookings.store') }}" class="space-y-8">

                @csrf

                <!-- ważne: index zamiast flight_id -->
                <input type="hidden" name="flight_index" value="{{ $index }}">

                <!-- PASSENGERS -->
                <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8">

                    <div class="flex justify-between items-center mb-6">

                        <h2 class="text-2xl font-bold">Passengers</h2>

                        <button type="button"
                                onclick="addPassenger()"
                                class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl">
                            + Add passenger
                        </button>

                    </div>

                    <div id="passengers" class="space-y-6"></div>

                </div>

                <!-- SUBMIT -->
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 py-4 rounded-2xl text-xl font-semibold">
                    Confirm Booking
                </button>

            </form>

        </div>

    </section>

@endsection

@section('scripts')

    <script>
        let i = 0;

        function addPassenger() {

            const container = document.getElementById('passengers');

            const div = document.createElement('div');
            div.className = "bg-gray-800 p-6 rounded-2xl space-y-3";

            div.innerHTML = `
            <div class="flex justify-between items-center">
                <h3 class="font-bold">Passenger</h3>

                <button type="button"
                        class="text-red-400"
                        onclick="removePassenger(this)">
                    Remove
                </button>
            </div>

            <input name="passengers[${i}][first_name]" placeholder="First name"
                   class="w-full p-3 bg-gray-900 rounded-xl">

            <input name="passengers[${i}][last_name]" placeholder="Last name"
                   class="w-full p-3 bg-gray-900 rounded-xl">

            <input type="date" name="passengers[${i}][birth_date]"
                   class="w-full p-3 bg-gray-900 rounded-xl">

            <input name="passengers[${i}][nationality]" placeholder="Nationality"
                   class="w-full p-3 bg-gray-900 rounded-xl">

            <input name="passengers[${i}][document_number]" placeholder="Document number"
                   class="w-full p-3 bg-gray-900 rounded-xl">

            <select name="passengers[${i}][passenger_type]"
                    class="w-full p-3 bg-gray-900 rounded-xl">

                <option value="adult">Adult</option>
                <option value="child">Child</option>
                <option value="infant">Infant</option>

            </select>
        `;

            container.appendChild(div);
            i++;
        }

        function removePassenger(btn) {
            const container = document.getElementById('passengers');

            if (container.children.length === 1) {
                alert("At least one passenger is required");
                return;
            }

            btn.closest('.bg-gray-800').remove();
        }

        document.addEventListener('DOMContentLoaded', () => {
            addPassenger();
        });
    </script>

@endsection
