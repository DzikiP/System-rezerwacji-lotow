@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-[80vh]">

        <div class="w-full max-w-md bg-gray-900 p-8 rounded-2xl border border-gray-800">

            <h1 class="text-2xl font-bold mb-6 text-center">
                Logowanie
            </h1>

            {{-- błędy --}}
            @if ($errors->any())
                <div class="mb-4 text-red-400 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm text-gray-300">Email</label>
                    <input type="email" name="email"
                           class="w-full mt-1 p-3 rounded-lg bg-gray-800 border border-gray-700 focus:border-blue-500 outline-none"
                           required>
                </div>

                <div>
                    <label class="text-sm text-gray-300">Hasło</label>
                    <input type="password" name="password"
                           class="w-full mt-1 p-3 rounded-lg bg-gray-800 border border-gray-700 focus:border-blue-500 outline-none"
                           required>
                </div>

                <button class="w-full bg-blue-600 hover:bg-blue-700 transition p-3 rounded-lg font-semibold">
                    Zaloguj się
                </button>
            </form>

            <p class="text-sm text-gray-400 mt-4 text-center">
                Nie masz konta?
                <a href="{{ route('register') }}" class="text-blue-400 hover:underline">
                    Zarejestruj się
                </a>
            </p>

        </div>

    </div>
@endsection
