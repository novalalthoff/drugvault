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
              <form id="form" action="{{ route('drug.store') }}" method="POST">
                @csrf

                <div class="form-group">
                  <label for="pharma_id">Farmasi <span style="color: red">*</span></label>
                  <select class="form-control select2-purple" name="pharma_id" id="pharma_id" data-dropdown-css-class="select2-purple" style="width: 100%;"></select>
                </div>

                <div class="form-group">
                  <label for="name_drug">Nama Obat <span style="color: red">*</span></label>
                  <input type="text" name="name_drug" class="form-control" id="name_drug" placeholder="Enter Nama Obat">
                </div>

                <div class="form-group">
                  <label for="drug_type_id">Tipe <span style="color: red">*</span></label>
                  <select class="form-control select2-purple" name="drug_type_id" id="drug_type_id" data-dropdown-css-class="select2-purple" style="width: 100%;"></select>
                </div>

                <div class="form-group">
                  <label for="drug_category_id">Category <span style="color: red">*</span></label>
                  <select class="form-control select2-purple" name="drug_category_id" id="drug_category_id" data-dropdown-css-class="select2-purple" style="width: 100%;"></select>
                </div>

                <div class="form-group">
                  <label for="avatar_drug">Image</label>
                  <input type="file" class="form-control" id="avatar_drug" name="avatar_drug">
                  <small class="text-muted mb-0 ml-1">Allowed PNG, JPG, or JPEG. Max size of 2Mb</small>
                </div>

                <div class="form-group row">
                  <div class="col-2">
                    <label for="is_active">Status Aktif <span style="color: red">*</span></label>
                  </div>
                  <div class="col-10">
                    <input type="checkbox" data-bootstrap-switch name="is_active" id="is_active" data-off-color="default" data-on-color="purple" value="1" checked>
                  </div>
                </div>

                <div class="form-group">
                  <label for="note_drug">Catatan</label>
                  <textarea name="note_drug" class="form-control" id="note_drug" placeholder="Catatan Obat"></textarea>
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

      // Pharma select2
      $("#pharma_id").select2({
        ajax: {
          url: "{{ route('getPharmaBySelect2') }}",
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
        placeholder: "Pilih Perusahaan Farmasi"
      });

      // Drug Type select2
      $("#drug_type_id").select2({
        ajax: {
          url: "{{ route('getDrugTypeBySelect2') }}",
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
        placeholder: "Pilih Tipe Obat"
      });

      // Drug Category select2
      $("#drug_category_id").select2({
        ajax: {
          url: "{{ route('getDrugCategoryBySelect2') }}",
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
        placeholder: "Pilih Kategori Obat"
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
                document.location = "{{ route('drug.index') }}";
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