<header class="fixed top-0 left-0 w-full z-50 bg-black/40 backdrop-blur-lg border-b border-white/10">

    <div class="container mx-auto px-6">

        <div class="flex items-center justify-between h-20">

            <!-- LOGO -->
            <a
                href="/"
                class="text-2xl font-bold tracking-wide hover:text-blue-400 transition"
            >
                ✈ SkyBook
            </a>

            <!-- NAVIGATION -->
            <nav class="hidden md:flex items-center gap-8">

                <a href="/" class="text-gray-300 hover:text-white transition">
                    Home
                </a>

                <a href="/flights" class="text-gray-300 hover:text-white transition">
                    Flights
                </a>

                <a href="#" class="text-gray-300 hover:text-white transition">
                    Destinations
                </a>

                <a href="#" class="text-gray-300 hover:text-white transition">
                    About
                </a>

            </nav>

            <!-- AUTH BUTTONS -->
            <div class="hidden md:flex items-center gap-4">

                <a
                    href="#"
                    class="text-gray-300 hover:text-white transition"
                >
                    Login
                </a>

                <a
                    href="#"
                    class="bg-blue-600 hover:bg-blue-700 transition px-5 py-2 rounded-xl font-medium shadow-lg"
                >
                    Register
                </a>

            </div>

            <!-- MOBILE BUTTON -->
            <button
                id="mobile-menu-button"
                class="md:hidden text-white"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-8 w-8"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
            </button>

        </div>

    </div>

    <!-- MOBILE MENU -->
    <div
        id="mobile-menu"
        class="hidden md:hidden bg-gray-900 border-t border-white/10"
    >

        <div class="px-6 py-6 flex flex-col gap-4">

            <a href="/" class="text-gray-300 hover:text-white transition">
                Home
            </a>

            <a href="/flights" class="text-gray-300 hover:text-white transition">
                Flights
            </a>

            <a href="#" class="text-gray-300 hover:text-white transition">
                Destinations
            </a>

            <a href="#" class="text-gray-300 hover:text-white transition">
                About
            </a>

            <hr class="border-gray-700">

            <a href="#" class="text-gray-300 hover:text-white transition">
                Login
            </a>

            <a
                href="#"
                class="bg-blue-600 hover:bg-blue-700 transition px-5 py-3 rounded-xl font-medium text-center"
            >
                Register
            </a>

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
