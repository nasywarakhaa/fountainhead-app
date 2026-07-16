@extends('layouts.landing')

@section('title', 'Home')

@section('styles')
    <style>
        /* Hero gradient animation */
        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg);
            }

            33% {
                transform: translate(30px, -30px) rotate(120deg);
            }

            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }

        .hero-gradient {
            animation: float 20s ease-in-out infinite;
        }
    </style>
@endsection

@section('content')
    {{-- Hero Section with Flowbite Carousel --}}
    <section class="relative min-h-screen flex items-center bg-gradient-to-br from-gray-50 to-orange-50 overflow-hidden">
        <div
            class="absolute top-[-10%] right-[-20%] w-[600px] h-[600px] bg-gradient-to-br from-orange-400 to-orange-600 opacity-10 rounded-full blur-3xl hero-gradient">
        </div>

        <div class="container mx-auto px-4 relative z-10">
            @if (isset($heroSliders) && $heroSliders->count() > 0)
                {{-- Flowbite Carousel for Hero Sliders --}}
                <div id="hero-carousel" class="pt-8 md:pt-12" data-carousel="slide">
                    <div class="relative h-screen overflow-hidden rounded-lg md:h-[calc(100vh-160px)] flex items-start pt-24">
                        @foreach ($heroSliders as $index => $slider)
                            <div class="hidden duration-700 ease-in-out" data-carousel-item="{{ $index === 0 ? 'active' : '' }}">
                                <div class="grid lg:grid-cols-2 gap-12 items-center px-4 md:px-0" pt-12> {{-- Tambah padding di sini untuk mobile --}}
                                    <div class="text-center lg:text-left" data-aos="fade-right">
                                        <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-800 leading-tight mb-6">
                                            {{ $slider->title }}
                                        </h1>
                                        <p class="text-xl text-gray-600 mb-8">
                                            {{ $slider->subtitle }}
                                        </p>
                                        <div class="flex gap-4 justify-center lg:justify-start flex-wrap">
                                            @if ($slider->cta_text && $slider->cta_link)
                                                <a href="{{ $slider->cta_link }}"
                                                    class="inline-flex items-center gap-2 bg-orange-500 text-white px-8 py-3 rounded-full font-semibold hover:bg-orange-600 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                                                    <i class="fas fa-bed"></i>
                                                    {{ $slider->cta_text }}
                                                </a>
                                            @endif
                                            <a href="{{ route('cafe.index') }}"
                                                class="inline-flex items-center gap-2 bg-transparent text-orange-500 border-2 border-orange-500 px-8 py-3 rounded-full font-semibold hover:bg-orange-500 hover:text-white hover:-translate-y-1 transition-all duration-300">
                                                <i class="fas fa-coffee"></i>
                                                Event Spaces
                                            </a>
                                        </div>
                                    </div>
                                    <div data-aos="fade-left" class="flex justify-center lg:justify-end"> {{-- Tambahkan flex agar mudah mengatur posisi --}}
                                        @if ($slider->image)
                                            <img src="{{ Storage::url($slider->image) }}" alt="{{ $slider->title }}"
                                                class="block w-full h-auto max-w-[400px] lg:max-w-none lg:w-[600px] lg:h-[600px] object-cover object-center rounded-2xl drop-shadow-2xl">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
                        @foreach ($heroSliders as $index => $slider)
                            <button type="button" class="w-3 h-3 rounded-full bg-orange-300 aria-[current=true]:bg-orange-500" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}" data-carousel-slide-to="{{ $index }}"></button>
                        @endforeach
                    </div>
                    <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>
            @else
                {{-- Default Hero (when no sliders) - NO CHANGE NEEDED HERE --}}
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left" data-aos="fade-right">
                        <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-800 leading-tight mb-6">
                            Your Perfect Space for Living & Creating
                        </h1>
                        <p class="text-xl text-gray-600 mb-8">
                            Experience modern coliving and vibrant cafe culture in the heart of Jakarta. Work, live, and
                            connect.
                        </p>
                        <div class="flex gap-4 justify-center lg:justify-start flex-wrap">
                            <a href="{{ route('coliving.index') }}"
                                class="inline-flex items-center gap-2 bg-orange-500 text-white px-8 py-3 rounded-full font-semibold hover:bg-orange-600 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                                <i class="fas fa-bed"></i>
                                Explore Rooms
                            </a>
                            <a href="{{ route('cafe.index') }}"
                                class="inline-flex items-center gap-2 bg-transparent text-orange-500 border-2 border-orange-500 px-8 py-3 rounded-full font-semibold hover:bg-orange-500 hover:text-white hover:-translate-y-1 transition-all duration-300">
                                <i class="fas fa-coffee"></i>
                                Event Spaces
                            </a>
                        </div>
                    </div>
                    <div data-aos="fade-left">
                        <img src="{{ asset('images/hero-illustration.png') }}" alt="Coliving and Cafe Space"
                            class="w-full h-auto drop-shadow-2xl" onerror="this.style.display='none'">
                    </div>
                </div>
            @endif
        </div>
    </section>
    {{-- Stats Section --}}
    @if (isset($stats) && $stats)
        <section class="py-16 bg-gradient-to-r from-orange-500 to-orange-600">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-8" data-aos="fade-up">
                    <div class="text-center text-white">
                        <div class="text-4xl lg:text-5xl font-extrabold mb-2">{{ $stats['available_rooms'] }}</div>
                        <div class="text-orange-100 font-medium">Available Rooms</div>
                    </div>
                    <div class="text-center text-white">
                        <div class="text-4xl lg:text-5xl font-extrabold mb-2">{{ $stats['total_residents'] }}</div>
                        <div class="text-orange-100 font-medium">Happy Residents</div>
                    </div>
                    <div class="text-center text-white">
                        <div class="text-4xl lg:text-5xl font-extrabold mb-2">{{ $stats['rating'] }}</div>
                        <div class="text-orange-100 font-medium">Average Rating</div>
                    </div>
                    <div class="text-center text-white">
                        <div class="text-4xl lg:text-5xl font-extrabold mb-2">{{ $stats['events_hosted'] }}</div>
                        <div class="text-orange-100 font-medium">Events Hosted</div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    {{-- Quick Booking Section --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800 mb-4 relative inline-block">
                        Quick Booking
                        <span class="absolute bottom-0 left-0 w-16 h-1 bg-orange-500 rounded-full"></span>
                    </h2>
                    <p class="text-xl text-gray-600 mt-6">Check availability and book your perfect space instantly.</p>
                </div>
                {{-- Booking Tabs --}}
                <div class="bg-gray-50 rounded-3xl p-8 shadow-lg" data-aos="fade-up">
                    <div class="flex justify-center mb-8">
                        <div class="inline-flex rounded-full bg-white p-1 shadow-md">
                            <button onclick="switchTab('room')" id="roomTab"
                                class="tab-button px-8 py-3 rounded-full font-semibold transition-all duration-300 bg-orange-500 text-white">
                                <i class="fas fa-bed mr-2"></i>Book a Room
                            </button>
                            <button onclick="switchTab('cafe')" id="cafeTab"
                                class="tab-button px-8 py-3 rounded-full font-semibold transition-all duration-300 text-gray-600 hover:text-orange-500">
                                <i class="fas fa-coffee mr-2"></i>Book Cafe/Event
                            </button>
                        </div>
                    </div>
                    {{-- Room Booking Form --}}
                    <div id="roomBooking" class="booking-content">
                        <form action="{{ route('coliving.index') }}" method="GET"
                            class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt text-orange-500 mr-1"></i>Check-in Date
                                </label>
                                <input type="date" name="check_in" id="roomCheckIn"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-check text-orange-500 mr-1"></i>Check-out Date
                                </label>
                                <input type="date" name="check_out" id="roomCheckOut"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-users text-orange-500 mr-1"></i>Room Type
                                </label>
                                <select name="room_type"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                                    <option value="">All Types</option>
                                    <option value="single">Single Room</option>
                                    <option value="shared">Shared Room</option>
                                    <option value="private">Private Room</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-dollar-sign text-orange-500 mr-1"></i>Max Price
                                </label>
                                <select name="max_price"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                                    <option value="">Any Price</option>
                                    <option value="500000">Under 500K</option>
                                    <option value="1000000">Under 1M</option>
                                    <option value="2000000">Under 2M</option>
                                    <option value="3000000">Under 3M</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 lg:col-span-4">
                                <button type="submit"
                                    class="w-full bg-orange-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-orange-600 hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-search mr-2"></i>Check Availability
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Cafe/Event Booking Form --}}
                    <div id="cafeBooking" class="booking-content hidden">
                        <form action="{{ route('cafe.index') }}" method="GET"
                            class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-alt text-orange-500 mr-1"></i>Event Date
                                </label>
                                <input type="date" name="event_date" id="cafeEventDate"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-clock text-orange-500 mr-1"></i>Start Time
                                </label>
                                <input type="time" name="start_time"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-hourglass-end text-orange-500 mr-1"></i>Duration
                                </label>
                                <select name="duration"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                                    <option value="">Select Duration</option>
                                    <option value="2">2 Hours</option>
                                    <option value="4">4 Hours</option>
                                    <option value="8">Full Day (8 Hours)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-users text-orange-500 mr-1"></i>Guests
                                </label>
                                <select name="guests"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                                    <option value="">Select Guests</option>
                                    <option value="10">Up to 10 people</option>
                                    <option value="25">Up to 25 people</option>
                                    <option value="50">Up to 50 people</option>
                                    <option value="100">Up to 100 people</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 lg:col-span-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-list text-orange-500 mr-1"></i>Event Type
                                </label>
                                <select name="event_type"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none">
                                    <option value="">Select Event Type</option>
                                    <option value="meeting">Business Meeting</option>
                                    <option value="workshop">Workshop/Training</option>
                                    <option value="party">Private Party</option>
                                    <option value="gathering">Community Gathering</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 lg:col-span-4">
                                <button type="submit"
                                    class="w-full bg-orange-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-orange-600 hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-search mr-2"></i>Check Cafe Availability
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Quick Info --}}
                    <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-blue-500 text-xl mt-1"></i>
                            <div class="text-sm text-gray-700">
                                <strong class="text-blue-700">Instant Confirmation:</strong> Get real-time availability
                                updates.
                                <span class="inline-block ml-1">For special requests, call us at <strong
                                        class="text-orange-600">+62 812-3456-7890</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CMS Sections from Admin Panel --}}
    @if (isset($sections) && $sections->count() > 0)
        <section class="py-20">
            <div class="container mx-auto px-4">
                @foreach ($sections as $section)
                    <div class="bg-gray-50 rounded-3xl p-8 lg:p-12 mb-12" data-aos="fade-up">
                        <div
                            class="grid lg:grid-cols-2 gap-12 items-center {{ $loop->even ? 'lg:flex-row-reverse' : '' }}">
                            @if ($section->banner_image)
                                <div class="{{ $loop->even ? 'lg:order-2' : '' }}">
                                    <img src="{{ Storage::url($section->banner_image) }}" alt="{{ $section->title }}"
                                        class="w-full h-auto rounded-2xl shadow-xl">
                                </div>
                            @endif
                            <div
                                class="{{ $section->banner_image ? ($loop->even ? 'lg:order-1' : '') : 'lg:col-span-2' }}">
                                <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800 mb-4 relative inline-block">
                                    {{ $section->title }}
                                    <span class="absolute bottom-0 left-0 w-16 h-1 bg-orange-500 rounded-full"></span>
                                </h2>
                                @if ($section->description)
                                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">{{ $section->description }}</p>
                                @endif
                                @if ($section->cta_text && $section->cta_link)
                                    <a href="{{ $section->cta_link }}"
                                        class="inline-flex items-center gap-2 bg-orange-500 text-white px-6 py-3 rounded-full font-semibold hover:bg-orange-600 hover:-translate-y-1 transition-all duration-300">
                                        {{ $section->cta_text }}
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Featured Rooms Section --}}
    @if (!empty($featuredRooms) && $featuredRooms->count())
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">

                {{-- Heading --}}
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800 mb-4 relative inline-block">
                        Featured Coliving Rooms
                        <span class="absolute bottom-0 left-0 w-16 h-1 bg-orange-500 rounded-full"></span>
                    </h2>
                    <p class="text-xl text-gray-600 mt-6">
                        Discover our most popular and comfortable living spaces, designed for modern life.
                    </p>
                </div>
                {{-- Grid --}}
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($featuredRooms as $room)
                        <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:-translate-y-3 hover:shadow-2xl h-full flex flex-col">
                                {{-- Thumbnail --}}
                                @if ($room->thumbnail)
                                    <div class="relative overflow-hidden h-64">
                                        <img
                                            src="{{ Storage::url($room->thumbnail) }}"
                                            alt="{{ $room->name }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        >
                                        <div class="absolute top-4 right-4">
                                            @if ($room->is_available)
                                                <span class="bg-green-500 text-white px-4 py-1 rounded-full text-sm font-semibold">
                                                    Available
                                                </span>
                                            @else
                                                <span class="bg-red-500 text-white px-4 py-1 rounded-full text-sm font-semibold">
                                                    Not Available
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                {{-- Content --}}
                                <div class="p-6 flex-1 flex flex-col">
                                    <h3 class="text-xl font-bold text-gray-800 mb-3">
                                        {{ $room->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mb-2 flex items-center gap-2">
                                        <i class="fas fa-user-friends text-orange-500"></i>
                                        {{ ucfirst($room->room_type) }} Room
                                    </p>
                                    {{-- Short Description --}}
                                    @if (!empty($room->short_description))
                                        <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                                            {{ $room->short_description }}
                                        </p>
                                    @endif
                                    {{-- Room Specs --}}
                                    <div class="flex justify-around py-4 border-t border-b border-gray-100 mb-4">
                                        <div class="text-center">
                                            <i class="fas fa-bed text-orange-500 text-lg mb-1 block"></i>
                                            <span class="text-sm text-gray-600">{{ $room->beds_count }} Bed(s)</span>
                                        </div>
                                        <div class="text-center">
                                            <i class="fas fa-users text-orange-500 text-lg mb-1 block"></i>
                                            <span class="text-sm text-gray-600">{{ $room->capacity }} Person</span>
                                        </div>
                                        @if(!empty($room->room_size))
                                            <div class="text-center">
                                                <i class="fas fa-ruler-combined text-orange-500 text-lg mb-1 block"></i>
                                                <span class="text-sm text-gray-600">{{ $room->room_size }}m²</span>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- Price + Button --}}
                                    <div class="flex justify-between items-center mt-auto">
                                        <div>
                                            <div class="text-3xl font-extrabold text-orange-500">
                                                Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                                            </div>
                                            <span class="text-sm text-gray-500">/ night</span>
                                        </div>
                                        <a href="{{ route('coliving.show', $room->id) }}"
                                        class="bg-transparent text-orange-500 border-2 border-orange-500 px-6 py-2 rounded-full font-semibold hover:bg-orange-500 hover:text-white transition-all duration-300">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- CTA --}}
                <div class="text-center mt-12" data-aos="fade-up">
                    <a href="{{ route('coliving.index') }}"
                        class="inline-flex items-center gap-2 bg-orange-500 text-white px-8 py-3 rounded-full font-semibold hover:bg-orange-600 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                        View All Rooms
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            </div>
        </section>
    @endif


    {{-- Features Section --}}
    @if (isset($features) && $features->count() > 0)
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800 mb-4 relative inline-block">
                        Why Choose Fountainhead?
                        <span class="absolute bottom-0 left-0 w-16 h-1 bg-orange-500 rounded-full"></span>
                    </h2>
                    <p class="text-xl text-gray-600 mt-6">We provide more than just a room. We offer an experience and a
                        community.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($features as $feature)
                        <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                            <div
                                class="bg-white rounded-2xl p-8 text-center border border-gray-100 transition-all duration-300 hover:-translate-y-3 hover:shadow-xl hover:border-orange-500 h-full">
                                <div
                                    class="text-5xl text-orange-500 mb-4 transition-transform duration-300 group-hover:scale-110">
                                    <i class="fas {{ $feature->icon }}"></i>
                                </div>
                                <h5 class="text-lg font-bold text-gray-800 mb-2">{{ $feature->title }}</h5>
                                @if ($feature->description)
                                    <p class="text-sm text-gray-600">{{ $feature->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Gallery Section --}}
    @if (isset($galleries) && $galleries->count() > 0)
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800 mb-4 relative inline-block">
                        Our Space Gallery
                        <span class="absolute bottom-0 left-0 w-16 h-1 bg-orange-500 rounded-full"></span>
                    </h2>
                    <p class="text-xl text-gray-600 mt-6">Take a peek at our beautiful coliving and cafe spaces.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($galleries as $gallery)
                        <div class="group relative overflow-hidden rounded-2xl shadow-lg cursor-pointer"
                            data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                            <img src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->title }}"
                                class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <div class="text-white">
                                    <h4 class="font-bold text-lg">{{ $gallery->title }}</h4>
                                    @if ($gallery->description)
                                        <p class="text-sm text-gray-200">{{ $gallery->description }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    {{-- DIGITAL MENU SECTION (LIGHT THEME) --}}
    <section class="py-24 bg-white relative overflow-hidden" id="digital-menu">
        <div class="container mx-auto px-4">
            <div class="bg-gradient-to-br from-orange-50 to-white border border-orange-100 rounded-[3rem] p-8 lg:p-16 relative overflow-hidden shadow-xl">
                <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-orange-300 rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob"></div>
                <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-yellow-300 rounded-full mix-blend-multiply filter blur-[80px] opacity-30 animate-blob animation-delay-2000"></div>
                <div class="grid lg:grid-cols-2 gap-12 items-center relative z-10">
                    <div class="text-left" data-aos="fade-right">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-100 border border-orange-200 text-orange-600 text-sm font-bold mb-6">
                            <i class="fas fa-book-open"></i> Digital Menu
                        </div>
                        <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800 mb-6 leading-tight">
                            Explore Our Flavors <br>
                            <span class="text-orange-500">Before You Arrive</span>
                        </h2>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg">
                            Curious about our coffee blends or today's special? Browse our complete digital menu to see prices, photos, and descriptions instantly.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="https://fountainheadcafe.mygostore.com/FOUNTAINHEAD-CAFE-&-COLIVING/0aa08506-7c0d-17b9-817c-179f84fb009d?tableId=0ae01522-95af-1a1b-8197-35adf5b9267c"
                                target="_blank"
                                class="inline-flex justify-center items-center gap-3 bg-orange-500 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-orange-600 hover:scale-105 transition-all duration-300 shadow-lg shadow-orange-500/30">
                                <span>Browse Full Menu</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Right Content: Phone Mockup & QR --}}
                    <div class="relative flex justify-center lg:justify-end" data-aos="fade-left">
                        <div class="relative w-[280px] h-[520px] bg-white rounded-[3rem] border-[8px] border-gray-100 shadow-2xl overflow-hidden z-20">
                            {{-- Notch --}}
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-7 bg-gray-100 rounded-b-2xl z-30"></div>

                            {{-- Screen Content --}}
                            <div class="w-full h-full bg-gray-50 flex flex-col relative">
                                {{-- Fake Header overlay --}}
                                <div class="absolute top-0 left-0 right-0 bg-gradient-to-b from-black/40 to-transparent p-6 pt-12 z-10">
                                    <h3 class="text-white font-bold text-xl text-center drop-shadow-md">Fountainhead Menu</h3>
                                </div>

                                {{-- Menu Preview Image (UPDATED SOURCE DARI STORAGE KAMU) --}}
                                <div class="h-full w-full relative">
                                    {{-- Menggunakan gambar dari storage public --}}
                                    <img src="{{ Storage::url('galleries/vso9Mew4xMqwf3GTg8AsGpK96K8872PzjG8ShkjG.jpg') }}"
                                         class="w-full h-full object-cover" alt="Menu Preview">
                                </div>

                                {{-- Floating Card inside Phone --}}
                                <div class="absolute bottom-8 left-4 right-4 bg-white/95 backdrop-blur-md p-5 rounded-2xl shadow-lg text-center z-20">
                                    <p class="text-sm text-orange-500 font-bold mb-1 tracking-wider uppercase">Digital Catalog</p>
                                    <p class="font-extrabold text-gray-800 text-lg">Discover & Decide</p>
                                    <p class="text-xs text-gray-500 mt-2">View all items, prices, and details.</p>
                                </div>
                            </div>
                        </div>

                        {{-- QR Code Card (Floating beside phone) --}}
                        <div class="absolute -bottom-6 -left-6 lg:left-0 bg-white border border-orange-100 p-4 rounded-2xl shadow-xl z-30 animate-bounce-slow hidden sm:block">
                            <div class="text-center">
                                <p class="text-xs font-bold text-gray-500 mb-2 tracking-widest">SCAN ME</p>
                                {{-- QR Code otomatis (saya ubah warnanya jadi oranye juga biar matching) --}}
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&color=ea580c&data=https://fountainheadcafe.mygostore.com/FOUNTAINHEAD-CAFE-&-COLIVING/0aa08506-7c0d-17b9-817c-179f84fb009d?tableId=0ae01522-95af-1a1b-8197-35adf5b9267c"
                                     alt="Scan for Menu" class="w-24 h-24 rounded-lg">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Testimonials Section --}}
    @if (isset($testimonials) && $testimonials->count() > 0)
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800 mb-4 relative inline-block">
                        What Our Residents Say
                        <span class="absolute bottom-0 left-0 w-16 h-1 bg-orange-500 rounded-full"></span>
                    </h2>
                    <p class="text-xl text-gray-600 mt-6">Hear from people who have made Fountainhead their home.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($testimonials as $testimonial)
                        <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div
                                class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl h-full">
                                <div class="flex items-center mb-4">
                                    @if ($testimonial->customer_image)
                                        <img src="{{ Storage::url($testimonial->customer_image) }}"
                                            alt="{{ $testimonial->customer_name }}"
                                            class="w-16 h-16 rounded-full object-cover mr-4">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial->customer_name) }}&background=f59e0b&color=fff&size=64"
                                            alt="{{ $testimonial->customer_name }}" class="w-16 h-16 rounded-full mr-4">
                                    @endif
                                    <div>
                                        <h6 class="font-bold text-gray-800">{{ $testimonial->customer_name }}</h6>
                                        @if ($testimonial->customer_role)
                                            <p class="text-sm text-gray-500">{{ $testimonial->customer_role }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex mb-4 text-yellow-400">
                                    @for ($i = 0; $i < ($testimonial->rating ?? 5); $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                                <p class="text-gray-600 leading-relaxed">"{{ $testimonial->testimonial_text }}"</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Available Rooms Section --}}
    @if (isset($availableRooms) && $availableRooms->count() > 0)
        <section class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800 mb-4 relative inline-block">
                        Available Rooms
                        <span class="absolute bottom-0 left-0 w-16 h-1 bg-orange-500 rounded-full"></span>
                    </h2>
                    <p class="text-xl text-gray-600 mt-6">Find your perfect room at the best price.</p>
                </div>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($availableRooms as $room)
                        <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                            <div
                                class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:-translate-y-3 hover:shadow-2xl h-full flex flex-col">
                                @if ($room->thumbnail)
                                    <div class="relative overflow-hidden h-64">
                                        <img src="{{ Storage::url($room->thumbnail) }}" alt="{{ $room->name }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        <div class="absolute top-4 right-4">
                                            <span
                                                class="bg-green-500 text-white px-4 py-1 rounded-full text-sm font-semibold">Available</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="p-6 flex-1 flex flex-col">
                                    <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $room->name }}</h3>
                                    <p class="text-sm text-gray-500 mb-4 flex items-center gap-2">
                                        <i class="fas fa-user-friends text-orange-500"></i>
                                        {{ ucfirst($room->room_type) }} Room
                                    </p>

                                    <div class="flex justify-around py-4 border-t border-b border-gray-100 mb-4">
                                        <div class="text-center">
                                            <i class="fas fa-bed text-orange-500 text-lg mb-1 block"></i>
                                            <span class="text-sm text-gray-600">{{ $room->beds_count }} Bed(s)</span>
                                        </div>
                                        <div class="text-center">
                                            <i class="fas fa-users text-orange-500 text-lg mb-1 block"></i>
                                            <span class="text-sm text-gray-600">{{ $room->capacity }} Person</span>
                                        </div>
                                        @if ($room->room_size)
                                            <div class="text-center">
                                                <i class="fas fa-ruler-combined text-orange-500 text-lg mb-1 block"></i>
                                                <span class="text-sm text-gray-600">{{ $room->room_size }} m²</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex justify-between items-center mt-auto">
                                        <div>
                                            <div class="text-2xl font-extrabold text-orange-500">
                                                Rp {{ number_format($room->price_per_night, 0, ',', '.') }}
                                            </div>
                                            <span class="text-sm text-gray-500">/ night</span>
                                        </div>
                                        <a href="{{ route('coliving.show', $room->id) }}"
                                            class="bg-orange-500 text-white px-6 py-2 rounded-full font-semibold hover:bg-orange-600 transition-colors duration-300">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA Section --}}
    <section class="py-20">
        <div class="container mx-auto px-4" data-aos="zoom-in">
            <div
                class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-3xl p-12 lg:p-20 text-center text-white shadow-2xl">
                <h2 class="text-4xl lg:text-5xl font-extrabold mb-6">Ready to Join Our Community?</h2>
                <p class="text-xl lg:text-2xl mb-10 text-orange-100">Start your coliving journey today and experience a new
                    way of living.</p>
                <div class="flex gap-4 justify-center flex-wrap">
                    <a href="{{ route('coliving.index') }}"
                        class="inline-flex items-center gap-2 bg-white text-orange-500 px-8 py-4 rounded-full font-bold text-lg hover:scale-105 hover:shadow-2xl transition-all duration-300">
                        <i class="fas fa-home"></i>
                        Browse Rooms
                    </a>
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center gap-2 bg-transparent text-white border-2 border-white px-8 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-orange-500 transition-all duration-300">
                        <i class="fas fa-envelope"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        // Tab Switching Function
        function switchTab(tab) {
            const roomTab = document.getElementById('roomTab');
            const cafeTab = document.getElementById('cafeTab');
            const roomBooking = document.getElementById('roomBooking');
            const cafeBooking = document.getElementById('cafeBooking');

            if (tab === 'room') {
                roomTab.classList.add('bg-orange-500', 'text-white');
                roomTab.classList.remove('text-gray-600');
                cafeTab.classList.remove('bg-orange-500', 'text-white');
                cafeTab.classList.add('text-gray-600');
                roomBooking.classList.remove('hidden');
                cafeBooking.classList.add('hidden');
            } else {
                cafeTab.classList.add('bg-orange-500', 'text-white');
                cafeTab.classList.remove('text-gray-600');
                roomTab.classList.remove('bg-orange-500', 'text-white');
                roomTab.classList.add('text-gray-600');
                cafeBooking.classList.remove('hidden');
                roomBooking.classList.add('hidden');
            }
        }

        // Set minimum date to today for all date inputs
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];

            // Room booking dates
            const roomCheckIn = document.getElementById('roomCheckIn');
            const roomCheckOut = document.getElementById('roomCheckOut');

            if (roomCheckIn) {
                roomCheckIn.setAttribute('min', today);
                roomCheckIn.addEventListener('change', function() {
                    if (roomCheckOut) {
                        roomCheckOut.setAttribute('min', this.value);
                        if (roomCheckOut.value && roomCheckOut.value < this.value) {
                            roomCheckOut.value = '';
                        }
                    }
                });
            }

            if (roomCheckOut) {
                roomCheckOut.setAttribute('min', today);
            }

            // Cafe event date
            const cafeEventDate = document.getElementById('cafeEventDate');
            if (cafeEventDate) {
                cafeEventDate.setAttribute('min', today);
            }
        });

        console.log('Fountainhead Home Page Loaded - Tailwind Version with Booking Filters');
    </script>
@endsection
