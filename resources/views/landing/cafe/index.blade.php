@extends('layouts.landing')

@section('title', 'Book Cafe for Your Event')

@section('content')

    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-amber-50 to-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12" data-aos="fade-up">
                <h1 class="text-5xl font-extrabold text-gray-800 mb-4">Host Your Perfect Event</h1>
                <p class="text-xl text-gray-600">Transform our cafe into your dream event space</p>
            </div>

            {{-- Event Highlights --}}
            <div class="max-w-4xl mx-auto grid md:grid-cols-3 gap-6 mb-12" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-2xl p-6 shadow-lg text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-amber-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Up to 100 Guests</h3>
                    <p class="text-sm text-gray-600">Spacious venue for all event sizes</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-coffee text-amber-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Premium Catering</h3>
                    <p class="text-sm text-gray-600">Delicious food & beverage options</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-lg text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-wifi text-amber-600 text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Full Facilities</h3>
                    <p class="text-sm text-gray-600">WiFi, AV equipment & more</p>
                </div>
            </div>
        </div>
    </section>
    @auth

        @include('landing.cafe.partials.booking-form')

    @endauth

    @guest

    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">

            <div class="max-w-3xl mx-auto bg-white border border-gray-200 rounded-3xl shadow-lg p-10 text-center">

                <div class="w-20 h-20 mx-auto rounded-full bg-orange-100 flex items-center justify-center mb-6">
                    <i class="fas fa-lock text-3xl text-orange-500"></i>
                </div>

                <h2 class="text-3xl font-bold text-gray-800 mb-3">
                    Login Required
                </h2>

                <p class="text-gray-500 mb-8">
                    Please login to reserve our cafe for your event.
                </p>

                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-xl font-semibold transition">

                    <i class="fas fa-sign-in-alt"></i>
                    Login to Book Event

                </a>

            </div>

        </div>
    </section>

    @endguest
    {{-- Why Choose Us --}}
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Why Choose Our Venue?</h2>
            <div class="grid md:grid-cols-4 gap-8 max-w-5xl mx-auto">
                <div class="text-center" data-aos="fade-up">
                    <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-amber-600 text-3xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Prime Location</h3>
                    <p class="text-sm text-gray-600">Easy access & ample parking</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-utensils text-amber-600 text-3xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Quality Catering</h3>
                    <p class="text-sm text-gray-600">Fresh & delicious menu options</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-amber-600 text-3xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Dedicated Support</h3>
                    <p class="text-sm text-gray-600">Professional event assistance</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-amber-600 text-3xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-2">Flexible Terms</h3>
                    <p class="text-sm text-gray-600">Customizable packages</p>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        const eventDateInput = document.getElementById('eventDate');
        if (eventDateInput) {
            eventDateInput.setAttribute('min', today);
        }

        // Client-side time validation
        const startTime = document.getElementById('startTime');
        const endTime = document.getElementById('endTime');

        if (endTime) {
            endTime.addEventListener('change', function() {
                if (startTime.value && endTime.value) {
                    if (endTime.value <= startTime.value) {

                        // ### INI PERUBAHANNYA: alert() diganti swal() ###
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Time',
                            text: 'End time must be after start time',
                            confirmButtonColor: '#ea580c'
                        });
                        endTime.value = ''; // Kosongkan field yang salah
                    }
                }
            });
        }


        // --- Bagian untuk menampilkan error dari Server (setelah 302) ---

        // 1. Tampilkan error validasi otomatis (misal 'end_time' salah)
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops... Validation Failed',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#ea580c'
            });

        // 2. Tampilkan error custom (misal 'Slot tidak tersedia')
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ea580c'
            });

        // 3. Tampilkan pesan sukses (jika ada)
        @elseif (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#ea580c',
                timer: 3000
            });
        @endif

    });
</script>
@endsection
