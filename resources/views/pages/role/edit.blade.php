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
              </span>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              <form id="form" action="{{ route('role.update', $get_data->id_role) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                  <label for="code_role">Kode Akses <span style="color: red">*</span></label>
                  <input type="text" name="code_role" class="form-control" id="code_role" placeholder="Enter Kode Akses" value="{{ $get_data->code_role ?? old('code_role') }}">
                </div>

                <div class="form-group">
                  <label for="name_role">Nama Akses <span style="color: red">*</span></label>
                  <input type="text" name="name_role" class="form-control" id="name_role" placeholder="Enter Nama Akses" value="{{ $get_data->name_role ?? old('name_role') }}">
                </div>

                <div class="form-group row">
                  <div class="col-2">
                    <label for="is_active">Status Aktif <span style="color: red">*</span></label>
                  </div>
                  <div class="col-10">
                    <input type="checkbox" data-bootstrap-switch name="is_active" id="is_active" data-off-color="default" data-on-color="purple" value="1" {{ $get_data->is_active == '1' ? 'checked' : '' }}>
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

      // No Spacing and Lowercase Characters on code_role input
      $('#code_role').on("input", function() {
        this.value = this.value.toUpperCase();
        this.value = this.value.replace(/\s/g,'');
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
                document.location = "{{ route('role.index') }}";
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