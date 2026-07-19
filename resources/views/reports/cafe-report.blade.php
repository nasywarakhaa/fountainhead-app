<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>

    <style>
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

        .info {
            width: 100%;
            margin-bottom: 18px;
        }

        .info td {
            padding: 3px 0;
            vertical-align: top;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 11px;
        }

        .report-table th {
            background: #dddddd;
            color: #000;
            padding: 9px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #999;
        }

        .report-table td {
            padding: 8px;
            border: 1px solid #999;
        }

        .report-table tbody tr:nth-child(even) {
            background: #fcfcfc;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .report-summary {
            width: 40%;
            margin-left: auto;
            margin-top: 18px;
        }

        .report-summary h4 {
            margin: 0 0 ;
            padding-bottom: 4px;
            border-bottom: 1px solid;
            color: ;
            font-size: 14px;
        }

        .report-summary table {
            width: 100%;
            padding-top: 4px;
            padding-bottom: 4px;
            border-collapse: collapse;
        }

        .report-summary td {
            padding: 2px 0;
        }

        .report-summary hr {
            border: none;
            border-top: 1px solid #999;
            margin: 0 0;
        }

        .grand-total td {
            font-size: 14px;
            font-weight: bold;
            color: ;
            padding-top: 0 0;
        }

        .footer {
            margin-top: 60px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
    </style>

</head>

<body>

    {{-- Header --}}
    <div class="header">

        <table style="width:100%; border:none;">

            <tr>

                <td style="width:120px; border:none; vertical-align:middle;">

                    <img src="{{ public_path('/images/ic_bw.png') }}" class="logo">

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

    {{-- Judul --}}
    <div class="title">

        <h2>Laporan Pemesanan Event</h2>

    </div>

    {{-- Informasi --}}
    <table class="info">

        <tr>

            <td width="18%"><strong>Periode</strong></td>

            <td>
                : {{ $startDate->translatedFormat('d F Y') }}
                -
                {{ $endDate->translatedFormat('d F Y') }}
            </td>

        </tr>

        <tr>

            <td><strong>Tanggal Dicetak</strong></td>

            <td>
                : {{ now()->translatedFormat('d F Y H:i') }}
            </td>

        </tr>

    </table>

    <table class="report-table">

        <thead>

            <tr>

                <th width="5%">No</th>
                <th width="18%">Booking Ref</th>
                <th width="18%">Nama</th>
                <th width="15%">Event</th>
                <th width="12%">Tanggal Event</th>
                <th width="12%">Jam</th>
                <th width="7%">Tamu</th>
                <th width="8%">Status</th>
                <th width="15%">Total</th>

            </tr>

        </thead>

        <tbody>

            @forelse ($bookings as $booking)

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $booking->booking_reference }}
                    </td>

                    <td>
                        {{ $booking->customer_name }}
                    </td>

                    <td>
                        {{ $booking->event_name }}
                    </td>

                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($booking->event_date)->format('d/m/Y') }}
                    </td>

                    <td class="text-center">
                        {{ $booking->start_time }}
                        -
                        {{ $booking->end_time }}
                    </td>

                    <td class="text-center">
                        {{ $booking->expected_guests }}
                    </td>

                    <td class="text-center">
                        {{ ucfirst(str_replace('_', ' ', $booking->booking_status)) }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="9" class="text-center">

                        No booking data found.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    <div class="report-summary">

        <h4>Ringkasan</h4>

        <table>

            <tr>

                <td>Total Booking</td>

                <td class="text-right">

                    {{ $totalBookings }}

                </td>

            </tr>

            <tr>

                <td>Total Pendapatan</td>

                <td class="text-right">

                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}

                </td>

            </tr>

            <tr>

                <td colspan="2">

                    <hr>

                </td>

            </tr>

            <tr class="grand-total">

                <td>Grand Total</td>

                <td class="text-right">

                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}

                </td>

            </tr>

        </table>

    </div>

    <div class="footer">

        Printed by FountainHead System

    </div>
</body>