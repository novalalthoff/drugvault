<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/dist/img/favicon.ico') }}" />
  <title>DrugVault | {{ $title }}</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  @yield('css-library')
  @yield('css-custom')
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Page Header Starts -->
  @include('auth.layouts.header')
  <!-- Page Header Ends -->

  <!-- Container-fluid Start -->
  @yield('content')
  <!-- Container-fluid Ends -->

  <footer class="main-footer text-center">
    <strong>Copyright &copy; 2023 <a target="_blank" rel="noopener noreferrer" href="https://github.com/novalalthoff">Noval Althoff</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
<!-- Page specific script -->
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  
  const swalCustom = Swal.mixin({
    confirmButtonColor: "#6f42c1",
    cancelButtonColor: "#6c757d"
    // confirmButtonColor: '#ffc107',
    // confirmButtonColor: '#e83e8c',
    // confirmButtonColor: '#17a2b8',
    // confirmButtonColor: '#007bff',
    // confirmButtonColor: '#0056b3',
    // confirmButtonColor: '#3d9970',
  });
</script>
@yield('js-library')
@yield('js-custom')
</body>
</html>
