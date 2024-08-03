@extends( 'pages.layouts.main' )

@section('css-library')
@endsection

@section('css-custom')
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content mt-3">
    <div class="container-fluid">
      <div class="card">
        <div class="row p-3">
          <div class="col-sm-6">
            <span class="align-middle">
              <a href="{{ route('home') }}" class="text-purple"><i class="fas fa-home"></i> Home</a> &nbsp;/&nbsp;
              <a href="{{ url($url) }}" class="text-purple">{{ $page }}</a> &nbsp;/&nbsp;
              <span class="text-muted">{{ $title }}</span>
            </span>
          </div>
          <div class="col-sm-6">
            <a href="{{ url($url) }}" class="btn btn-default btn-sm float-right"><i class="fas fa-arrow-left mr-2"></i> Kembali</a>
          </div>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- column -->
        <div class="col-md-12">
          <!-- jquery validation -->
          <div class="card card-outline card-purple">
            <div class="card-header h3 font-weight-light">
              <span class="align-middle">
                Edit Data <span class="text-pink font-weight-bold">{{ $page }}</span>
                <button class="btn bg-purple float-right btn-change-password" style="width: 12rem;"><i class="fas fa-user-lock text-sm mr-1"></i> Change Password</button>
                <button class="btn btn-danger float-right btn-cancel" style="width: 12rem; display: none;"><i class="fas fa-window-close text-sm mr-1"></i> Cancel</button>
              </span>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              <form id="form" action="{{ route('user.update', $get_data->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group" style="display: none;" id="form-change-password">
                  <div class="d-flex justify-content-center">
                    <label for="password">Change Password</label>
                  </div>
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                      <input type="password" name="password" class="form-control text-center mb-2" id="password" autocomplete="off" placeholder="Enter Password" value="">
                      <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                      <input type="password" name="verify_password" class="form-control text-center" id="verify_password" autocomplete="off" placeholder="Verify Password" value="">
                      <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                </div>

                @if (isAccess('update', $get_menu, auth()->user()->role_id))
                  <div class="form-group">
                    <label for="role_id">Hak Akses <span style="color: red">*</span></label>
                    <select class="form-control select2-purple" name="role_id" id="role_id" data-dropdown-css-class="select2-purple" style="width: 100%;">
                      <option value="{{ $get_data->role->id_role }}" selected>{{ $get_data->role->name_role }}</option>
                    </select>
                  </div>
                @endif

                <div class="form-group">
                  <label for="name">Nama Lengkap <span style="color: red">*</span></label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Enter Nama Lengkap" value="{{ $get_data->name ?? old('name') }}">
                </div>

                @if (isAccess('update', $get_menu, auth()->user()->role_id))
                  <div class="form-group">
                    <label for="username">Username <span style="color: red">*</span></label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username" value="{{ $get_data->username ?? old('username') }}">
                  </div>
                @endif

                <div class="form-group row">
                  <div class="col-2">
                    <label for="is_active">Status Aktif <span style="color: red">*</span></label>
                  </div>
                  <div class="col-10">
                    <input type="checkbox" data-bootstrap-switch name="is_active" id="is_active" data-off-color="default" data-on-color="purple" value="1" {{ $get_data->is_active == '1' ? 'checked' : '' }}>
                  </div>
                </div>

                <div class="form-group">
                  <label for="avatar">User Avatar</label>
                  <input type="file" class="form-control" id="avatar" name="avatar">
                  <small class="text-muted mb-0 ml-1">Allowed <span style="color: red">PNG</span>, <span style="color: red">JPG</span>, or <span style="color: red">JPEG</span>. Max size of 2Mb</small>
                </div>

                <button type="submit" class="btn btn-success btn-submit"><i class="fas fa-check-square text-sm mr-1"></i> Submit</button>
                <button type="button" class="btn btn-secondary btn-reset ml-2"><i class="fas fa-sync-alt text-sm mr-1"></i> Reset</button>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!--/.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
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
      $('.select2').select2();

      // Bootstrap Switch
      $('input[data-bootstrap-switch]').each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      });

      // Reset Form
      $('.btn-reset').click(function() {
        $('#form').trigger('reset');
      });

      // Change Password
      $('.btn-change-password').click(function() {
        $('#form-change-password').show();
        $('.btn-change-password').hide();
        $('.btn-cancel').show();
      });

      $('.btn-cancel').click(function() {
        $("#form").resetForm();
        $('#form-change-password').hide();
        $('.btn-cancel').hide();
        $('.btn-change-password').show();
      });

      $('#verify_password').on('input', function() {
        if ($('#verify_password').val() != $('#password').val()) {
          $('#verify_status').val(false);
        } else {
          $('#verify_status').val(true);
        }
      });

      jQuery.validator.addMethod("verify_pasword_format", function(value, element) {
        if ($('#verify_password').val() != $('#password').val()) {
          return false;
        } else {
          return true;
        }
      }, "Password tidak cocok!");

      $("#form").validate({
        rules: {
          password: {
            required: true
          },
          verify_password: {
            required: true,
            verify_pasword_format: true
          }
        },
        messages: {
          password: {
            required: "Password tidak boleh kosong!",
          },
          verify_password: {
            required: "Verifikasi Password tidak boleh kosong!",
          }
        },
        highlight: function(input) {
          $(input).addClass('is-invalid');
        },
        unhighlight: function(input) {
          $(input).removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
          // error.addClass('invalid-feedback');
          // element.closest('.form-group').append(error);
          $(element).next().append(error);
        }
      });

      // Role select2
      $("#role_id").select2({
        ajax: {
          url: "{{ route('getRoleBySelect2') }}",
          type: "POST",
          dataType: "JSON",
          delay: 250,
          data: function(params) {
            return {
              _token: "{{ csrf_token() }}",
              search: params.term // Search Term
            };
          },
          processResults: function(response) {
            return {
              results: response
            };
          },
          cache: true
        },
        placeholder: "Pilih Hak Akses"
      });

      // Button Submit
      $('.btn-submit').click(function() {
        $('#form').ajaxForm({
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
                document.location = "{{ route('user.index') }}";
              });
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            var err = eval("(" + jqXHR.responseText + ")");
            swalCustom.fire("Error!", err.Message, "error");
          }
        })
      });
    });
  </script>
@endsection