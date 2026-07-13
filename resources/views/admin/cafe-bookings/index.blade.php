@extends('layouts.app')

@section('title', 'Cafe Event Bookings')
@section('styles')
<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
}

#bookings-table thead th {
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #dee2e6;
}

#bookings-table tbody tr {
    transition: all 0.2s ease;
}

#bookings-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.btn-group .btn {
    transition: all 0.2s ease;
}

.btn-group .btn:hover {
    transform: scale(1.1);
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #3052ea 0%, #a2924b 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 text-white"><i class="fas fa-calendar-alt mr-2"></i>Event Bookings</h3>
                            <p class="mb-0 text-white-50">Manage cafe event reservations</p>
                        </div>
                        <div>
                            <span class="badge badge-light px-3 py-2" style="font-size: 1rem;">
                                <i class="fas fa-coffee mr-1"></i> Cafe Management
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #f39c12;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Pending Approval</h6>
                            <h3 class="mb-0 font-weight-bold" id="pending-count">-</h3>
                        </div>
                        <div class="text-warning" style="font-size: 2rem;">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #28a745;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Confirmed</h6>
                            <h3 class="mb-0 font-weight-bold" id="confirmed-count">-</h3>
                        </div>
                        <div class="text-success" style="font-size: 2rem;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #17a2b8;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">This Month</h6>
                            <h3 class="mb-0 font-weight-bold" id="month-count">-</h3>
                        </div>
                        <div class="text-info" style="font-size: 2rem;">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #6f42c1;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Revenue</h6>
                            <h3 class="mb-0 font-weight-bold" id="revenue-count">-</h3>
                        </div>
                        <div class="text-purple" style="font-size: 2rem; color: #6f42c1;">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                <div class="card-header bg-white" style="border-radius: 15px 15px 0 0; border-bottom: 2px solid #f0f0f0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-list mr-2 text-primary"></i>All Event Bookings
                        </h5>
                        <div>
                            <button class="btn btn-outline-primary btn-sm" id="refresh-btn">
                                <i class="fas fa-sync-alt mr-1"></i> Refresh
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="bookings-table" class="table table-hover" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Booking Ref</th>
                                    <th>Customer</th>
                                    <th>Event Info</th>
                                    <th>Schedule</th>
                                    <th>Venue</th>
                                    <th>Total Amount</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#bookings-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ route("admin.cafe-bookings.index") }}',
        columns: [
            { data: 'booking_ref', name: 'id' },
            { data: 'customer', name: 'customer_name' },
            { data: 'event_info', name: 'event_name' },
            { data: 'schedule', name: 'event_date' },
            { data: 'venue', name: 'space_type' },
            { data: 'total', name: 'total_amount' },
            { data: 'payment_status', name: 'payment_status' },
            { data: 'booking_status', name: 'booking_status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[3, 'desc']],
        pageLength: 25,
        language: {
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
            emptyTable: '<i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>No event bookings found',
            zeroRecords: '<i class="fas fa-search fa-3x text-muted mb-3"></i><br>No matching records found'
        },
        drawCallback: function() {
            loadStats();
            initApproveButtons();
        }
    });

    // Refresh button
    $('#refresh-btn').on('click', function() {
        $(this).find('i').addClass('fa-spin');
        table.ajax.reload(function() {
            $('#refresh-btn i').removeClass('fa-spin');
        });
    });

    // Approve button handler
    function initApproveButtons() {
        $('.approve-btn').off('click').on('click', function() {
            const bookingId = $(this).data('id');

            Swal.fire({
                title: 'Approve Booking?',
                text: "This will confirm the event booking.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-check mr-1"></i> Yes, Approve',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    approveBooking(bookingId);
                }
            });
        });
    }

    function approveBooking(bookingId) {
        $.ajax({
            url: `/admin/cafe-bookings/${bookingId}/approve`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                table.ajax.reload();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || 'Failed to approve booking',
                });
            }
        });
    }
    // Function to load stats
    function loadStats() {
        $.ajax({
            url: '{{ route("admin.cafe-bookings.stats") }}',
            type: 'GET',
            beforeSend: function() {
                $('.card-body h3[id$="-count"]').html('<i class="fas fa-spinner fa-sm fa-spin"></i>');
            },
            success: function(response) {
                if (response) {
                    $('#pending-count').text(response.pending_booking || 0);
                    $('#confirmed-count').text(response.confirmed_booking || 0);
                    $('#revenue-count').text(
                    response.total_revenue
                        ? 'Rp ' + new Intl.NumberFormat('id-ID').format(response.total_revenue)
                        : 'Rp 0'
                    );
                    $('#month-count').text(response.monthly_booking || 0);
                }
            },
            error: function(xhr) {
                console.error('Failed to load room stats:', xhr);
                $('.card-body h3[id$="-count"]').text('-');
            }
        });
    }
});
</script>
@endsection
