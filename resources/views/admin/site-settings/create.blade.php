@extends('layouts.app')

@section('title', 'Create Site Setting')

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

/* Type selector */
.type-selector .form-check {
    padding: 15px;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.type-selector .form-check:hover {
    border-color: #667eea;
    background-color: #f8f9ff;
}

.type-selector .form-check-input:checked + .form-check-label {
    color: #667eea;
    font-weight: 600;
}

.type-selector .form-check-input:checked ~ .type-icon {
    color: #667eea;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1"><i class="fas fa-plus-circle mr-2 text-primary"></i>Create Site Setting</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.site-settings.index') }}">Site Settings</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.site-settings.store') }}" method="POST" enctype="multipart/form-data">
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
                            <label for="key" class="font-weight-bold">Setting Key <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="key"
                                id="key"
                                class="form-control form-control-lg @error('key') is-invalid @enderror"
                                value="{{ old('key') }}"
                                required
                                placeholder="e.g., site_name, contact_phone, facebook_url"
                                maxlength="255"
                            >
                            @error('key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle text-info"></i>
                                Use snake_case format (lowercase with underscores). This key will be used to retrieve the setting value.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="group" class="font-weight-bold">Group <span class="text-danger">*</span></label>
                            <select
                                name="group"
                                id="group"
                                class="form-control form-control-lg @error('group') is-invalid @enderror"
                                required
                            >
                                <option value="">-- Select Group --</option>
                                <option value="general" {{ old('group') == 'general' ? 'selected' : '' }}>General</option>
                                <option value="contact" {{ old('group') == 'contact' ? 'selected' : '' }}>Contact</option>
                                <option value="social" {{ old('group') == 'social' ? 'selected' : '' }}>Social Media</option>
                                <option value="seo" {{ old('group') == 'seo' ? 'selected' : '' }}>SEO</option>
                                <option value="other" {{ old('group') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('group')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Organize settings by grouping them into categories</small>
                        </div>
                    </div>
                </div>

                <!-- Setting Type Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-sliders-h mr-2"></i>Setting Type</h5>
                    </div>
                    <div class="card-body p-4">
                        <label class="font-weight-bold d-block mb-3">Choose Setting Type <span class="text-danger">*</span></label>

                        <div class="type-selector">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="type"
                                    id="type_text"
                                    value="text"
                                    {{ old('type', 'text') == 'text' ? 'checked' : '' }}
                                    required
                                >
                                <label class="form-check-label w-100" for="type_text">
                                    <i class="fas fa-font type-icon mr-2"></i>
                                    <strong>Text</strong>
                                    <small class="d-block text-muted mt-1">Single line text input (e.g., site name, email, phone)</small>
                                </label>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="type"
                                    id="type_textarea"
                                    value="textarea"
                                    {{ old('type') == 'textarea' ? 'checked' : '' }}
                                >
                                <label class="form-check-label w-100" for="type_textarea">
                                    <i class="fas fa-align-left type-icon mr-2"></i>
                                    <strong>Textarea</strong>
                                    <small class="d-block text-muted mt-1">Multi-line text input (e.g., description, address)</small>
                                </label>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="type"
                                    id="type_file"
                                    value="file"
                                    {{ old('type') == 'file' ? 'checked' : '' }}
                                >
                                <label class="form-check-label w-100" for="type_file">
                                    <i class="fas fa-image type-icon mr-2"></i>
                                    <strong>File/Image</strong>
                                    <small class="d-block text-muted mt-1">File upload (e.g., logo, favicon, banner)</small>
                                </label>
                            </div>

                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    name="type"
                                    id="type_boolean"
                                    value="boolean"
                                    {{ old('type') == 'boolean' ? 'checked' : '' }}
                                >
                                <label class="form-check-label w-100" for="type_boolean">
                                    <i class="fas fa-toggle-on type-icon mr-2"></i>
                                    <strong>Boolean</strong>
                                    <small class="d-block text-muted mt-1">True/false switch (e.g., maintenance mode, feature toggles)</small>
                                </label>
                            </div>
                        </div>

                        @error('type')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Value Input Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-edit mr-2"></i>Setting Value</h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Text Input -->
                        <div id="value-text" class="value-input">
                            <div class="form-group">
                                <label for="value" class="font-weight-bold">Value</label>
                                <input
                                    type="text"
                                    name="value"
                                    id="value"
                                    class="form-control @error('value') is-invalid @enderror"
                                    value="{{ old('value') }}"
                                    placeholder="Enter the setting value..."
                                >
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Enter the value for this setting</small>
                            </div>
                        </div>

                        <!-- Textarea Input -->
                        <div id="value-textarea" class="value-input" style="display: none;">
                            <div class="form-group">
                                <label for="value_textarea" class="font-weight-bold">Value</label>
                                <textarea
                                    name="value_textarea"
                                    id="value_textarea"
                                    rows="6"
                                    class="form-control @error('value') is-invalid @enderror"
                                    placeholder="Enter the setting value..."
                                >{{ old('value') }}</textarea>
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Enter multi-line text for this setting</small>
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div id="value-file" class="value-input" style="display: none;">
                            <div class="form-group">
                                <label for="value_file" class="font-weight-bold">Upload File</label>
                                <div class="custom-file">
                                    <input
                                        type="file"
                                        name="value_file"
                                        id="value_file"
                                        class="custom-file-input @error('value') is-invalid @enderror"
                                        accept="image/*"
                                    >
                                    <label class="custom-file-label" for="value_file">Choose file...</label>
                                </div>
                                @error('value')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle text-info"></i>
                                    <strong>Max size:</strong> 2MB | <strong>Formats:</strong> JPG, PNG, SVG, ICO, WEBP
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
                                        style="max-width: 100%; max-height: 300px; object-fit: contain; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Boolean Input -->
                        <div id="value-boolean" class="value-input" style="display: none;">
                            <div class="form-group">
                                <div class="custom-control custom-switch" style="padding-top: 10px;">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        id="value_boolean"
                                        name="value_boolean"
                                        value="1"
                                        {{ old('value') == '1' ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label font-weight-bold" for="value_boolean">
                                        Enable this setting
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">Toggle this switch to set the value to true or false</small>
                            </div>
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
                                <strong>Naming:</strong> Use descriptive, consistent key names (e.g., site_*, contact_*, social_*)
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Grouping:</strong> Organize settings by category for easier management
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Type:</strong> Choose the appropriate type based on the data you want to store
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Validation:</strong> Keys must be unique across all settings
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Examples Card -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px; border: none;">
                    <div class="card-header bg-info text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-code mr-2"></i>Key Examples</h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="mb-2"><strong>General:</strong></p>
                        <ul class="mb-3 small">
                            <li>site_name</li>
                            <li>site_tagline</li>
                            <li>site_logo</li>
                        </ul>
                        <p class="mb-2"><strong>Contact:</strong></p>
                        <ul class="mb-3 small">
                            <li>contact_email</li>
                            <li>contact_phone</li>
                            <li>contact_address</li>
                        </ul>
                        <p class="mb-2"><strong>Social:</strong></p>
                        <ul class="mb-0 small">
                            <li>facebook_url</li>
                            <li>instagram_url</li>
                            <li>twitter_url</li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3" style="border-radius: 10px; font-weight: 600;">
                            <i class="fas fa-save mr-2"></i>Create Setting
                        </button>
                        <a href="{{ route('admin.site-settings.index') }}" class="btn btn-outline-secondary btn-lg btn-block" style="border-radius: 10px; font-weight: 600;">
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
    // Show/hide value input based on type selection
    $('input[name="type"]').on('change', function() {
        const type = $(this).val();

        // Hide all value inputs
        $('.value-input').hide();

        // Show selected type input
        $('#value-' + type).show();

        // Reset hidden inputs
        $('.value-input:hidden input, .value-input:hidden textarea').val('');
        $('.value-input:hidden input[type="checkbox"]').prop('checked', false);
    });

    // File upload handler
    $('#value_file').on('change', function() {
        const file = this.files[0];

        if (file) {
            // Update label
            const fileName = file.name;
            $(this).next('.custom-file-label').html(fileName);

            // Validate file size (2MB)
            if (file.size > 2097152) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'File size must be less than 2MB. Please choose a smaller file.',
                });
                $(this).val('');
                $(this).next('.custom-file-label').html('Choose file...');
                $('#image-preview').fadeOut();
                return;
            }

            // Show preview for images
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-img').attr('src', e.target.result);
                    $('#image-preview').fadeIn();
                }
                reader.readAsDataURL(file);
            }
        }
    });

    // Auto-format key input (convert to snake_case)
    $('#key').on('input', function() {
        let value = $(this).val();
        // Convert to lowercase and replace spaces with underscores
        value = value.toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_]/g, '');
        $(this).val(value);
    });

    // Form submission handler
    $('form').on('submit', function(e) {
        const type = $('input[name="type"]:checked').val();

        // Copy value from visible input to main value field
        if (type === 'textarea') {
            $('input[name="value"]').val($('#value_textarea').val());
        } else if (type === 'boolean') {
            $('input[name="value"]').val($('#value_boolean').is(':checked') ? '1' : '0');
        }
        // For file and text types, no special handling needed

        // Disable submit button to prevent double submission
        $(this).find('button[type="submit"]')
            .prop('disabled', true)
            .html('<i class="fas fa-spinner fa-spin mr-2"></i>Creating...');
    });

    // Trigger initial type change to show correct input
    $('input[name="type"]:checked').trigger('change');
});
</script>
@endsection
