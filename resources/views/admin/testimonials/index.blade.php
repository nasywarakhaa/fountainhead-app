@extends('layouts.app')

@section('title', 'Testimonial Management')

@section('styles')
<style>
/* Style yang sama persis dengan modul sebelumnya */
.hover-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.hover-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important; }
#testimonials-table thead th { font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #dee2e6; }
#testimonials-table tbody tr { transition: all 0.2s ease; }
#testimonials-table tbody tr:hover { background-color: #f8f9fa; transform: scale(1.01); box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #17a2b8 0%, #28a745 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 text-white"><i class="fas fa-comments mr-2"></i>Testimonial Management</h3>
                            <p class="mb-0 text-white-50">Manage customer feedback and testimonials</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-light btn-lg"><i class="fas fa-plus mr-2"></i>Add Testimonial</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #007bff;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Testimonials</h6>
                            <h3 class="mb-0 font-weight-bold" id="total-testimonials-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #007bff;"><i class="fas fa-layer-group"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #6f42c1;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Featured</h6>
                            <h3 class="mb-0 font-weight-bold" id="featured-testimonials-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #6f42c1;"><i class="fas fa-award"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #ffc107;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Average Rating</h6>
                            <h3 class="mb-0 font-weight-bold" id="average-rating-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #ffc107;"><i class="fas fa-star-half-alt"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white" style="border-radius: 15px 15px 0 0; border-bottom: 2px solid #f0f0f0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-list mr-2 text-primary"></i>All Testimonials</h5>
                        <button class="btn btn-outline-primary btn-sm" id="refresh-btn"><i class="fas fa-sync-alt mr-1"></i> Refresh</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="testimonials-table" class="table table-hover" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th width="10%">Customer</th>
                                    <th width="20%">Info</th>
                                    <th width="50%">Testimonial</th>
                                    <th width="10%">Rating</th>
                                    <th width="10%">Status</th>
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
    const table = $('#testimonials-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ route("admin.testimonials.index") }}',
        columns: [
            { data: 'customer_preview', name: 'customer_image', orderable: false, searchable: false },
            { data: 'customer_info', name: 'customer_name' },
            { data: 'testimonial_text', name: 'testimonial_text' },
            { data: 'rating', name: 'rating' },
            { data: 'status', name: 'is_featured' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']], // Default sort by customer name
        language: {
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
            emptyTable: '<i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>No testimonials found',
            zeroRecords: '<i class="fas fa-search fa-3x text-muted mb-3"></i><br>No matching records found'
        },
        drawCallback: function() {
            loadStats();
            initDeleteButtons();
        }
    });

    $('#refresh-btn').on('click', function() {
        $(this).find('i').addClass('fa-spin');
        table.ajax.reload(() => $(this).find('i').removeClass('fa-spin'));
    });

    function initDeleteButtons() {
        $('.delete-btn').off('click').on('click', function() {
            const deleteUrl = $(this).data('url');
            Swal.fire({
                title: 'Delete Testimonial?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash mr-1"></i> Yes, Delete',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(deleteUrl);
                }
            });
        });
    }

    function deleteItem(url) {
        $.ajax({
            url: url,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: (response) => {
                Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000, showConfirmButton: false });
                table.ajax.reload();
            },
            error: () => Swal.fire('Error!', 'Failed to delete testimonial.', 'error')
        });
    }

    function loadStats() {
        $.ajax({
            url: '{{ route("admin.testimonials.stats") }}',
            type: 'GET',
            beforeSend: () => $('[id$="-count"]').html('<i class="fas fa-spinner fa-sm fa-spin"></i>'),
            success: (response) => {
                $('#total-testimonials-count').text(response.total_testimonials || 0);
                $('#featured-testimonials-count').text(response.featured_testimonials || 0);
                $('#average-rating-count').text(response.average_rating || '0.0');
            },
            error: () => $('[id$="-count"]').text('-')
        });
    }
});
</script>
@endsection
