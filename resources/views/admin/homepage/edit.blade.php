@extends('layouts.app')

@section('title', 'Edit Homepage Section')
@section('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1"><i class="fas fa-edit mr-2 text-primary"></i>Edit Homepage Section</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.homepage.index') }}">Homepage</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.homepage.update', $homepage) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-primary text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Section Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $homepage->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description', $homepage->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Banner Image -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-info text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-image mr-2"></i>Banner Image</h5>
                    </div>
                    <div class="card-body">
                        @if($homepage->banner_image)
                        <div class="mb-3">
                            <label class="d-block mb-2">Current Banner:</label>
                            <img src="{{ Storage::url($homepage->banner_image) }}" alt="Current Banner" class="img-thumbnail" style="max-width: 400px; max-height: 300px; object-fit: cover; border-radius: 10px;">
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="banner_image">{{ $homepage->banner_image ? 'Replace Banner' : 'Upload Banner' }}</label>
                            <div class="custom-file">
                                <input type="file" name="banner_image" id="banner_image" class="custom-file-input @error('banner_image') is-invalid @enderror" accept="image/*">
                                <label class="custom-file-label" for="banner_image">Choose file...</label>
                            </div>
                            @error('banner_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave empty to keep current image. Max size: 2MB</small>
                        </div>

                        <!-- New Image Preview -->
                        <div id="image-preview" style="display: none;">
                            <label class="d-block mb-2">New Preview:</label>
                            <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 400px; max-height: 300px; object-fit: cover; border-radius: 10px;">
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-success text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-mouse-pointer mr-2"></i>Call to Action (CTA)</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cta_text">CTA Button Text</label>
                            <input type="text" name="cta_text" id="cta_text" class="form-control @error('cta_text') is-invalid @enderror" value="{{ old('cta_text', $homepage->cta_text) }}" placeholder="e.g., Learn More, Book Now">
                            @error('cta_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="cta_link">CTA Link URL</label>
                            <input type="url" name="cta_link" id="cta_link" class="form-control @error('cta_link') is-invalid @enderror" value="{{ old('cta_link', $homepage->cta_link) }}" placeholder="https://example.com/page">
                            @error('cta_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-warning text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Section Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Created</small>
                            <p class="mb-0">{{ $homepage->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="mb-0">
                            <small class="text-muted">Last Updated</small>
                            <p class="mb-0">{{ $homepage->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            <i class="fas fa-save mr-2"></i>Update Section
                        </button>
                        <a href="{{ route('admin.homepage.index') }}" class="btn btn-outline-secondary btn-lg btn-block">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
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
    // Update file input label and preview
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);

        // Show new image preview
        if (this.files && this.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-img').attr('src', e.target.result);
                $('#image-preview').fadeIn();
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>
@endsection
