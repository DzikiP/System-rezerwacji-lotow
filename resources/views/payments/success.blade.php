@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-950 text-white">

        <div class="text-center">

            <h1 class="text-4xl font-bold text-green-400">
                Payment successful 🎉
            </h1>

            <p class="mt-3 text-gray-400">
                Redirecting to your booking...
            </p>

            <script>
                setTimeout(function () {
                    window.location.href = "{{ route('bookings.show', $booking) }}";
                }, 3000);
            </script>

        </div>

    </div>
@endsection
