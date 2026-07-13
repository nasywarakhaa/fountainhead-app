@extends('layouts.app')

@section('title', 'Co-living Bookings')

@section('styles')
<!-- Custom CSS -->
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
  <!-- Header Card -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #3052ea 0%, #a2924b 100%);">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h3 class="mb-1 text-white"><i class="fas fa-bed mr-2"></i>Co-living Bookings</h3>
              <p class="mb-0 text-white-50">Manage Co-Living reservations</p>
            </div>
            <div>
              <span class="badge badge-light px-3 py-2" style="font-size: 1rem;">
                <i class="fas fa-building mr-1"></i> Co-Living Management
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
                        <i class="fas fa-list mr-2 text-primary"></i>All Co-living Bookings
                    </h5>
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary btn-sm" id="reset-filter">
                            <i class="fas fa-undo mr-1"></i> Reset Filter
                        </button>
                        <button class="btn btn-outline-primary btn-sm" id="refresh-btn">
                            <i class="fas fa-sync-alt mr-1"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <form id="filter-form" class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label for="payment_status_filter">Payment Status</label>
                            <select name="payment_status" id="payment_status_filter" class="form-control form-control-sm">
                                <option value="">All</option>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="failed">Failed</option>
                                <option value="refunded">Refunded</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label for="booking_status_filter">Booking Status</label>
                            <select name="booking_status" id="booking_status_filter" class="form-control form-control-sm">
                                <option value="">All</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="completed">Completed</option>
                                <option value="no_show">No Show</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="date_range">Check-in Date Range</label>
                            <input type="text" id="date_range" class="form-control form-control-sm" placeholder="Select date range">
                        </div>
                    </div>
                </form>

                <hr>

                <!-- DataTable -->
                <div class="table-responsive">
                    <table id="bookings-table" class="table table-hover" style="width:100%">
                        <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Booking Ref</th>
                            <th>Room</th>
                            <th>Customer</th>
                            <th>Check-in / Check-out</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th width="10%">Actions</th>
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

  // Initialize Date Range Picker
  $('#date_range').daterangepicker({
    opens: 'left',
    autoUpdateInput: false,
    locale: { cancelLabel: 'Clear', format: 'YYYY-MM-DD' },
    ranges: {
      'Today': [moment(), moment()],
      'Yesterday': [moment().subtract(1,'days'), moment().subtract(1,'days')],
      'Last 7 Days': [moment().subtract(6,'days'), moment()],
      'Last 30 Days': [moment().subtract(29,'days'), moment()],
      'This Month': [moment().startOf('month'), moment().endOf('month')],
      'Last Month': [moment().subtract(1,'month').startOf('month'), moment().subtract(1,'month').endOf('month')]
    }
  });

  $('#date_range').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
    table.ajax.reload();
  });

  $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
    table.ajax.reload();
  });

  // Initialize DataTable
  const table = $('#bookings-table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
      url: '{{ route('admin.coliving-bookings.index') }}',
      data: function(d) {
        d.payment_status = $('#payment_status_filter').val();
        d.booking_status = $('#booking_status_filter').val();
        d.date_range = $('#date_range').val();
      }
    },
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'booking_ref', name: 'id' },
      { data: 'room', name: 'colivingRoom.name' },
      { data: 'customer', name: 'customer_name' },
      { data: 'dates', name: 'check_in_date' },
      { data: 'total', name: 'total_amount', render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ') },
      {
        data: 'payment_status',
        name: 'payment_status',
        render: function(data){
          let cls = '';
          switch(data) {
              case 'paid': cls = 'badge-success'; break;
              case 'pending': cls = 'badge-warning'; break;
              case 'failed': cls = 'badge-danger'; break;
              case 'refunded': cls = 'badge-info'; break;
              default: cls = 'badge-secondary';
          }
          return `<span class="badge ${cls}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
        }
      },
      {
        data: 'booking_status',
        name: 'booking_status',
        render: function(data){
          let text = data.replace('_',' ');
          let cls = '';
           switch(data) {
              case 'confirmed': cls = 'badge-success'; break;
              case 'completed': cls = 'badge-primary'; break;
              case 'cancelled': cls = 'badge-danger'; break;
              case 'no_show': cls = 'badge-dark'; break;
              default: cls = 'badge-info';
          }
          return `<span class="badge ${cls}">${text.charAt(0).toUpperCase() + text.slice(1)}</span>`;
        }
      },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    language: {
        processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
        emptyTable: '<i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>No bookings found',
        zeroRecords: '<i class="fas fa-search fa-3x text-muted mb-3"></i><br>No matching records found'
    },
    order: [[1, 'desc']],
        drawCallback: function(settings) {
        loadStats();
    }
  });

  // Filters Change Handler
  $('#payment_status_filter, #booking_status_filter').on('change', function() {
    table.ajax.reload();
  });

  // Reset Button
  $('#reset-filter').on('click', function() {
    $('#filter-form').trigger('reset');
    $('#date_range').val('');
    table.ajax.reload();
  });

  // Refresh button
  $('#refresh-btn').on('click', function() {
      $(this).find('i').addClass('fa-spin');
      table.ajax.reload(function() {
          $('#refresh-btn i').removeClass('fa-spin');
      });
  });
    // Function to load stats
    function loadStats() {
        $.ajax({
            url: '{{ route("admin.coliving-bookings.stats") }}',
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
