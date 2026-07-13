@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
.border-left-primary {
  border-left: 4px solid #007bff !important;
}
.border-left-success {
  border-left: 4px solid #28a745 !important;
}
.border-left-warning {
  border-left: 4px solid #ffc107 !important;
}
.border-left-info {
  border-left: 4px solid #17a2b8 !important;
}
.border-left-danger {
  border-left: 4px solid #dc3545 !important;
}
.opacity-50 {
  opacity: 0.5;
}
.card {
  border-radius: 8px;
  transition: transform 0.2s;
}
.card:hover {
  transform: translateY(-2px);
}
.text-xs {
  font-size: 0.75rem;
}
</style>
@endsection
@section('content')
<div class="container-fluid">
  <!-- Header -->
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="mb-2 font-weight-bold">Dashboard</h2>
      <p class="text-muted">Welcome back, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>! Here's what's happening today.</p>
    </div>
  </div>

  <!-- Stats Cards Row 1: Coliving -->
  <div class="row mb-4">
    <div class="col-12">
      <h5 class="text-muted mb-3"><i class="fas fa-bed mr-2"></i>Coliving Overview</h5>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
      <div class="card border-left-primary shadow-sm h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Rooms</div>
              <div class="h3 mb-0 font-weight-bold">{{ \App\Models\ColivingRoom::count() }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-bed fa-2x text-primary opacity-50"></i>
            </div>
          </div>
          <div class="mt-2">
            <a href="{{ route('admin.coliving-rooms.index') }}" class="btn btn-sm btn-outline-primary btn-block">
              Manage Rooms <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
      <div class="card border-left-success shadow-sm h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Available</div>
              <div class="h3 mb-0 font-weight-bold">{{ \App\Models\ColivingRoom::where('is_available', true)->count() }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-check-circle fa-2x text-success opacity-50"></i>
            </div>
          </div>
          <div class="mt-2">
            <small class="text-muted">Ready for booking</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
      <div class="card border-left-warning shadow-sm h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Bookings</div>
              <div class="h3 mb-0 font-weight-bold">{{ \App\Models\ColivingBooking::count() }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar-check fa-2x text-warning opacity-50"></i>
            </div>
          </div>
          <div class="mt-2">
            <a href="{{ route('admin.coliving-bookings.index') }}" class="btn btn-sm btn-outline-warning btn-block">
              View Bookings <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
      <div class="card border-left-info shadow-sm h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Revenue</div>
              <div class="h5 mb-0 font-weight-bold">Rp {{ number_format(\App\Models\ColivingBooking::where('payment_status', 'paid')->sum('total_amount'), 0, ',', '.') }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-money-bill-wave fa-2x text-info opacity-50"></i>
            </div>
          </div>
          <div class="mt-2">
            <small class="text-muted">Total paid bookings</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Cards Row 2: Cafe Events -->
  <div class="row mb-4">
    <div class="col-12">
      <h5 class="text-muted mb-3"><i class="fas fa-coffee mr-2"></i>Cafe Events Overview</h5>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
      <div class="card border-left-danger shadow-sm h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pending Approval</div>
              <div class="h3 mb-0 font-weight-bold">{{ \App\Models\CafeEventBooking::where('booking_status', 'pending_approval')->count() }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clock fa-2x text-danger opacity-50"></i>
            </div>
          </div>
          <div class="mt-2">
            <a href="{{ route('admin.cafe-bookings.index') }}" class="btn btn-sm btn-outline-danger btn-block">
              Review Now <i class="fas fa-arrow-right ml-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
      <div class="card border-left-success shadow-sm h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Confirmed</div>
              <div class="h3 mb-0 font-weight-bold">{{ \App\Models\CafeEventBooking::where('booking_status', 'confirmed')->count() }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-check-double fa-2x text-success opacity-50"></i>
            </div>
          </div>
          <div class="mt-2">
            <small class="text-muted">Upcoming events</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
      <div class="card border-left-primary shadow-sm h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">This Month</div>
              <div class="h3 mb-0 font-weight-bold">{{ \App\Models\CafeEventBooking::whereMonth('event_date', now()->month)->count() }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar-alt fa-2x text-primary opacity-50"></i>
            </div>
          </div>
          <div class="mt-2">
            <small class="text-muted">Events scheduled</small>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
      <div class="card border-left-info shadow-sm h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Event Revenue</div>
              <div class="h5 mb-0 font-weight-bold">Rp {{ number_format(\App\Models\CafeEventBooking::where('payment_status', 'paid')->sum('total_amount'), 0, ',', '.') }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-info opacity-50"></i>
            </div>
          </div>
          <div class="mt-2">
            <small class="text-muted">Total event revenue</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Activity Section -->
  <div class="row">
    <!-- Recent Coliving Bookings -->
    <div class="col-lg-6 mb-4">
      <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 font-weight-bold">
              <i class="fas fa-bed text-primary mr-2"></i>Recent Coliving Bookings
            </h5>
            <a href="{{ route('admin.coliving-bookings.index') }}" class="btn btn-sm btn-primary">View All</a>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Ref</th>
                  <th>Customer</th>
                  <th>Room</th>
                  <th>Check-in</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse(\App\Models\ColivingBooking::with('colivingRoom')->latest()->limit(5)->get() as $booking)
                <tr>
                  <td>
                    <a href="{{ route('admin.coliving-bookings.show', $booking) }}" class="font-weight-bold">
                      {{ $booking->booking_reference }}
                    </a>
                  </td>
                  <td>
                    <small>{{ $booking->customer_name }}</small>
                  </td>
                  <td>
                    <small>{{ $booking->colivingRoom->name ?? '-' }}</small>
                  </td>
                  <td>
                    <small>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</small>
                  </td>
                  <td>
                    @php
                      $badges = ['confirmed' => 'success', 'cancelled' => 'danger', 'completed' => 'primary', 'no_show' => 'dark'];
                      $badge = $badges[$booking->booking_status] ?? 'secondary';
                    @endphp
                    <span class="badge badge-{{ $badge }}">{{ ucfirst($booking->booking_status) }}</span>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                    No bookings yet
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Event Bookings -->
    <div class="col-lg-6 mb-4">
      <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 font-weight-bold">
              <i class="fas fa-calendar-alt text-danger mr-2"></i>Recent Event Bookings
            </h5>
            <a href="{{ route('admin.cafe-bookings.index') }}" class="btn btn-sm btn-danger">View All</a>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-hover mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Ref</th>
                  <th>Event</th>
                  <th>Customer</th>
                  <th>Date</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse(\App\Models\CafeEventBooking::latest()->limit(5)->get() as $booking)
                <tr>
                  <td>
                    <a href="{{ route('admin.cafe-bookings.show', $booking) }}" class="font-weight-bold">
                      {{ $booking->booking_reference }}
                    </a>
                  </td>
                  <td>
                    <small>{{ $booking->event_name }}</small>
                  </td>
                  <td>
                    <small>{{ $booking->customer_name }}</small>
                  </td>
                  <td>
                    <small>{{ $booking->event_date}}</small>
                  </td>
                  <td>
                    @php
                      $badges = [
                        'pending_approval' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'primary'
                      ];
                      $badge = $badges[$booking->booking_status] ?? 'secondary';
                    @endphp
                    <span class="badge badge-{{ $badge }}">{{ ucfirst(str_replace('_', ' ', $booking->booking_status)) }}</span>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                    No event bookings yet
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions & Additional Info -->
  <div class="row">
    <!-- Today's Activity -->
    <div class="col-lg-4 mb-4">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><i class="fas fa-calendar-day mr-2"></i>Today's Activity</h5>
        </div>
        <div class="card-body">
          <div class="mb-3 pb-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-muted">Check-ins</span>
              <h4 class="mb-0 font-weight-bold">
                {{ \App\Models\ColivingBooking::whereDate('check_in_date', today())->where('booking_status', 'confirmed')->count() }}
              </h4>
            </div>
            <small class="text-muted">Guests arriving today</small>
          </div>
          <div class="mb-3 pb-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-muted">Events Today</span>
              <h4 class="mb-0 font-weight-bold">
                {{ \App\Models\CafeEventBooking::whereDate('event_date', today())->where('booking_status', 'confirmed')->count() }}
              </h4>
            </div>
            <small class="text-muted">Scheduled events</small>
          </div>
          <div>
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-muted">Check-outs</span>
              <h4 class="mb-0 font-weight-bold">
                {{ \App\Models\ColivingBooking::whereDate('check_out_date', today())->where('booking_status', 'confirmed')->count() }}
              </h4>
            </div>
            <small class="text-muted">Guests leaving today</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Actions -->
    <div class="col-lg-4 mb-4">
      <div class="card shadow-sm">
        <div class="card-header bg-warning text-white">
          <h5 class="mb-0"><i class="fas fa-exclamation-circle mr-2"></i>Pending Actions</h5>
        </div>
        <div class="card-body">
          <div class="mb-3 pb-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-muted">Pending Payments</span>
              <h4 class="mb-0 font-weight-bold text-warning">
                {{ \App\Models\ColivingBooking::where('payment_status', 'pending')->count() + \App\Models\CafeEventBooking::where('payment_status', 'pending')->count() }}
              </h4>
            </div>
            <small class="text-muted">Awaiting payment confirmation</small>
          </div>
          <div class="mb-3 pb-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-muted">Event Approvals</span>
              <h4 class="mb-0 font-weight-bold text-danger">
                {{ \App\Models\CafeEventBooking::where('booking_status', 'pending_approval')->count() }}
              </h4>
            </div>
            <small class="text-muted">Needs your review</small>
          </div>
          <div>
            <a href="{{ route('admin.cafe-bookings.index') }}" class="btn btn-warning btn-block">
              <i class="fas fa-tasks mr-2"></i>Review Pending
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- System Info -->
    <div class="col-lg-4 mb-4">
      <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
          <h5 class="mb-0"><i class="fas fa-chart-line mr-2"></i>Quick Stats</h5>
        </div>
        <div class="card-body">
          <div class="mb-3 pb-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-muted">Featured Rooms</span>
              <h4 class="mb-0 font-weight-bold text-success">
                {{ \App\Models\ColivingRoom::where('is_featured', true)->count() }}
              </h4>
            </div>
            <small class="text-muted">Currently promoted</small>
          </div>
          <div class="mb-3 pb-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
              <span class="text-muted">Homepage Sections</span>
              <h4 class="mb-0 font-weight-bold text-info">
                {{ \App\Models\HomepageSection::count() }}
              </h4>
            </div>
            <small class="text-muted">Active sections</small>
          </div>
          <div>
            <a href="{{ route('admin.homepage.index') }}" class="btn btn-success btn-block">
              <i class="fas fa-home mr-2"></i>Manage Homepage
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
