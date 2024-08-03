@extends( 'auth.layouts.main' )

@section('css-library')
@endsection

@section('css-custom')
<style>
  /* {{ asset('assets/dist/img/drugvault-bg.jpg') }} */
  body, html {
    height: 100%;
    margin: 0;
  }

  .bg {
    /* The image used */
    background-image: url('http://localhost:8080/drugvault/public/assets/dist/img/drugvault-bg.jpg');
    /* Full height */
    height: 100%;
    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  .navbar {
    background-color: transparent !important;
    background: transparent !important;
    border-color: transparent !important;
  }

  /* .navbar li { color: #000 }  */

  /* h1 {
    font-size: 40px;
  } */

  .main-text {
    color: black;
    text-shadow: 0.5px 0.5px 0.5px black;
  }
</style>
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg">
    <!-- Main content -->
    <div class="content">

      <!-- /.Login Modal -->
      <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="card card-outline card-purple mb-0">
              <div class="card-header text-center">
                <a href="#" class="h1"><i class="fas fa-capsules text-pink"></i> <b>Drug</b>Vault</a>
                <button type="button" class="close text-purple" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="card-body">
                <p class="text-muted text-center">Sign in to start your session</p>
                {{-- <form id="form-login" action="{{ route('login') }}" method="POST"> --}}
                <form id="form-login">
                  @csrf
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" id="username" name="username" autocomplete="off" placeholder="Username">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="password" class="form-control" id="password" name="password" autocomplete="off" placeholder="Password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="custom-control custom-checkbox mb-3 ml-1">
                    <input class="custom-control-input custom-control-input-purple" type="checkbox" id="show-password">
                    <label for="show-password" class="custom-control-label">Show Password</label>
                  </div>
                  <button type="submit" class="btn btn-block bg-purple btn-login"><i class="fas fa-door-open mr-2"></i> Sign In</button>
                  <p class="text-center text-muted mt-3 mb-2">Don't have account yet?</p>
                  <a href="#" class="btn btn-block btn-secondary mb-2"><i class="fas fa-users mr-2"></i> Register</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.modal -->

      <div class="container">
        <div class="row p-5">
          <div class="col-lg-12">
            <div class="text-center" style="margin-top: 170px; margin-bottom: 120px;">
              <h1 class="font-weight-bold main-text">
                Everything you need to <span class="font-italic">manage</span><br>and <span class="font-italic">organize</span> your<br>Drugs<i class="fas fa-capsules ml-2"></i>
              </h1>
              <br>
              <a href="#" class="btn btn-outline-dark">Sign up for DrugVault</a>
              <br><br>
              <small class="text-muted">Or get a free<br><span class="font-weight-bold"><i class="fas fa-atom mr-1"></i>DrugVault's Trial</span> Account</small>
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('js-library')
@endsection

@section('js-custom')
  <script>
    // Document Ready Function
    $(function() {
      // Show / Hide Password
      $('#show-password').click(function() {
        var pwd_field = document.getElementById('password');
        if (pwd_field.type == "password") {
          pwd_field.type = "text";
        } else {
          pwd_field.type = "password";
        }
      });

      // Login Form & Alerts
      $("#form-login").submit(function(event) {
        $.ajax({
          url: "{{ route('login') }}",
          type: "POST",
          data: $('#form-login').serialize(),
          dataType: "JSON",
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
                swalCustom.fire({
                  title: "Error",
                  html: wrapper,
                  icon: "warning"
                });
              } else {
                swalCustom.fire("Error", data_message, "warning");
              }
            } else {
              swalCustom.fire({
                title: "Success",
                text: response.message,
                icon: "success",
                timer: 1500
              }).then(function() {
                document.location = "{{ route('home') }}";
              });
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            var err = eval("(" + jqXHR.responseText + ")");
            swalCustom.fire("Error!", err.Message, "error");
          }
        });
        event.preventDefault();
      });
    });
  </script>
@endsection
