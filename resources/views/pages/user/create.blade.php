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
                New <span class="text-pink font-weight-bold">{{ $page }}</span>
              </span>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              <form id="form" action="{{ route('user.store') }}" method="POST">
                @csrf

                <div class="form-group">
                  <label for="role_id">Hak Akses <span style="color: red">*</span></label>
                  {{-- <select class="form-control select2 select2-purple" name="role" id="role" data-dropdown-css-class="select2-purple" style="width: 100%;" data-placeholder="Select Hak Akses">
                    <option value=""></option>
                    @foreach ($role as $p)
                      <option value="{{ $p->id_role }}">{{ $p->name_role }}</option>
                    @endforeach
                  </select> --}}
                  <select class="form-control select2-purple" name="role_id" id="role_id" data-dropdown-css-class="select2-purple" style="width: 100%;"></select>
                </div>

                <div class="form-group">
                  <label for="name">Nama Lengkap <span style="color: red">*</span></label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Enter Nama Lengkap">
                </div>

                <div class="form-group">
                  <label for="username">Username <span style="color: red">*</span></label>
                  <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username">
                </div>

                <div class="form-group row">
                  <div class="col-2">
                    <label for="is_active">Status Aktif <span style="color: red">*</span></label>
                  </div>
                  <div class="col-10">
                    <input type="checkbox" data-bootstrap-switch name="is_active" id="is_active" data-off-color="default" data-on-color="purple" value="1" checked>
                  </div>
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