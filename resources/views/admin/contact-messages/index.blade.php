@extends('layouts.app')

@section('title', 'Contact Messages')

@section('styles')
<style>
/* Style yang sama persis dari modul sebelumnya */
.hover-card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.hover-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important; }
#messages-table thead th { font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
#messages-table tbody tr:hover { background-color: #f8f9fa; }
#messages-table .unread-row { font-weight: bold; background-color: #f0f8ff; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="mb-1 text-white"><i class="fas fa-envelope-open-text mr-2"></i>Contact Messages</h3>
                            <p class="mb-0 text-white-50">View and manage messages from visitors</p>
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
                            <h6 class="text-muted mb-1">Total Messages</h6>
                            <h3 class="mb-0 font-weight-bold" id="total-messages-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #4facfe;"><i class="fas fa-mail-bulk"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #f5576c;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Unread Messages</h6>
                            <h3 class="mb-0 font-weight-bold" id="unread-messages-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #f5576c;"><i class="fas fa-envelope"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm hover-card" style="border-radius: 12px; border-left: 4px solid #11998e;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Received Today</h6>
                            <h3 class="mb-0 font-weight-bold" id="today-messages-count">-</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #11998e;"><i class="fas fa-calendar-day"></i></div>
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
                    <h5 class="mb-0 font-weight-bold"><i class="fas fa-inbox mr-2 text-primary"></i>Inbox</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="messages-table" class="table table-hover" style="width:100%">
                            <thead class="thead-light">
                                <tr>
                                    <th width="25%">Sender</th>
                                    <th width="45%">Subject & Preview</th>
                                    <th width="15%">Received At</th>
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
    const table = $('#messages-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.contact-messages.index") }}',
        columns: [
            { data: 'sender_details', name: 'name' },
            { data: 'subject_preview', name: 'subject' },
            { data: 'received_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[2, 'desc']], // Order by received date descending
        language: { processing: '<i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...' },
        createdRow: function( row, data, dataIndex ) {
            // Add a class to unread rows for styling
            if(data.sender_details.includes('New')) {
                $(row).addClass('font-weight-bold');
            }
        },
        drawCallback: function() {
            initDeleteButtons();
        }
    });

    // Load Stats
    function loadStats() {
        $.ajax({
            url: '{{ route("admin.contact-messages.stats") }}',
            type: 'GET',
            success: function(response) {
                $('#total-messages-count').text(response.total_messages || 0);
                $('#unread-messages-count').text(response.unread_messages || 0);
                $('#today-messages-count').text(response.today_messages || 0);
            }
        });
    }
    loadStats();

    // Delete button handler
    function initDeleteButtons() {
        $('.delete-btn').off('click').on('click', function() {
            const deleteUrl = $(this).data('url');
            Swal.fire({
                title: 'Delete this message?',
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
                            Swal.fire('Error!', 'Failed to delete message.', 'error');
                        }
                    });
                }
            });
        });
    }
});
</script>
@endsection
