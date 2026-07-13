@extends('layouts.app')

@section('title', 'Booking Detail')
@section('styles')
<style>
  @media print {
    .main-sidebar, .main-header, .main-footer, .btn, .card-header {
      display: none !important;
    }
  }
</style>
@endsection
@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-3">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Booking Detail: {{ $colivingBooking->booking_reference }}</h1>
        <div>
          <a href="{{ route('admin.coliving-bookings.edit', $colivingBooking) }}" class="btn btn-warning">
            <i class="fas fa-edit mr-2"></i> Edit Status
          </a>
          <a href="{{ route('admin.coliving-bookings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Left Column -->
    <div class="col-md-8">
      <!-- Booking Information -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Booking Information</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <tr>
              <th width="30%">Booking Reference</th>
              <td><strong>{{ $colivingBooking->booking_reference }}</strong></td>
            </tr>
            <tr>
              <th>Room</th>
              <td>
                <strong>{{ $colivingBooking->colivingRoom->name ?? '-' }}</strong>
                <br>
                <small class="text-muted">{{ $colivingBooking->colivingRoom->getRoomTypeLabel() ?? '-' }}</small>
              </td>
            </tr>
            <tr>
              <th>Check-in Date</th>
              <td>{{ $colivingBooking->check_in_date->format('d F Y') }}</td>
            </tr>
            <tr>
              <th>Check-out Date</th>
              <td>{{ $colivingBooking->check_out_date->format('d F Y') }}</td>
            </tr>
            <tr>
              <th>Total Nights</th>
              <td><span class="badge badge-info">{{ $colivingBooking->total_nights }} nights</span></td>
            </tr>
            <tr>
              <th>Number of Guests</th>
              <td>{{ $colivingBooking->number_of_guests }} {{ $colivingBooking->number_of_guests > 1 ? 'guests' : 'guest' }}</td>
            </tr>
          </table>
        </div>
      </div>

      <!-- Customer Information -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Customer Information</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <tr>
              <th width="30%">Name</th>
              <td>{{ $colivingBooking->customer_name }}</td>
            </tr>
            <tr>
              <th>Email</th>
              <td><a href="mailto:{{ $colivingBooking->customer_email }}">{{ $colivingBooking->customer_email }}</a></td>
            </tr>
            <tr>
              <th>Phone</th>
              <td><a href="tel:{{ $colivingBooking->customer_phone }}">{{ $colivingBooking->customer_phone }}</a></td>
            </tr>
            @if($colivingBooking->user)
            <tr>
              <th>Registered User</th>
              <td>
                <span class="badge badge-success">Yes</span>
                <small class="text-muted">User ID: {{ $colivingBooking->user_id }}</small>
              </td>
            </tr>
            @endif
          </table>
        </div>
      </div>

      <!-- Special Requests -->
      @if($colivingBooking->special_requests)
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Special Requests</h3>
        </div>
        <div class="card-body">
          <p class="mb-0">{{ $colivingBooking->special_requests }}</p>
        </div>
      </div>
      @endif

      <!-- Cancellation Info -->
      @if($colivingBooking->booking_status === 'cancelled')
      <div class="card border-danger">
        <div class="card-header bg-danger">
          <h3 class="card-title text-white">Cancellation Information</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered mb-0">
            <tr>
              <th width="30%">Cancelled At</th>
              <td>{{ $colivingBooking->cancelled_at?->format('d F Y H:i') ?? '-' }}</td>
            </tr>
            @if($colivingBooking->cancellation_reason)
            <tr>
              <th>Reason</th>
              <td>{{ $colivingBooking->cancellation_reason }}</td>
            </tr>
            @endif
          </table>
        </div>
      </div>
      @endif
    </div>

    <!-- Right Column -->
    <div class="col-md-4">
      <!-- Status Card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Status</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label>Payment Status</label>
            <div>
              @php
                $paymentBadges = [
                  'pending' => 'warning',
                  'paid' => 'success',
                  'failed' => 'danger',
                  'refunded' => 'secondary'
                ];
                $badge = $paymentBadges[$colivingBooking->payment_status] ?? 'secondary';
              @endphp
              <span class="badge badge-{{ $badge }} badge-lg">{{ ucfirst($colivingBooking->payment_status) }}</span>
            </div>
          </div>

          <div class="form-group">
            <label>Booking Status</label>
            <div>
              @php
                $bookingBadges = [
                  'confirmed' => 'success',
                  'cancelled' => 'danger',
                  'completed' => 'primary',
                  'no_show' => 'dark'
                ];
                $badge = $bookingBadges[$colivingBooking->booking_status] ?? 'secondary';
              @endphp
              <span class="badge badge-{{ $badge }} badge-lg">{{ ucfirst($colivingBooking->booking_status) }}</span>
            </div>
          </div>

          @if($colivingBooking->payment_reference)
          <div class="form-group">
            <label>Payment Reference</label>
            <div>
              <code>{{ $colivingBooking->payment_reference }}</code>
            </div>
          </div>
          @endif

          @if($colivingBooking->paid_at)
          <div class="form-group">
            <label>Paid At</label>
            <div>
              <small>{{ $colivingBooking->paid_at->format('d F Y H:i') }}</small>
            </div>
          </div>
          @endif

          <div class="form-group mb-0">
            <label>Booking Created</label>
            <div>
              <small>{{ $colivingBooking->created_at->format('d F Y H:i') }}</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Pricing Breakdown -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Pricing Breakdown</h3>
        </div>
        <div class="card-body">
          <table class="table table-sm">
            <tr>
              <td>Price per Night</td>
              <td class="text-right">Rp {{ number_format($colivingBooking->price_per_night, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <td>Nights</td>
              <td class="text-right">x {{ $colivingBooking->total_nights }}</td>
            </tr>
            <tr>
              <td><strong>Subtotal</strong></td>
              <td class="text-right"><strong>Rp {{ number_format($colivingBooking->subtotal, 0, ',', '.') }}</strong></td>
            </tr>
            @if($colivingBooking->service_fee > 0)
            <tr>
              <td>Service Fee</td>
              <td class="text-right">Rp {{ number_format($colivingBooking->service_fee, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="border-top">
              <td><strong>Total Amount</strong></td>
              <td class="text-right"><strong class="text-primary">Rp {{ number_format($colivingBooking->total_amount, 0, ',', '.') }}</strong></td>
            </tr>
          </table>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Quick Actions</h3>
        </div>
        <div class="card-body">
          <a href="{{ route('admin.coliving-bookings.edit', $colivingBooking) }}" class="btn btn-warning btn-block">
            <i class="fas fa-edit mr-2"></i> Update Status
          </a>
          <button type="button" class="btn btn-info btn-block" onclick="window.print()">
            <i class="fas fa-print mr-2"></i> Print Invoice
          </button>
          <a href="mailto:{{ $colivingBooking->customer_email }}" class="btn btn-secondary btn-block">
            <i class="fas fa-envelope mr-2"></i> Send Email
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
