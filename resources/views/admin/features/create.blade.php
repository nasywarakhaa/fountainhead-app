@extends('layouts.app')

@section('title', 'Create New Feature')

@section('styles')
<style>
/* Style yang sama persis dengan modul Hero Sliders */
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
            <h3 class="mb-1"><i class="fas fa-plus-circle mr-2 text-primary"></i>Create New Feature</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.features.index') }}">Features</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.features.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <!-- Kartu Detail -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Feature Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g., Free Wi-Fi">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="e.g., High-speed internet for all our guests.">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Kartu Ikon -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-icons mr-2"></i>Icon</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="icon" class="font-weight-bold d-block mb-2">Choose an Icon</label>
                            <button type="button" id="icon-picker" class="btn btn-outline-secondary btn-block" data-iconset="fontawesome5" data-icon="{{ old('icon', 'fas fa-star') }}" role="iconpicker"></button>
                            <input type="hidden" name="icon" id="icon" value="{{ old('icon', 'fas fa-star') }}">
                            @error('icon')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-2"><i class="fas fa-info-circle text-info"></i> Click the button above to select an icon visually.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-lg-4">
                 <!-- Kartu Pro Tips (Sama seperti Hero Slider) -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-lightbulb mr-2"></i>Pro Tips</h5>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3"><i class="fas fa-check-circle text-success mr-2"></i>Choose icons that are easy to understand.</li>
                            <li class="mb-3"><i class="fas fa-check-circle text-success mr-2"></i>Keep titles short and to the point.</li>
                            <li class="mb-0"><i class="fas fa-check-circle text-success mr-2"></i>Use Sort Order to arrange important features first.</li>
                        </ul>
                    </div>
                </div>
                <!-- Kartu Settings -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #3052ea 0%, #a2924b 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-cog mr-2"></i>Settings & Status</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="sort_order" class="font-weight-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                            <small class="text-muted">Features sort ascending (0, 1, 2...).</small>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                            <label class="custom-control-label" for="is_active">Set as Active</label>
                        </div>
                    </div>
                </div>
                <!-- Kartu Aksi -->
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3" style="border-radius: 10px; font-weight: 600;"><i class="fas fa-save mr-2"></i>Create Feature</button>
                        <a href="{{ route('admin.features.index') }}" class="btn btn-outline-secondary btn-lg btn-block" style="border-radius: 10px; font-weight: 600;"><i class="fas fa-times mr-2"></i>Cancel</a>
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
    $('#icon-picker').iconpicker();
    $('#icon-picker').on('change', function(e) {
        $('#icon').val(e.icon);
    });
    $('form').on('submit', function(e) {
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Creating...');
    });
});
</script>
@endsection

