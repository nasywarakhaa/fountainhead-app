@extends('layouts.landing')

@section('title', 'Payment Successful')

@section('content')
    <section class="pt-32 pb-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <!-- Success Animation -->
                <div class="text-center mb-8" data-aos="zoom-in">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-4">
                        <i class="fas fa-check-circle text-5xl text-green-500"></i>
                    </div>
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Payment Successful!</h1>
                    <p class="text-gray-600 text-lg">Thank you for your booking at Fountainhead</p>
                </div>

                <!-- Booking Confirmation Card -->
                <div class="bg-white rounded-lg shadow-lg p-8 mb-6" data-aos="fade-up">
                    <div class="border-b pb-4 mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Booking Confirmed</h2>
                        <p class="text-gray-600">Your booking reference: <span
                                class="font-mono font-semibold text-orange-600">{{ $booking->booking_reference }}</span></p>
                    </div>

                    <!-- Room Details -->
                    <div class="flex gap-4 mb-6 pb-6 border-b">
                        <img src="{{ Storage::url($booking->colivingRoom->thumbnail) ?: 'https://via.placeholder.com/150' }}"
                            alt="{{ $booking->colivingRoom->name }}" class="w-32 h-32 rounded-lg object-cover">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $booking->colivingRoom->name }}</h3>
                            <p class="text-gray-600 mb-2">{{ ucfirst($booking->colivingRoom->room_type) }} Room</p>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-users"></i>
                                <span>Up to {{ $booking->colivingRoom->capacity }}
                                    guest{{ $booking->colivingRoom->capacity > 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Guest Name</p>
                            <p class="font-semibold text-gray-900">{{ $booking->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Email</p>
                            <p class="font-semibold text-gray-900">{{ $booking->customer_email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Phone</p>
                            <p class="font-semibold text-gray-900">{{ $booking->customer_phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Payment Status</p>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Paid
                            </span>
                        </div>
                    </div>

                    <!-- Stay Duration -->
                    <div class="bg-orange-50 rounded-lg p-4 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Check-in</p>
                                <p class="font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('l') }}</p>
                            </div>
                            <div class="flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-orange-600">{{ $booking->total_nights }}</p>
                                    <p class="text-sm text-gray-600">Night{{ $booking->total_nights > 1 ? 's' : '' }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Check-out</p>
                                <p class="font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('l') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="border-t pt-4">
                        <h3 class="font-semibold text-gray-900 mb-3">Payment Summary</h3>
                        <div class="space-y-2 mb-3">
                            <div class="flex justify-between text-gray-700">
                                <span>{{ $booking->total_nights }} night{{ $booking->total_nights > 1 ? 's' : '' }} × Rp
                                    {{ number_format($booking->price_per_night, 0, ',', '.') }}</span>
                                <span>Rp
                                    {{ number_format($booking->price_per_night * $booking->total_nights, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Service Fee</span>
                                <span>Rp 0</span>
                            </div>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-gray-900 pt-3 border-t">
                            <span>Total Paid</span>
                            <span class="text-orange-600">Rp
                                {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-blue-50 rounded-lg p-6 mb-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        What's Next?
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-calendar-check text-blue-500 mt-1"></i>
                            <span>Please arrive on your check-in date between 2:00 PM - 10:00 PM</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-id-card text-blue-500 mt-1"></i>
                            <span>Bring a valid ID for check-in verification</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-phone text-blue-500 mt-1"></i>
                            <span>Contact us at +62 8151-1730-175 if you have any questions</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('coliving.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-orange-600 text-orange-600 font-semibold rounded-lg hover:bg-orange-50 transition-colors duration-200">
                        <i class="fas fa-search mr-2"></i>
                        Browse More Rooms
                    </a>
                    <button onclick="window.print()"
                        class="inline-flex items-center justify-center px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition-colors duration-200">
                        <i class="fas fa-print mr-2"></i>
                        Print Confirmation
                    </button>
                </div>

                <!-- Support Contact -->
                <div class="text-center mt-8" data-aos="fade-up" data-aos-delay="300">
                    <p class="text-gray-600">Need help? <a href="https://wa.me/6281511730175"target="_blank"
                            class="text-orange-600 hover:text-orange-700 font-semibold">Contact Support</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Print Styles -->
    <style>
        @media print {

            nav,
            footer,
            button,
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .container {
                max-width: 100% !important;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show success animation
            Swal.fire({
                icon: 'success',
                title: 'Payment Successful!',
                text: 'Your booking has been confirmed.',
                confirmButtonColor: '#ea580c',
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>
@endsection
