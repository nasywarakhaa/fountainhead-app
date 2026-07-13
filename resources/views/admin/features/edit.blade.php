@extends('layouts.app')

@section('title', 'Edit Feature')

@section('styles')
<style>
/* Style helper yang konsisten */
.bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-gradient-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.form-control-lg { font-size: 1.1rem; padding: 0.75rem 1rem; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1"><i class="fas fa-edit mr-2 text-primary"></i>Edit Feature</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.features.index') }}">Features</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.features.update', $feature) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
             <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <!-- Kartu Detail -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-primary text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Feature Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title', $feature->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $feature->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Kartu Ikon -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                     <div class="card-header bg-gradient-info text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-icons mr-2"></i>Icon</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                             <label for="icon" class="font-weight-bold d-block mb-2">Choose an Icon</label>
                            <button type="button" id="icon-picker" class="btn btn-outline-secondary btn-block" data-iconset="fontawesome5" data-icon="{{ old('icon', $feature->icon) }}" role="iconpicker"></button>
                            <input type="hidden" name="icon" id="icon" value="{{ old('icon', $feature->icon) }}">
                             @error('icon')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

             <!-- Kolom Kanan -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-warning text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Info</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><small class="text-muted">Created:</small> {{ $feature->created_at->format('d M Y H:i') }}</p>
                        <p class="mb-0"><small class="text-muted">Updated:</small> {{ $feature->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                     <div class="card-header text-white" style="background: linear-gradient(135deg, #3052ea 0%, #a2924b 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-cog mr-2"></i>Settings & Status</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="sort_order" class="font-weight-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $feature->sort_order) }}">
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ $feature->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Set as Active</label>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fas fa-save mr-2"></i>Update Feature</button>
                        <a href="{{ route('admin.features.index') }}" class="btn btn-outline-secondary btn-lg btn-block"><i class="fas fa-times mr-2"></i>Cancel</a>
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
});
</script>
@endsection

