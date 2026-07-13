@extends('layouts.app')

@section('title', 'Edit Testimonial')

@section('styles')
<style>
/* Style helper yang konsisten */
.bg-gradient-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.bg-gradient-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.bg-gradient-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.form-control-lg { font-size: 1.1rem; padding: 0.75rem 1rem; }

/* Star Rating Input */
.rating-stars { display: inline-block; }
.rating-stars input[type="radio"] { display: none; }
.rating-stars label { font-size: 2rem; color: #ddd; cursor: pointer; transition: color 0.2s; }
.rating-stars input[type="radio"]:checked ~ label,
.rating-stars label:hover,
.rating-stars label:hover ~ label { color: #ffc107; }
.rating-stars input[type="radio"] + label { float: right; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1"><i class="fas fa-edit mr-2 text-primary"></i>Edit Testimonial</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <!-- Kartu Customer Info -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-primary text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-user-circle mr-2"></i>Customer Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="customer_name" class="font-weight-bold">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg @error('customer_name') is-invalid @enderror" value="{{ old('customer_name', $testimonial->customer_name) }}" required>
                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="customer_role" class="font-weight-bold">Role / Position</label>
                            <input type="text" name="customer_role" id="customer_role" class="form-control @error('customer_role') is-invalid @enderror" value="{{ old('customer_role', $testimonial->customer_role) }}">
                            @error('customer_role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Kartu Customer Image -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-info text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-image mr-2"></i>Customer Image</h5>
                    </div>
                    <div class="card-body p-4">
                         @if($testimonial->customer_image)
                         <div class="mb-3 text-center">
                             <label class="d-block mb-2">Current Image:</label>
                             <img src="{{ Storage::url($testimonial->customer_image) }}" alt="Current Image" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                         </div>
                         @endif
                        <div class="form-group">
                            <label for="customer_image" class="font-weight-bold">{{ $testimonial->customer_image ? 'Replace Image' : 'Upload Image' }}</label>
                            <div class="custom-file">
                                <input type="file" name="customer_image" id="customer_image" class="custom-file-input @error('customer_image') is-invalid @enderror" accept="image/*">
                                <label class="custom-file-label" for="customer_image">Choose new file...</label>
                            </div>
                            @error('customer_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                        <div id="image-preview" style="display: none;" class="mt-3 text-center">
                             <label class="d-block mb-2">New Preview:</label>
                            <img id="preview-img" src="" alt="Preview" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                    </div>
                </div>

                 <!-- Kartu Testimonial Content -->
                 <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-gradient-success text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-quote-left mr-2"></i>Testimonial & Rating</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="testimonial_text" class="font-weight-bold">Testimonial Text <span class="text-danger">*</span></label>
                            <textarea name="testimonial_text" id="testimonial_text" rows="6" class="form-control @error('testimonial_text') is-invalid @enderror" required>{{ old('testimonial_text', $testimonial->testimonial_text) }}</textarea>
                             @error('testimonial_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold d-block">Rating <span class="text-danger">*</span></label>
                            <div class="rating-stars">
                                @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" {{ (old('rating', $testimonial->rating) == $i) ? 'checked' : '' }}><label for="star{{$i}}" title="{{$i}} stars"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                            @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
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
                        <p class="mb-1"><small class="text-muted">Created:</small> {{ $testimonial->created_at->format('d M Y H:i') }}</p>
                        <p class="mb-0"><small class="text-muted">Updated:</small> {{ $testimonial->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #3052ea 0%, #a2924b 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-cog mr-2"></i>Settings & Status</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="sort_order" class="font-weight-bold">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $testimonial->sort_order) }}">
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ $testimonial->is_featured ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_featured">Set as Featured</label>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fas fa-save mr-2"></i>Update Testimonial</button>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary btn-lg btn-block"><i class="fas fa-times mr-2"></i>Cancel</a>
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
    $('#customer_image').on('change', function() {
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

