@extends('layouts.app')

@section('title', 'FAQ Management')

@section('styles')
<style>
/* Style yang sama persis dari modul sebelumnya */
.hover-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.hover-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important; }
#faqs-table thead th { font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
#faqs-table tbody tr:hover { background-color: #f8f9fa; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 text-white"><i class="fas fa-question-circle mr-2"></i>FAQ Management</h3>
                            <p class="mb-0 text-white-50">Manage Frequently Asked Questions</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.faqs.create') }}" class="btn btn-light btn-lg"><i class="fas fa-plus mr-2"></i>Add FAQ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #667eea;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total FAQs</h6>
                            <h3 class="mb-0 font-weight-bold" id="total-faqs-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #667eea;"><i class="fas fa-layer-group"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #11998e;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Active FAQs</h6>
                            <h3 class="mb-0 font-weight-bold" id="active-faqs-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #11998e;"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #f093fb;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Unique Categories</h6>
                            <h3 class="mb-0 font-weight-bold" id="unique-categories-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #f093fb;"><i class="fas fa-tags"></i></div>
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
                    <h5 class="mb-0 font-weight-bold"><i class="fas fa-list mr-2 text-primary"></i>All FAQs</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="faqs-table" class="table table-hover" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50%">Question & Answer</th>
                                    <th width="20%">Category</th>
                                    <th width="15%">Status</th>
                                    <th width="15%">Actions</th>
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
    const table = $('#faqs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.faqs.index") }}',
        columns: [
            { data: 'question_details', name: 'question' },
            { data: 'category', name: 'category' },
            { data: 'status', name: 'is_active' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[0, 'asc']],
        language: { processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...' },
        drawCallback: function() {
            initDeleteButtons();
        }
    });

    // Load Stats
    function loadStats() {
        $.ajax({
            url: '{{ route("admin.faqs.stats") }}',
            type: 'GET',
            success: function(response) {
                $('#total-faqs-count').text(response.total_faqs || 0);
                $('#active-faqs-count').text(response.active_faqs || 0);
                $('#unique-categories-count').text(response.unique_categories || 0);
            }
        });
    }
    loadStats(); // Load on initial page load

    // Delete button handler
    function initDeleteButtons() {
        $('.delete-btn').off('click').on('click', function() {
            const deleteUrl = $(this).data('url');
            Swal.fire({
                title: 'Delete this FAQ?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: '<i class="fas fa-trash mr-1"></i> Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success');
                            table.ajax.reload();
                            loadStats(); // Reload stats after delete
                        },
                        error: function() {
                            Swal.fire('Error!', 'Failed to delete FAQ.', 'error');
                        }
                    });
                }
            });
        });
    }
});
</script>
@endsection
