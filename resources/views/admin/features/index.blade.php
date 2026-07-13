@extends('layouts.app')

@section('title', 'Feature Management')

@section('styles')
<style>
.hover-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.hover-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important; }
#features-table thead th { font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #dee2e6; }
#features-table tbody tr { transition: all 0.2s ease; }
#features-table tbody tr:hover { background-color: #f8f9fa; transform: scale(1.01); box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #007bff 0%, #343a40 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 text-white"><i class="fas fa-star mr-2"></i>Feature Management</h3>
                            <p class="mb-0 text-white-50">Manage the features displayed on the site</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.features.create') }}" class="btn btn-light btn-lg"><i class="fas fa-plus mr-2"></i>Add Feature</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #17a2b8;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Features</h6>
                            <h3 class="mb-0 font-weight-bold" id="total-features-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #17a2b8;"><i class="fas fa-layer-group"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #28a745;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Active Features</h6>
                            <h3 class="mb-0 font-weight-bold" id="active-features-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #28a745;"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #ffc107;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">With Icon</h6>
                            <h3 class="mb-0 font-weight-bold" id="with-icon-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #ffc107;"><i class="fas fa-icons"></i></div>
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
                        <h5 class="mb-0 font-weight-bold"><i class="fas fa-list mr-2 text-primary"></i>All Features</h5>
                        <button class="btn btn-outline-primary btn-sm" id="refresh-btn"><i class="fas fa-sync-alt mr-1"></i> Refresh</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="features-table" class="table table-hover" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>Icon</th>
                                    <th>Title</th>
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
    const table = $('#features-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ route("admin.features.index") }}',
        columns: [
            { data: 'icon_preview', name: 'icon', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'status', name: 'is_active' },
            { data: 'sort_order', name: 'sort_order' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[3, 'asc']],
        language: {
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
            emptyTable: '<i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>No features found',
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
                title: 'Delete Feature?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash mr-1"></i> Yes, Delete',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteFeature(deleteUrl);
                }
            });
        });
    }

    function deleteFeature(url) {
        $.ajax({
            url: url,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: (response) => {
                Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000, showConfirmButton: false });
                table.ajax.reload();
            },
            error: () => Swal.fire('Error!', 'Failed to delete feature.', 'error')
        });
    }

    function loadStats() {
        $.ajax({
            url: '{{ route("admin.features.stats") }}',
            type: 'GET',
            beforeSend: () => $('[id$="-count"]').html('<i class="fas fa-spinner fa-sm fa-spin"></i>'),
            success: (response) => {
                $('#total-features-count').text(response.total_features || 0);
                $('#active-features-count').text(response.active_features || 0);
                $('#with-icon-count').text(response.with_icon || 0);
            },
            error: () => $('[id$="-count"]').text('-')
        });
    }
});
</script>
@endsection
