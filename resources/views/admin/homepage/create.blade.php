@extends('layouts.app')

@section('title', 'Create Homepage Section')
@section('styles')
<style>
/* Gradient buttons */
.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}

/* Custom file upload */
.custom-file-label::after {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-weight: 600;
}

/* Form controls */
.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-control-lg {
    font-size: 1.1rem;
    padding: 0.75rem 1rem;
}

/* Image preview animation */
#image-preview {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection
@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1"><i class="fas fa-plus-circle mr-2 text-primary"></i>Create Homepage Section</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.homepage.index') }}">Homepage</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.homepage.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Left Column - Main Form -->
            <div class="col-lg-8">
                <!-- Basic Information Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Section Title <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-control form-control-lg @error('title') is-invalid @enderror"
                                value="{{ old('title') }}"
                                required
                                placeholder="e.g., Welcome to Fountainhead Cafe"
                                maxlength="255"
                            >
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Keep it short and catchy (max 255 characters)</small>
                        </div>

                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Description</label>
                            <textarea
                                name="description"
                                id="description"
                                rows="6"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Write a compelling description for this section... Tell your visitors about your cafe, the ambiance, special features, etc."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted"><i class="fas fa-lightbulb text-warning"></i> Optional. Add a description to make this section more engaging and informative.</small>
                        </div>
                    </div>
                </div>

                <!-- Banner Image Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-image mr-2"></i>Banner Image</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="banner_image" class="font-weight-bold">Upload Banner Image</label>
                            <div class="custom-file">
                                <input
                                    type="file"
                                    name="banner_image"
                                    id="banner_image"
                                    class="custom-file-input @error('banner_image') is-invalid @enderror"
                                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                >
                                <label class="custom-file-label" for="banner_image">Choose image file...</label>
                            </div>
                            @error('banner_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle text-info"></i>
                                <strong>Accepted formats:</strong> JPEG, PNG, JPG, GIF, WEBP |
                                <strong>Max size:</strong> 2MB |
                                <strong>Recommended:</strong> 1920x1080px
                            </small>
                        </div>

                        <!-- Image Preview -->
                        <div id="image-preview" style="display: none;" class="mt-3">
                            <label class="d-block mb-2 font-weight-bold">Preview:</label>
                            <div class="text-center">
                                <img
                                    id="preview-img"
                                    src=""
                                    alt="Preview"
                                    class="img-thumbnail"
                                    style="max-width: 100%; max-height: 400px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-mouse-pointer mr-2"></i>Call to Action (CTA)</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Optional:</strong> Add a call-to-action button to direct visitors to a specific page or action.
                        </div>

                        <div class="form-group">
                            <label for="cta_text" class="font-weight-bold">CTA Button Text</label>
                            <input
                                type="text"
                                name="cta_text"
                                id="cta_text"
                                class="form-control @error('cta_text') is-invalid @enderror"
                                value="{{ old('cta_text') }}"
                                placeholder="e.g., Learn More, Book Now, Explore Menu, Visit Us"
                                maxlength="100"
                            >
                            @error('cta_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Use action verbs for better engagement (max 100 characters)</small>
                        </div>

                        <div class="form-group">
                            <label for="cta_link" class="font-weight-bold">CTA Link URL</label>
                            <input
                                type="url"
                                name="cta_link"
                                id="cta_link"
                                class="form-control @error('cta_link') is-invalid @enderror"
                                value="{{ old('cta_link') }}"
                                placeholder="https://example.com/page"
                            >
                            @error('cta_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-link text-primary"></i>
                                Full URL including https:// (e.g., https://fountainhead.com/menu)
                            </small>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Note:</strong> Both CTA text and link must be filled together, or leave both empty.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="col-lg-4">
                <!-- Tips Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-lightbulb mr-2"></i>Pro Tips</h5>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Images:</strong> Use high-quality, optimized images for better performance
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Title:</strong> Keep titles concise and meaningful (under 10 words)
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Description:</strong> Write engaging copy that tells your story
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>CTA:</strong> Use clear action verbs (Book, Explore, Discover)
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Mobile:</strong> Preview on different devices before publishing
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Image Guidelines Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                    <div class="card-header bg-info text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-image mr-2"></i>Image Guidelines</h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="mb-2"><strong>Recommended Dimensions:</strong></p>
                        <ul class="mb-3">
                            <li>1920x1080px (Full HD)</li>
                            <li>1200x630px (Social)</li>
                            <li>Minimum: 800x600px</li>
                        </ul>
                        <p class="mb-2"><strong>File Size:</strong></p>
                        <ul class="mb-0">
                            <li>Maximum: 2MB</li>
                            <li>Recommended: Under 500KB</li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3" style="border-radius: 10px; font-weight: 600;">
                            <i class="fas fa-save mr-2"></i>Create Section
                        </button>
                        <a href="{{ route('admin.homepage.index') }}" class="btn btn-outline-secondary btn-lg btn-block" style="border-radius: 10px; font-weight: 600;">
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
    // Update custom file input label and show preview
    $('#banner_image').on('change', function() {
        const file = this.files[0];

        if (file) {
            // Update label
            const fileName = file.name;
            $(this).next('.custom-file-label').html(fileName);

            // Validate file size (2MB = 2097152 bytes)
            if (file.size > 2097152) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'Image size must be less than 2MB. Please choose a smaller file.',
                });
                $(this).val('');
                $(this).next('.custom-file-label').html('Choose image file...');
                $('#image-preview').fadeOut();
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-img').attr('src', e.target.result);
                $('#image-preview').fadeIn();
            }
            reader.readAsDataURL(file);
        }
    });

    // Form validation before submit
    $('form').on('submit', function(e) {
        const ctaText = $('#cta_text').val().trim();
        const ctaLink = $('#cta_link').val().trim();

        // Check if only one CTA field is filled
        if ((ctaText && !ctaLink) || (!ctaText && ctaLink)) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete CTA',
                text: 'Please provide both CTA text and link, or leave both empty.',
                confirmButtonColor: '#667eea'
            });
            return false;
        }

        // Disable submit button to prevent double submission
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Creating...');
    });

    // Character counter for title
    $('#title').on('input', function() {
        const length = $(this).val().length;
        const max = 255;
        const remaining = max - length;

        if (remaining < 50) {
            $(this).next('small').html(`${remaining} characters remaining`).addClass('text-warning');
        }
    });
});
</script>
@endsection
