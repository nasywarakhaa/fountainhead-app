@extends('layouts.app')

@section('title', 'Homepage Management')
@section('styles')
<style>
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
}

#sections-table thead th {
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #dee2e6;
}

#sections-table tbody tr {
    transition: all 0.2s ease;
}

#sections-table tbody tr:hover {
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
            <div class="card shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #3052ea 0%, #a2924b 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 text-white"><i class="fas fa-home mr-2"></i>Homepage Management</h3>
                            <p class="mb-0 text-white-50">Manage homepage sections and banners</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.homepage.create') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-plus mr-2"></i>Add Section
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
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #f093fb;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Sections</h6>
                            <h3 class="mb-0 font-weight-bold" id="total-sections-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #f093fb;">
                            <i class="fas fa-layer-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #4facfe;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">With Banners</h6>
                            <h3 class="mb-0 font-weight-bold" id="with-banners-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #4facfe;">
                            <i class="fas fa-image"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #f5576c;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">With CTA</h6>
                            <h3 class="mb-0 font-weight-bold" id="with-cta-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #f5576c;">
                            <i class="fas fa-mouse-pointer"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                <div class="card-header bg-white" style="border-radius: 15px 15px 0 0; border-bottom: 2px solid #f0f0f0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-list mr-2 text-primary"></i>All Sections
                        </h5>
                        <button class="btn btn-outline-primary btn-sm" id="refresh-btn">
                            <i class="fas fa-sync-alt mr-1"></i> Refresh
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="sections-table" class="table table-hover" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th width="15%">Banner</th>
                                    <th width="25%">Title</th>
                                    <th width="35%">Description</th>
                                    <th width="15%">CTA</th>
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
    // Initialize DataTable
    const table = $('#sections-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{{ route("admin.homepage.index") }}',
        columns: [
            { data: 'banner', name: 'banner_image', orderable: false },
            { data: 'title', name: 'title' },
            { data: 'description', name: 'description' },
            { data: 'cta', name: 'cta_text' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
        pageLength: 10,
        language: {
            processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...',
            emptyTable: '<i class="fas fa-inbox fa-3x text-muted mb-3"></i><br>No sections found',
            zeroRecords: '<i class="fas fa-search fa-3x text-muted mb-3"></i><br>No matching records found'
        },
        drawCallback: function() {
            loadStats();
            initDeleteButtons();
        }
    });

    // Refresh button
    $('#refresh-btn').on('click', function() {
        $(this).find('i').addClass('fa-spin');
        table.ajax.reload(function() {
            $('#refresh-btn i').removeClass('fa-spin');
        });
    });

    // Delete button handler
    function initDeleteButtons() {
        $('.delete-btn').off('click').on('click', function() {
            const sectionId = $(this).data('id');
            const deleteUrl = $(this).data('url');

            Swal.fire({
                title: 'Delete Section?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash mr-1"></i> Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteSection(deleteUrl);
                }
            });
        });
    }

    function deleteSection(url) {
        $.ajax({
            url: url,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
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
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to delete section',
                });
            }
        });
    }
    // Function to load stats
    function loadStats() {
        $.ajax({
            url: '{{ route("admin.homepage.stats") }}',
            type: 'GET',
            beforeSend: function() {
                $('.card-body h3[id$="-count"]').html('<i class="fas fa-spinner fa-sm fa-spin"></i>');
            },
            success: function(response) {
                if (response) {
                    $('#total-sections-count').text(response.total_sections || 0);
                    $('#with-banners-count').text(response.with_banners || 0);
                    $('#with-cta-count').text(response.with_cta || 0);
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
