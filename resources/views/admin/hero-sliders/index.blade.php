@extends('layouts.app')

@section('title', 'Hero Slider Management')

@section('styles')
<style>
/* Konsisten dengan style hover dari modul Homepage */
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
}
#sliders-table thead th {
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #dee2e6;
}
#sliders-table tbody tr {
    transition: all 0.2s ease;
}
#sliders-table tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 text-white"><i class="fas fa-images mr-2"></i>Hero Slider Management</h3>
                            <p class="mb-0 text-white-50">Manage sliders for the main homepage banner</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.hero-sliders.create') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-plus mr-2"></i>Add Slider
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #4facfe;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Sliders</h6>
                            <h3 class="mb-0 font-weight-bold" id="total-sliders-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #4facfe;"><i class="fas fa-layer-group"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #38ef7d;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Active Sliders</h6>
                            <h3 class="mb-0 font-weight-bold" id="active-sliders-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #38ef7d;"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #f093fb;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">With CTA</h6>
                            <h3 class="mb-0 font-weight-bold" id="with-cta-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #f093fb;"><i class="fas fa-mouse-pointer"></i></div>
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
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-list mr-2 text-primary"></i>All Sliders</h5>
                        <button class="btn btn-outline-primary btn-sm" id="refresh-btn"><i class="fas fa-sync-alt mr-1"></i> Refresh</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="sliders-table" class="table table-hover" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>CTA</th>
                                    <th>Status</th>
                                    <th>Sort</th>
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
    const table = $('#sliders-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ route("admin.hero-sliders.index") }}',
        columns: [
            { data: 'image_preview', name: 'image', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'cta', name: 'cta_text' },
            { data: 'status', name: 'is_active' },
            { data: 'sort_order', name: 'sort_order' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[4, 'asc']],
        language: {
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
            emptyTable: '<i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>No sliders found',
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
                title: 'Delete Slider?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash mr-1"></i> Yes, Delete',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteSlider(deleteUrl);
                }
            });
        });
    }

    function deleteSlider(url) {
        $.ajax({
            url: url,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                table.ajax.reload();
            },
            error: function() {
                Swal.fire('Error!', 'Failed to delete slider.', 'error');
            }
        });
    }

    function loadStats() {
        $.ajax({
            url: '{{ route("admin.hero-sliders.stats") }}',
            type: 'GET',
            beforeSend: function() {
                $('[id$="-count"]').html('<i class="fas fa-spinner fa-sm fa-spin"></i>');
            },
            success: function(response) {
                if(response) {
                    $('#total-sliders-count').text(response.total_sliders || 0);
                    $('#active-sliders-count').text(response.active_sliders || 0);
                    $('#with-cta-count').text(response.with_cta || 0);
                }
            },
            error: function() {
                $('[id$="-count"]').text('-');
            }
        });
    }
});
</script>
@endsection
