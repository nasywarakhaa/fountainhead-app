@extends('layouts.app')

@section('title', 'Create New Testimonial')

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
            <h3 class="mb-1"><i class="fas fa-plus-circle mr-2 text-primary"></i>Create New Testimonial</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-lg-8">
                <!-- Kartu Customer Info -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-user-circle mr-2"></i>Customer Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="customer_name" class="font-weight-bold">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control form-control-lg @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" required placeholder="e.g., John Doe">
                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="customer_role" class="font-weight-bold">Role / Position</label>
                            <input type="text" name="customer_role" id="customer_role" class="form-control @error('customer_role') is-invalid @enderror" value="{{ old('customer_role') }}" placeholder="e.g., Frequent Visitor, Food Blogger">
                            @error('customer_role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Kartu Customer Image -->
                <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-image mr-2"></i>Customer Image</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="customer_image" class="font-weight-bold">Upload Image</label>
                            <div class="custom-file">
                                <input type="file" name="customer_image" id="customer_image" class="custom-file-input @error('customer_image') is-invalid @enderror" accept="image/*">
                                <label class="custom-file-label" for="customer_image">Choose image file...</label>
                            </div>
                            @error('customer_image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-2"><i class="fas fa-info-circle text-info"></i> Optional. Max size: 2MB. Recommended: square image.</small>
                        </div>
                        <div id="image-preview" style="display: none;" class="mt-3 text-center">
                            <img id="preview-img" src="" alt="Preview" class="img-thumbnail rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
                    </div>
                </div>

                <!-- Kartu Testimonial Content -->
                 <div class="card shadow-sm mb-4" style="border-radius: 15px;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-quote-left mr-2"></i>Testimonial & Rating</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="testimonial_text" class="font-weight-bold">Testimonial Text <span class="text-danger">*</span></label>
                            <textarea name="testimonial_text" id="testimonial_text" rows="6" class="form-control @error('testimonial_text') is-invalid @enderror" required placeholder="Write the customer's feedback here...">{{ old('testimonial_text') }}</textarea>
                             @error('testimonial_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold d-block">Rating <span class="text-danger">*</span></label>
                            <div class="rating-stars">
                                <input type="radio" id="star5" name="rating" value="5" {{ old('rating') == 5 ? 'checked' : '' }}><label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star4" name="rating" value="4" {{ old('rating') == 4 ? 'checked' : '' }}><label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star3" name="rating" value="3" {{ old('rating') == 3 ? 'checked' : '' }}><label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star2" name="rating" value="2" {{ old('rating') == 2 ? 'checked' : '' }}><label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                                <input type="radio" id="star1" name="rating" value="1" {{ old('rating') == 1 ? 'checked' : '' }} required><label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                            </div>
                            @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
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
                            <li class="mb-3"><i class="fas fa-check-circle text-success mr-2"></i>Authentic testimonials build trust.</li>
                            <li class="mb-3"><i class="fas fa-check-circle text-success mr-2"></i>A good quality customer photo adds credibility.</li>
                            <li class="mb-0"><i class="fas fa-check-circle text-success mr-2"></i>Use "Featured" to highlight the best testimonials.</li>
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
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3" style="border-radius: 10px; font-weight: 600;"><i class="fas fa-save mr-2"></i>Create Testimonial</button>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary btn-lg btn-block" style="border-radius: 10px; font-weight: 600;"><i class="fas fa-times mr-2"></i>Cancel</a>
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

    $('form').on('submit', function(e) {
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Creating...');
    });
});
</script>
@endsection

