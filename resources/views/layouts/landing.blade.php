<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Fountainhead - Your Perfect Coliving & Cafe Space')">
    <meta name="keywords" content="@yield('meta_keywords', 'coliving, cafe, coworking, jakarta')">

    <title>@yield('title', 'Fountainhead') | Modern Coliving & Cafe</title>
    {{-- Favicon & Logo dari Site Settings --}}
    @php
        $siteFavicon = App\Models\SiteSetting::where('key', 'site_favicon')->value('value');
        $siteLogo = App\Models\SiteSetting::where('key', 'site_logo')->value('value');
    @endphp

    @if($siteFavicon)
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($siteFavicon) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">

    {{-- AOS Animation --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            @apply bg-gray-100;
        }
        ::-webkit-scrollbar-thumb {
            @apply bg-orange-500 rounded-md;
        }
        ::-webkit-scrollbar-thumb:hover {
            @apply bg-orange-600;
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Loading Spinner Animation */
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .animate-spin-custom {
            animation: spin 1s linear infinite;
        }

        /* WhatsApp Pulse Animation */
        @keyframes pulse-wa {
            0%, 100% {
                box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
            }
            50% {
                box-shadow: 0 4px 30px rgba(37, 211, 102, 0.7);
            }
        }
        .animate-pulse-wa {
            animation: pulse-wa 2s infinite;
        }
        nav img {
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>

    @yield('styles')
</head>
<body class="min-h-screen flex flex-col font-['Inter'] text-gray-800 overflow-x-hidden antialiased">
    {{-- Loading Spinner --}}
    <div id="loader" class="fixed inset-0 bg-white flex items-center justify-center z-[9999] transition-opacity duration-500">
        <div class="w-12 h-12 border-4 border-gray-200 border-t-orange-500 rounded-full animate-spin-custom"></div>
    </div>

    {{-- Navbar --}}
    <nav id="navbar" class="fixed w-full top-0 z-50 transition-all duration-300 bg-white shadow-md py-4">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between">
                {{-- Logo (kiri) --}}
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="flex items-center">
                        @if($siteLogo ?? null)
                            <img src="{{ Storage::url($siteLogo) }}"
                                alt="Fountainhead"
                                class="h-12 w-auto object-contain rounded-md shadow-sm" />
                        @else
                            <img src="{{ asset('images/logo.png') }}"
                                alt="Fountainhead"
                                class="h-12 w-auto object-contain rounded-md shadow-sm" />
                        @endif
                    </div>
                </a>

                {{-- Nav Menu (tengah) --}}
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('home') }}"
                    class="nav-link px-4 py-2 text-gray-800 font-medium relative group transition-colors hover:text-orange-500 {{ request()->is('/') ? 'text-orange-500' : '' }}">
                        Home
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-4/5 -translate-x-1/2 {{ request()->is('/') ? 'w-4/5' : '' }}"></span>
                    </a>
                    <a href="{{ route('coliving.index') }}"
                    class="nav-link px-4 py-2 text-gray-800 font-medium relative group transition-colors hover:text-orange-500 {{ request()->is('coliving*') ? 'text-orange-500' : '' }}">
                        Coliving
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-4/5 -translate-x-1/2 {{ request()->is('coliving*') ? 'w-4/5' : '' }}"></span>
                    </a>
                    <a href="{{ route('cafe.menu') }}"
                    class="nav-link px-4 py-2 text-gray-800 font-medium relative group transition-colors hover:text-orange-500 {{ request()->routeIs('cafe.menu') ? 'text-orange-500' : '' }}">
                        Cafe Menu
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-4/5 -translate-x-1/2 {{ request()->routeIs('cafe.menu') ? 'w-4/5' : '' }}"></span>
                    </a>
                    <a href="{{ route('cafe.index') }}"
                    class="nav-link px-4 py-2 text-gray-800 font-medium relative group transition-colors hover:text-orange-500 {{ request()->routeIs('cafe.index') ? 'text-orange-500' : '' }}">
                        Events
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-4/5 -translate-x-1/2 {{ request()->routeIs('cafe.index') ? 'w-4/5' : '' }}"></span>
                    </a>
                    <a href="{{ route('about') }}"
                    class="nav-link px-4 py-2 text-gray-800 font-medium relative group transition-colors hover:text-orange-500 {{ request()->is('about') ? 'text-orange-500' : '' }}">
                        About
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-4/5 -translate-x-1/2 {{ request()->is('about') ? 'w-4/5' : '' }}"></span>
                    </a>
                    <a href="{{ route('contact') }}"
                    class="nav-link px-4 py-2 text-gray-800 font-medium relative group transition-colors hover:text-orange-500 {{ request()->is('contact') ? 'text-orange-500' : '' }}">
                        Contact
                        <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-4/5 -translate-x-1/2 {{ request()->is('contact') ? 'w-4/5' : '' }}"></span>
                    </a>
                </div>

                {{-- User Menu --}}
                <div class="hidden lg:flex items-center space-x-3">

                    @guest
                        <a href="{{ route('login') }}"
                            class="text-gray-700 hover:text-orange-500 font-medium transition">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-full font-medium transition">
                            Register
                        </a>
                    @endguest

                    @auth

                    {{-- Customer --}}
                    @if(auth()->user()->hasRole('customer'))

                        <div class="relative" x-data="{ open: false }">

                            <button
                                @click="open = !open"
                                class="flex items-center gap-2 border border-orange-300 bg-white px-4 py-2 rounded-full hover:border-orange-500 transition">

                                <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>

                                <span class="font-semibold text-gray-700">
                                    Hi, {{ explode(' ', auth()->user()->name)[0] }}
                                </span>

                                <i class="fas fa-chevron-down text-xs"
                                :class="{ 'rotate-180': open }"></i>

                            </button>

                            <div
                                x-show="open"
                                @click.away="open = false"
                                class="absolute right-0 mt-2 w-52 bg-white rounded-lg shadow-lg border">

                                <a href="{{ route('my-booking') }}"
                                    class="block px-4 py-3 hover:bg-gray-100">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    My Booking
                                </a>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="w-full text-left px-4 py-3 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        Logout
                                    </button>
                                </form>

                            </div>

                        </div>

                    {{-- Admin & Operator --}}
                    @elseif(auth()->user()->hasAnyRole(['admin', 'operator']))

                        <div class="flex items-center gap-3">

                            <a href="{{ route('admin.dashboard') }}"
                                class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-full font-medium transition">
                                Dashboard
                            </a>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button
                                    class="border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white px-5 py-2 rounded-full transition">

                                    Logout

                                </button>

                            </form>

                        </div>

                    @endif

                @endauth

                </div>

                {{-- Mobile Menu Button --}}
                <button id="mobileMenuBtn" class="lg:hidden text-gray-800 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="menuIcon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                        <path id="closeIcon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobileMenu" class="hidden lg:hidden mt-4 pb-4">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-gray-800 font-medium hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->is('/') ? 'text-orange-500 bg-orange-50' : '' }}">Home</a>
                    <a href="{{ route('coliving.index') }}" class="px-4 py-2 text-gray-800 font-medium hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->is('coliving*') ? 'text-orange-500 bg-orange-50' : '' }}">Coliving</a>
                    <a href="{{ route('cafe.menu') }}" class="px-4 py-2 text-gray-800 font-medium hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->routeIs('cafe.menu') ? 'text-orange-500 bg-orange-50' : '' }}">Menu</a>
                    <a href="{{ route('cafe.index') }}" class="px-4 py-2 text-gray-800 font-medium hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->is('cafe*') ? 'text-orange-500 bg-orange-50' : '' }}">Cafe & Events</a>
                    <a href="{{ route('about') }}" class="px-4 py-2 text-gray-800 font-medium hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->is('about') ? 'text-orange-500 bg-orange-50' : '' }}">About</a>
                    <a href="{{ route('contact') }}" class="px-4 py-2 text-gray-800 font-medium hover:text-orange-500 hover:bg-orange-50 rounded-lg transition {{ request()->is('contact') ? 'text-orange-500 bg-orange-50' : '' }}">Contact</a>
                    {{-- <a href="{{ route('coliving.index') }}" class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-full text-center shadow-md hover:bg-orange-600 transition-all">Book Now</a> --}}
                </div>
            </div>
        </div>
    </nav>


    {{-- Main Content --}}
    <main class="pt-20">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-6 pt-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                {{-- About --}}
                <div>
                    <h5 class="text-orange-500 font-bold text-lg mb-4">Fountainhead</h5>
                    <p class="text-gray-300 mb-4">Your perfect space for living, working, and connecting. Experience modern coliving and creative cafe culture.</p>
                    <div class="flex space-x-4">
                        {{-- <a href="{{ $settings['facebook_url'] ?? 'https://www.instagram.com/fountainhead.co' }}" class="text-white hover:text-orange-500 transition text-xl">
                            <i class="fab fa-facebook"></i>
                        </a> --}}
                        <!-- Instagram -->
                        <div class="relative group">
                            <a href="{{ $settings['instagram_url'] ?? 'https://www.instagram.com/fountainhead.co' }}"
                            class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition text-xl"
                            target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <span class="absolute bottom-full mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded px-2 py-1 whitespace-nowrap">
                                @fountainhead.co
                            </span>
                        </div>

                        <!-- TikTok Café -->
                        <div class="relative group">
                            <a href="{{ $settings['tiktok_cafe'] ?? 'https://www.tiktok.com/@fountainheadcafe'}}"
                            class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition text-xl"
                            target="_blank">
                                <i class="fab fa-tiktok"></i>
                            </a>
                            <span class="absolute bottom-full mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded px-2 py-1 whitespace-nowrap">
                                @fountainheadcafe
                            </span>
                        </div>

                        <!-- TikTok Co-living -->
                        <div class="relative group">
                            <a href="{{ $settings['tiktok_coliving'] ?? 'https://www.tiktok.com/@fountainhead.coliving'}}"
                            class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition text-xl"
                            target="_blank">
                                <i class="fab fa-tiktok"></i>
                            </a>
                            <span class="absolute bottom-full mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded px-2 py-1 whitespace-nowrap">
                                @fountainhead.coliving
                            </span>
                        </div>
                        {{-- <a href="{{ $settings['twitter_url'] ?? 'https://www.instagram.com/fountainhead.co' }}"class="text-white hover:text-orange-500 transition text-xl">
                            <i class="fab fa-twitter"></i>
                        </a> --}}
                        {{-- <a href="{{ $settings['linkedin_url'] ?? 'https://www.instagram.com/fountainhead.co' }}" class="text-white hover:text-orange-500 transition text-xl">
                            <i class="fab fa-linkedin"></i>
                        </a> --}}
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h5 class="text-orange-500 font-bold text-lg mb-4">Quick Links</h5>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-orange-500 transition">Home</a></li>
                        <li><a href="{{ route('coliving.index') }}" class="text-gray-300 hover:text-orange-500 transition">Coliving Rooms</a></li>
                        <li><a href="{{ route('cafe.index') }}" class="text-gray-300 hover:text-orange-500 transition">Cafe & Events</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-orange-500 transition">About Us</a></li>
                    </ul>
                </div>
                {{-- Contact --}}
                <div>
                    <h5 class="text-orange-500 font-bold text-lg mb-4">Contact</h5>
                    <ul class="space-y-2">
                        <li class="flex items-start text-gray-300">
                            <i class="fas fa-map-marker-alt mt-1 mr-2"></i>
                            <span>{{ $settings['address'] ?? 'RT.2/RW.10, North Meruya, Kembangan, West Jakarta City, Jakarta 11620' }}</span>
                        </li>
                        <li class="flex items-start text-gray-300">
                            <i class="fas fa-phone mt-1 mr-2"></i>
                            <span>{{ $settings['contact_phone'] ?? '+62 8151-1730-175' }}</span>
                        </li>
                        <li class="flex items-start text-gray-300">
                            <i class="fas fa-envelope mt-1 mr-2"></i>
                            <span>{{ $settings['contact_email'] ?? 'hello@fountainhead.id' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Bottom Footer --}}
            <div class="border-t border-gray-700 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-gray-400">&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Fountainhead' }}. All rights reserved.</p>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-400 hover:text-orange-500 transition">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-orange-500 transition">Terms & Conditions</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- WhatsApp Float Button --}}
    <a href="https://wa.me/6281511730175" target="_blank"
       class="fixed bottom-8 right-8 w-14 h-14 bg-green-500 rounded-full flex items-center justify-center shadow-lg z-50 hover:scale-110 transition-transform animate-pulse-wa"
       title="Chat on WhatsApp">
        <i class="fab fa-whatsapp text-white text-3xl"></i>
    </a>

    {{-- Scroll to Top Button --}}
    <button id="scrollTopBtn"
            class="fixed bottom-24 right-8 w-12 h-12 bg-orange-500 text-white rounded-full flex items-center justify-center shadow-lg z-50 opacity-0 invisible transition-all duration-300 hover:bg-orange-600 hover:scale-110"
            title="Back to Top">
        <i class="fas fa-arrow-up text-lg"></i>
    </button>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Booking Helper --}}
    <script src="{{ asset('js/booking-helper.js') }}"></script>

    {{-- Midtrans Snap --}}
    @if(config('services.midtrans.is_production'))
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    @else
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Navbar scroll effect - Keep it white with subtle shadow change
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('shadow-xl');
            } else {
                navbar.classList.remove('shadow-xl');
            }
        });

        // Scroll to Top Button
        const scrollTopBtn = document.getElementById('scrollTopBtn');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollTopBtn.classList.remove('opacity-0', 'invisible');
                scrollTopBtn.classList.add('opacity-100', 'visible');
            } else {
                scrollTopBtn.classList.add('opacity-0', 'invisible');
                scrollTopBtn.classList.remove('opacity-100', 'visible');
            }
        });

        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');

        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // Hide loader when page is loaded
        window.addEventListener('load', function() {
            document.getElementById('loader').style.opacity = '0';
            setTimeout(() => {
                document.getElementById('loader').style.display = 'none';
            }, 500);
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Format Rupiah
        function formatRupiah(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        }

        // Base64 Encode/Decode Functions for Data Security
        function encodeData(data) {
            return btoa(encodeURIComponent(JSON.stringify(data)));
        }

        function decodeData(encodedData) {
            try {
                return JSON.parse(decodeURIComponent(atob(encodedData)));
            } catch (e) {
                console.error('Decode error:', e);
                return null;
            }
        }

        // Midtrans payment handler with encoded data
        function processPayment(snapToken, bookingData = null) {
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    console.log('Payment success:', encodeData(result));
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful!',
                        text: 'Thank you for your payment.',
                        confirmButtonColor: '#F59E0B'
                    }).then(() => {
                        window.location.reload();
                    });
                },
                onPending: function(result) {
                    console.log('Payment pending:', encodeData(result));
                    Swal.fire({
                        icon: 'info',
                        title: 'Payment Pending',
                        text: 'Please complete your payment.',
                        confirmButtonColor: '#F59E0B'
                    });
                },
                onError: function(result) {
                    console.log('Payment error:', encodeData(result));
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: 'Something went wrong. Please try again.',
                        confirmButtonColor: '#F59E0B'
                    });
                },
                onClose: function() {
                    console.log('Payment popup closed');
                }
            });
        }
    </script>

    @yield('scripts')
</body>
</html>
