@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 offset-md-2">

      <div class="card mt-4">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Profile Information</h5>
        </div>
        <div class="card-body">
          @include('profile.partials.update-profile-information-form')
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header bg-warning text-white">
          <h5 class="mb-0">Update Password</h5>
        </div>
        <div class="card-body">
          @include('profile.partials.update-password-form')
        </div>
      </div>

      <div class="card mt-4 mb-5">
        <div class="card-header bg-danger text-white">
          <h5 class="mb-0">Delete Account</h5>
        </div>
        <div class="card-body">
          @include('profile.partials.delete-user-form')
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
