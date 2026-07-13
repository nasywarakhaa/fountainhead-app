@extends('layouts.app')

@section('title', 'Edit Event Booking')
@section('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="mb-1"><i class="fas fa-edit mr-2 text-primary"></i>Edit Event Booking</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.cafe-bookings.index') }}">Event Bookings</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.cafe-bookings.show', $cafeBooking) }}">{{ $cafeBooking->booking_reference }}</a>
                        </li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>

        <form action="{{ route('admin.cafe-bookings.update', $cafeBooking) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-8">
                    <!-- Booking Status -->
                    <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-clipboard-check mr-2"></i>Booking Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="booking_status">Booking Status <span
                                                class="text-danger">*</span></label>
                                        <select name="booking_status" id="booking_status"
                                            class="form-control @error('booking_status') is-invalid @enderror" required>
                                            <option value="pending_approval"
                                                {{ $cafeBooking->booking_status == 'pending_approval' ? 'selected' : '' }}>
                                                Pending Approval</option>
                                            <option value="confirmed"
                                                {{ $cafeBooking->booking_status == 'confirmed' ? 'selected' : '' }}>
                                                Confirmed</option>
                                            <option value="cancelled"
                                                {{ $cafeBooking->booking_status == 'cancelled' ? 'selected' : '' }}>
                                                Cancelled</option>
                                            <option value="completed"
                                                {{ $cafeBooking->booking_status == 'completed' ? 'selected' : '' }}>
                                                Completed</option>
                                        </select>
                                        @error('booking_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_status">Payment Status <span
                                                class="text-danger">*</span></label>
                                        <select name="payment_status" id="payment_status"
                                            class="form-control @error('payment_status') is-invalid @enderror" required>
                                            <option value="pending"
                                                {{ $cafeBooking->payment_status == 'pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="dp_paid"
                                                {{ $cafeBooking->payment_status == 'dp_paid' ? 'selected' : '' }}>DP Paid
                                            </option>
                                            <option value="paid"
                                                {{ $cafeBooking->payment_status == 'paid' ? 'selected' : '' }}>Paid
                                            </option>
                                            <option value="failed"
                                                {{ $cafeBooking->payment_status == 'failed' ? 'selected' : '' }}>Failed
                                            </option>
                                            <option value="refunded"
                                                {{ $cafeBooking->payment_status == 'refunded' ? 'selected' : '' }}>Refunded
                                            </option>
                                        </select>
                                        @error('payment_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i>Admin Notes</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="admin_notes">Internal Notes</label>
                                <textarea name="admin_notes" id="admin_notes" rows="4"
                                    class="form-control @error('admin_notes') is-invalid @enderror"
                                    placeholder="Add internal notes (not visible to customer)...">{{ old('admin_notes', $cafeBooking->admin_notes) }}</textarea>
                                @error('admin_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Cancellation Reason -->
                    <div class="card shadow-sm mb-4" style="border-radius: 15px;" id="cancellation-card"
                        style="display: {{ $cafeBooking->booking_status == 'cancelled' ? 'block' : 'none' }};">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0"><i class="fas fa-ban mr-2"></i>Cancellation Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="cancellation_reason">Cancellation Reason</label>
                                <textarea name="cancellation_reason" id="cancellation_reason" rows="3"
                                    class="form-control @error('cancellation_reason') is-invalid @enderror" placeholder="Reason for cancellation...">{{ old('cancellation_reason', $cafeBooking->cancellation_reason) }}</textarea>
                                @error('cancellation_reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar - Event Summary -->
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4 sticky-top" style="border-radius: 15px; top: 20px;">
                        <div class="card-header bg-gradient-primary text-white" style="border-radius: 15px 15px 0 0;">
                            <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Event Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted">Booking Reference</small>
                                <h6 class="font-weight-bold">{{ $cafeBooking->booking_reference }}</h6>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <small class="text-muted">Event Name</small>
                                <h6>{{ $cafeBooking->event_name }}</h6>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Customer</small>
                                <p class="mb-0">{{ $cafeBooking->customer_name }}</p>
                                <small>{{ $cafeBooking->customer_email }}</small>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Date & Time</small>
                                <p class="mb-0">
                                    <i class="fas fa-calendar text-primary mr-1"></i>{{ \Carbon\Carbon::parse($cafeBooking->event_date)->format('d M Y') }}
                                </p>
                                <p class="mb-0"><i
                                        class="fas fa-clock text-warning mr-1"></i>{{ date('H:i', strtotime($cafeBooking->start_time)) }}
                                    - {{ date('H:i', strtotime($cafeBooking->end_time)) }}</p>
                            </div>
                            <hr>
                            <div class="mb-0">
                                <small class="text-muted">Total Amount</small>
                                <h4 class="text-success font-weight-bold mb-0">Rp
                                    {{ number_format($cafeBooking->total_amount, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save mr-2"></i>Update Booking
                            </button>
                            <a href="{{ route('admin.cafe-bookings.show', $cafeBooking) }}"
                                class="btn btn-outline-secondary btn-block">
                                <i class="fas fa-times mr-2"></i>Cancel
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
            // Show/hide cancellation card based on booking status
            $('#booking_status').on('change', function() {
                if ($(this).val() === 'cancelled') {
                    $('#cancellation-card').slideDown();
                } else {
                    $('#cancellation-card').slideUp();
                }
            });
        });
    </script>
@endsection
