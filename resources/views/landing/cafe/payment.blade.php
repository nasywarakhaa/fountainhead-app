@extends('layouts.landing')

@section('title', 'Complete Payment - ' . $booking->booking_reference)

@section('content')
    <section class="pt-32 pb-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
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
                                <a href="{{ route('cafe.index') }}"
                                    class="text-sm font-medium text-gray-700 hover:text-orange-600">Cafe</a>
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

                <div class="text-center mb-8" data-aos="fade-up">
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Complete Your Payment</h1>
                    <p class="text-gray-600">Booking Reference: <span
                            class="font-semibold text-orange-600">{{ $booking->booking_reference }}</span></p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- LEFT: Booking Summary --}}
                    <div class="lg:col-span-2 space-y-6">
                        {{-- Booking Details Card --}}
                        <div class="bg-white rounded-lg shadow-md p-6" data-aos="fade-up">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-file-invoice text-orange-500 mr-3"></i>Booking Details
                            </h2>
                            <div class="space-y-4">
                                {{-- Event Info --}}
                                <div class="flex items-start gap-4 pb-4 border-b">
                                    <div class="w-20 h-20 rounded-lg bg-orange-100 flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-4xl text-orange-500"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-lg text-gray-900">{{ $booking->event_name }}</h3>
                                        <p class="text-sm text-gray-600">{{ ucfirst($booking->event_type) }} Event</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <i class="fas fa-users text-gray-400 mr-1"></i>
                                            Up to {{ $booking->expected_guests }}
                                            guest{{ $booking->expected_guests > 1 ? 's' : '' }}
                                        </p>
                                    </div>
                                </div>
                                {{-- Guest Info --}}
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
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ ucwords(str_replace('_', ' ', $booking->booking_status)) }}
                                        </span>
                                    </div>
                                </div>
                                {{-- Date Info --}}
                                <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Event Date & Start</p>
                                        <p class="font-semibold text-gray-900">
                                            <i class="fas fa-calendar-check text-green-500 mr-2"></i>
                                            {{ \Carbon\Carbon::parse($booking->event_date . ' ' . $booking->start_time)->format('D, M d, Y - H:i') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 mb-1">Event End</p>
                                        <p class="font-semibold text-gray-900">
                                            <i class="fas fa-calendar-times text-red-500 mr-2"></i>
                                            {{ \Carbon\Carbon::parse($booking->event_date . ' ' . $booking->end_time)->format('D, M d, Y - H:i') }}
                                        </p>
                                    </div>
                                </div>
                                @if ($booking->special_requirements)
                                    <div class="pt-4 border-t">
                                        <p class="text-sm text-gray-500 mb-1">Special Requirements</p>
                                        <p class="text-gray-700">{{ $booking->special_requirements }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- Payment Method Info (seperti coliving) --}}
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
                    {{-- RIGHT: Payment Summary Sidebar --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-md p-6 sticky top-32" data-aos="fade-left">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Payment Summary</h3>
                            <div class="space-y-3 mb-4">
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
                            {{-- DP 50% --}}
                            <div class="border-t pt-4 mb-6">
                                <div class="bg-orange-50 rounded-lg p-4 mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-lg font-semibold text-gray-900">Down Payment (50%)</span>
                                        <span class="text-2xl font-bold text-orange-600">
                                            Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-2">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Remaining 50% to be paid at cafe location
                                    </p>
                                </div>
                                <div class="bg-blue-50 rounded-lg p-3 mb-4">
                                    <p class="text-sm text-blue-800">
                                        <i class="fas fa-store mr-1"></i>
                                        <strong>Remaining Payment:</strong>
                                        Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}
                                        <br>
                                        <span class="text-xs">Pay at our cafe on event day</span>
                                    </p>
                                </div>
                            </div>
                            <button type="button" id="pay-button"
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                <i class="fas fa-lock"></i>
                                <span>Pay Down Payment (50%)</span>
                            </button>
                            <p class="text-xs text-gray-500 mt-3">
                                if you encounter any issues during payment, please contact our support team.
                            </p>
                            <div class="mt-4 p-4 bg-yellow-50 rounded-lg">
                                <p class="text-xs text-yellow-800 flex items-start gap-2">
                                    <i class="fas fa-exclamation-circle mt-0.5"></i>
                                    <span>
                                        Your booking is pending. Pay 50% DP now to confirm your slot. The remaining 50% can be
                                        paid at our cafe location on the event day.
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Important Notes --}}
                <div class="mt-8 bg-white rounded-lg shadow-md p-6" data-aos="fade-up">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-exclamation-circle text-orange-500 mr-2"></i>
                        Important Information
                    </h3>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>Pay the 50% Down Payment to confirm your booking slot</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>You will receive a confirmation after successful DP payment</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>The remaining 50% can be paid at our cafe on the event day</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-500 mt-1"></i>
                            <span>All personal information is encrypted and secure</span>
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
            const URL_SNAP_TOKEN = @json(route('cafe.snap-token', $booking->booking_reference));
            const URL_STATUS = @json(route('cafe.payment.status', $booking->booking_reference));
            const URL_SUCCESS = @json(route('cafe.payment.success', $booking->booking_reference));
            const URL_CALLBACK = @json(route('cafe.payment.callback') . '?order_id=' . $booking->booking_reference);

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

            function toastError(msg) {
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
                // anti-cache
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

                        if (res.payment_status === 'failed') {
                            stopPolling();
                            closeChecking();
                            setBusy(false);
                            toastError('Pembayaran gagal / expired. Silakan coba lagi.');
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
                    toastError('Midtrans Snap belum siap. Coba refresh / cek koneksi / matikan adblock.');
                    return;
                }

                window.snap.pay(token, {
                    onSuccess: function() {
                        window.location.href = URL_CALLBACK;
                    },
                    onPending: function() {
                        window.location.href = URL_CALLBACK;
                    },
                    onClose: function() {
                        // ✅ user nutup popup pun kita cek server
                        window.location.href = URL_CALLBACK;
                    },
                    onError: function() {
                        setBusy(false);
                        toastError('Ada error saat proses pembayaran. Coba lagi ya.');
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
                        toastError(err.message || 'Gagal memulai pembayaran.');
                    });
            });

            // ✅ auto-check saat user balik ke halaman payment (cadangan)
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
