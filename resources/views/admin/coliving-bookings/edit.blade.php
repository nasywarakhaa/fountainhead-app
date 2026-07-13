@extends('layouts.app')

@section('title', 'Edit Booking Status')

{{-- Tambahan CSS (kalau nanti butuh plugin seperti datepicker dsb) --}}
@section('styles')
{{-- Contoh:
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
--}}
@endsection

@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-3">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Edit Booking Status: {{ $colivingBooking->booking_reference }}</h1>
        <a href="{{ route('admin.coliving-bookings.show', $colivingBooking) }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left mr-2"></i> Back to Detail
        </a>
      </div>
    </div>
  </div>

  <form action="{{ route('admin.coliving-bookings.update', $colivingBooking) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row">
      <!-- Left Column -->
      <div class="col-md-8">
        <!-- Booking Summary -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Booking Summary</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <p><strong>Customer:</strong> {{ $colivingBooking->customer_name }}</p>
                <p><strong>Email:</strong> {{ $colivingBooking->customer_email }}</p>
                <p><strong>Phone:</strong> {{ $colivingBooking->customer_phone }}</p>
              </div>
              <div class="col-md-6">
                <p><strong>Room:</strong> {{ $colivingBooking->colivingRoom->name ?? '-' }}</p>
                <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($colivingBooking->check_in_date->format('d M Y')) }}</p>
                <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($colivingBooking->check_out_date->format('d M Y')) }}</p>
                <p><strong>Total:</strong>
                  <span class="text-primary">Rp {{ number_format($colivingBooking->total_amount, 0, ',', '.') }}</span>
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Status Update Form -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Update Status</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="payment_status">Payment Status <span class="text-danger">*</span></label>
                  <select name="payment_status" id="payment_status" class="form-control @error('payment_status') is-invalid @enderror" required>
                    <option value="pending" {{ old('payment_status', $colivingBooking->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ old('payment_status', $colivingBooking->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ old('payment_status', $colivingBooking->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ old('payment_status', $colivingBooking->payment_status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                  </select>
                  @error('payment_status')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                  <small class="form-text text-muted">Update payment status dari customer</small>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label for="booking_status">Booking Status <span class="text-danger">*</span></label>
                  <select name="booking_status" id="booking_status" class="form-control @error('booking_status') is-invalid @enderror" required>
                    <option value="confirmed" {{ old('booking_status', $colivingBooking->booking_status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ old('booking_status', $colivingBooking->booking_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="completed" {{ old('booking_status', $colivingBooking->booking_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="no_show" {{ old('booking_status', $colivingBooking->booking_status) == 'no_show' ? 'selected' : '' }}>No Show</option>
                  </select>
                  @error('booking_status')
                    <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                  <small class="form-text text-muted">Status kehadiran customer</small>
                </div>
              </div>
            </div>

            <div class="form-group" id="cancellation-reason-group" style="display: none;">
              <label for="cancellation_reason">Cancellation Reason</label>
              <textarea name="cancellation_reason" id="cancellation_reason" rows="3" class="form-control @error('cancellation_reason') is-invalid @enderror" placeholder="Kenapa booking ini dibatalkan?">{{ old('cancellation_reason', $colivingBooking->cancellation_reason) }}</textarea>
              @error('cancellation_reason')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
              <small class="form-text text-muted">Required jika status booking adalah Cancelled</small>
            </div>
          </div>
        </div>

        <!-- Current Status Info -->
        <div class="card bg-light">
          <div class="card-body">
            <h5 class="mb-3">Current Status Information</h5>
            <div class="row">
              <div class="col-md-6">
                <p class="mb-2">
                  <strong>Current Payment Status:</strong>
                  @php
                    $paymentBadges = ['pending' => 'warning', 'paid' => 'success', 'failed' => 'danger', 'refunded' => 'secondary'];
                    $badge = $paymentBadges[$colivingBooking->payment_status] ?? 'secondary';
                  @endphp
                  <span class="badge badge-{{ $badge }}">{{ ucfirst($colivingBooking->payment_status) }}</span>
                </p>
                @if($colivingBooking->paid_at)
                <p class="mb-0"><small class="text-muted">Paid at: {{ $colivingBooking->paid_at->format('d M Y H:i') }}</small></p>
                @endif
              </div>
              <div class="col-md-6">
                <p class="mb-2">
                  <strong>Current Booking Status:</strong>
                  @php
                    $bookingBadges = ['confirmed' => 'success', 'cancelled' => 'danger', 'completed' => 'primary', 'no_show' => 'dark'];
                    $badge = $bookingBadges[$colivingBooking->booking_status] ?? 'secondary';
                  @endphp
                  <span class="badge badge-{{ $badge }}">{{ ucfirst($colivingBooking->booking_status) }}</span>
                </p>
                @if($colivingBooking->cancelled_at)
                <p class="mb-0"><small class="text-muted">Cancelled at: {{ $colivingBooking->cancelled_at->format('d M Y H:i') }}</small></p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-md-4">
        <!-- Status Guide -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Status Guide</h3>
          </div>
          <div class="card-body">
            <h6 class="text-bold">Payment Status:</h6>
            <ul class="pl-3 mb-3">
              <li><strong>Pending:</strong> Menunggu pembayaran</li>
              <li><strong>Paid:</strong> Sudah dibayar lunas</li>
              <li><strong>Failed:</strong> Pembayaran gagal</li>
              <li><strong>Refunded:</strong> Uang dikembalikan</li>
            </ul>

            <h6 class="text-bold">Booking Status:</h6>
            <ul class="pl-3 mb-0">
              <li><strong>Confirmed:</strong> Booking aktif</li>
              <li><strong>Cancelled:</strong> Dibatalkan</li>
              <li><strong>Completed:</strong> Selesai check-out</li>
              <li><strong>No Show:</strong> Tidak datang</li>
            </ul>
          </div>
        </div>

        <!-- Important Notes -->
        <div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title">Important Notes</h3>
          </div>
          <div class="card-body">
            <div class="callout callout-warning mb-0">
              <h6><i class="fas fa-exclamation-triangle"></i> Perhatian!</h6>
              <ul class="mb-0 pl-3">
                <li>Pastikan status payment dan booking sesuai</li>
                <li>Jika cancel, isi alasan pembatalan</li>
                <li>Status completed untuk customer yang sudah check-out</li>
                <li>Perubahan status akan mempengaruhi availability room</li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Submit Actions -->
        <div class="card">
          <div class="card-body">
            <button type="submit" class="btn btn-primary btn-block btn-lg">
              <i class="fas fa-save mr-2"></i> Update Status
            </button>
            <a href="{{ route('admin.coliving-bookings.show', $colivingBooking) }}" class="btn btn-secondary btn-block">
              <i class="fas fa-times mr-2"></i> Cancel
            </a>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
  // Toggle cancellation reason field
  function toggleCancellationReason() {
    const bookingStatus = $('#booking_status').val();
    if (bookingStatus === 'cancelled') {
      $('#cancellation-reason-group').slideDown();
      $('#cancellation_reason').attr('required', true);
    } else {
      $('#cancellation-reason-group').slideUp();
      $('#cancellation_reason').attr('required', false);
    }
  }

  // Initial check
  toggleCancellationReason();

  // On change
  $('#booking_status').on('change', toggleCancellationReason);

  // Form validation
  $('form').on('submit', function(e) {
    const bookingStatus = $('#booking_status').val();
    const cancellationReason = $('#cancellation_reason').val().trim();

    if (bookingStatus === 'cancelled' && cancellationReason === '') {
      e.preventDefault();
      alert('Please provide a cancellation reason when setting status to Cancelled');
      $('#cancellation_reason').focus();
      return false;
    }
  });
});
</script>
@endsection
