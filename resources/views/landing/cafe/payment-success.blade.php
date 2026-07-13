@extends('layouts.landing')

@section('title', 'Payment Successful')
@section('styles')
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

@section('content')
    <section class="pt-32 pb-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-8" data-aos="zoom-in">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-4">
                        <i class="fas fa-check-circle text-5xl text-green-500"></i>
                    </div>
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Down Payment Received!</h1>
                    <p class="text-gray-600 text-lg">Thank you for your booking at Fountainhead Cafe</p>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8 mb-6" data-aos="fade-up">
                    <div class="border-b pb-4 mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Booking Confirmed</h2>
                        <p class="text-gray-600">Your booking reference:
                            <span class="font-mono font-semibold text-orange-600">{{ $booking->booking_reference }}</span>
                        </p>
                    </div>

                    <div class="flex gap-4 mb-6 pb-6 border-b">
                        <div class="w-32 h-32 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar-alt text-6xl text-orange-500"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $booking->event_name }}</h3>
                            <p class="text-gray-600 mb-2">{{ ucfirst($booking->event_type) }} Event</p>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-users"></i>
                                <span>Up to {{ $booking->expected_guests }}
                                    guest{{ $booking->expected_guests > 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                    </div>

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
                                <i class="fas fa-check-circle mr-1"></i>
                                DP Paid (50%)
                            </span>
                        </div>
                    </div>

                    <div class="bg-orange-50 rounded-lg p-4 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Event Start</p>
                                <p class="font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->event_date . ' ' . $booking->start_time)->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                                </p>
                            </div>
                            <div class="flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-orange-600">{{ $booking->duration_hours }}</p>
                                    <p class="text-sm text-gray-600">Hour{{ $booking->duration_hours > 1 ? 's' : '' }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Event End</p>
                                <p class="font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->event_date . ' ' . $booking->end_time)->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h3 class="font-semibold text-gray-900 mb-3">Payment Summary</h3>
                        <div class="space-y-2 mb-3">
                            <div class="flex justify-between text-gray-700">
                                <span>Venue Price ({{ $booking->duration_hours }} hr)</span>
                                <span>Rp {{ number_format($booking->venue_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Additional Services</span>
                                <span>Rp {{ number_format($booking->services_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Tax (11%)</span>
                                <span>Rp {{ number_format($booking->tax, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-900 font-semibold pt-2 border-t">
                                <span>Total Amount</span>
                                <span>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- ✅ TAMPILKAN DP YANG SUDAH DIBAYAR --}}
                        <div class="bg-green-50 rounded-lg p-4 mb-3">
                            <div class="flex justify-between text-lg font-bold text-gray-900">
                                <span><i class="fas fa-check-circle text-green-600 mr-2"></i>DP Paid (50%)</span>
                                <span class="text-green-600">Rp
                                    {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- ✅ TAMPILKAN REMAINING YANG HARUS DIBAYAR OFFLINE --}}
                        <div class="bg-yellow-50 border-2 border-yellow-300 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-lg font-bold text-gray-900">
                                    <i class="fas fa-store text-yellow-600 mr-2"></i>Remaining Payment (50%)
                                </span>
                                <span class="text-2xl font-bold text-yellow-700">
                                    Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}
                                </span>
                            </div>
                            <p class="text-sm text-yellow-800 flex items-start gap-2 mt-2">
                                <i class="fas fa-exclamation-triangle mt-0.5"></i>
                                <span><strong>Important:</strong> Please pay the remaining 50% at our cafe location on the
                                    event day.</span>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ✅ INFO CARD --}}
                <div class="bg-blue-50 rounded-lg p-6 mb-6" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        What's Next?
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-calendar-check text-blue-500 mt-1"></i>
                            <span>Your event slot on
                                <strong>{{ \Carbon\Carbon::parse($booking->event_date)->format('M d, Y') }}</strong> is
                                confirmed.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-money-bill-wave text-blue-500 mt-1"></i>
                            <span><strong>Pay the remaining Rp
                                    {{ number_format($booking->remaining_amount, 0, ',', '.') }}</strong> at our cafe on
                                the event day.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-headset text-blue-500 mt-1"></i>
                            <span>Our event team will contact you ({{ $booking->customer_phone }}) 1-2 days before the
                                event for coordination.</span>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('cafe.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-orange-600 text-orange-600 font-semibold rounded-lg hover:bg-orange-50 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Cafe
                    </a>
                    <button onclick="window.print()"
                        class="inline-flex items-center justify-center px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition-colors duration-200">
                        <i class="fas fa-print mr-2"></i>
                        Print Confirmation
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Down Payment Successful!',
                html: `
                    <div class="text-left px-4">
                        <p class="mb-3"><strong>Booking Reference:</strong><br><span class="text-orange-600 font-mono">{{ $booking->booking_reference }}</span></p>
                        <p class="mb-3"><strong>Event:</strong> {{ $booking->event_name }}</p>
                        <p class="mb-3"><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}</p>
                        <hr class="my-3">
                        <div class="bg-green-50 p-3 rounded mb-3">
                            <p class="text-green-800"><i class="fas fa-check-circle mr-2"></i><strong>DP Paid:</strong> Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-yellow-50 p-3 rounded">
                            <p class="text-yellow-800"><i class="fas fa-exclamation-triangle mr-2"></i><strong>Remaining Payment:</strong> Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</p>
                            <p class="text-sm text-yellow-700 mt-2"><i class="fas fa-store mr-1"></i>Please pay at our cafe location on the event day.</p>
                        </div>
                    </div>
                `,
                confirmButtonText: 'Understood',
                confirmButtonColor: '#ea580c',
                allowOutsideClick: false,
                width: '600px'
            });
        });
    </script>
@endsection
