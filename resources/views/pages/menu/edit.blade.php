@extends( 'pages.layouts.main' )

@section('css-library')
@endsection

@section('css-custom')
  <style>
    div.tagsinput span.tag {
      background: #6f42c1;
      color: #ecf0f1;
      padding: 4px;
      margin: 1px;
      font-size: 14px;
      text-transform: lowercase !important;
      border: none;
    }

    div.tagsinput span.tag a {
      color: #ecf0f1;
    }
  </style>
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
                Edit <span class="text-pink font-weight-bold">{{ $page }}</span>
              </span>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              <form id="form" action="{{ route('menu.update', $get_data->id_menu) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                  <label for="upid_menu">Parent Menu <span class="font-weight-light">( Jangan pilih jika hendak membuat menu induk )</span></label>
                  <select class="form-control select2 select2-purple" name="upid_menu" id="upid_menu" data-dropdown-css-class="select2-purple" style="width: 100%;" data-placeholder="Select Status">
                    <option value="0" {{ IsSelected("0", $get_data->upid_menu) }}>None ( Jadikan Menu Induk )</option>
                    @foreach ($menu as $item)
                      <option value="{{ $item->id_menu }}" {{ IsSelected($item->id_menu, $get_data->upid_menu) }}>{{ $item->name_menu }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="code_menu">Kode Menu <span style="color: red">*</span></label>
                  <input type="text" name="code_menu" class="form-control" id="code_menu" placeholder="ex: MD" value="{{ $get_data->code_menu ?? old('code_menu') }}">
                </div>

                <div class="form-group">
                  <label for="name_menu">Nama Menu <span style="color: red">*</span></label>
                  <input type="text" name="name_menu" class="form-control" id="name_menu" placeholder="Enter Nama Menu" value="{{ $get_data->name_menu ?? old('name_menu') }}">
                </div>

                <div class="form-group">
                  <label for="link_menu">Link Menu</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">https://drugvault.com/</span>
                    </div>
                    <input type="text" name="link_menu" class="form-control" id="link_menu" value="{{ $get_data->link_menu ?? old('link_menu') }}">
                  </div>
                  <small class="text-muted ml-1">Masukkan '<span style="color: red">#</span>' jika tidak memiliki URL khusus.</small>
                </div>

                <div class="form-group">
                  <label for="icon_menu"><i class="fas fa-icons mr-2"></i>Icon Menu <span style="color: red">*</span></label>
                  <input type="text" name="icon_menu" class="form-control" id="icon_menu" placeholder="ex: fas fa-user" value="{{ $get_data->icon_menu ?? old('icon_menu') }}">
                </div>

                <div class="form-group">
                  <label for="action_menu">Aksi Menu <span class="font-weight-light">( Gunakan "<span class="font-weight-bold text-danger">,</span>" untuk membedakan tiap aksi )</span> <span style="color: red">*</span></label>
                  <input type="text" name="action_menu" class="form-control" id="action_menu" value="{{ $get_data->action_menu ?? old('action_menu') }}">
                  <small class="text-muted ml-1">Aksi menu dapat berupa: create, read, update, delete, detail, list</small>
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

      // No Spacing and Lowercase Characters on code_menu input
      $('#code_menu').on("input", function() {
        this.value = this.value.toUpperCase();
        this.value = this.value.replace(/\s/g,'');
      });

      // No Spacing and Uppercase Characters on link_menu input
      $('#link_menu').on("input", function() {
        this.value = this.value.toLowerCase();
        this.value = this.value.replace(/\s/g,'');
      });

      // TagsInput Action Menu
      $('#action_menu').tagsInput({
        'width': '100%',
        'height': '75%',
        'interactive': true,
        'delimiter': ',',
        'defaultText': "gunakan,",
        'removeWithBackspace': true,
        'placeholderColor': '#666666',
        'allowDuplicates': false,
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
                document.location = "{{ route('menu.index') }}";
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