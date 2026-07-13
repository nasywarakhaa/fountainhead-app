@extends('layouts.app')

@section('title', 'Edit Hero Slider')

@section('styles')
<style>
    /* Mengadopsi style helper dari referensi untuk konsistensi */
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
            <h3 class="mb-1"><i class="fas fa-edit mr-2 text-primary"></i>Edit Hero Slider</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.hero-sliders.index') }}">Hero Sliders</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.hero-sliders.update', $heroSlider) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <!-- Slider Details Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Slider Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control form-control-lg @error('title') is-invalid @enderror" value="{{ old('title', $heroSlider->title) }}" required placeholder="e.g., The Best Coffee in Town" maxlength="255">
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Keep it short and catchy (max 255 characters).</small>
                        </div>
                        <div class="form-group">
                            <label for="subtitle" class="font-weight-bold">Subtitle</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $heroSlider->subtitle) }}" placeholder="e.g., Freshly Brewed, Every Day">
                            @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted"><i class="fas fa-lightbulb text-warning"></i> Optional. Add a short subtitle.</small>
                        </div>
                    </div>
                </div>

                <!-- Slider Image Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-image mr-2"></i>Slider Image</h5>
                    </div>
                    <div class="card-body p-4">
                        @if($heroSlider->image)
                        <div class="mb-3">
                            <label class="d-block mb-2 font-weight-bold">Current Image:</label>
                            <div class="text-center">
                                <img src="{{ Storage::url($heroSlider->image) }}" alt="Current Image" class="img-thumbnail" style="max-width: 100%; max-height: 300px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="image" class="font-weight-bold">{{ $heroSlider->image ? 'Replace Image (Optional)' : 'Upload Image' }}</label>
                            <div class="custom-file">
                                <input type="file" name="image" id="image" class="custom-file-input @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/webp">
                                <label class="custom-file-label" for="image">Choose image file...</label>
                            </div>
                            @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle text-info"></i>
                                @if($heroSlider->image)
                                    Leave empty to keep current image. <strong>Max size:</strong> 2MB
                                @else
                                    <strong>Formats:</strong> JPG, PNG, WEBP | <strong>Max size:</strong> 2MB
                                @endif
                            </small>
                        </div>
                        <div id="image-preview" style="display: none;" class="mt-3">
                            <label class="d-block mb-2 font-weight-bold">New Preview:</label>
                            <div class="text-center">
                                <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 100%; max-height: 300px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action Card -->
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-mouse-pointer mr-2"></i>Call to Action (Optional)</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="cta_text" class="font-weight-bold">Button Text</label>
                            <input type="text" name="cta_text" id="cta_text" class="form-control @error('cta_text') is-invalid @enderror" value="{{ old('cta_text', $heroSlider->cta_text) }}" placeholder="e.g., Explore Menu" maxlength="100">
                            @error('cta_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="cta_link_select" class="font-weight-bold">Button Link</label>
                            <select name="cta_link_select" id="cta_link_select" class="form-control @error('cta_link') is-invalid @enderror">
                                @foreach($routes as $url => $label)
                                    <option value="{{ $url }}" {{ old('cta_link', $heroSlider->cta_link) == $url ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cta_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-link text-primary"></i>
                                Select a page from your site or choose "Custom URL"
                            </small>
                        </div>

                        <!-- Custom URL Input (Hidden by default) -->
                        <div class="form-group" id="custom-url-group" style="display: none;">
                            <label for="cta_link_custom" class="font-weight-bold">Custom URL</label>
                            <input
                                type="url"
                                name="cta_link_custom"
                                id="cta_link_custom"
                                class="form-control"
                                placeholder="https://fountainhead.com/contoh-page"
                                value="{{ old('cta_link_custom', $heroSlider->cta_link) }}"
                            >
                            <small class="text-muted">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                Make sure to include https:// for external links
                            </small>
                        </div>

                        <!-- Hidden input untuk submit actual value -->
                        <input type="hidden" name="cta_link" id="cta_link" value="{{ old('cta_link', $heroSlider->cta_link) }}">

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Note:</strong> Both fields must be filled, or both left empty.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Info Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Slider Info</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Created</small>
                            <p class="mb-0 font-weight-bold">
                                <i class="fas fa-calendar text-primary mr-1"></i>
                                {{ $heroSlider->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">Last Updated</small>
                            <p class="mb-0 font-weight-bold">
                                <i class="fas fa-clock text-success mr-1"></i>
                                {{ $heroSlider->updated_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Settings & Status Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #3052ea 0%, #a2924b 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-cog mr-2"></i>Settings & Status</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="sort_order" class="font-weight-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $heroSlider->sort_order) }}">
                            <small class="text-muted">Sliders sort ascending (0, 1, 2...).</small>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $heroSlider->is_active) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="is_active">
                                <i class="fas fa-toggle-on text-success mr-1"></i> Set as Active
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Card -->
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3" style="border-radius: 10px; font-weight: 600;">
                            <i class="fas fa-save mr-2"></i>Update Slider
                        </button>
                        <a href="{{ route('admin.hero-sliders.index') }}" class="btn btn-outline-secondary btn-lg btn-block" style="border-radius: 10px; font-weight: 600;">
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
    // ========== Image Upload Handler ==========
    $('#image').on('change', function() {
        const file = this.files[0];
        if (file) {
            $(this).next('.custom-file-label').html(file.name);

            // Validate file size (2MB)
            if (file.size > 2097152) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'Image must be less than 2MB.',
                    confirmButtonColor: '#667eea'
                });
                $(this).val('').next('.custom-file-label').html('Choose image file...');
                $('#image-preview').fadeOut();
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-img').attr('src', e.target.result);
                $('#image-preview').fadeIn();
            }
            reader.readAsDataURL(file);
        }
    });

    // ========== CTA Link Dropdown Handler ==========
    $('#cta_link_select').on('change', function() {
        const selectedValue = $(this).val();
        const customUrlGroup = $('#custom-url-group');
        const ctaLinkInput = $('#cta_link');

        if (selectedValue === 'custom') {
            customUrlGroup.slideDown();
            // Keep existing custom URL value if available
            const existingCustomUrl = $('#cta_link_custom').val();
            if (existingCustomUrl) {
                ctaLinkInput.val(existingCustomUrl);
            } else {
                ctaLinkInput.val('');
            }
        } else {
            customUrlGroup.slideUp();
            ctaLinkInput.val(selectedValue);
        }
    });

    // Update hidden input saat custom URL diketik
    $('#cta_link_custom').on('input', function() {
        $('#cta_link').val($(this).val());
    });

    // ========== Initial State pada Page Load ==========
    // Check if current CTA link is in the dropdown or custom
    const currentCtaLink = '{{ old('cta_link', $heroSlider->cta_link) }}';
    const dropdownOptions = $('#cta_link_select option').map(function() {
        return $(this).val();
    }).get();

    if (currentCtaLink && !dropdownOptions.includes(currentCtaLink) && currentCtaLink !== '') {
        // Current link is custom (not in dropdown)
        $('#cta_link_select').val('custom');
        $('#cta_link_custom').val(currentCtaLink);
        $('#custom-url-group').show();
        $('#cta_link').val(currentCtaLink);
    } else if ($('#cta_link_select').val() === 'custom') {
        $('#custom-url-group').show();
    }

    // ========== Form Validation Before Submit ==========
    $('form').on('submit', function(e) {
        const ctaText = $('#cta_text').val().trim();
        const ctaLink = $('#cta_link').val().trim();

        if ((ctaText && !ctaLink) || (!ctaText && ctaLink)) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete CTA',
                text: 'Please provide both button text and link, or leave both empty.',
                confirmButtonColor: '#667eea'
            });
            return false;
        }

        $(this).find('button[type="submit"]')
            .prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin mr-2"></i>Updating...');
    });

    // ========== Title Character Counter ==========
    $('#title').on('input', function() {
        const max = $(this).attr('maxlength');
        const remaining = max - $(this).val().length;
        const small = $(this).nextAll('small').first();

        if (remaining < 50) {
            small.html(`<span class="text-warning">${remaining} characters remaining</span>`);
        } else {
            small.html(`Keep it short and catchy (max 255 characters).`);
        }
    });
});
</script>
@endsection
