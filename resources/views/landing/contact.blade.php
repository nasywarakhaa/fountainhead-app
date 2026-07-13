@extends('layouts.landing')

@section('title', 'Contact Us')

@section('content')

    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-orange-50 via-amber-50 to-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
                <h1 class="text-5xl md:text-6xl font-extrabold text-gray-800 mb-6">Get In Touch</h1>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>
        </div>

        {{-- Decorative elements --}}
        <div class="absolute top-20 left-10 w-20 h-20 bg-orange-200 rounded-full opacity-20 blur-xl"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-amber-200 rounded-full opacity-20 blur-xl"></div>
    </section>

    {{-- Contact Info & Form Section --}}
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid lg:grid-cols-5 gap-8">
                    {{-- Contact Information --}}
                    <div class="lg:col-span-2" data-aos="fade-right">
                        <div class="bg-gradient-to-br from-orange-500 to-amber-600 rounded-3xl p-8 text-white h-full">
                            <h2 class="text-3xl font-bold mb-6">Contact Information</h2>
                            <p class="text-white/90 mb-8">
                                Fill out the form and our team will get back to you within 24 hours.
                            </p>

                            <div class="space-y-6">
                                {{-- Phone --}}
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-phone text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold mb-1">Phone</div>
                                        <a href="tel:+6281511730175" class="text-white/90 hover:text-white transition">
                                            +62 8151-1730-175
                                        </a>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-envelope text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold mb-1">Email</div>
                                        <a href="mailto:{{ $settings['contact_email'] ?? 'hello@fountainhead.id' }}" class="text-white/90 hover:text-white transition">
                                            {{ $settings['contact_email'] ?? 'hello@fountainhead.id' }}
                                        </a>
                                    </div>
                                </div>

                                {{-- Address --}}
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-map-marker-alt text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold mb-1">Address</div>
                                        <p class="text-white/90">
                                            {{ $settings['address'] ?? 'RT.2/RW.10, North Meruya, Kembangan,West Jakarta City, Jakarta 11620' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Working Hours --}}
                                <div class="flex items-start">
                                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                                        <i class="fas fa-clock text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold mb-1">Working Hours</div>
                                        <p class="text-white/90">
                                            {{ $settings['working_hours'] ?? 'Monday - Sunday : 9am - 9pm' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Social Media --}}
                            <div class="mt-8 pt-8 border-t border-white/20">
                                <div class="font-semibold mb-4">Follow Us</div>
                                <div class="flex gap-3">
                                    {{-- <a href="#" class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition">
                                        <i class="fab fa-facebook-f"></i>
                                    </a> --}}
                                    <!-- Instagram -->
                                    <div class="relative group">
                                        <a href="{{ $settings['instagram_url'] ?? 'https://www.instagram.com/fountainhead.co' }}"
                                        class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition"
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
                                        class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition"
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
                                        class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition"
                                        target="_blank">
                                            <i class="fab fa-tiktok"></i>
                                        </a>
                                        <span class="absolute bottom-full mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded px-2 py-1 whitespace-nowrap">
                                            @fountainhead.coliving
                                        </span>
                                    </div>
                                    {{-- <a href="#" class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition">
                                        <i class="fab fa-twitter"></i>
                                    </a> --}}
                                    {{-- <a href="#" class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Form --}}
                    <div class="lg:col-span-3" data-aos="fade-left">
                        <div class="bg-white rounded-3xl shadow-2xl p-8">
                            <h2 class="text-3xl font-bold text-gray-800 mb-2">Send us a Message</h2>
                            <p class="text-gray-600 mb-8">We'll get back to you as soon as possible</p>

                            {{-- Success Message --}}
                            @if(session('success'))
                            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg" data-aos="fade-down">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                                    <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                                </div>
                            </div>
                            @endif

                            {{-- Error Messages --}}
                            @if($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg" data-aos="fade-down">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-0.5"></i>
                                    <div>
                                        <p class="text-red-700 font-semibold mb-2">Please fix the following errors:</p>
                                        <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                                            @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                                @csrf

                                <div class="grid md:grid-cols-2 gap-6 mb-6">
                                    {{-- Name --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-user text-orange-500 mr-1"></i>Full Name *
                                        </label>
                                        <input type="text"
                                               name="name"
                                               required
                                               value="{{ old('name') }}"
                                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('name') border-red-500 @enderror"
                                               placeholder="John Doe">
                                        @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-envelope text-orange-500 mr-1"></i>Email Address *
                                        </label>
                                        <input type="email"
                                               name="email"
                                               required
                                               value="{{ old('email') }}"
                                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('email') border-red-500 @enderror"
                                               placeholder="john@example.com">
                                        @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6 mb-6">
                                    {{-- Phone --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-phone text-orange-500 mr-1"></i>Phone Number
                                        </label>
                                        <input type="tel"
                                               name="phone"
                                               value="{{ old('phone') }}"
                                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('phone') border-red-500 @enderror"
                                               placeholder="+62 812-3456-7890">
                                        @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Subject --}}
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-tag text-orange-500 mr-1"></i>Subject *
                                        </label>
                                        <input type="text"
                                               name="subject"
                                               required
                                               value="{{ old('subject') }}"
                                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none @error('subject') border-red-500 @enderror"
                                               placeholder="What is this about?">
                                        @error('subject')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Message --}}
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-comment text-orange-500 mr-1"></i>Message *
                                    </label>
                                    <textarea name="message"
                                              required
                                              rows="6"
                                              class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition outline-none resize-none @error('message') border-red-500 @enderror"
                                              placeholder="Tell us more about your inquiry...">{{ old('message') }}</textarea>
                                    @error('message')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Submit Button --}}
                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-orange-500 to-amber-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:from-orange-600 hover:to-amber-600 transition-all shadow-lg hover:shadow-xl">
                                    <i class="fas fa-paper-plane mr-2"></i>Send Message
                                </button>

                                <p class="text-center text-sm text-gray-600 mt-4">
                                    We typically respond within 24 hours
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Map Section --}}
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12" data-aos="fade-up">
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">Find Us Here</h2>
                    <p class="text-gray-600">Visit our location and experience our community firsthand</p>
                </div>

                <div class="rounded-3xl overflow-hidden shadow-2xl" data-aos="fade-up" data-aos-delay="100">
                    {{-- Replace this with your actual Google Maps embed --}}
                    <div class="bg-gray-200 h-96 flex items-center justify-center">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4978716988744!2d106.72625337499021!3d-6.197853193789843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f74bf5e5b4f7%3A0x7bcd758a5dc4e6ad!2sFountainhead%20Cafe%20%26%20Co-Living!5e0!3m2!1sid!2sid!4v1763885910148!5m2!1sid!2sid"                             width="100%"
                            height="384"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="w-full h-96">
                    </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ Section --}}
    @if($faqs->count() > 0)
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12" data-aos="fade-up">
                    <span class="text-orange-500 font-semibold text-sm tracking-wider uppercase">FAQ</span>
                    <h2 class="text-4xl font-bold text-gray-800 mt-3 mb-4">Frequently Asked Questions</h2>
                    <p class="text-gray-600">Quick answers to common questions</p>
                </div>
                <div id="faq-accordion" data-accordion="collapse" data-accordion-flush>
                    @foreach($faqs as $faq)
                    <h2 id="faq-heading-{{ $loop->index }}"
                        data-aos="fade-up"
                        data-aos-delay="{{ $loop->index * 50 }}">
                        <button type="button"
                                class="flex items-center justify-between w-full px-6 py-5 font-semibold text-left text-gray-800 bg-white border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-900 dark:text-white dark:border-gray-700 rounded-t-2xl"
                                data-accordion-target="#faq-content-{{ $loop->index }}"
                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                aria-controls="faq-content-{{ $loop->index }}">
                            <span>{{ $faq->question }}</span>
                            <svg data-accordion-icon class="w-6 h-6 text-orange-500 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </h2>
                    <div id="faq-content-{{ $loop->index }}"
                        class="{{ $loop->first ? '' : 'hidden' }} bg-white"
                        aria-labelledby="faq-heading-{{ $loop->index }}">
                        <div class="px-6 pb-5 text-gray-600 leading-relaxed dark:text-gray-400">
                            <p>{{ $faq->answer }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-br from-orange-500 to-amber-600 text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
                <h2 class="text-4xl font-bold mb-6">Still Have Questions?</h2>
                <p class="text-xl text-white/90 mb-8">
                    Our team is here to help. Reach out anytime and we'll get back to you shortly.
                </p>
                <div class="flex flex-wrap gap-4 justify-center">
                    <a href="https://wa.me/6281511730175"
                       target="_blank"
                       class="bg-white text-orange-500 px-8 py-4 rounded-xl font-semibold hover:bg-orange-50 transition-colors shadow-lg hover:shadow-xl">
                        <i class="fab fa-whatsapp mr-2"></i>Chat on WhatsApp
                    </a>
                    <a href="tel:+6281511730175"
                       class="bg-white/20 text-white border-2 border-white px-8 py-4 rounded-xl font-semibold hover:bg-white/30 transition-colors">
                        <i class="fas fa-phone mr-2"></i>Call Us Now
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    // FAQ Toggle
    function toggleFaq(button) {
        const content = button.nextElementSibling;
        const icon = button.querySelector('i');
        const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';

        // Close all FAQs
        document.querySelectorAll('.faq-content').forEach(item => {
            item.style.maxHeight = '0px';
        });
        document.querySelectorAll('.faq-toggle i').forEach(item => {
            item.style.transform = 'rotate(0deg)';
        });

        // Open clicked FAQ if it was closed
        if (!isOpen) {
            content.style.maxHeight = content.scrollHeight + 'px';
            icon.style.transform = 'rotate(180deg)';
        }
    }

    // Form validation
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
    });

    // Auto-hide success message after 5 seconds
    @if(session('success'))
    setTimeout(function() {
        const successAlert = document.querySelector('.bg-green-50');
        if (successAlert) {
            successAlert.style.transition = 'opacity 0.5s';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }
    }, 5000);
    @endif
</script>
@endsection
