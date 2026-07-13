@extends('layouts.app')

@section('title', 'Add New Gallery Image')

@section('styles')
<style>
/* Style yang sama persis dengan modul sebelumnya */
.btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; border: none; transition: all 0.3s ease; }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4); }
.form-control:focus { border-color: #667eea; box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25); }
.form-control-lg { font-size: 1.1rem; padding: 0.75rem 1rem; }
.custom-file-label::after { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
#image-preview { animation: fadeIn 0.5s ease-in; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1"><i class="fas fa-plus-circle mr-2 text-primary"></i>Add New Gallery Image</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.galleries.index') }}">Gallery</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <!-- Kartu Image Details -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Image Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g., Morning Coffee Vibes">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="A short description about the image...">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Kartu Upload Image -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-upload mr-2"></i>Upload Image</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="image" class="font-weight-bold">Image File <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" name="image" id="image" class="custom-file-input @error('image') is-invalid @enderror" accept="image/*" required>
                                <label class="custom-file-label" for="image">Choose image file...</label>
                            </div>
                            @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-2"><i class="fas fa-info-circle text-info"></i> Max size: 2MB. Recommended: landscape orientation.</small>
                        </div>
                        <div id="image-preview" style="display: none;" class="mt-3 text-center">
                            <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; max-height: 300px; object-fit: cover; border-radius: 10px;">
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
                            <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Select Category --</option>
                                <option value="coliving" {{ old('category') == 'coliving' ? 'selected' : '' }}>Coliving</option>
                                <option value="cafe" {{ old('category') == 'cafe' ? 'selected' : '' }}>Cafe</option>
                                <option value="event" {{ old('category') == 'event' ? 'selected' : '' }}>Event</option>
                                <option value="facility" {{ old('category') == 'facility' ? 'selected' : '' }}>Facility</option>
                                <option value="community" {{ old('category') == 'community' ? 'selected' : '' }}>Community</option>
                            </select>

                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Select the appropriate category for this image.</small>
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
                            <li class="mb-3"><i class="fas fa-check-circle text-success mr-2"></i>High-quality images attract more visitors.</li>
                            <li class="mb-3"><i class="fas fa-check-circle text-success mr-2"></i>Use consistent categories for easy management.</li>
                            <li class="mb-0"><i class="fas fa-check-circle text-success mr-2"></i>"Featured" images can be shown on the homepage.</li>
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
                            <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1">
                            <label class="custom-control-label" for="is_featured">Set as Featured</label>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3" style="border-radius: 10px; font-weight: 600;"><i class="fas fa-save mr-2"></i>Add to Gallery</button>
                        <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary btn-lg btn-block" style="border-radius: 10px; font-weight: 600;"><i class="fas fa-times mr-2"></i>Cancel</a>
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

    $('form').on('submit', function(e) {
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...');
    });
});
</script>
@endsection
