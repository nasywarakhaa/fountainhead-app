@extends('layouts.landing')

@section('title', 'My Booking')

@section('content')
<div class="container mx-auto px-4 py-10">

    <h1 class="text-3xl font-bold mb-8">
        My Booking
    </h1>

    @forelse ($bookings as $booking)

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 overflow-hidden mb-8">

            <div class="flex flex-col md:flex-row">

                {{-- Informasi --}}
                <div class="flex-1 p-8">

                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-6">

                        <div>

                            <h2 class="text-3xl font-bold">
                                {{ $booking->colivingRoom->name }}
                            </h2>

                            <p class="mt-3 text-gray-600">
                                <span class="font-semibold">Booking ID :</span>
                                {{ $booking->booking_reference }}
                            </p>

                            <p class="mt-1 text-gray-600">
                                <span class="font-semibold">Booking Date :</span>
                                {{ $booking->created_at->format('d M Y') }}
                            </p>

                        </div>

                        <div class="flex flex-col gap-2">

                            {{-- Booking Status --}}
                            @if($booking->booking_status == 'confirmed')
                                <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                    Confirmed
                                </span>
                            @endif

                            {{-- Payment Status --}}
                            @if($booking->payment_status == 'pending')
                                <span class="px-4 py-2 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold">
                                    Pending Payment
                                </span>
                            @elseif($booking->payment_status == 'paid')
                                <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                    Paid
                                </span>
                            @endif

                        </div>

                    </div>

                    <div class="grid grid-cols-2 gap-6 mt-8">

                        <div>
                            <p class="text-gray-500">Check In</p>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Check Out</p>
                            <p class="font-semibold">
                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Total Nights</p>
                            <p class="font-semibold">
                                {{ $booking->total_nights }} Night(s)
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500">Total Payment</p>
                            <p class="font-bold text-orange-500 text-xl">
                                Rp {{ number_format($booking->total_amount,0,',','.') }}
                            </p>
                        </div>

                    </div>

                    {{-- Tombol --}}
                    <div class="flex gap-3 mt-8">

                        @if($booking->payment_status == 'pending')

                            <a href="{{ route('coliving.payment', $booking->booking_reference) }}"
                                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition">

                                <i class="fas fa-credit-card mr-2"></i>
                                Pay Now

                            </a>

                        @endif

                        <a href="{{ route('coliving.show', $booking->colivingRoom->id) }}"
                            class="border border-orange-500 text-orange-500 hover:bg-orange-500 hover:text-white px-6 py-3 rounded-lg font-semibold transition">

                            View Room

                        </a>

                    </div>

                </div>

            </div>

        </div>

    @empty

        <div class="max-w-6xl mx-auto px-6 py-20 text-center">

    <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-6">
        <i class="fas fa-bed text-3xl text-orange-500"></i>
    </div>

    <h2 class="text-3xl font-bold text-gray-800 mb-3">
        Belum Ada Booking
    </h2>

    <p class="text-gray-500 mb-8">
        Kamu belum pernah melakukan booking kamar.
    </p>

    <a href="{{ route('coliving.index') }}"
       class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold transition">

        <i class="fas fa-search"></i>
        Cari Kamar

    </a>

</div>

    @endforelse

</div>
@endsection