@extends('layouts.app')

@section('title', 'Coliving Rooms')

@section('styles')
<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
}
#rooms-table thead th {
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #dee2e6;
}
#rooms-table tbody tr {
    transition: all 0.2s ease;
}
#rooms-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.room-thumbnail {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
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
              <h3 class="mb-1 text-white"><i class="fas fa-person-booth mr-2"></i>Coliving Rooms</h3>
              <p class="mb-0 text-white-50">Manage co-living room data</p>
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
  <!-- Stats Cards -->
  <div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #17a2b8;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Rooms</h6>
                    <h3 class="mb-0 font-weight-bold" id="total-rooms-count">-</h3>
                </div>
                <div class="text-info" style="font-size: 2rem;"><i class="fas fa-door-open"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #28a745;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Available</h6>
                    <h3 class="mb-0 font-weight-bold" id="available-rooms-count">-</h3>
                </div>
                <div class="text-success" style="font-size: 2rem;"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #ffc107;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Featured</h6>
                    <h3 class="mb-0 font-weight-bold" id="featured-rooms-count">-</h3>
                </div>
                <div class="text-warning" style="font-size: 2rem;"><i class="fas fa-star"></i></div>
            </div>
        </div>
    </div>
     <div class="col-lg-3 col-md-6 mb-3">
        <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #dc3545;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Unavailable</h6>
                    <h3 class="mb-0 font-weight-bold" id="unavailable-rooms-count">-</h3>
                </div>
                <div class="text-danger" style="font-size: 2rem;"><i class="fas fa-times-circle"></i></div>
            </div>
        </div>
    </div>
  </div>

  <!-- Main Table Card -->
  <div class="card shadow-sm" style="border-radius: 15px; border: none;">
    <div class="card-header bg-white" style="border-radius: 15px 15px 0 0; border-bottom: 2px solid #f0f0f0;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 font-weight-bold"><i class="fas fa-list mr-2 text-primary"></i>All Rooms</h5>
            <div>
                <button class="btn btn-outline-secondary btn-sm" id="refresh-btn"><i class="fas fa-sync-alt mr-1"></i> Refresh</button>
                <a href="{{ route('admin.coliving-rooms.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i> Add New Room</a>
            </div>
        </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="rooms-table" class="table table-hover" style="width: 100%">
            <thead class="thead-light">
            <tr>
                <th width="5%">No</th>
                <th width="10%">Image</th>
                <th width="20%">Name</th>
                <th>Type</th>
                <th>Price/Night</th>
                <th>Capacity</th>
                <th>Status</th>
                <th>Featured</th>
                <th width="12%">Actions</th>
            </tr>
            </thead>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#rooms-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ route('admin.coliving-rooms.index') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false},
            { data: 'name', name: 'name' },
            { data: 'room_type', name: 'room_type' },
            { data: 'price', name: 'price_per_night', render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ') },
            { data: 'capacity', name: 'capacity' },
            { data: 'status', name: 'is_available' },
            { data: 'featured', name: 'is_featured' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
            emptyTable: '<i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>No bookings found',
            zeroRecords: '<i class="fas fa-search fa-3x text-muted mb-3"></i><br>No matching records found'
        },
        order: [[2, 'asc']],
        drawCallback: function(settings) {
            loadStats();
        }
    });

    // Refresh button handler
    $('#refresh-btn').on('click', function() {
        $(this).find('i').addClass('fa-spin');
        table.ajax.reload(function() {
            $('#refresh-btn i').removeClass('fa-spin');
        });
    });

    // Delete handler using SweetAlert2
    $(document).on('click', '.delete-btn', function() {
        const url = $(this).data('url');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                table.ajax.reload(); // Reloads data without refreshing page
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function(xhr) {
                Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: xhr.responseJSON?.message || 'Failed to delete the item.'
                });
            }
        });
        }
    });
});

    // Function to load stats
    function loadStats() {
        $.ajax({
            url: '{{ route("admin.coliving-rooms.stats") }}',
            type: 'GET',
            beforeSend: function() {
                $('.card-body h3[id$="-count"]').html('<i class="fas fa-spinner fa-sm fa-spin"></i>');
            },
            success: function(response) {
                if (response) {
                    $('#total-rooms-count').text(response.total_rooms || 0);
                    $('#available-rooms-count').text(response.available_rooms || 0);
                    $('#featured-rooms-count').text(response.featured_rooms || 0);
                    $('#unavailable-rooms-count').text(response.unavailable_rooms || 0);
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
