@extends('layouts.app')

@section('title', 'Event Booking Details')

@section('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}
.bg-gradient-secondary {
    background: linear-gradient(135deg, #757F9A 0%, #D7DDE8 100%);
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1"><i class="fas fa-calendar-alt mr-2 text-primary"></i>Event Booking Details</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.cafe-bookings.index') }}">Event Bookings</a></li>
                            <li class="breadcrumb-item active">{{ $cafeBooking->booking_reference }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.cafe-bookings.edit', $cafeBooking) }}" class="btn btn-info">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.cafe-bookings.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Event Information -->
            <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                <div class="card-header bg-gradient-primary text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Event Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Event Name</label>
                            <h6 class="font-weight-bold">{{ $cafeBooking->event_name }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Event Type</label>
                            <h6><span class="badge badge-secondary">{{ ucfirst($cafeBooking->event_type) }}</span></h6>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="text-muted small">Description</label>
                            <p class="mb-0">{{ $cafeBooking->event_description }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Expected Guests</label>
                            <h6><i class="fas fa-users text-primary mr-2"></i>{{ $cafeBooking->expected_guests }} people</h6>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Space Type</label>
                            <h6><span class="badge badge-info">{{ ucfirst($cafeBooking->space_type) }}</span></h6>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Duration</label>
                            <h6><i class="fas fa-clock text-warning mr-2"></i>{{ $cafeBooking->duration_hours }} hours</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule -->
            <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                <div class="card-header bg-gradient-success text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-calendar-check mr-2"></i>Schedule</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="text-muted small">Event Date</label>
                            <h6><i class="fas fa-calendar text-success mr-2"></i>{{ \Carbon\Carbon::parse($cafeBooking->event_date)->format('d M Y') }}</h6>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">Start Time</label>
                            <h6><i class="fas fa-play-circle text-info mr-2"></i>{{ date('H:i', strtotime($cafeBooking->start_time)) }}</h6>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small">End Time</label>
                            <h6><i class="fas fa-stop-circle text-danger mr-2"></i>{{ date('H:i', strtotime($cafeBooking->end_time)) }}</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Services -->
            @if($cafeBooking->additional_services && count($cafeBooking->additional_services) > 0)
            <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                <div class="card-header bg-gradient-warning text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-concierge-bell mr-2"></i>Additional Services</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($cafeBooking->additional_services as $service)
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success mr-2"></i>{{ $service }}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- Special Requirements -->
            @if($cafeBooking->special_requirements)
            <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                <div class="card-header bg-gradient-info text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-sticky-note mr-2"></i>Special Requirements</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $cafeBooking->special_requirements }}</p>
                </div>
            </div>
            @endif

            <!-- Admin Notes -->
            @if($cafeBooking->admin_notes)
            <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                <div class="card-header bg-gradient-secondary text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i>Admin Notes</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $cafeBooking->admin_notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Customer Information -->
            <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                <div class="card-header bg-gradient-primary text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-user mr-2"></i>Customer Info</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Name</label>
                        <h6 class="font-weight-bold">{{ $cafeBooking->customer_name }}</h6>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0"><a href="mailto:{{ $cafeBooking->customer_email }}">{{ $cafeBooking->customer_email }}</a></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Phone</label>
                        <p class="mb-0"><a href="tel:{{ $cafeBooking->customer_phone }}">{{ $cafeBooking->customer_phone }}</a></p>
                    </div>
                    @if($cafeBooking->organization_name)
                    <div>
                        <label class="text-muted small">Organization</label>
                        <p class="mb-0">{{ $cafeBooking->organization_name }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pricing Details -->
            <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                <div class="card-header bg-gradient-success text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave mr-2"></i>Pricing</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr>
                            <td>Venue Price</td>
                            <td class="text-right font-weight-bold">Rp {{ number_format($cafeBooking->venue_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Services Price</td>
                            <td class="text-right font-weight-bold">Rp {{ number_format($cafeBooking->services_price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-right font-weight-bold">Rp {{ number_format($cafeBooking->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Tax (11%)</td>
                            <td class="text-right font-weight-bold">Rp {{ number_format($cafeBooking->tax, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border-top">
                            <td class="font-weight-bold">Total</td>
                            <td class="text-right font-weight-bold text-success" style="font-size: 1.2rem;">Rp {{ number_format($cafeBooking->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </table>

                    @if($cafeBooking->payment_status === 'dp_paid')
                    <hr>
                    <table class="table table-sm mb-0">
                        <tr>
                            <td><span class="badge badge-success">DP Paid</span></td>
                            <td class="text-right font-weight-bold text-success">Rp {{ number_format($cafeBooking->dp_amount, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-warning">Remaining</span></td>
                            <td class="text-right font-weight-bold text-warning">Rp {{ number_format($cafeBooking->remaining_amount, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                    @endif
                </div>
            </div>

            <!-- Status Information -->
            <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                <div class="card-header bg-gradient-info text-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Booking Status</label>
                        <h6>
                            @php
                                $statusBadge = [
                                    'pending_approval' => 'warning',
                                    'confirmed' => 'success',
                                    'cancelled' => 'danger',
                                    'completed' => 'primary'
                                ][$cafeBooking->booking_status] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $statusBadge }}">{{ ucfirst(str_replace('_', ' ', $cafeBooking->booking_status)) }}</span>
                        </h6>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Payment Status</label>
                        <h6>
                            @php
                                $paymentBadge = [
                                    'pending' => 'warning',
                                    'dp_paid' => 'info',
                                    'paid' => 'success',
                                    'failed' => 'danger',
                                    'refunded' => 'secondary'
                                ][$cafeBooking->payment_status] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $paymentBadge }}">{{ ucfirst(str_replace('_', ' ', $cafeBooking->payment_status)) }}</span>
                        </h6>
                    </div>
                    @if($cafeBooking->payment_reference)
                    <div class="mb-3">
                        <label class="text-muted small">Payment Reference</label>
                        <p class="mb-0 font-weight-bold">{{ $cafeBooking->payment_reference }}</p>
                    </div>
                    @endif
                    @if($cafeBooking->approved_at)
                    <div class="mb-3">
                        <label class="text-muted small">Approved At</label>
                        <p class="mb-0">{{ $cafeBooking->approved_at->format('d M Y H:i') }}</p>
                        @if($cafeBooking->approver)
                        <small class="text-muted">by {{ $cafeBooking->approver->name }}</small>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
