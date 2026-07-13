@extends('layouts.landing')

@section('title', 'About Us')

@section('content')

    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-orange-50 via-amber-50 to-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
                <h1 class="text-5xl md:text-6xl font-extrabold text-gray-800 mb-6">About Us</h1>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Creating a vibrant community where living, working, and connecting come together seamlessly
                </p>
            </div>
        </div>

        {{-- Decorative elements --}}
        <div class="absolute top-20 left-10 w-20 h-20 bg-orange-200 rounded-full opacity-20 blur-xl"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-amber-200 rounded-full opacity-20 blur-xl"></div>
    </section>

    {{-- Our Story Section --}}
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div data-aos="fade-right">
                        <div class="relative">
                            <div class="absolute -top-6 -left-6 w-full h-full bg-orange-100 rounded-3xl"></div>
                            <img src="{{ asset('images/about-story.jpg') }}"
                                 alt="Our Story"
                                 class="relative rounded-3xl shadow-2xl w-full h-96 object-cover"
                                 onerror="this.src='https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800'">
                        </div>
                    </div>
                    <div data-aos="fade-left">
                        <span class="text-orange-500 font-semibold text-sm tracking-wider uppercase">Our Story</span>
                        <h2 class="text-4xl font-bold text-gray-800 mt-3 mb-6">Building More Than Just Spaces</h2>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Founded with a vision to revolutionize modern living, we started our journey with a simple belief:
                            that the best ideas emerge when people from diverse backgrounds come together in inspiring spaces.
                        </p>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            What began as a small coliving space has grown into a thriving community hub, where residents
                            don't just share spaces—they share experiences, ideas, and dreams.
                        </p>
                        <p class="text-gray-600 leading-relaxed">
                            Today, we're proud to offer premium coliving accommodations and a vibrant cafe space that
                            hosts workshops, events, and gatherings that bring our community closer together.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission & Vision --}}
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-white rounded-3xl p-8 shadow-lg" data-aos="fade-up">
                        <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-bullseye text-orange-500 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Mission</h3>
                        <p class="text-gray-600 leading-relaxed">
                            To create affordable, comfortable, and inspiring living spaces that foster meaningful
                            connections and enable individuals to thrive personally and professionally. We're committed
                            to building a sustainable community where everyone feels welcome and valued.
                        </p>
                    </div>
                    <div class="bg-white rounded-3xl p-8 shadow-lg" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-eye text-amber-500 text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Our Vision</h3>
                        <p class="text-gray-600 leading-relaxed">
                            To be the leading coliving and community space provider, recognized for creating
                            environments that inspire innovation, collaboration, and personal growth. We envision
                            a future where community-centered living is the norm, not the exception.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Core Values --}}
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-orange-500 font-semibold text-sm tracking-wider uppercase">What We Stand For</span>
                    <h2 class="text-4xl font-bold text-gray-800 mt-3 mb-4">Our Core Values</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        The principles that guide everything we do and shape our community culture
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center" data-aos="fade-up" data-aos-delay="0">
                        <div class="w-20 h-20 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-users text-orange-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Community First</h3>
                        <p class="text-gray-600">
                            We believe in the power of community and prioritize creating connections that enrich lives
                        </p>
                    </div>
                    <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-20 h-20 bg-gradient-to-br from-amber-100 to-amber-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-heart text-amber-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Inclusivity</h3>
                        <p class="text-gray-600">
                            Everyone is welcome here. We celebrate diversity and create spaces where all feel at home
                        </p>
                    </div>
                    <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-leaf text-green-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Sustainability</h3>
                        <p class="text-gray-600">
                            We're committed to eco-friendly practices and responsible resource management
                        </p>
                    </div>
                    <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-lightbulb text-blue-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Innovation</h3>
                        <p class="text-gray-600">
                            We constantly evolve and improve to provide the best living and working experiences
                        </p>
                    </div>
                    <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-shield-alt text-purple-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Integrity</h3>
                        <p class="text-gray-600">
                            We operate with transparency, honesty, and respect in all our interactions
                        </p>
                    </div>
                    <div class="text-center" data-aos="fade-up" data-aos-delay="500">
                        <div class="w-20 h-20 bg-gradient-to-br from-pink-100 to-pink-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-star text-pink-600 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Excellence</h3>
                        <p class="text-gray-600">
                            We strive for excellence in every detail, from amenities to customer service
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    @if($features->count() > 0)
    <section class="py-20 bg-gradient-to-br from-orange-50 to-amber-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-orange-500 font-semibold text-sm tracking-wider uppercase">What We Offer</span>
                    <h2 class="text-4xl font-bold text-gray-800 mt-3 mb-4">Premium Amenities & Features</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Everything you need for comfortable living and productive working
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($features as $feature)
                    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all hover:-translate-y-2"
                         data-aos="fade-up"
                         data-aos-delay="{{ $loop->index * 50 }}">
                        @if($feature->icon)
                        <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                            <i class="{{ $feature->icon }} text-orange-500 text-2xl"></i>
                        </div>
                        @endif
                        <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $feature->title }}</h3>
                        @if($feature->description)
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $feature->description }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Gallery Section --}}
    @if($galleries->count() > 0)
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-orange-500 font-semibold text-sm tracking-wider uppercase">Take A Look</span>
                    <h2 class="text-4xl font-bold text-gray-800 mt-3 mb-4">Our Spaces</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Explore our thoughtfully designed spaces that inspire and connect
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($galleries as $gallery)
                    <div class="relative group overflow-hidden rounded-2xl aspect-square"
                         data-aos="fade-up"
                         data-aos-delay="{{ $loop->index * 50 }}">
                        <img src="{{ Storage::url($gallery->image) }}"
                             alt="{{ $gallery->title }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h4 class="text-white font-semibold">{{ $gallery->title }}</h4>
                                @if($gallery->description)
                                <p class="text-white/80 text-sm">{{ $gallery->description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
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
    {{-- CTA Section --}}
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
                <h2 class="text-4xl font-bold text-gray-800 mb-6">Ready to Join Our Community?</h2>
                <p class="text-xl text-gray-600 mb-8">
                    Discover the perfect space for you. Start your journey with us today.
                </p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="{{ route('coliving.index') }}"
                       class="bg-orange-500 text-white px-8 py-4 rounded-xl font-semibold hover:bg-orange-600 transition-colors shadow-lg hover:shadow-xl">
                        <i class="fas fa-home mr-2"></i>Explore Rooms
                    </a>
                    <a href="{{ route('cafe.book-event') }}"
                       class="bg-white text-orange-500 border-2 border-orange-500 px-8 py-4 rounded-xl font-semibold hover:bg-orange-50 transition-colors">
                        <i class="fas fa-calendar mr-2"></i>Book Event Space
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
