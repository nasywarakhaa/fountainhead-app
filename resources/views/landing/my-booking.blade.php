@extends('layouts.landing')

@section('title','My Booking')

@section('content')

<section class="bg-gray-50 min-h-screen py-20">
    <div class="max-w-6xl mx-auto px-6 py-10">

        <div class="mb-10">
            <h1 class="text-4xl font-bold text-gray-800">
                My Booking
            </h1>

            <p class="text-gray-500 mt-2">
                View and manage all of your reservations.
            </p>
        </div>

        @forelse($bookings as $booking)

            <div
                class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition duration-300 p-8 mb-6">

                @if($booking->booking_type == 'coliving')

                
                    <div class="flex justify-between items-start flex-wrap gap-4">

                        <div>

                            <div class="flex items-center gap-2 mb-2">

                                <span
                                    class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">

                                    🏨 COLIVING

                                </span>

                                @if($booking->booking_status == 'confirmed')
                                    <span
                                        class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">

                                        Confirmed

                                    </span>
                                @endif

                                @if($booking->payment_status == 'pending')
                                    <span
                                        class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs">

                                        Pending

                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">

                                        Paid

                                    </span>
                                @endif

                            </div>

                            <h2 class="text-2xl font-bold">

                                {{ $booking->colivingRoom->name }}

                            </h2>

                            <p class="text-gray-500">

                                {{ $booking->booking_reference }}

                            </p>

                        </div>

                        <div class="text-right">

                            <p class="text-gray-500 text-sm">
                                Total Payment
                            </p>

                            <h2 class="text-3xl font-bold text-orange-500">

                                Rp {{ number_format($booking->total_amount,0,',','.') }}

                            </h2>

                        </div>

                    </div>

                    <div class="grid md:grid-cols-4 gap-4 mt-8">

                        <div class="border rounded-xl p-4">
                            <p class="text-gray-400 text-sm">Check In</p>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="border rounded-xl p-4">
                            <p class="text-gray-400 text-sm">Check Out</p>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="border rounded-xl p-4">
                            <p class="text-gray-400 text-sm">Nights</p>
                            <p class="font-semibold">
                                {{ $booking->total_nights }}
                            </p>
                        </div>

                        <div class="border rounded-xl p-4">
                            <p class="text-gray-400 text-sm">Booking Date</p>
                            <p class="font-semibold">
                                {{ $booking->created_at->format('d M Y') }}
                            </p>
                        </div>

                    </div>

                    <div class="mt-6 flex gap-3">

                        @if($booking->payment_status == 'pending')

                            <a href="{{ route('coliving.payment',$booking->booking_reference) }}"
                                class="px-6 py-3 rounded-xl bg-orange-500 text-white hover:bg-orange-600">

                                Pay Now

                            </a>

                        @endif

                        <a href="{{ route('coliving.show',$booking->coliving_room_id) }}"
                            class="px-6 py-3 rounded-xl border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white">

                            View Room

                        </a>

                    </div>

                @else

                    <div class="flex justify-between items-start flex-wrap gap-4">

                        <div>

                            <div class="flex items-center gap-2 mb-2">

                                <span
                                    class="px-3 py-1 rounded-full bg-red-100 text-purple-700 text-xs font-semibold">

                                    🎉 EVENT

                                </span>

                                <span
                                    class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs">

                                    {{ ucfirst($booking->payment_status) }}

                                </span>

                            </div>

                            <h2 class="text-2xl font-bold">

                                {{ $booking->event_name }}

                            </h2>

                            <p class="text-gray-500">

                                {{ $booking->booking_reference }}

                            </p>

                        </div>

                        <div class="text-right">

                            <p class="text-gray-500 text-sm">

                                Total Payment

                            </p>

                            <h2 class="text-3xl font-bold text-orange-500">

                                Rp {{ number_format($booking->total_amount,0,',','.') }}

                            </h2>

                        </div>

                    </div>

                    <div class="grid md:grid-cols-4 gap-4 mt-8">

                        <div class="border rounded-xl p-4">
                            <p class="text-gray-400 text-sm">Event Date</p>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="border rounded-xl p-4">
                            <p class="text-gray-400 text-sm">Time</p>
                            <p class="font-semibold">
                                {{ substr($booking->start_time,0,5) }} - {{ substr($booking->end_time,0,5) }}
                            </p>
                        </div>

                        <div class="border rounded-xl p-4">
                            <p class="text-gray-400 text-sm">Guests</p>
                            <p class="font-semibold">
                                {{ $booking->expected_guests }}
                            </p>
                        </div>

                        <div class="border rounded-xl p-4">
                            <p class="text-gray-400 text-sm">Booking Date</p>
                            <p class="font-semibold">
                                {{ $booking->created_at->format('d M Y') }}
                            </p>
                        </div>

                    </div>

                    @if($booking->payment_status == 'pending')

                        <div class="mt-6">

                            <a href="{{ route('cafe.payment',$booking->booking_reference) }}"
                                class="px-6 py-3 rounded-xl bg-orange-500 text-white hover:bg-orange-600">

                                Pay Now

                            </a>

                        </div>

                    @endif

                @endif

            </div>

        @empty

            <div class="text-center py-20">

                <div class="text-6xl mb-4">
                    📄
                </div>

                <h2 class="text-3xl font-bold text-gray-700">

                    Belum Ada Booking

                </h2>

                <p class="text-gray-500 mt-2">

                    Kamu belum memiliki riwayat booking.

                </p>

            </div>

        @endforelse

    </div>
    
</section>

@endsection