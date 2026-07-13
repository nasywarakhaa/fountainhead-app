@extends('layouts.landing')

@section('title', 'Complete Payment - ' . $booking->booking_reference)

@section('content')
    <section class="pt-32 pb-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="flex mb-8" aria-label="Breadcrumb" data-aos="fade-right">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 hover:text-orange-600">
                                <i class="fas fa-home mr-2"></i>Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <a href="{{ route('coliving.index') }}"
                                    class="text-sm font-medium text-gray-700 hover:text-orange-600">Coliving</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="text-sm font-medium text-gray-500">Payment</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Page Title -->
                <div class="text-center mb-8" data-aos="fade-up">
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Complete Your Payment</h1>
                    <p class="text-gray-600">Booking Reference: <span
                            class="font-semibold text-orange-600">{{ $booking->booking_reference }}</span></p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Booking Summary -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Booking Details Card -->
                        <div class="bg-white rounded-lg shadow-md p-6" data-aos="fade-up">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-file-invoice text-orange-500 mr-3"></i>Booking Details
                            </h2>

                            <div class="space-y-4">
                                <!-- Room Info -->
                                <div class="flex items-start gap-4 pb-4 border-b">
                                    <img src="{{ Storage::url($booking->colivingRoom->thumbnail) ?: 'https://via.placeholder.com/100' }}"
                                        alt="{{ $booking->colivingRoom->name }}" class="w-20 h-20 rounded-lg object-cover">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-lg text-gray-900">{{ $booking->colivingRoom->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600">{{ ucfirst($booking->colivingRoom->room_type) }}
                                            Room</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <i class="fas fa-users text-gray-400 mr-1"></i>
                                            Up to {{ $booking->colivingRoom->capacity }}
                                            guest{{ $booking->colivingRoom->capacity > 1 ? 's' : '' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Guest Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Guest Name</p>
                                        <p class="font-medium text-gray-900">{{ $booking->customer_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Email</p>
                                        <p class="font-medium text-gray-900">{{ $booking->customer_email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Phone</p>
                                        <p class="font-medium text-gray-900">{{ $booking->customer_phone }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Booking Status</p>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>{{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Date Info -->
                                <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Check-in</p>
                                        <p class="font-semibold text-gray-900">
                                            <i class="fas fa-calendar-check text-green-500 mr-2"></i>
                                            {{ \Carbon\Carbon::parse($booking->check_in_date)->format('D, M d, Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Check-out</p>
                                        <p class="font-semibold text-gray-900">
                                            <i class="fas fa-calendar-times text-red-500 mr-2"></i>
                                            {{ \Carbon\Carbon::parse($booking->check_out_date)->format('D, M d, Y') }}
                                        </p>
                                    </div>
                                </div>

                                @if ($booking->special_requests)
                                    <div class="pt-4 border-t">
                                        <p class="text-sm text-gray-500 mb-1">Special Requests</p>
                                        <p class="text-gray-700">{{ $booking->special_requests }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Payment Method Info -->
                        <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-lg p-6" data-aos="fade-up"
                            data-aos-delay="100">
                            <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-shield-alt text-orange-600 mr-2"></i>
                                Secure Payment with Midtrans
                            </h3>
                            <p class="text-sm text-gray-700 mb-3">We accept the following payment methods:</p>
                            <div class="flex flex-wrap gap-3 items-center">
                                <div class="bg-white rounded shadow-sm w-20 h-12 flex items-center justify-center px-3">
                                    <img src="{{ asset('images/logo-bank/bca.svg') }}" alt="BCA"
                                        class="h-9 w-auto object-contain">
                                </div>
                                <div class="bg-white rounded shadow-sm w-20 h-12 flex items-center justify-center px-3">
                                    <img src="{{ asset('images/logo-bank/mandiri.svg') }}" alt="Mandiri"
                                        class="h-9 w-auto object-contain">
                                </div>
                                <div class="bg-white rounded shadow-sm w-20 h-12 flex items-center justify-center px-3">
                                    <img src="{{ asset('images/logo-bank/bni.svg') }}" alt="BNI"
                                        class="h-9 w-auto object-contain">
                                </div>
                                <div class="bg-white rounded shadow-sm w-20 h-12 flex items-center justify-center px-3">
                                    <img src="{{ asset('images/logo-bank/gopay.svg') }}" alt="GoPay"
                                        class="h-9 w-auto object-contain">
                                </div>
                                <div class="bg-white rounded shadow-sm w-20 h-12 flex items-center justify-center px-3">
                                    <img src="{{ asset('images/logo-bank/ovo.svg') }}" alt="OVO"
                                        class="h-9 w-auto object-contain">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-32" data-aos="fade-left">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Payment Summary</h3>

                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between text-gray-700">
                                    <span>Rp {{ number_format($booking->price_per_night, 0, ',', '.') }} ×
                                        {{ $booking->total_nights }}
                                        night{{ $booking->total_nights > 1 ? 's' : '' }}</span>
                                    <span>Rp
                                        {{ number_format($booking->price_per_night * $booking->total_nights, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <span>Service Fee</span>
                                    <span>Rp 0</span>
                                </div>
                            </div>

                            <div class="border-t pt-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total</span>
                                    <span class="text-2xl font-bold text-orange-600">Rp
                                        {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <button type="button" id="pay-button"
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                <i class="fas fa-lock"></i>
                                <span>Pay Now</span>
                            </button>
                            <p class="text-xs text-gray-500 mt-3">
                                if you encounter any issues during payment, please contact our support team.
                            </p>
                            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                                <p class="text-xs text-blue-800 flex items-start gap-2">
                                    <i class="fas fa-info-circle mt-0.5"></i>
                                    <span>Your booking is confirmed. Complete the payment to secure your room.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="mt-8 bg-white rounded-lg shadow-md p-6" data-aos="fade-up">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-exclamation-circle text-orange-500 mr-2"></i>
                        Important Information
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>Payment must be completed within 24 hours to confirm your booking</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>You will receive a confirmation email after successful payment</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>All personal information is encrypted and secure</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>For questions, contact us at support@fountainhead.com</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(function() {
            const $btn = $('#pay-button');
            if (!$btn.length) return;

            const originalHTML = $btn.html();
            let isBusy = false;

            // Routes
            const URL_SNAP_TOKEN = @json(route('coliving.snap-token', $booking->booking_reference));
            const URL_STATUS = @json(route('coliving.payment.status', $booking->booking_reference));
            const URL_SUCCESS = @json(route('coliving.payment.success', $booking->booking_reference));
            const URL_CALLBACK = @json(route('coliving.payment.callback') . '?order_id=' . $booking->booking_reference);

            const csrf = $('meta[name="csrf-token"]').attr('content') || '';

            // Polling (cadangan)
            let pollTimer = null;
            let pollAttempt = 0;
            const POLL_INTERVAL_MS = 3000;
            const POLL_MAX_ATTEMPT = 60;

            function setBusy(state) {
                isBusy = state;
                $btn.prop('disabled', state);
                $btn.html(state ? '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...' : originalHTML);
            }

            function showError(msg) {
                if (window.Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: msg,
                        confirmButtonColor: '#ea580c'
                    });
                } else {
                    alert(msg);
                }
            }

            function showChecking() {
                if (!window.Swal) return;
                Swal.fire({
                    title: 'Checking Payment...',
                    html: 'Verifying payment...<br><br><i class="fas fa-spinner fa-spin text-4xl text-orange-500"></i>',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                });
            }

            function closeChecking() {
                if (window.Swal && Swal.isVisible && Swal.isVisible()) Swal.close();
            }

            function fetchSnapToken() {
                return $.ajax({
                    url: URL_SNAP_TOKEN,
                    method: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    data: JSON.stringify({})
                }).then(function(data) {
                    if (!data || !data.ok || !data.token) {
                        throw new Error((data && data.message) ? data.message :
                            'Gagal membuat token pembayaran.');
                    }
                    return data.token;
                }).catch(function(xhrOrErr) {
                    let msg = 'Gagal membuat token pembayaran.';
                    if (xhrOrErr && xhrOrErr.responseJSON && xhrOrErr.responseJSON.message) msg = xhrOrErr
                        .responseJSON.message;
                    else if (xhrOrErr instanceof Error && xhrOrErr.message) msg = xhrOrErr.message;
                    throw new Error(msg);
                });
            }

            function checkStatusOnce() {
                return $.ajax({
                    url: URL_STATUS + '?_=' + Date.now(),
                    method: 'GET',
                    cache: false,
                    dataType: 'json',
                    headers: {
                        'Accept': 'application/json'
                    }
                }).then(function(res) {
                    return (res && res.ok) ? res : null;
                }).catch(function() {
                    return null;
                });
            }

            function stopPolling() {
                if (pollTimer) clearInterval(pollTimer);
                pollTimer = null;
                pollAttempt = 0;
            }

            function startPolling(showModal) {
                if (pollTimer) return;
                pollAttempt = 0;

                if (showModal) showChecking();

                pollTimer = setInterval(function() {
                    pollAttempt++;

                    checkStatusOnce().then(function(res) {
                        if (!res) {
                            if (pollAttempt >= POLL_MAX_ATTEMPT) {
                                stopPolling();
                                closeChecking();
                                setBusy(false);
                            }
                            return;
                        }

                        if (res.is_paid) {
                            stopPolling();
                            closeChecking();
                            window.location.href = URL_SUCCESS;
                            return;
                        }

                        if (res.payment_status === 'failed' || res.booking_status === 'cancelled') {
                            stopPolling();
                            closeChecking();
                            setBusy(false);
                            showError('Transaksi gagal/expired. Silakan booking ulang ya.');
                            return;
                        }

                        if (pollAttempt >= POLL_MAX_ATTEMPT) {
                            stopPolling();
                            closeChecking();
                            setBusy(false);
                        }
                    });
                }, POLL_INTERVAL_MS);
            }

            function openSnap(token) {
                if (!window.snap || typeof window.snap.pay !== 'function') {
                    setBusy(false);
                    showError('Midtrans Snap belum siap. Coba refresh / cek koneksi / matikan adblock.');
                    return;
                }

                window.snap.pay(token, {
                    onSuccess: function() {
                        // ✅ paksa server update DB (paling aman local)
                        window.location.href = URL_CALLBACK;
                    },
                    onPending: function() {
                        window.location.href = URL_CALLBACK;
                    },
                    onClose: function() {
                        window.location.href = URL_CALLBACK;
                    },
                    onError: function() {
                        setBusy(false);
                        showError('Ada error saat proses pembayaran. Coba lagi ya.');
                    }
                });
            }

            $btn.on('click', function() {
                if (isBusy) return;
                setBusy(true);

                fetchSnapToken()
                    .then(function(token) {
                        openSnap(token);
                    })
                    .catch(function(err) {
                        setBusy(false);
                        showError(err.message || 'Gagal memulai pembayaran.');
                    });
            });

            // ✅ auto-check kalau user balik ke halaman payment
            startPolling(false);
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: @json(session('success')),
                    confirmButtonColor: '#ea580c',
                    timer: 3000
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: @json(session('error')),
                    confirmButtonColor: '#ea580c'
                });
            @endif
            @if (session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Information',
                    text: @json(session('info')),
                    confirmButtonColor: '#ea580c'
                });
            @endif
        });
    </script>
@endsection
