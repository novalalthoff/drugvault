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
              <a href="{{ url($url) }}" class="text-purple">Role</a> &nbsp;/&nbsp;
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
                Configure <span class="text-pink font-weight-bold">{{ $page }}</span>
              </span>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Kode Akses</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-8 col-form-label">
                  {{ $role->code_role }}
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nama Akses</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-8 col-form-label">
                  {{ $role->name_role }}
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <div class="card">
            <div class="card-body table-responsive text-nowrap pt-0 pr-0 pl-0">
              <form id="form" action="{{ route('role.menu-auth.store') }}" method="POST">
                @csrf

                <input type="hidden" name="role_id" value="{{ $role->id_role }}">

                <table class="table" style="width: 100%">
                  <thead>
                    <tr>
                      <th></th>
                      <th width="20%">Nama Menu</th>
                      <th>Aksi</th>
                      <th style="text-align: center;">Aktif</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                    @foreach ($get_data as $pm)
                      @php
                        $menu_auth_now = $menu_auth->where('role_id', $role->id_role)->where('menu_id', $pm->id_menu)->first();
                        $action_now = $menu_auth_now ? $menu_auth_now->action_menu_auth : '';
                        $is_active = $menu_auth_now ? $menu_auth_now->is_active : '';
                      @endphp
                      <tr>
                        <td></td>
                        <td style="vertical-align: top" class="text-purple"><strong>{{ $pm->name_menu }}</strong></td>
                        <td>
                          <input type="text" class="form-control input-tags" name="action_menu_auth[{{ $pm->id_menu }}]" value="{{ $action_now }}">
                          <small>Available : <span class="text-pink">{{ $pm->action_menu }}</span></small>
                        </td>
                        <td style="vertical-align: top; text-align: center;">
                          <div class="form-check form-switch mb-2">
                            <input type="checkbox" data-bootstrap-switch name="is_active[{{ $pm->id_menu }}]" id="is_active" data-off-color="default" data-on-color="purple" value="1" {{ $is_active == 1 ? 'checked' : '' }}>
                          </div>
                        </td>
                      </tr>
                      @foreach ($pm->menus as $sm)
                        @php
                          $menu_auth_now = $menu_auth->where('role_id', $role->id_role)->where('menu_id', $sm->id_menu)->first();
                          $action_now = $menu_auth_now ? $menu_auth_now->action_menu_auth : '';
                          $is_active = $menu_auth_now ? $menu_auth_now->is_active : '';
                        @endphp
                        <tr>
                          <td></td>
                          <td style="vertical-align: top" class="text-purple">&emsp;&emsp;{{ $sm->name_menu }}</td>
                          <td>
                            <input type="text" class="form-control input-tags" name="action_menu_auth[{{ $sm->id_menu }}]" value="{{ $action_now }}">
                            <small>Available : <span class="text-pink">{{ $sm->action_menu }}</span></small>
                          </td>
                          <td style="vertical-align: top; text-align: center;">
                            <div class="form-check form-switch mb-2">
                              <input type="checkbox" data-bootstrap-switch name="is_active[{{ $sm->id_menu }}]" id="is_active" data-off-color="default" data-on-color="purple" value="1" {{ $is_active == 1 ? 'checked' : '' }}>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    @endforeach
                  </tbody>
                </table>

                <div style="text-align: center">
                  <button type="submit" class="btn btn-success btn-submit"><i class="fas fa-check-square text-sm mr-1"></i> Submit</button>
                </div>
              </form>
            </div>
          </div>

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
      // Bootstrap Switch
      $('input[data-bootstrap-switch]').each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      });

      // TagsInput Action Menu
      $('.input-tags').tagsInput({
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
                location.reload(true);
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