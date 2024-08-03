<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/dist/img/favicon.ico') }}" />
  <title>{{ $title }} | DrugVault</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- jQuery TagsInput -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-tagsinput/jquery.tagsinput.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">

  <style>
    .avatar-circle {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      font-size: 16px;
      font-family: roboto, arial;
      color: white;
      line-height: 32px;
      text-align: center;
      background: #6f42c1;
    }
  </style>

  @yield('css-library')
  @yield('css-custom')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Page Header Starts -->
  @include('pages.layouts.header')
  <!-- Page Header Ends -->

  <!-- Page Sidebar Starts -->
  @include('pages.layouts.sidebar')
  <!-- Page Sidebar Ends -->

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
<!-- jQuery Form (AjaxForm) -->
<script src="{{ asset('assets/plugins/jquery-form/jquery.form.js') }}"></script>
<!-- jQuery TagsInput -->
<script src="{{ asset('assets/plugins/jquery-tagsinput/jquery.tagsinput.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
<!-- Page specific script -->
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  const swalCustom = Swal.mixin({
    confirmButtonColor: "#6f42c1",
    cancelButtonColor: "#6c757d"
  });

  // $(function () {
  //   bsCustomFileInput.init();
  // });
  $(document).ready(function() {
    /** add active class and stay opened when selected */
    var url = window.location;
    // for sidebar menu entirely but not cover treeview
    $('ul.nav-sidebar a').filter(function() {
        return this.href == url;
    }).addClass('active');
    // for treeview
    $('ul.nav-treeview a').filter(function() {
        return this.href == url;
    }).children().addClass('text-purple').parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
  })
</script>
@yield('js-library')
@yield('js-custom')
</body>
</html>
