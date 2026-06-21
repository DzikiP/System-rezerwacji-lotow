<header class="fixed top-0 left-0 w-full z-50 bg-black/40 backdrop-blur-lg border-b border-white/10">

    <div class="container mx-auto px-6">

        <div class="flex items-center justify-between h-20">

            <!-- LOGO -->
            <a href="{{ url('/') }}"
               class="text-2xl font-bold tracking-wide hover:text-blue-400 transition">
                ✈ SkyBook
            </a>

            <!-- NAVIGATION -->
            <nav class="hidden md:flex items-center gap-8">

                <a href="{{ url('/') }}"
                   class="{{ request()->is('/') ? 'text-white' : 'text-gray-300' }}  transition hover:text-blue-400">
                    Home
                </a>

                <a href="{{ route('about') }}" class="{{ request()->is('/') ? 'text-white' : 'text-gray-300' }}  transition hover:text-blue-400">
                    About
                </a>

            </nav>

            <!-- AUTH BUTTONS -->
            <div class="hidden md:flex items-center gap-4">

                @guest
                    <a href="{{ route('login') }}"
                       class="text-gray-300 hover:text-white transition">
                        Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="bg-blue-600 hover:bg-blue-700 transition px-5 py-2 rounded-xl font-medium shadow-lg">
                        Register
                    </a>
                @endguest

                    @auth

                        <a  href="{{ route('dashboard') }} "
                            class="text-blue-400 hover:text-blue-300 transition font-medium">
                            Dashboard
                        </a>

                        <span class="text-gray-300">
                            {{ auth()->user()->name }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="text-red-400 hover:text-red-300 transition">
                                Logout
                            </button>
                        </form>

                    @endauth

            </div>

            <!-- MOBILE BUTTON -->
            <button id="mobile-menu-button" class="md:hidden text-white">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-8 w-8"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

        </div>

    </div>

    <!-- MOBILE MENU -->
    <div id="mobile-menu"
         class="hidden md:hidden bg-gray-900 border-t border-white/10">

        <div class="px-6 py-6 flex flex-col gap-4">

            <a href="{{ url('/') }}"
               class="text-gray-300 hover:text-white transition">
                Home
            </a>

            <a href="{{ url('/flights') }}"
               class="text-gray-300 hover:text-white transition">
                Flights
            </a>

            <a href="#"
               class="text-gray-300 hover:text-white transition">
                Destinations
            </a>

            <a href="#"
               class="text-gray-300 hover:text-white transition">
                About
            </a>

            <hr class="border-gray-700">

            @guest
                <a href="{{ route('login') }}"
                   class="text-gray-300 hover:text-white transition">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="bg-blue-600 hover:bg-blue-700 transition px-5 py-3 rounded-xl font-medium text-center">
                    Register
                </a>
            @endguest

            @auth
                <a href="{{ route('dashboard') }}"
                   class="text-gray-300 hover:text-white transition">
                    Dashboard
                </a>
            @endauth

        </div>

    </div>

</header>

<script>
    const mobileButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
