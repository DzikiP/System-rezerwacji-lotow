@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-10">

        <!-- HEADER -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold">
                Witaj, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-gray-400 mt-1">
                Zarządzaj swoimi rezerwacjami i lotami
            </p>
        </div>

        <!-- QUICK STATS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl">
                <p class="text-gray-400 text-sm">Moje rezerwacje</p>
                <p class="text-2xl font-bold mt-2">
                    {{ auth()->user()->bookings()->count() }}
                </p>
            </div>

            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl">
                <p class="text-gray-400 text-sm">Status konta</p>
                <p class="text-2xl font-bold mt-2 text-green-400">
                    Aktywne
                </p>
            </div>

            <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl">
                <p class="text-gray-400 text-sm">Następny krok</p>
                <a href="{{ url('/') }}"
                   class="text-blue-400 hover:underline font-medium mt-2 inline-block">
                    Zarezerwuj lot →
                </a>
            </div>

        </div>

        <!-- RECENT BOOKINGS -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold">
                    Ostatnie rezerwacje
                </h2>

                <a href="{{ url('/') }}"
                   class="text-blue-400 hover:underline">
                    Wyszukaj loty
                </a>
            </div>

            @php
                $bookings = auth()->user()
                    ->bookings()
                    ->latest()
                    ->take(5)
                    ->get();
            @endphp

            @if($bookings->count() > 0)

                <div class="space-y-4">

                    @foreach($bookings as $booking)
                        <div class="flex items-center justify-between bg-gray-800 p-4 rounded-xl">

                            <div>
                                <p class="font-medium">
                                    <a href="{{ route('bookings.show', $booking) }}"
                                       class="text-blue-400 hover:underline">
                                        {{ $booking->booking_reference }}
                                    </a>
                                </p>

                                <p class="text-sm text-gray-400">
                                    {{ $booking->created_at->format('Y-m-d H:i') }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-sm text-gray-400">Status</p>
                                <span class="{{ $booking->status->color() }}">
                                {{ $booking->status->label() }}
                                </span>
                            </div>

                        </div>
                    @endforeach

                </div>

            @else
                <p class="text-gray-400">
                    Brak rezerwacji. Zarezerwuj swój pierwszy lot ✈️
                </p>
            @endif

        </div>

    </div>
@endsection
