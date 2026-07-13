<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Admin Dashboard') | {{ config('app.name', 'Fountainhead') }}</title>
    @php
        $siteFavicon = App\Models\SiteSetting::where('key', 'site_favicon')->value('value');
        $siteLogo = App\Models\SiteSetting::where('key', 'site_logo')->value('value');
    @endphp

    @if($siteFavicon)
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($siteFavicon) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
  {{-- AdminLTE CSS --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css">

  {{-- Tailwind & JS (Breeze/Vite) --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- SweetAlert2 CSS --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  {{-- Daterangepicker CSS --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  {{-- DataTables CSS --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
  {{-- Icon Picker Bootstrap CSS --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-iconpicker/1.10.0/css/bootstrap-iconpicker.min.css"/>
  {{-- Custom Global Styles --}}
  <style>
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #f8f9fa;
    }

    .content-wrapper {
      background-color: #f8f9fa;
    }

    /* Smooth transitions */
    .btn, .card, .nav-link {
      transition: all 0.2s ease;
    }

    /* Card improvements */
    .card {
      border: none;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    }

    .card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    /* Button improvements */
    .btn {
      font-weight: 500;
      border-radius: 6px;
      padding: 0.5rem 1rem;
    }

    .btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    /* Badge improvements */
    .badge {
      font-weight: 500;
      padding: 0.35rem 0.65rem;
      border-radius: 4px;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    /* DataTables styling */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
      background: #007bff !important;
      border-color: #007bff !important;
      color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
      background: #0056b3 !important;
      border-color: #0056b3 !important;
      color: white !important;
    }

    /* Form improvements */
    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .custom-file-label::after {
      background: #007bff;
      color: white;
    }

    /* Alert improvements */
    .alert {
      border-radius: 8px;
      border: none;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Sidebar custom styling */
    .sidebar .nav-link:hover {
      background: rgba(243,156,18,0.15) !important;
      transform: translateX(5px);
    }

    .sidebar .nav-link.active {
      box-shadow: 0 2px 8px rgba(243,156,18,0.3);
    }

    .sidebar .nav-treeview .nav-link:hover {
      transform: translateX(8px);
    }

    .sidebar::-webkit-scrollbar {
      width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
      background: rgba(255,255,255,0.05);
    }

    .sidebar::-webkit-scrollbar-thumb {
      background: rgba(243,156,18,0.5);
      border-radius: 10px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
      background: rgba(243,156,18,0.7);
    }

    /* Loading animation */
    .swal2-popup {
      border-radius: 12px;
    }

    /* Table hover effect */
    .table-hover tbody tr:hover {
      background-color: #f8f9fa;
    }
  </style>

  {{-- Custom Page Styles --}}
  @yield('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse font-sans antialiased">
<div class="wrapper">
  {{-- Navbar --}}
  @include('partials.navbar')

  {{-- Sidebar --}}
  @include('partials.sidebar')

  {{-- Main Content --}}
  <div class="content-wrapper p-4">
    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle mr-2"></i>
      <strong>Success!</strong> {{ session('success') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="fas fa-exclamation-circle mr-2"></i>
      <strong>Error!</strong> {{ session('error') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <i class="fas fa-exclamation-triangle mr-2"></i>
      <strong>Validation Error!</strong>
      <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif

    {{-- Page Content --}}
    @yield('content')
  </div>

  {{-- Footer --}}
  @include('partials.footer')
</div>

{{-- Base Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

{{-- DataTables JS --}}
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

{{-- SweetAlert2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

{{-- Daterangepicker JS --}}
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
{{-- Icon Picker Bootstrap  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-iconpicker/1.10.0/js/bootstrap-iconpicker.bundle.min.js"></script>
{{-- Midtrans Snap JS (for payment integration) --}}
@if(config('services.midtrans.is_production'))
<script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@else
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@endif

{{-- Global JavaScript Functions --}}
<script>
$(document).ready(function() {
  // Auto-hide alerts after 5 seconds
  setTimeout(function() {
    $('.alert').fadeOut('slow');
  }, 5000);

  // Confirmation for delete actions
  $('.delete-confirm').on('click', function(e) {
    e.preventDefault();
    const form = $(this).closest('form');

    Swal.fire({
      title: 'Are you sure?',
      text: "This action cannot be undone!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dc3545',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });

  // Tooltip initialization
  $('[data-toggle="tooltip"]').tooltip();

  // Prevent double submission
  $('form').on('submit', function() {
    const submitBtn = $(this).find('button[type="submit"]');
    if (!submitBtn.prop('disabled')) {
      submitBtn.prop('disabled', true);
      setTimeout(function() {
        submitBtn.prop('disabled', false);
      }, 3000);
    }
  });
});

// Midtrans Payment Helper Function
function openMidtransPayment(snapToken) {
  if (typeof snap === 'undefined') {
    Swal.fire({
      icon: 'error',
      title: 'Payment Error',
      text: 'Midtrans is not loaded. Please refresh the page.',
    });
    return;
  }

  snap.pay(snapToken, {
    onSuccess: function(result) {
      console.log('Payment success:', result);
      Swal.fire({
        icon: 'success',
        title: 'Payment Success!',
        text: 'Thank you for your payment.',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.reload();
      });
    },
    onPending: function(result) {
      console.log('Payment pending:', result);
      Swal.fire({
        icon: 'info',
        title: 'Payment Pending',
        text: 'Please complete your payment.',
      });
    },
    onError: function(result) {
      console.log('Payment error:', result);
      Swal.fire({
        icon: 'error',
        title: 'Payment Failed',
        text: 'Something went wrong. Please try again.',
      });
    },
    onClose: function() {
      console.log('Payment popup closed');
    }
  });
}

// Format currency helper
function formatRupiah(amount) {
  return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
}

// Date formatter helper
function formatDate(date, format = 'DD MMM YYYY') {
  return moment(date).format(format);
}
</script>

{{-- Custom Page Scripts --}}
@yield('scripts')
</body>
</html>
