@extends('layouts.app')

@section('title', 'View Message')

@section('styles')
<style>
/* Style yang konsisten dengan modul lain */
.card-message-body {
    white-space: pre-wrap; /* Mempertahankan format spasi dan baris baru */
    font-size: 1.05rem;
    line-height: 1.6;
}
.list-group-item {
    border: none;
    padding-left: 0;
    padding-right: 0;
}
.list-group-item strong {
    display: inline-block;
    width: 90px;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1"><i class="fas fa-eye mr-2 text-primary"></i>View Message</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.contact-messages.index') }}">Inbox</a></li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri: Isi Pesan -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0">
                        <i class="fas fa-comment-dots mr-2"></i>
                        <strong>Subject:</strong> {{ $contactMessage->subject }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="card-message-body">{{ $contactMessage->message }}</p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Detail & Aksi -->
        <div class="col-lg-4">
            <!-- Kartu Sender Info -->
            <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-user-circle mr-2"></i>Sender Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong> {{ $contactMessage->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></li>
                        <li class="list-group-item"><strong>Phone:</strong> {{ $contactMessage->phone ?? '-' }}</li>
                    </ul>
                </div>
            </div>

            <!-- Kartu Message Details -->
            <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Message Details</h5>
                </div>
                <div class="card-body">
                     <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Status:</strong>
                            @if($contactMessage->read_at)
                                <span class="badge badge-success">Read</span>
                            @else
                                <span class="badge badge-primary">New</span>
                            @endif
                        </li>
                        <li class="list-group-item"><strong>Received:</strong> {{ $contactMessage->created_at->format('d M Y, H:i') }}</li>
                        <li class="list-group-item"><strong>Read At:</strong> {{ $contactMessage->read_at ? $contactMessage->read_at->format('d M Y, H:i') : '-' }}</li>
                    </ul>
                </div>
            </div>

            <!-- Kartu Aksi -->
            <div class="card shadow-sm" style="border-radius: 15px;">
                <div class="card-body">
                    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary btn-lg btn-block mb-3"><i class="fas fa-arrow-left mr-2"></i>Back to Inbox</a>
                    <button id="delete-btn" data-url="{{ route('admin.contact-messages.destroy', $contactMessage->id) }}" class="btn btn-danger btn-lg btn-block"><i class="fas fa-trash mr-2"></i>Delete Message</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#delete-btn').on('click', function() {
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
                        Swal.fire('Deleted!', response.message, 'success').then(() => {
                            window.location.href = '{{ route("admin.contact-messages.index") }}';
                        });
                    },
                    error: function() {
                        Swal.fire('Error!', 'Failed to delete message.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endsection
