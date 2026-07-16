@extends('layouts.landing')

@section('title', $room->name)

@section('content')
    <section class="pt-32 pb-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <nav class="flex mb-8" aria-label="Breadcrumb" data-aos="fade-right">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-orange-600">
                            <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <a href="{{ route('coliving.index') }}"
                                class="ms-1 text-sm font-medium text-gray-700 hover:text-orange-600 md:ms-2">Coliving
                                Rooms</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">{{ $room->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-12" data-aos="fade-up">
                <div>
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">{{ $room->name }}</h1>
                    <div class="flex flex-wrap gap-6 text-gray-600 text-sm">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-door-open text-orange-500"></i> {{ ucfirst($room->room_type) }} Room
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-users text-orange-500"></i> Up to {{ $room->capacity }}
                            guest{{ $room->capacity > 1 ? 's' : '' }}
                        </div>
                        @if ($room->room_size)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-ruler-combined text-orange-500"></i> {{ $room->room_size }}m²
                            </div>
                        @endif
                    </div>
                    <div class="flex gap-4 mt-4">
                        @if ($room->is_featured)
                            <span
                                class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Featured</span>
                        @endif
                        @if ($room->is_available)
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Available</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs fornt medium px-2.5 py-0.5 rounded-full">Not
                                Available</span>
                        @endif
                    </div>
                </div>
                <button onclick="sharePage()" type="button"
                    class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mt-6 lg:mt-0">
                    <i class="fas fa-share-alt mr-2"></i> Share
                </button>
            </div>

            <div class="mb-12" data-aos="zoom-in">
                @php
                    $images = $room->images ? collect($room->images) : collect();
                    if ($room->thumbnail) {
                        $images->prepend($room->thumbnail);}
                @endphp

                @if ($images->isNotEmpty())
                    <div id="default-carousel" class="relative w-full" data-carousel="slide">
                        <div class="relative h-64 overflow-hidden rounded-lg md:h-96 lg:h-[400px]">
                            @foreach ($images as $image)
                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <img src="{{ Storage::url($image) }}"
                                        class="carousel-image absolute block top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-black/5 object-contain"
                                        alt="Image {{ $loop->iteration }} of {{ $room->name }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                            @foreach ($images as $image)
                                <button type="button" class="w-3 h-3 rounded-full"
                                    aria-current="{{ $loop->first ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $loop->iteration }}"
                                    data-carousel-slide-to="{{ $loop->index }}"></button>
                            @endforeach
                        </div>
                        <button type="button"
                            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-prev>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                        <button type="button"
                            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                            data-carousel-next>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    </div>
                @else
                    <div class="w-full h-64 md:h-96 lg:h-[500px] bg-gray-200 flex items-center justify-center rounded-lg">
                        <svg class="w-12 h-12 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 18">
                            <path
                                d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.611 3.732 2.18-3.054a.965.965 0 0 1 .933-.526 1 1 0 0 1 .965.836l2.391 6.969Z" />
                        </svg>
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div class="lg:col-span-2 space-y-8">
                    @if ($room->description)
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow" data-aos="fade-up">
                            <h2 class="text-2xl font-bold text-gray-900 mb-3 flex items-center gap-3">
                                <i class="fas fa-info-circle text-orange-500"></i> About This Room
                            </h2>
                            @if (!empty($room->description_view['lead']) || !empty($room->description_view['items']))
                                @if (!empty($room->description_view['lead']))
                                    <p class="text-gray-700 text-[15px] leading-6 break-words whitespace-pre-line">
                                        {{ $room->description_view['lead'] }}
                                    </p>
                                @endif
                                @if (!empty($room->description_view['items']))
                                    <ul class="mt-3 list-disc pl-5 space-y-1 text-gray-700 text-[15px] leading-6">
                                        @foreach ($room->description_view['items'] as $it)
                                            <li class="break-words">{{ $it }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endif
                        </div>
                    @endif

                    <div class="bg-white border border-gray-200 rounded-lg shadow" data-aos="fade-up"
                        data-aos-delay="100">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Room Details & Specifications</h2>
                        </div>
                        <div id="accordion-collapse" data-accordion="collapse">
                            <h2 id="accordion-collapse-heading-1">
                                <button type="button"
                                    class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-900 border-t border-gray-200 hover:bg-gray-100 gap-3"
                                    data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                                    aria-controls="accordion-collapse-body-1">
                                    <span class="flex items-center gap-3 text-lg"><i
                                            class="fas fa-bed text-orange-500"></i> Room Features</span>
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-collapse-body-1" class="hidden"
                                aria-labelledby="accordion-collapse-heading-1">
                                <div class="p-5 border-t border-gray-200">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <h4 class="font-semibold mb-3">Bedroom Amenities</h4>
                                            <ul class="space-y-2 text-gray-700">
                                                <li class="flex items-center gap-2"><i
                                                        class="fas fa-check text-green-500"></i>
                                                    {{ ucfirst($room->bed_type) }} bed</li>
                                                <li class="flex items-center gap-2"><i
                                                        class="fas fa-check text-green-500"></i> Built-in wardrobe</li>
                                                <li class="flex items-center gap-2"><i
                                                        class="fas fa-check text-green-500"></i> Study desk and chair</li>
                                                <li class="flex items-center gap-2"><i
                                                        class="fas fa-check text-green-500"></i> Air conditioning</li>
                                                <li class="flex items-center gap-2"><i
                                                        class="fas fa-check text-green-500"></i>
                                                    {{ ucfirst($room->bathroom_type) }} Bathroom</li>
                                            </ul>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold mb-3">Tech & Connectivity</h4>
                                            <ul class="space-y-2 text-gray-700">
                                                @forelse($room->amenities ?? [] as $amenity)
                                                    <li class="flex items-center gap-2"><i
                                                            class="fas fa-check text-green-500"></i> {{ $amenity }}
                                                    </li>
                                                @empty
                                                    <li class="flex items-center gap-2 text-gray-400"><i
                                                            class="fas fa-times"></i> No specific tech amenities</li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($room->facilities && count($room->facilities) > 0)
                                <h2 id="accordion-collapse-heading-2">
                                    <button type="button"
                                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-900 border-t border-gray-200 hover:bg-gray-100 gap-3"
                                        data-accordion-target="#accordion-collapse-body-2" aria-expanded="false"
                                        aria-controls="accordion-collapse-body-2">
                                        <span class="flex items-center gap-3 text-lg"><i
                                                class="fas fa-utensils text-orange-500"></i> Common Facilities</span>
                                        <svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-2" class="hidden"
                                    aria-labelledby="accordion-collapse-heading-2">
                                    <div class="p-5 border-t border-gray-200">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach ($room->facilities as $facility)
                                                <div class="flex items-center gap-2"><i
                                                        class="fas fa-check text-green-500"></i> {{ $facility }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($room->house_rules || $room->cancellation_policy)
                                <h2 id="accordion-collapse-heading-3">
                                    <button type="button"
                                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-900 border-t border-gray-200 hover:bg-gray-100 gap-3"
                                        data-accordion-target="#accordion-collapse-body-3" aria-expanded="false"
                                        aria-controls="accordion-collapse-body-3">
                                        <span class="flex items-center gap-3 text-lg"><i
                                                class="fas fa-scroll text-orange-500"></i> Rules & Policies</span>
                                        <svg data-accordion-icon class="w-3 h-3 shrink-0" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M9 5 5 1 1 5" />
                                        </svg>
                                    </button>
                                </h2>
                                <div id="accordion-collapse-body-3" class="hidden"
                                    aria-labelledby="accordion-collapse-heading-3">
                                    <div class="p-5 border-t border-gray-200 space-y-4">
                                        @if (!empty($room->house_rules_view['lead']) || !empty($room->house_rules_view['items']))
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-2">House Rules</h4>

                                                @if (!empty($room->house_rules_view['lead']))
                                                    <p class="text-gray-700 text-[14px] leading-6 break-words whitespace-pre-line">
                                                        {{ $room->house_rules_view['lead'] }}
                                                    </p>
                                                @endif

                                                @if (!empty($room->house_rules_view['items']))
                                                    <ul class="mt-3 list-disc pl-5 space-y-1 text-gray-700 text-[14px] leading-6">
                                                        @foreach ($room->house_rules_view['items'] as $it)
                                                            <li class="break-words">{{ $it }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        @endif
                                        @if (!empty($room->cancellation_policy_view['lead']) || !empty($room->cancellation_policy_view['items']))
                                            <div>
                                                <h4 class="font-semibold text-gray-900 mb-2">Cancellation Policy</h4>

                                                @if (!empty($room->cancellation_policy_view['lead']))
                                                    <p class="text-gray-700 text-[14px] leading-6 break-words whitespace-pre-line">
                                                        {{ $room->cancellation_policy_view['lead'] }}
                                                    </p>
                                                @endif

                                                @if (!empty($room->cancellation_policy_view['items']))
                                                    <ul class="mt-3 list-disc pl-5 space-y-1 text-gray-700 text-[14px] leading-6">
                                                        @foreach ($room->cancellation_policy_view['items'] as $it)
                                                            <li class="break-words">{{ $it }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-32" data-aos="fade-left">
                        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow">
                            <div class="mb-4">
                                <span class="text-3xl font-extrabold text-orange-500">Rp
                                    {{ number_format($room->price_per_night, 0, ',', '.') }}</span>
                                <span class="text-base font-normal text-gray-500">/ night</span>
                            </div>
                            @if ($room->weekly_price || $room->monthly_price)
                                <div class="text-sm space-y-2 mb-4">
                                    @if ($room->weekly_price)
                                        <p><span class="font-medium text-gray-800">Weekly:</span> Rp
                                            {{ number_format($room->weekly_price, 0, ',', '.') }}</p>
                                    @endif
                                    @if ($room->monthly_price)
                                        <p><span class="font-medium text-gray-800">Monthly:</span> Rp
                                            {{ number_format($room->monthly_price, 0, ',', '.') }}</p>
                                    @endif
                                </div>
                            @endif
                            @guest
                            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4 text-center">
                                <i class="fas fa-lock text-orange-500 text-2xl mb-2"></i>

                                <h3 class="font-semibold text-gray-800">
                                    Login Required
                                </h3>

                                <p class="text-sm text-gray-600 mt-2">
                                    Please login first before booking this room.
                                </p>

                                <a href="{{ route('login') }}"
                                    class="mt-4 inline-block w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-3 rounded-lg">
                                    Login
                                </a>
                            </div>
                            @endguest

                            @auth
                            <form action="{{ route('coliving.book', $room->id) }}" method="POST" id="bookingForm"
                                class="space-y-4">
                                @csrf
                                <div>
                                    <label for="check_in_date"
                                        class="block mb-2 text-sm font-medium text-gray-900">Check-in Date</label>
                                    <input type="date" name="check_in_date" id="checkInDate"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5"
                                        required min="{{ date('Y-m-d') }}" />
                                </div>
                                <div>
                                    <label for="check_out_date"
                                        class="block mb-2 text-sm font-medium text-gray-900">Check-out Date</label>
                                    <input type="date" name="check_out_date" id="checkOutDate"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5"
                                        required min="{{ date('Y-m-d', strtotime('+1 day')) }}" />
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900">
                                        Full Name
                                    </label>

                                    <input type="text"
                                        value="{{ auth()->user()->name }}"
                                        readonly
                                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" />
                                </div>
                                <div>
                                    <label for="customer_email"
                                        class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                    <input
                                        type="email"
                                        value="{{ auth()->user()->email }}"
                                        readonly
                                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed">
                                </div>
                                <div>
                                    <label for="customer_phone" class="block mb-2 text-sm font-medium text-gray-900">Phone
                                        Number</label>
                                    <input type="tel" name="customer_phone" placeholder="+62 812-3456-7890"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5"
                                        required />
                                </div>
                                <div>
                                    <label for="special_requests"
                                        class="block mb-2 text-sm font-medium text-gray-900">Special Requests
                                        (Optional)</label>
                                    <textarea name="special_requests" rows="3"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-orange-500 focus:border-orange-500"
                                        placeholder="Any special requirements?"></textarea>
                                </div>

                                <div class="p-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                                    <i class="fas fa-info-circle mr-1"></i> You won't be charged yet. Payment will be
                                    processed after booking confirmation.
                                </div>
                                @guest
                                    <a href="{{ route('login') }}"
                                        class="w-full block text-center text-white bg-orange-600 hover:bg-orange-700 font-medium rounded-lg px-5 py-3">
                                        Login to Book
                                    </a>
                                @endguest

                                @auth
                                    @if(auth()->user()->hasRole('customer'))
                                        <button type="submit" id="bookingSubmitBtn"
                                            class="w-full text-white bg-orange-600 hover:bg-orange-700 font-medium rounded-lg px-5 py-3">
                                            Book Now
                                        </button>
                                    @else
                                        <button
                                            type="button"
                                            disabled
                                            class="w-full bg-gray-400 text-white rounded-lg px-5 py-3 cursor-not-allowed">
                                            Booking is for customer accounts only
                                        </button>
                                    @endif
                                @endauth
                                <p class="mt-2 text-xs text-gray-500 text-center"><i class="fas fa-shield-alt mr-1"></i>
                                    Secure booking - Your information is protected</p>
                            </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            @if ($similarRooms->count() > 0)
                <div class="mt-20" data-aos="fade-up">
                    <h2 class="text-3xl font-extrabold mb-8 text-center text-gray-900">Similar Rooms You Might Like</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($similarRooms as $similar)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-md group">
                                <a href="{{ route('coliving.show', $similar->id) }}" class="block overflow-hidden">
                                    <img class="rounded-t-lg group-hover:scale-105 transition-transform duration-300 w-full h-48 object-cover"
                                        src="{{ Storage::url($similar->thumbnail) ?: 'https://via.placeholder.com/400x225.png/fb923c/ffffff?text=Fountainhead' }}"
                                        alt="{{ $similar->name }}" />
                                </a>
                                <div class="p-5">
                                    <h3 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $similar->name }}
                                    </h3>
                                    <p class="mb-3 font-normal text-gray-700">{{ ucfirst($similar->room_type) }} Room</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-orange-500">Rp
                                            {{ number_format($similar->price_per_night, 0, ',', '.') }}</span>
                                        <a href="{{ route('coliving.show', $similar->id) }}"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-orange-600 rounded-lg hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // ✅ Show SweetAlert for Success/Error Messages
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#ea580c',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#ea580c',
                    footer: '<a href="{{ route('coliving.index') }}">Browse other available rooms</a>'
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: '<ul style="text-align: left;">' +
                        @foreach ($errors->all() as $error)
                            '<li>{{ $error }}</li>' +
                        @endforeach
                    '</ul>',
                    confirmButtonColor: '#ea580c'
                });
            @endif

            // Date picker logic
            const checkInInput = document.getElementById('checkInDate');
            const checkOutInput = document.getElementById('checkOutDate');

            if (checkInInput && checkOutInput) {
                checkInInput.addEventListener('change', function() {
                    const checkInDate = new Date(this.value);
                    checkInDate.setDate(checkInDate.getDate() + 1);
                    const minCheckOutDate = checkInDate.toISOString().split('T')[0];
                    checkOutInput.setAttribute('min', minCheckOutDate);

                    if (checkOutInput.value && new Date(checkOutInput.value) <= new Date(this.value)) {
                        checkOutInput.value = minCheckOutDate;
                    }
                });

                // Trigger change if already has value
                if (checkInInput.value) {
                    checkInInput.dispatchEvent(new Event('change'));
                }
            }

            // Form submission handler with loading state
            const bookingForm = document.getElementById('bookingForm');
            if (bookingForm) {
                bookingForm.addEventListener('submit', function(e) {
                    const btn = document.getElementById('bookingSubmitBtn');
                    const btnText = document.getElementById('btnText');
                    const btnLoading = document.getElementById('btnLoading');

                    // Show loading state
                    btn.disabled = true;
                    btnText.classList.add('hidden');
                    btnLoading.classList.remove('hidden');

                    console.log('Form submitted');
                    console.log('Action:', this.action);
                    console.log('Method:', this.method);
                });
            }
            // Image Carousel Potrait Or Landscape
            const images = document.querySelectorAll('.carousel-image');
            // Fungsi untuk mengatur object fit
            const adjustImageFit = (img) => {
                img.classList.remove('object-cover', 'object-contain', 'w-full', 'h-full', 'w-auto');

                const portrait = img.naturalHeight > img.naturalWidth;

                if (portrait) {
                    img.classList.add('h-full', 'w-auto', 'object-contain');
                } else {
                    img.classList.add('w-full', 'h-full', 'object-cover');
                }
            };
            images.forEach(img => {
                // Cek apakah gambar sudah selesai dimuat (untuk thumbnail/cached image)
                if (img.complete) {
                    adjustImageFit(img);
                } else {
                    // Jika belum, tunggu event onload
                    img.onload = function() {
                        adjustImageFit(this);
                    };
                }
            });
        });

        // Share function
        function sharePage() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ addslashes($room->name) }}',
                    text: 'Check out this amazing coliving room at Fountainhead!',
                    url: window.location.href
                }).catch(console.error);
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Link Copied!',
                        text: 'The room link has been copied to your clipboard.',
                        timer: 2000,
                        showConfirmButton: false,
                    });
                });
            }
        }
    </script>
@endsection
