@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-20 bg-gray-900 text-white p-6 rounded">

        <h1 class="text-2xl font-bold mb-4">Checkout</h1>

        <div class="space-y-2 mb-6">
            <p><strong>Booking:</strong> {{ $booking->booking_reference }}</p>
            <p><strong>Status:</strong> {{ $booking->status->value ?? $booking->status }}</p>

            <p><strong>Passengers:</strong> {{ $booking->passengers_count }}</p>

            <p><strong>Total:</strong> {{ $payment->amount }} {{ $payment->currency }}</p>
            <p><strong>Payment status:</strong> {{ $payment->status }}</p>
            <p><strong>Method:</strong> {{ $payment->method }}</p>
        </div>

        <form method="POST" action="{{ route('pay', $booking) }}">
            @csrf

            <button class="bg-green-600 px-4 py-2 rounded w-full">
                Zapłać (mock)
            </button>
        </form>

    </div>
@endsection
