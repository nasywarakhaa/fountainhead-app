@extends('layouts.app')

@section('title', 'Add New FAQ')

@section('styles')
<style>
/* Style yang sama persis dengan modul sebelumnya */
.btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; border: none; transition: all 0.3s ease; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4); }
.form-control:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25); }
.form-control-lg { font-size: 1.1rem; padding: 0.75rem 1rem; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1"><i class="fas fa-plus-circle mr-2 text-primary"></i>Add New FAQ</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.faqs.index') }}">FAQs</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.faqs.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <!-- Kartu FAQ Details -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>FAQ Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="question" class="font-weight-bold">Question <span class="text-danger">*</span></label>
                            <input type="text" name="question" id="question" class="form-control form-control-lg @error('question') is-invalid @enderror" value="{{ old('question') }}" required placeholder="e.g., What are the opening hours?">
                            @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="answer" class="font-weight-bold">Answer <span class="text-danger">*</span></label>
                            <textarea name="answer" id="answer" rows="6" class="form-control @error('answer') is-invalid @enderror" required placeholder="Provide a clear and concise answer...">{{ old('answer') }}</textarea>
                            @error('answer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Kartu Category -->
                 <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-tags mr-2"></i>Category</h5>
                    </div>
                    <div class="card-body p-4">
                         <div class="form-group">
                            <label for="category" class="font-weight-bold">Category</label>
                            <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}" placeholder="e.g., General, Booking, Facilities">
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Group FAQs by category for better organization.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-lightbulb mr-2"></i>Pro Tips</h5>
                    </div>
                    <div class="card-body p-4">
                         <ul class="list-unstyled mb-0">
                            <li class="mb-3"><i class="fas fa-check-circle text-success mr-2"></i>Keep answers short and to the point.</li>
                            <li class="mb-3"><i class="fas fa-check-circle text-success mr-2"></i>Use categories to help users find answers faster.</li>
                            <li class="mb-0"><i class="fas fa-check-circle text-success mr-2"></i>Regularly update FAQs based on customer feedback.</li>
                        </ul>
                    </div>
                </div>
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #3052ea 0%, #a2924b 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-cog mr-2"></i>Settings & Status</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="sort_order" class="font-weight-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                            <label class="custom-control-label" for="is_active">Set as Active</label>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3" style="border-radius: 10px; font-weight: 600;"><i class="fas fa-save mr-2"></i>Create FAQ</button>
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary btn-lg btn-block" style="border-radius: 10px; font-weight: 600;"><i class="fas fa-times mr-2"></i>Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('form').on('submit', function(e) {
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Creating...');
    });
});
</script>
@endsection
