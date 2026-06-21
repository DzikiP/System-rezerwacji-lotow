@extends('layouts.app')

@section('content')

    <section class="min-h-screen bg-gray-950 text-white pt-32 pb-20">

        <div class="container mx-auto px-6 max-w-5xl">

            <!-- HEADER -->
            <div class="mb-10">
                <h1 class="text-4xl font-bold">Confirm Booking</h1>
                <p class="text-gray-400 mt-2">Review flight details and add passengers</p>
            </div>

            <!-- FLIGHT SUMMARY -->
            <div class="bg-gray-900 border border-gray-800 rounded-3xl p-8 mb-10">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-8">

                    <div>
                        <p class="text-gray-400 text-sm">Airline</p>
                        <p class="text-xl font-semibold">{{ $flight['airline'] ?? 'Unknown' }}</p>

                        <p class="text-gray-500 text-sm mt-2">
                            Flight {{ $flight['flight_number'] ?? '-' }}
                        </p>
                    </div>

                    <div class="text-center">
                        <div class="text-2xl font-bold tracking-wide">
                            {{ $flight['from'] ?? '---' }}
                            <span class="text-gray-500">→</span>
                            {{ $flight['to'] ?? '---' }}
                        </div>

                        <div class="text-gray-400 text-sm mt-2">
                            {{ \Carbon\Carbon::parse($flight['departure_time'] ?? now())->format('d M Y • H:i') }}
                        </div>
                    </div>

                    <div class="text-right">
                        <p class="text-gray-400 text-sm">Price per passenger</p>
                        <p class="text-3xl font-bold text-blue-400">
                            {{ number_format($flight['price'] ?? 0) }} PLN
                        </p>
                    </div>

                </div>

            </div>


            <!-- FORM -->
            <form method="POST" action="{{ route('bookings.store') }}" class="space-y-8">
                @csrf

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

                    <div id="passengers" class="space-y-6">

                        @php
                            $firstId = 'INIT-' . uniqid();
                            $errorsBag = $errors->getMessages();
                        @endphp

                        <div class="bg-gray-800 p-6 rounded-2xl space-y-4">

                            <input type="hidden" name="passengers[{{ $firstId }}][id]" value="{{ $firstId }}">

                            <div class="flex justify-between items-center">
                                <h3 class="font-bold">Passenger</h3>
                            </div>

                            <input name="passengers[{{ $firstId }}][first_name]"
                                   placeholder="First name"
                                   class="w-full p-3 bg-gray-900 rounded-xl">

                            @foreach ($errorsBag as $key => $messages)
                                @if (str_ends_with($key, 'first_name'))
                                    <p class="text-red-400 text-sm mt-1">{{ $messages[0] }}</p>
                                    @break
                                @endif
                            @endforeach

                            <input name="passengers[{{ $firstId }}][last_name]"
                                   placeholder="Last name"
                                   class="w-full p-3 bg-gray-900 rounded-xl">

                            @foreach ($errorsBag as $key => $messages)
                                @if (str_ends_with($key, 'last_name'))
                                    <p class="text-red-400 text-sm mt-1">{{ $messages[0] }}</p>
                                    @break
                                @endif
                            @endforeach

                            <input type="date"
                                   name="passengers[{{ $firstId }}][birth_date]"
                                   class="w-full p-3 bg-gray-900 rounded-xl">

                            @foreach ($errorsBag as $key => $messages)
                                @if (str_ends_with($key, 'birth_date'))
                                    <p class="text-red-400 text-sm mt-1">{{ $messages[0] }}</p>
                                    @break
                                @endif
                            @endforeach

                            <input name="passengers[{{ $firstId }}][nationality]"
                                   placeholder="Nationality"
                                   class="w-full p-3 bg-gray-900 rounded-xl">

                            @foreach ($errorsBag as $key => $messages)
                                @if (str_ends_with($key, 'nationality'))
                                    <p class="text-red-400 text-sm mt-1">{{ $messages[0] }}</p>
                                    @break
                                @endif
                            @endforeach

                            <input name="passengers[{{ $firstId }}][document_number]"
                                   placeholder="Document number"
                                   class="w-full p-3 bg-gray-900 rounded-xl">

                            @foreach ($errorsBag as $key => $messages)
                                @if (str_ends_with($key, 'document_number'))
                                    <p class="text-red-400 text-sm mt-1">{{ $messages[0] }}</p>
                                    @break
                                @endif
                            @endforeach

                            <select name="passengers[{{ $firstId }}][passenger_type]"
                                    class="w-full p-3 bg-gray-900 rounded-xl">

                                <option value="adult">Adult</option>
                                <option value="child">Child</option>
                                <option value="infant">Infant</option>

                            </select>

                        </div>

                    </div>

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
        function addPassenger() {

            const container = document.getElementById('passengers');
            const id = crypto.randomUUID();

            const div = document.createElement('div');
            div.className = "bg-gray-800 p-6 rounded-2xl space-y-4";

            div.innerHTML = `
        <div class="flex justify-between items-center">
            <h3 class="font-bold">Passenger</h3>

            <button type="button"
                    class="text-red-400"
                    onclick="removePassenger(this)">
                Remove
            </button>
        </div>

        <input name="passengers[${id}][first_name]"
               placeholder="First name"
               class="w-full p-3 bg-gray-900 rounded-xl">

        <input name="passengers[${id}][last_name]"
               placeholder="Last name"
               class="w-full p-3 bg-gray-900 rounded-xl">

        <input type="date"
               name="passengers[${id}][birth_date]"
               class="w-full p-3 bg-gray-900 rounded-xl">

        <input name="passengers[${id}][nationality]"
               placeholder="Nationality"
               class="w-full p-3 bg-gray-900 rounded-xl">

        <input name="passengers[${id}][document_number]"
               placeholder="Document number"
               class="w-full p-3 bg-gray-900 rounded-xl">

        <select name="passengers[${id}][passenger_type]"
                class="w-full p-3 bg-gray-900 rounded-xl">

            <option value="adult">Adult</option>
            <option value="child">Child</option>
            <option value="infant">Infant</option>

        </select>
    `;

            container.appendChild(div);
        }

        function removePassenger(btn) {
            const container = document.getElementById('passengers');
            btn.closest('.bg-gray-800').remove();

            if (container.children.length === 0) {
                location.reload();
            }
        }
    </script>

@endsection
