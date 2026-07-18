@php
    $serviceNames = [
        'catering' => 'Catering',
        'decoration' => 'Decoration',
        'photographer' => 'Photographer',
        'sound_system' => 'Sound System',
        'av_equipment' => 'AV Equipment',
        'projector' => 'Projector',
        'microphone' => 'Microphone',
    ];
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <style>
        /* ===========================
            HEADER
        =========================== */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #2d3748;
            line-height: 1;
            margin: 25px;
        }

        .header{
            width:100%;
            border-bottom:2px solid;
            padding-bottom:12px;
            margin-bottom:25px;
        }

        .logo {
            width: 100px;
        }

        .company {
            margin-left: 0;
        }

        .company h1 {
            margin: 0;
            font-size: 24px;
            color: ;
        }

        .company p {
            margin: 3px 0;
            font-size: 12px;
        }

        .title {
            text-align: center;
            margin: 5px 0 10px;
        }

        .title h2 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 1px;
        }

        /* ===========================
            SECTION TITLE
        =========================== */

        .section-title{
            font-size:15px;
            font-weight:bold;
            /* color:#d97706; */
            /* border-bottom:1px solid #dddddd; */
            padding-bottom:2px;
            margin-bottom:2px;
            letter-spacing:.5px;
        }

        /* ===========================
            INFORMATION TABLE
        =========================== */

        .info-table{
            width:100%;
            border:none;
            border-collapse:collapse;
        }

        .info-table td{
            border:none;
            padding:2px 0;
            font-size:12px;
            vertical-align:top;
        }

        .info-label{
            width:120px;
            color:#555;
        }

        .info-colon{
            width:15px;
            text-align:center;
        }

        .info-value{
            color:#222;
        }

        /* ===========================
            STATUS
        =========================== */

        .status-confirmed{
            /* color:#16a34a; */
            font-weight:bold;
        }

        .status-pending{
            /* color:#f59e0b; */
            font-weight:bold;
        }

        .status-paid{
            /* color:#16a34a; */
            font-weight:bold;
        }

        .status-dp{
            /* color:#2563eb; */
            font-weight:bold;
        }

        /* ===========================
            CUSTOMER & BOOKING
        =========================== */

        .info-wrapper{
            width:100%;
            border:none;
            margin-bottom:25px;
        }

        .info-column{
            width:48%;
            vertical-align:top;
        }

        .info-space{
            width:4%;
        }

        /* ===========================
            EVENT DETAILS
        =========================== */

        .event-title{
            font-size:15px;
            font-weight:bold;
            /* color:#d97706; */
            /* border-bottom:1px solid #dddddd; */
            padding-bottom:2px;
            margin-bottom:2px;
            letter-spacing:.5px;
        }

        .event-table{
            width:100%;
            border:none;
            border-collapse:collapse;
            margin-bottom:25px;
        }

        .event-table td{
            padding:2px 0;
            font-size:12px;
        }

        .event-label{
            width:35%;
            /* background:#fafafa; */
            /* color:#555; */
            /* font-weight:bold; */
        }

        .event-value{
            color:#222;
        }

        /* ===========================
            PAYMENT SUMMARY
        =========================== */

        .payment-title{
            font-size:15px;
            font-weight:bold;
            /* color:#d97706; */
            border-bottom:1px solid #dddddd;
            padding-bottom:6px;
            margin-bottom:12px;
            letter-spacing:.5px;
        }

        .payment-table{
            width:100%;
            border-collapse:collapse;
            margin-bottom:20px;
        }

        .payment-table th{

            /* background:#faf7f2; */
            /* color:#d97706; */
            font-size:12px;
            font-weight:bold;
            padding:2px 0;
            /* border:1px solid #e5e7eb; */
            text-align:left;

        }

        .payment-table td{

            padding:2px 0;
            /* border-bottom:1px solid #ececec; */
            font-size:12px;

        }

        .payment-table td:last-child{

            text-align:right;

        }

        .total-row{

            font-weight:bold;
            font-size:14px;
            /* background:#fff8f1; */
            /* border-top:2px solid #d97706; */

        }

        .total-row td{

            padding: 2px 0;

        }

        .deposit-row{

            /* color:#16a34a; */
            /* font-weight:bold; */

        }

        .remaining-row{

            /* color:red; */
            font-weight:bold;

        }

        /* ===========================
            FOOTER
        =========================== */
        .payment-footer {
            position: fixed;
            bottom: 20px;
            left: 40px;
            right: 40px;

            border-top: 1px solid #dcdcdc;
            padding-top: 12px;

            text-align: center;
            font-size: 12px;
            color: #6b7280;
            line-height: 1.6;
        }

        .payment-footer strong {
            display: block;
            margin-bottom: 6px;
            color: #1f2937;
            font-size: 13px;
        }

        .payment-footer p {
            margin: 2px 0;
        }

    </style>
</head>

<body>

    {{-- Header --}}
    <div class="header">

        <table style="width:100%; border:none;">

            <tr>

                <td style="width:120px; border:none; vertical-align:middle;">

                    <img src="{{ public_path('/images/logo.png') }}" class="logo">

                </td>

                <td style="border:none; vertical-align:middle;">

                    <h1 style="margin:0;">
                        FountainHead Cafe & Co-Living
                    </h1>

                    <p style="margin:4px 0 0;">
                        Modern Coliving & Cafe
                    </p>

                    <p style="margin:4px 0 0;">
                        Jl. Masjid Al Ihsan No.6 Blok 38, RT.2/RW.10, North Meruya, Kembangan, West Jakarta City, Jakarta 11620
                    </p>

                    <p style="margin:4px 0 0;">
                        Telp: 0856-7892-823
                    </p>

                </td>

            </tr>

        </table>

    </div>


    {{-- Customer & Booking Information --}}

    <table class="info-wrapper">

        <tr>

            {{-- Customer Information --}}

            <td class="info-column">

                <div class="section-title">

                    CUSTOMER INFORMATION

                </div>

                <table class="info-table">

                    <tr>

                        <td class="info-label">Name</td>

                        <td class="info-colon">:</td>

                        <td class="info-value">

                            {{ $booking->customer_name }}

                        </td>

                    </tr>

                    <tr>

                        <td class="info-label">Email</td>

                        <td class="info-colon">:</td>

                        <td class="info-value">

                            {{ $booking->customer_email }}

                        </td>

                    </tr>

                    <tr>

                        <td class="info-label">Phone</td>

                        <td class="info-colon">:</td>

                        <td class="info-value">

                            {{ $booking->customer_phone }}

                        </td>

                    </tr>

                    @if($booking->organization_name)

                    <tr>

                        <td class="info-label">Organization</td>

                        <td class="info-colon">:</td>

                        <td class="info-value">

                            {{ $booking->organization_name }}

                        </td>

                    </tr>

                    @endif

                </table>

            </td>

            <td class="info-space"></td>

            {{-- Booking Information --}}

            <td class="info-column">

                <div class="section-title">

                    BOOKING INFORMATION

                </div>

                <table class="info-table">

                    <tr>

                        <td class="info-label">Booking Ref</td>

                        <td class="info-colon">:</td>

                        <td class="info-value">

                            {{ $booking->booking_reference }}

                        </td>

                    </tr>

                    <tr>

                        <td class="info-label">Event Name</td>

                        <td class="info-colon">:</td>

                        <td class="info-value">

                            {{ $booking->event_name }}

                        </td>

                    </tr>

                    <tr>

                        <td class="info-label">Event Type</td>

                        <td class="info-colon">:</td>

                        <td class="info-value">

                            {{ ucfirst($booking->event_type) }}

                        </td>

                    </tr>

                    <tr>

                        <td class="info-label">Booking Status</td>

                        <td class="info-colon">:</td>

                        <td class="info-value">

                            @if($booking->booking_status == 'confirmed')

                                <span class="status-confirmed">

                                    Confirmed

                                </span>

                            @elseif($booking->booking_status == 'pending')

                                <span class="status-pending">

                                    Pending

                                </span>

                            @else

                                {{ ucfirst($booking->booking_status) }}

                            @endif

                        </td>

                    </tr>

                    <tr>

                        <td class="info-label">Payment Status</td>

                        <td class="info-colon">:</td>

                        <td class="info-value">

                            @if($booking->payment_status == 'paid')

                                <span class="status-paid">

                                    Paid

                                </span>

                            @elseif($booking->payment_status == 'dp_paid')

                                <span class="status-dp">

                                    DP Paid

                                </span>

                            @else

                                {{ ucfirst(str_replace('_',' ', $booking->payment_status)) }}

                            @endif

                        </td>

                    </tr>

                </table>

            </td>

        </tr>

    </table>

    <hr>

    {{-- Event Details --}}

    <div class="event-title">

        EVENT DETAILS

    </div>

    <table class="event-table">

        <tr>

            <td class="event-label">

                Event Name

            </td>

            <td class="info-colon">:</td>

            <td class="event-value">

                {{ $booking->event_name }}

            </td>

        </tr>

        <tr>

            <td class="event-label">

                Event Type

            </td>

            <td class="info-colon">:</td>

            <td class="event-value">

                {{ ucfirst($booking->event_type) }}

            </td>

        </tr>

        <tr>

            <td class="event-label">

                Event Date

            </td>

            <td class="info-colon">:</td>

            <td class="event-value">

                {{ \Carbon\Carbon::parse($booking->event_date)->format('d F Y') }}

            </td>

        </tr>

        <tr>

            <td class="event-label">

                Event Time

            </td>

            <td class="info-colon">:</td>

            <td class="event-value">

                {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                -
                {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}

            </td>

        </tr>

        <tr>

            <td class="event-label">

                Duration

            </td>

            <td class="info-colon">:</td>

            <td class="event-value">

                {{ $booking->duration_hours }} Hours

            </td>

        </tr>

        <tr>

            <td class="event-label">

                Expected Guests

            </td>

            <td class="info-colon">:</td>

            <td class="event-value">

                {{ number_format($booking->expected_guests) }} Guests

            </td>

        </tr>

        <tr>

            <td class="event-label">

                Space Type

            </td>

            <td class="info-colon">:</td>

            <td class="event-value">

                {{ ucfirst($booking->space_type ?? 'Indoor') }}

            </td>

        </tr>

        <tr>

            <td class="event-label">

                Additional Services

            </td>

            <td class="info-colon">:</td>

            <td class="event-value">

                @if($booking->additional_services && count($booking->additional_services))

                    {{
                        collect($booking->additional_services)
                            ->map(fn($item) => $serviceNames[$item] ?? ucfirst(str_replace('_', ' ', $item)))
                            ->implode(', ')
                    }}

                @else

                    -

                @endif

            </td>

        </tr>

    </table>

    {{-- Payment Summary --}}

    <div class="payment-title">

        PAYMENT SUMMARY

    </div>

    <table class="payment-table">

        <thead>

            <tr>

                <th>

                    Description

                </th>

                <th width="180" style="text-align: right;">

                    Amount

                </th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>

                    Venue Rental

                </td>

                <td>

                    Rp {{ number_format($booking->venue_price,0,',','.') }}

                </td>

            </tr>

            <tr>

                <td>

                    Additional Services

                </td>

                <td>

                    Rp {{ number_format($booking->services_price,0,',','.') }}

                </td>

            </tr>

            <tr>

                <td>

                    Subtotal

                </td>

                <td>

                    Rp {{ number_format($booking->subtotal,0,',','.') }}

                </td>

            </tr>

            <tr>

                <td>

                    Tax (11%)

                </td>

                <td>

                    Rp {{ number_format($booking->tax,0,',','.') }}

                </td>

            </tr>

            <tr class="total-row">

                <td>

                    TOTAL PAYMENT

                </td>

                <td>

                    Rp {{ number_format($booking->total_amount,0,',','.') }}

                </td>

            </tr>

            @if($booking->payment_status == 'dp_paid')

                <tr class="deposit-row">

                    <td>

                        Deposit Paid (50%)

                    </td>

                    <td>

                        Rp {{ number_format($booking->dp_amount,0,',','.') }}

                    </td>

                </tr>

                <tr class="remaining-row">

                    <td>

                        Remaining Payment

                    </td>

                    <td>

                        Rp {{ number_format($booking->remaining_amount,0,',','.') }}

                    </td>

                </tr>

            @elseif($booking->payment_status == 'paid')

                <tr class="deposit-row">

                    <td>

                        Paid

                    </td>

                    <td>

                        Rp {{ number_format($booking->total_amount,0,',','.') }}

                    </td>

                </tr>

            @endif

        </tbody>

    </table>

    <footer class="payment-footer">
        <strong>Thank you for choosing FountainHead Cafe &amp; Co-Living.</strong>

        <p>
            This payment summary is generated automatically and serves as a valid proof of booking.
        </p>

        <p>
            If you have any questions, please contact our team.
        </p>
    </footer>