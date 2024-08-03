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
              <form id="form" action="{{ route('pharma.update', $get_data->id_pharma) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                  <label for="name_pharma">Nama Farmasi <span style="color: red">*</span></label>
                  <input type="text" name="name_pharma" class="form-control" id="name_pharma" placeholder="Enter Nama Farmasi" value="{{ $get_data->name_pharma ?? old('name_pharma') }}">
                </div>

                <div class="form-group">
                  <label for="country_id">Negara <span style="color: red">*</span></label>
                  <select class="form-control select2-purple" name="country_id" id="country_id" data-dropdown-css-class="select2-purple" style="width: 100%;">
                    <option value="{{ $get_data->country->id_country }}" selected>{{ $get_data->country->name_country }}</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="address_pharma">Alamat</label>
                  <textarea name="address_pharma" class="form-control" id="address_pharma" placeholder="Enter Alamat">{{ $get_data->address_pharma ?? old('address_pharma') }}</textarea>
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

      // Reset Form
      $('.btn-reset').click(function() {
        $('#form').trigger('reset');
      });

      // Country select2
      $("#country_id").select2({
        ajax: {
          url: "{{ route('getCountryBySelect2') }}",
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
        placeholder: "Pilih Negara"
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
                document.location = "{{ route('pharma.index') }}";
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