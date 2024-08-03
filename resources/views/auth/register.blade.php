<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>{{ $title }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-secondary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Biblio</b>zone</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg text-muted">{{ $page }}</p>
      <form id="form-login">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="name" autocomplete="off" placeholder="Nama Lengkap">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-edit"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="username" autocomplete="off" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="role">User Level</label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="role" autocomplete="off" placeholder="Siswa" disabled>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user-tag"></span>
              </div>
            </div>
          </div>
        </div>
        {{-- <div class="input-group mb-3">
          <input type="password" class="form-control" id="password" autocomplete="off" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="confirm-password" autocomplete="off" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div> --}}
        <div class="form-group ml-1">
          <div class="custom-control custom-checkbox">
            <input class="custom-control-input custom-control-input-purple" type="checkbox" id="terms">
            <label for="terms" class="custom-control-label">I agree to the <a href="#">terms of service.</a></label>
          </div>
        </div>
        <button type="submit" class="btn btn-block btn-secondary btn-register"><i class="fas fa-user-edit mr-2"></i> Register</button>
        <a href="{{ url('') }}" class="btn btn-block btn-light mb-2"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
      </form>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).ready(function() {
    // Confirm Password Validation
    // var status_password = false;
    // $('#confirm-password').keyup(function() {
    //   var password = $("#password").val();
    //   var confirm_password = $("#confirm-password").val();
    //   if (password != confirm_password) {
    //     $('#password').addClass('is-invalid');
    //     $('#confirm-password').addClass('is-invalid');
    //     status_password = false;
    //   } else {
    //     $('#password').removeClass('is-invalid');
    //     $('#confirm-password').removeClass('is-invalid');
    //     $('#password').addClass('is-valid');
    //     $('#confirm-password').addClass('is-valid');
    //     status_password = true;
    //   }
    // });
    // Terms & Aggrements Toggle
    // $('#terms').click(function() {
    //   console.log($('#terms').val());
    // });
    // Set Terms Condition
    $('#terms').prop('checked', false);
    $('#terms').val(0);
    $('#terms').click(function() {
      if ($('#terms').val() == 0) {
        $('#terms').val(1);
      } else {
        $('#terms').val(0);
      }
    });
    // Login Form & Alerts
    $("#form-login").submit(function(event) {
      $.ajax({
        type: "POST",
        url: "{{ url('registerProses') }}",
        dataType: "JSON",
        encode: true,
        data: {
          name: $("#name").val(),
          username: $("#username").val(),
          // password: $("#password").val(),
          // status_password: status_password,
          terms: $('#terms').val(),
        },
        success: function(response) {
          if (response.status == false) {
            var message = "";
            var data_message = response.message;
            const wrapper = document.createElement('div');
            if (typeof(data_message) == 'object') {
              jQuery.each(data_message, function(key, value) {
                message += value[0] + '<br>';
                wrapper.innerHTML = message;
              });
              Swal.fire({
                title: "Error !",
                html: wrapper,
                icon: "warning",
                confirmButtonColor: '#6f42c1',
              });
            } else {
              Swal.fire({
                title: "Error !",
                text: response.message,
                icon: "warning",
                confirmButtonColor: '#6f42c1',
              });
            }
          } else if (response.status == true) {
            Swal.fire({
              title: "Success !",
              text: response.message,
              icon: "success",
              confirmButtonColor: '#6f42c1',
              timer: 1500,
            })
            .then(function() {
              document.location = "{{ url('') }}";
            });
          }
        },
        error: function() {
          Swal.fire({
            title: "Error !",
            text: "Gagal Register.",
            icon: "warning",
            confirmButtonColor: '#6f42c1',
          });
        }
      });
      event.preventDefault();
    });
  });
</script>
</body>
</html>
