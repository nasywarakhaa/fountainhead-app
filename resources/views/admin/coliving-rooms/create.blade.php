@extends('layouts.app')

@section('title', 'Add New Room')

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
.form-control:focus,
.custom-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-control-lg {
    font-size: 1.1rem;
    padding: 0.75rem 1rem;
}

/* Custom checkbox/switch */
.custom-control-input:checked ~ .custom-control-label::before {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
}

.custom-switch .custom-control-input:checked ~ .custom-control-label::before {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Image preview animation */
#thumbnail-preview, #gallery-preview {
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

/* Card styling */
.card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.card-header {
    border-radius: 15px 15px 0 0;
    border: none;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="mb-1"><i class="fas fa-plus-circle mr-2 text-primary"></i>Add New Coliving Room</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.coliving-rooms.index') }}">Coliving Rooms</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.coliving-rooms.store') }}" method="POST" enctype="multipart/form-data" id="room-form">
        @csrf

        <div class="row">
            <!-- Left Column - Main Form -->
            <div class="col-lg-8">
                <!-- Basic Information Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Room Name <span class="text-danger">*</span></label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                required
                                placeholder="e.g., Deluxe King Room with City View"
                                maxlength="255"
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Give your room a descriptive and appealing name</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_type" class="font-weight-bold">Room Type <span class="text-danger">*</span></label>
                                    <select name="room_type" id="room_type" class="form-control @error('room_type') is-invalid @enderror" required>
                                        <option value="">Select Type</option>
                                        <option value="single" {{ old('room_type') == 'single' ? 'selected' : '' }}>Single Room</option>
                                        <option value="double" {{ old('room_type') == 'double' ? 'selected' : '' }}>Double Room</option>
                                        <option value="shared" {{ old('room_type') == 'shared' ? 'selected' : '' }}>Shared Room</option>
                                        <option value="suite" {{ old('room_type') == 'suite' ? 'selected' : '' }}>Suite</option>
                                        <option value="dormitory" {{ old('room_type') == 'dormitory' ? 'selected' : '' }}>Dormitory</option>
                                    </select>
                                    @error('room_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bed_type" class="font-weight-bold">Bed Type <span class="text-danger">*</span></label>
                                    <select name="bed_type" id="bed_type" class="form-control @error('bed_type') is-invalid @enderror" required>
                                        <option value="">Select Bed Type</option>
                                        <option value="single" {{ old('bed_type') == 'single' ? 'selected' : '' }}>Single Bed</option>
                                        <option value="double" {{ old('bed_type') == 'double' ? 'selected' : '' }}>Double Bed</option>
                                        <option value="queen" {{ old('bed_type') == 'queen' ? 'selected' : '' }}>Queen Bed</option>
                                        <option value="king" {{ old('bed_type') == 'king' ? 'selected' : '' }}>King Bed</option>
                                        <option value="bunk" {{ old('bed_type') == 'bunk' ? 'selected' : '' }}>Bunk Bed</option>
                                    </select>
                                    @error('bed_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="short_description" class="font-weight-bold">Short Description</label>
                            <textarea
                                name="short_description"
                                id="short_description"
                                rows="2"
                                class="form-control @error('short_description') is-invalid @enderror"
                                placeholder="Brief description for card preview (max 150 characters)"
                                maxlength="150"
                            >{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted"><i class="fas fa-info-circle text-info"></i> This will appear in room cards on the listing page</small>
                        </div>

                        <div class="form-group">
                            <label for="description" class="font-weight-bold">Full Description</label>
                            <textarea
                                name="description"
                                id="description"
                                rows="6"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Provide detailed information about the room, its features, and what makes it special..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted"><i class="fas fa-lightbulb text-warning"></i> Include details about comfort, ambiance, and unique features</small>
                        </div>
                    </div>
                </div>

                <!-- Pricing Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-tag mr-2"></i>Pricing</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="price_per_night" class="font-weight-bold">Price per Night <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input
                                            type="number"
                                            name="price_per_night"
                                            id="price_per_night"
                                            class="form-control @error('price_per_night') is-invalid @enderror"
                                            value="{{ old('price_per_night') }}"
                                            step="1000"
                                            min="0"
                                            required
                                        >
                                    </div>
                                    @error('price_per_night')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="weekly_price" class="font-weight-bold">Weekly Price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input
                                            type="number"
                                            name="weekly_price"
                                            id="weekly_price"
                                            class="form-control @error('weekly_price') is-invalid @enderror"
                                            value="{{ old('weekly_price') }}"
                                            step="1000"
                                            min="0"
                                        >
                                    </div>
                                    @error('weekly_price')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Optional discount rate</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="monthly_price" class="font-weight-bold">Monthly Price</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input
                                            type="number"
                                            name="monthly_price"
                                            id="monthly_price"
                                            class="form-control @error('monthly_price') is-invalid @enderror"
                                            value="{{ old('monthly_price') }}"
                                            step="1000"
                                            min="0"
                                        >
                                    </div>
                                    @error('monthly_price')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Optional long-stay rate</small>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info mt-2">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Pricing Tips:</strong> Consider offering discounts for weekly and monthly stays to attract long-term guests.
                        </div>
                    </div>
                </div>

                <!-- Room Details Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-bed mr-2"></i>Room Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="capacity" class="font-weight-bold">Capacity <span class="text-danger">*</span></label>
                                    <input
                                        type="number"
                                        name="capacity"
                                        id="capacity"
                                        class="form-control @error('capacity') is-invalid @enderror"
                                        value="{{ old('capacity', 1) }}"
                                        min="1"
                                        required
                                    >
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Max guests</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="beds_count" class="font-weight-bold">Beds Count <span class="text-danger">*</span></label>
                                    <input
                                        type="number"
                                        name="beds_count"
                                        id="beds_count"
                                        class="form-control @error('beds_count') is-invalid @enderror"
                                        value="{{ old('beds_count', 1) }}"
                                        min="1"
                                        required
                                    >
                                    @error('beds_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="room_size" class="font-weight-bold">Room Size (m²)</label>
                                    <input
                                        type="number"
                                        name="room_size"
                                        id="room_size"
                                        class="form-control @error('room_size') is-invalid @enderror"
                                        value="{{ old('room_size') }}"
                                        step="0.01"
                                        min="0"
                                    >
                                    @error('room_size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="floor" class="font-weight-bold">Floor</label>
                                    <input
                                        type="number"
                                        name="floor"
                                        id="floor"
                                        class="form-control @error('floor') is-invalid @enderror"
                                        value="{{ old('floor') }}"
                                    >
                                    @error('floor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bathroom_type" class="font-weight-bold">Bathroom Type <span class="text-danger">*</span></label>
                                    <select name="bathroom_type" id="bathroom_type" class="form-control @error('bathroom_type') is-invalid @enderror" required>
                                        <option value="private" {{ old('bathroom_type') == 'private' ? 'selected' : '' }}>Private Bathroom</option>
                                        <option value="shared" {{ old('bathroom_type') == 'shared' ? 'selected' : '' }}>Shared Bathroom</option>
                                    </select>
                                    @error('bathroom_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_units" class="font-weight-bold">Total Units</label>
                                    <input
                                        type="number"
                                        name="total_units"
                                        id="total_units"
                                        class="form-control"
                                        value="{{ old('total_units', 1) }}"
                                        min="1"
                                    >
                                    <small class="text-muted">Number of identical rooms available</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="custom-control custom-checkbox">
                                    <input
                                        type="checkbox"
                                        name="has_window"
                                        id="has_window"
                                        class="custom-control-input"
                                        value="1"
                                        {{ old('has_window', true) ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label font-weight-bold" for="has_window">
                                        <i class="fas fa-window-restore text-info mr-1"></i> Has Window
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="custom-control custom-checkbox">
                                    <input
                                        type="checkbox"
                                        name="has_balcony"
                                        id="has_balcony"
                                        class="custom-control-input"
                                        value="1"
                                        {{ old('has_balcony') ? 'checked' : '' }}
                                    >
                                    <label class="custom-control-label font-weight-bold" for="has_balcony">
                                        <i class="fas fa-home text-success mr-1"></i> Has Balcony
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-images mr-2"></i>Room Images</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="thumbnail" class="font-weight-bold">Thumbnail Image</label>
                            <div class="custom-file">
                                <input
                                    type="file"
                                    name="thumbnail"
                                    id="thumbnail"
                                    class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                >
                                <label class="custom-file-label" for="thumbnail">Choose thumbnail image...</label>
                            </div>
                            @error('thumbnail')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle text-info"></i>
                                This will be the main image shown in listings. Max 2MB.
                            </small>
                        </div>

                        <!-- Thumbnail Preview -->
                        <div id="thumbnail-preview" style="display: none;" class="mt-3 mb-4">
                            <label class="d-block mb-2 font-weight-bold">Thumbnail Preview:</label>
                            <div class="text-center">
                                <img
                                    id="thumbnail-img"
                                    src=""
                                    alt="Thumbnail Preview"
                                    class="img-thumbnail"
                                    style="max-width: 100%; max-height: 300px; object-fit: cover; border-radius: 10px;"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="images" class="font-weight-bold">Gallery Images</label>
                            <div class="custom-file">
                                <input
                                    type="file"
                                    name="images[]"
                                    id="images"
                                    class="custom-file-input @error('images.*') is-invalid @enderror"
                                    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                    multiple
                                >
                                <label class="custom-file-label" for="images">Choose gallery images...</label>
                            </div>
                            @error('images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle text-info"></i>
                                Select multiple images for the room gallery. Max 2MB per file.
                            </small>
                        </div>

                        <!-- Gallery Preview -->
                        <div id="gallery-preview" style="display: none;" class="mt-3">
                            <label class="d-block mb-2 font-weight-bold">Gallery Preview:</label>
                            <div id="gallery-images" class="row"></div>
                        </div>
                    </div>
                </div>

                <!-- Policies Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-file-contract mr-2"></i>Policies & Rules</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <label for="cancellation_policy" class="font-weight-bold">Cancellation Policy</label>
                            <textarea
                                name="cancellation_policy"
                                id="cancellation_policy"
                                rows="3"
                                class="form-control"
                                placeholder="e.g., Free cancellation up to 48 hours before check-in..."
                            >{{ old('cancellation_policy') }}</textarea>
                            <small class="text-muted">Define your cancellation terms clearly</small>
                        </div>

                        <div class="form-group">
                            <label for="house_rules" class="font-weight-bold">House Rules</label>
                            <textarea
                                name="house_rules"
                                id="house_rules"
                                rows="3"
                                class="form-control"
                                placeholder="e.g., No smoking, No pets, Quiet hours from 10PM-7AM..."
                            >{{ old('house_rules') }}</textarea>
                            <small class="text-muted">List important rules for guests to follow</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="col-lg-4">
                <!-- Status & Settings Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-cog mr-2"></i>Status & Settings</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    name="is_available"
                                    id="is_available"
                                    class="custom-control-input"
                                    value="1"
                                    {{ old('is_available', true) ? 'checked' : '' }}
                                >
                                <label class="custom-control-label font-weight-bold" for="is_available">
                                    <i class="fas fa-check-circle text-success mr-1"></i> Available for Booking
                                </label>
                            </div>
                            <small class="text-muted d-block ml-4">Enable this to allow guests to book this room</small>
                        </div>

                        <div class="form-group mt-3">
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    name="is_featured"
                                    id="is_featured"
                                    class="custom-control-input"
                                    value="1"
                                    {{ old('is_featured') ? 'checked' : '' }}
                                >
                                <label class="custom-control-label font-weight-bold" for="is_featured">
                                    <i class="fas fa-star text-warning mr-1"></i> Featured Room
                                </label>
                            </div>
                            <small class="text-muted d-block ml-4">Highlight this room on homepage and listings</small>
                        </div>

                        <div class="form-group mt-4">
                            <label for="sort_order" class="font-weight-bold">Sort Order</label>
                            <input
                                type="number"
                                name="sort_order"
                                id="sort_order"
                                class="form-control"
                                value="{{ old('sort_order', 0) }}"
                            >
                            <small class="text-muted">Lower numbers appear first in listings</small>
                        </div>
                    </div>
                </div>

                <!-- Facilities Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-list-check mr-2"></i>Facilities</h5>
                    </div>
                    <div class="card-body p-4">
                        <label class="font-weight-bold mb-3">Select Room Facilities</label>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="facilities[]" value="AC" id="fac_ac" class="custom-control-input">
                            <label class="custom-control-label" for="fac_ac">
                                <i class="fas fa-wind text-info mr-1"></i> Air Conditioning
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="facilities[]" value="WiFi" id="fac_wifi" class="custom-control-input">
                            <label class="custom-control-label" for="fac_wifi">
                                <i class="fas fa-wifi text-primary mr-1"></i> WiFi
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="facilities[]" value="TV" id="fac_tv" class="custom-control-input">
                            <label class="custom-control-label" for="fac_tv">
                                <i class="fas fa-tv text-secondary mr-1"></i> Television
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="facilities[]" value="Mini Fridge" id="fac_fridge" class="custom-control-input">
                            <label class="custom-control-label" for="fac_fridge">
                                <i class="fas fa-snowflake text-info mr-1"></i> Mini Fridge
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="facilities[]" value="Water Heater" id="fac_heater" class="custom-control-input">
                            <label class="custom-control-label" for="fac_heater">
                                <i class="fas fa-fire text-danger mr-1"></i> Water Heater
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Amenities Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-couch mr-2"></i>Amenities</h5>
                    </div>
                    <div class="card-body p-4">
                        <label class="font-weight-bold mb-3">Select Room Amenities</label>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="amenities[]" value="Wardrobe" id="ame_wardrobe" class="custom-control-input">
                            <label class="custom-control-label" for="ame_wardrobe">
                                <i class="fas fa-door-closed text-brown mr-1"></i> Wardrobe
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="amenities[]" value="Work Desk" id="ame_desk" class="custom-control-input">
                            <label class="custom-control-label" for="ame_desk">
                                <i class="fas fa-display text-secondary mr-1"></i> Work Desk
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="amenities[]" value="Chair" id="ame_chair" class="custom-control-input">
                            <label class="custom-control-label" for="ame_chair">
                                <i class="bi bi-chair text-info mr-1"></i> Chair
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="amenities[]" value="Mirror" id="ame_mirror" class="custom-control-input">
                            <label class="custom-control-label" for="ame_mirror">
                                <i class="fas fa-border-style text-primary mr-1"></i> Mirror
                            </label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="amenities[]" value="Towel" id="ame_towel" class="custom-control-input">
                            <label class="custom-control-label" for="ame_towel">
                                <i class="fas fa-hands-wash text-success mr-1"></i> Towel
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-header text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0"><i class="fas fa-lightbulb mr-2"></i>Pro Tips</h5>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Photos:</strong> Upload high-quality images with good lighting
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Description:</strong> Highlight unique features and comfort
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Pricing:</strong> Research competitor rates before setting prices
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Facilities:</strong> Accurate amenity lists increase bookings
                            </li>
                            <li class="mb-0">
                                <i class="fas fa-check-circle text-success mr-2"></i>
                                <strong>Policies:</strong> Clear rules prevent misunderstandings
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons Card -->
                <div class="card shadow-sm" style="border-radius: 15px; border: none;">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block mb-3" style="border-radius: 10px; font-weight: 600;">
                            <i class="fas fa-save mr-2"></i>Create Room
                        </button>
                        <a href="{{ route('admin.coliving-rooms.index') }}" class="btn btn-outline-secondary btn-lg btn-block" style="border-radius: 10px; font-weight: 600;">
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
    // Update custom file input label for thumbnail and show preview
    $('#thumbnail').on('change', function() {
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
                    text: 'Thumbnail image size must be less than 2MB. Please choose a smaller file.',
                    confirmButtonColor: '#667eea'
                });
                $(this).val('');
                $(this).next('.custom-file-label').html('Choose thumbnail image...');
                $('#thumbnail-preview').fadeOut();
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#thumbnail-img').attr('src', e.target.result);
                $('#thumbnail-preview').fadeIn();
            }
            reader.readAsDataURL(file);
        }
    });

    // Update custom file input label for gallery and show previews
    $('#images').on('change', function() {
        const files = this.files;

        if (files.length > 0) {
            // Update label
            const fileCount = files.length;
            $(this).next('.custom-file-label').html(`${fileCount} image${fileCount > 1 ? 's' : ''} selected`);

            // Clear previous previews
            $('#gallery-images').empty();

            let validFiles = 0;

            // Process each file
            Array.from(files).forEach((file, index) => {
                // Validate file size
                if (file.size > 2097152) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Too Large',
                        text: `Image "${file.name}" is larger than 2MB. Please choose smaller files.`,
                        confirmButtonColor: '#667eea'
                    });
                    return;
                }

                validFiles++;

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgHtml = `
                        <div class="col-6 mb-3">
                            <img src="${e.target.result}"
                                 alt="Gallery Preview ${index + 1}"
                                 class="img-thumbnail"
                                 style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">
                        </div>
                    `;
                    $('#gallery-images').append(imgHtml);
                }
                reader.readAsDataURL(file);
            });

            if (validFiles > 0) {
                $('#gallery-preview').fadeIn();
            }
        }
    });

    // Form validation before submit
    $('#room-form').on('submit', function(e) {
        const name = $('#name').val().trim();
        const roomType = $('#room_type').val();
        const bedType = $('#bed_type').val();
        const pricePerNight = $('#price_per_night').val();

        // Check required fields
        if (!name || !roomType || !bedType || !pricePerNight) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Missing Required Fields',
                text: 'Please fill in all required fields marked with *',
                confirmButtonColor: '#667eea'
            });
            return false;
        }

        // Disable submit button to prevent double submission
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Creating Room...');
    });

    // Character counter for room name
    $('#name').on('input', function() {
        const length = $(this).val().length;
        const max = 255;
        const remaining = max - length;

        if (remaining < 50) {
            $(this).next('small').html(`${remaining} characters remaining`).addClass('text-warning');
        } else {
            $(this).next('small').html('Give your room a descriptive and appealing name').removeClass('text-warning');
        }
    });

    // Character counter for short description
    $('#short_description').on('input', function() {
        const length = $(this).val().length;
        const max = 150;
        const remaining = max - length;

        const smallTag = $(this).siblings('small');
        if (remaining < 30) {
            smallTag.html(`<i class="fas fa-exclamation-triangle text-warning"></i> ${remaining} characters remaining`);
        } else {
            smallTag.html('<i class="fas fa-info-circle text-info"></i> This will appear in room cards on the listing page');
        }
    });

    // Auto-calculate weekly and monthly prices based on nightly price
    $('#price_per_night').on('input', function() {
        const nightlyPrice = parseFloat($(this).val()) || 0;

        if (nightlyPrice > 0) {
            // Suggest 10% discount for weekly (7 nights)
            const weeklyPrice = Math.round((nightlyPrice * 7) * 0.9);
            $('#weekly_price').attr('placeholder', `Suggested: ${weeklyPrice.toLocaleString('id-ID')}`);

            // Suggest 20% discount for monthly (30 nights)
            const monthlyPrice = Math.round((nightlyPrice * 30) * 0.8);
            $('#monthly_price').attr('placeholder', `Suggested: ${monthlyPrice.toLocaleString('id-ID')}`);
        }
    });

    // Show warning if capacity is less than beds count
    $('#capacity, #beds_count').on('input', function() {
        const capacity = parseInt($('#capacity').val()) || 0;
        const bedsCount = parseInt($('#beds_count').val()) || 0;

        if (capacity > 0 && bedsCount > 0 && capacity < bedsCount) {
            Swal.fire({
                icon: 'warning',
                title: 'Capacity Warning',
                text: 'Room capacity is less than the number of beds. Is this correct?',
                confirmButtonColor: '#667eea',
                timer: 3000
            });
        }
    });
});
</script>
@endsection
