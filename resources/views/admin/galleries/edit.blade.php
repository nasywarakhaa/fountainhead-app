@extends('layouts.app')

@section('title', 'Edit Gallery Image')

@section('styles')
<style>
/* Style helper yang konsisten */
.bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-gradient-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.form-control-lg { font-size: 1.1rem; padding: 0.75rem 1rem; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1"><i class="fas fa-edit mr-2 text-primary"></i>Edit Gallery Image</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.galleries.index') }}">Gallery</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <!-- Kartu Image Details -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-primary text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Image Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title', $gallery->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $gallery->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Kartu Upload Image -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-info text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-upload mr-2"></i>Update Image</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3 text-center">
                            <label class="d-block mb-2">Current Image:</label>
                            <img src="{{ Storage::url($gallery->image) }}" alt="Current Image" class="img-thumbnail" style="max-width: 100%; max-height: 300px; object-fit: cover; border-radius: 10px;">
                        </div>
                        <div class="form-group">
                            <label for="image" class="font-weight-bold">Replace Image</label>
                            <div class="custom-file">
                                <input type="file" name="image" id="image" class="custom-file-input @error('image') is-invalid @enderror" accept="image/*">
                                <label class="custom-file-label" for="image">Choose new file...</label>
                            </div>
                            @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div id="image-preview" style="display: none;" class="mt-3 text-center">
                            <label class="d-block mb-2">New Preview:</label>
                            <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; max-height: 300px; object-fit: cover; border-radius: 10px;">
                        </div>
                    </div>
                </div>

                 <!-- Kartu Category -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-success text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-tags mr-2"></i>Category</h5>
                    </div>
                    <div class="card-body p-4">
                         <div class="form-group">
                            <label for="category" class="font-weight-bold">Category</label>
                            <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                <option value="" disabled>-- Select Category --</option>
                                <option value="coliving" {{ old('category', $gallery->category) == 'coliving' ? 'selected' : '' }}>Coliving</option>
                                <option value="cafe" {{ old('category', $gallery->category) == 'cafe' ? 'selected' : '' }}>Cafe</option>
                                <option value="event" {{ old('category', $gallery->category) == 'event' ? 'selected' : '' }}>Event</option>
                                <option value="facility" {{ old('category', $gallery->category) == 'facility' ? 'selected' : '' }}>Facility</option>
                                <option value="community" {{ old('category', $gallery->category) == 'community' ? 'selected' : '' }}>Community</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Current category: <strong>{{ ucfirst($gallery->category) }}</strong></small>
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
                        <p class="mb-1"><small class="text-muted">Created:</small> {{ $gallery->created_at->format('d M Y H:i') }}</p>
                        <p class="mb-0"><small class="text-muted">Updated:</small> {{ $gallery->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #3052ea 0%, #a2924b 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-cog mr-2"></i>Settings & Status</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="sort_order" class="font-weight-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $gallery->sort_order) }}">
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ $gallery->is_featured ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_featured">Set as Featured</label>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fas fa-save mr-2"></i>Update Gallery</button>
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary btn-lg btn-block"><i class="fas fa-times mr-2"></i>Cancel</a>
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
    $('#image').on('change', function() {
        const file = this.files[0];
        if (file) {
            $(this).next('.custom-file-label').html(file.name);
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-img').attr('src', e.target.result);
                $('#image-preview').fadeIn();
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
