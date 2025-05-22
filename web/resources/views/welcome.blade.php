<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kapegabay - Welcome</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gradient-to-br from-[#FDFDFC] to-[#f5f5f3] dark:from-[#0a0a0a] dark:to-[#1a1a1a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen">
        <!-- Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-[#0a0a0a]/80 backdrop-blur-md border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-semibold">Kapegabay</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] hover:bg-opacity-90 transition-all duration-200">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg hover:bg-[#1b1b18]/5 dark:hover:bg-[#EDEDEC]/5 transition-all duration-200">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    {{-- <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] hover:bg-opacity-90 transition-all duration-200">
                                        Register
                                    </a> --}}
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="pt-24 pb-16 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-[#1b1b18] to-[#3E3E3A] dark:from-[#EDEDEC] dark:to-[#A1A09A]">
                        Welcome to Kapegabay
                    </h1>
                    <p class="text-lg sm:text-xl text-[#706f6c] dark:text-[#A1A09A] max-w-2xl mx-auto mb-8">
                        Your ultimate companion for coffee enthusiasts. Discover, share, and explore the world of coffee together.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('login') }}" class="px-8 py-3 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] hover:bg-opacity-90 transition-all duration-200 text-lg font-medium">
                            Get Started
                        </a>
                        <a href="#features" class="px-8 py-3 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] hover:bg-[#1b1b18]/5 dark:hover:bg-[#EDEDEC]/5 transition-all duration-200 text-lg font-medium">
                            Learn More
                        </a>
                    </div>
                </div>

                <!-- Features Section -->
                <div id="features" class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 rounded-xl bg-white/50 dark:bg-[#1a1a1a]/50 backdrop-blur-sm border border-[#e3e3e0] dark:border-[#3E3E3A] hover:shadow-lg transition-all duration-200">
                        <div class="w-12 h-12 rounded-lg bg-[#1b1b18]/10 dark:bg-[#EDEDEC]/10 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Discover Coffee</h3>
                        <p class="text-[#706f6c] dark:text-[#A1A09A]">Explore a vast collection of coffee recipes, brewing methods, and tips from experts.</p>
                    </div>

                    <div class="p-6 rounded-xl bg-white/50 dark:bg-[#1a1a1a]/50 backdrop-blur-sm border border-[#e3e3e0] dark:border-[#3E3E3A] hover:shadow-lg transition-all duration-200">
                        <div class="w-12 h-12 rounded-lg bg-[#1b1b18]/10 dark:bg-[#EDEDEC]/10 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Connect & Share</h3>
                        <p class="text-[#706f6c] dark:text-[#A1A09A]">Join a community of coffee lovers and share your experiences and knowledge.</p>
                    </div>

                    <div class="p-6 rounded-xl bg-white/50 dark:bg-[#1a1a1a]/50 backdrop-blur-sm border border-[#e3e3e0] dark:border-[#3E3E3A] hover:shadow-lg transition-all duration-200">
                        <div class="w-12 h-12 rounded-lg bg-[#1b1b18]/10 dark:bg-[#EDEDEC]/10 flex items-center justify-center mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Expert Guidance</h3>
                        <p class="text-[#706f6c] dark:text-[#A1A09A]">Get professional advice and learn from experienced baristas and coffee experts.</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-16 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    <p>&copy; {{ date('Y') }} Kapegabay. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
