@php
    $venuePrice = 1000000;

    $servicePrices = [
        'catering' => 150000,
        'av_equipment' => 200000,
        'decoration' => 300000,
        'photographer' => 500000,
    ];
@endphp

<style>
.service-card{
    transition:.3s;
}

.service-card.active{
    border-color:#f59e0b;
    background:#fffbeb;
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(245,158,11,.15);
}
</style>


    {{-- Booking Form Section --}}
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                    {{-- Form Header --}}
                    <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-8 text-white">
                        <h2 class="text-3xl font-bold mb-2">Event Booking Form</h2>
                        <p class="text-amber-100">Fill in the details below to reserve our space for your event</p>
                    </div>

                    <form action="{{ route('cafe.store-booking') }}" method="POST" class="p-8" id="bookingForm">
                        @csrf
                        {{-- Contact Information --}}
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center mr-3 text-sm">1</div>
                                Contact Information
                            </h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-user text-amber-500 mr-1"></i>Full Name *
                                    </label>
                                    <input type="text" name="customer_name" required
                                        value="{{ old('customer_name') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none"
                                        placeholder="John Doe">
                                    @error('customer_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-envelope text-amber-500 mr-1"></i>Email Address *
                                    </label>
                                    <input type="email" name="customer_email" required
                                        value="{{ old('customer_email') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none"
                                        placeholder="john@example.com">
                                    @error('customer_email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-phone text-amber-500 mr-1"></i>Phone Number *
                                    </label>
                                    <input type="tel" name="customer_phone" required
                                        value="{{ old('customer_phone') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none"
                                        placeholder="+62 812-3456-7890">
                                    @error('customer_phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-building text-amber-500 mr-1"></i>Organization Name
                                    </label>
                                    <input type="text" name="organization_name"
                                        value="{{ old('organization_name') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none"
                                        placeholder="Your company/organization (optional)">
                                </div>
                            </div>
                        </div>

                        {{-- Event Details --}}
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center mr-3 text-sm">2</div>
                                Event Details
                            </h3>
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-star text-amber-500 mr-1"></i>Event Name *
                                    </label>
                                    <input type="text" name="event_name" required
                                        value="{{ old('event_name') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none"
                                        placeholder="e.g., Birthday Party, Workshop">
                                    @error('event_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- ### PERUBAHAN 1: EVENT TYPE DISESUAIKAN MIGRATION ### --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-tag text-amber-500 mr-1"></i>Event Type *
                                    </label>
                                    <select name="event_type" required
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none">
                                        <option value="">Select event type</option>
                                        <option value="birthday" {{ old('event_type') == 'birthday' ? 'selected' : '' }}>Birthday</option>
                                        <option value="meeting" {{ old('event_type') == 'meeting' ? 'selected' : '' }}>Meeting</option>
                                        <option value="workshop" {{ old('event_type') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                                        <option value="party" {{ old('event_type') == 'party' ? 'selected' : '' }}>Party</option>
                                        <option value="wedding" {{ old('event_type') == 'wedding' ? 'selected' : '' }}>Wedding</option>
                                        <option value="corporate" {{ old('event_type') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                        <option value="other" {{ old('event_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('event_type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-align-left text-amber-500 mr-1"></i>Event Description
                                    </label>
                                    <textarea name="event_description" rows="3"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none"
                                        placeholder="Tell us more about your event...">{{ old('event_description') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-users text-amber-500 mr-1"></i>Expected Guests *
                                    </label>
                                    <input type="number" name="expected_guests" required min="1" max="100"
                                        value="{{ old('expected_guests') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none"
                                        placeholder="e.g., 50">
                                    @error('expected_guests')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- ### PERUBAHAN 2: SPACE TYPE DISESUAIKAN MIGRATION (data-price dihapus) ### --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-door-open text-amber-500 mr-1"></i>Space Type *
                                    </label>
                                    <select name="space_type" required id="spaceType"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none">
                                        <option value="indoor" {{ old('space_type') == 'indoor' ? 'selected' : '' }}>Indoor</option>
                                        <option value="outdoor" {{ old('space_type') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                                        <option value="both" {{ old('space_type') == 'both' ? 'selected' : '' }}>Both</option>
                                    </select>
                                    @error('space_type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Date & Time --}}
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center mr-3 text-sm">3</div>
                                Schedule
                            </h3>
                            <div class="grid md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-calendar text-amber-500 mr-1"></i>Event Date *
                                    </label>
                                    <input type="date" name="event_date" required id="eventDate"
                                        value="{{ old('event_date') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none">
                                    @error('event_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-clock text-amber-500 mr-1"></i>Start Time *
                                    </label>
                                    <input type="time" name="start_time" required id="startTime"
                                        value="{{ old('start_time') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none">
                                    @error('start_time')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-clock text-amber-500 mr-1"></i>End Time *
                                    </label>
                                    <input type="time" name="end_time" required id="endTime"
                                        value="{{ old('end_time') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none">
                                    @error('end_time')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2">
                                <i class="fas fa-info-circle text-amber-500 mr-1"></i>
                                Operating hours: 08:00 - 22:00
                            </p>
                        </div>

                        {{-- Additional Services --}}
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div
                                    class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center mr-3 text-sm">
                                    4
                                </div>
                                Additional Services
                            </h3>

                            <div class="grid md:grid-cols-2 gap-4">

                                {{-- Catering --}}
                                <label
                                    class="service-card flex items-start p-5 border-2 border-gray-200 rounded-2xl cursor-pointer transition-all duration-300 hover:border-amber-400 hover:shadow-md">

                                    <input
                                        type="checkbox"
                                        name="additional_services[]"
                                        value="catering"
                                        data-price="{{ $servicePrices['catering'] }}"
                                        data-name="Catering Package"
                                        class="service-checkbox mt-1 mr-3 w-5 h-5 text-amber-500 rounded focus:ring-amber-500">

                                    <div class="w-full">

                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-gray-800">
                                                Catering Package
                                            </div>

                                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">
                                                + Rp {{ number_format($servicePrices['catering'],0,',','.') }}
                                            </span>
                                        </div>

                                        <div class="text-xs text-gray-500 mt-1">
                                            Includes snacks & beverages
                                        </div>

                                    </div>

                                </label>

                                {{-- AV --}}
                                <label
                                    class="service-card flex items-start p-5 border-2 border-gray-200 rounded-2xl cursor-pointer transition-all duration-300 hover:border-amber-400 hover:shadow-md">

                                    <input
                                        type="checkbox"
                                        name="additional_services[]"
                                        value="av_equipment"
                                        data-price="{{ $servicePrices['av_equipment'] }}"
                                        data-name="AV Equipment"
                                        class="service-checkbox mt-1 mr-3 w-5 h-5 text-amber-500 rounded focus:ring-amber-500">

                                    <div class="w-full">

                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-gray-800">
                                                AV Equipment
                                            </div>

                                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">
                                                + Rp {{ number_format($servicePrices['av_equipment'],0,',','.') }}
                                            </span>
                                        </div>

                                        <div class="text-xs text-gray-500 mt-1">
                                            Projector, sound system, mic
                                        </div>

                                    </div>

                                </label>

                                {{-- Decoration --}}
                                <label
                                    class="service-card flex items-start p-5 border-2 border-gray-200 rounded-2xl cursor-pointer transition-all duration-300 hover:border-amber-400 hover:shadow-md">

                                    <input
                                        type="checkbox"
                                        name="additional_services[]"
                                        value="decoration"
                                        data-price="{{ $servicePrices['decoration'] }}"
                                        data-name="Decoration"
                                        class="service-checkbox mt-1 mr-3 w-5 h-5 text-amber-500 rounded focus:ring-amber-500">

                                    <div class="w-full">

                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-gray-800">
                                                Decoration
                                            </div>

                                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">
                                                + Rp {{ number_format($servicePrices['decoration'],0,',','.') }}
                                            </span>
                                        </div>

                                        <div class="text-xs text-gray-500 mt-1">
                                            Basic event decoration
                                        </div>

                                    </div>

                                </label>

                                {{-- Photography --}}
                                <label
                                    class="service-card flex items-start p-5 border-2 border-gray-200 rounded-2xl cursor-pointer transition-all duration-300 hover:border-amber-400 hover:shadow-md">

                                    <input
                                        type="checkbox"
                                        name="additional_services[]"
                                        value="photographer"
                                        data-price="{{ $servicePrices['photographer'] }}"
                                        data-name="Photography"
                                        class="service-checkbox mt-1 mr-3 w-5 h-5 text-amber-500 rounded focus:ring-amber-500">

                                    <div class="w-full">

                                        <div class="flex justify-between items-center">
                                            <div class="font-semibold text-gray-800">
                                                Photography
                                            </div>

                                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1 rounded-full">
                                                + Rp {{ number_format($servicePrices['photographer'],0,',','.') }}
                                            </span>
                                        </div>

                                        <div class="text-xs text-gray-500 mt-1">
                                            Professional event photographer
                                        </div>

                                    </div>

                                </label>

                            </div>
                        </div>

                        {{-- Special Requirements --}}
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center mr-3 text-sm">5</div>
                                Special Requirements
                            </h3>
                            <textarea name="special_requirements" rows="4"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition outline-none"
                                placeholder="Any special requests or requirements for your event? (dietary restrictions, accessibility needs, etc.)">{{ old('special_requirements') }}</textarea>
                        </div>

                        {{-- ### PERUBAHAN 3: PRICE SUMMARY DIHAPUS ### --}}
                        {{-- Blok ini dihapus karena kalkulasi pindah ke backend --}}
                        {{-- Booking Summary --}}
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <div class="w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center mr-3 text-sm">
                                    6
                                </div>
                                Booking Summary
                            </h3>

                            <div class="bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 rounded-2xl p-6">

                                <div class="flex justify-between items-centermb-2">
                                    <span class="text-gray-700 font-medium mb-4">
                                        Venue Booking
                                    </span>

                                    <span class="font-semibold">
                                        Rp {{ number_format($venuePrice,0,',','.') }}
                                    </span>
                                </div>

                                <div id="selectedServices"></div>

                                <hr class="my-5">

                                <div class="flex justify-between items-center mt-2">

                                    <span class="text-xl font-bold">
                                        Total
                                    </span>

                                    <span
                                        id="totalPrice"
                                        class="text-xl font-bold text-amber-600">

                                        Rp {{ number_format($venuePrice,0,',','.') }}

                                    </span>

                                </div>

                                <div class="flex justify-between items-center">

                                    <span class="text-gray-600">
                                        Down Payment (50%)
                                    </span>

                                    <span
                                        id="dpPrice"
                                        class="text-lg font-medium text-green-600">

                                        Rp {{ number_format($venuePrice/2,0,',','.') }}

                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- Terms & Submit --}}
                        <div class="mb-6">
                            <label class="flex items-start">
                                <input type="checkbox" required class="mt-1 mr-3 w-5 h-5 text-amber-500 rounded focus:ring-amber-500">
                                <span class="text-sm text-gray-700">
                                    I agree to the <a href="#" class="text-amber-500 hover:underline">terms and conditions</a>
                                    and understand that a 50% down payment is required to confirm the booking.
                                </span>
                            </label>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white px-8 py-4 rounded-xl font-bold text-lg hover:from-amber-600 hover:to-orange-600 transition-all shadow-lg hover:shadow-xl">
                            <i class="fas fa-calendar-check mr-2"></i>Submit Booking Request
                        </button>

                        <p class="text-center text-sm text-gray-600 mt-4">
                            Your booking will be confirmed after admin approval and down payment
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    {{-- End Booking Form Section --}}


    
<script>
    const venuePrice = {{ $venuePrice }};

    const checkboxes = document.querySelectorAll('.service-checkbox');
    const selectedServices = document.getElementById('selectedServices');
    const totalPrice = document.getElementById('totalPrice');
    const dpPrice = document.getElementById('dpPrice');

    function rupiah(number) {
        return "Rp " + number.toLocaleString("id-ID");
    }

    function updatePrice() {

        let total = venuePrice;

        selectedServices.innerHTML = "";

        checkboxes.forEach(item => {

            const card = item.closest('.service-card');

            if (item.checked) {

                card.classList.add('active');

                const price = Number(item.dataset.price);

                total += price;

                selectedServices.innerHTML += `
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-700">${item.dataset.name}</span>
                        <span class="font-small">${rupiah(price)}</span>
                    </div>
                `;

            } else {

                card.classList.remove('active');

            }

        });

        totalPrice.textContent = rupiah(total);
        dpPrice.textContent = rupiah(total / 2);

    }

    checkboxes.forEach(item => {

        item.addEventListener('change', updatePrice);

    });

    updatePrice();
</script>