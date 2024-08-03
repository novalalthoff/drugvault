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
                <span class="text-pink font-weight-bold">{{ $page }}</span> Detail
              </span>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">

              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Parent Menu</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-8 col-form-label">
                  @if ($get_data->upid_menu == '0')
                    <label class="btn btn-xs btn-outline-warning btn-status">None</label>
                  @else
                    <label class="btn btn-xs btn-outline-info btn-status">{{ $get_data->parent_menu->name_menu }}</label>
                  @endif
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Kode Menu</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-8 col-form-label">
                  {{ $get_data->code_menu }}
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nama Menu</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-8 col-form-label">
                  {{ $get_data->name_menu }}
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Link Menu</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-8 col-form-label">
                  <span class="font-weight-light">https://drugvault.com/</span>{{ $get_data->link_menu }}
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Icon Menu</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-1 col-form-label">
                  <span class="font-weight-light">Icon :</span> <i class="{{ $get_data->icon_menu }}"></i>
                </div>
                <div class="col-sm-7 col-form-label">
                  <span class="font-weight-light">Class :</span> {{ $get_data->icon_menu }}
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Aksi Menu</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-8 col-form-label">
                  {{ $get_data->action_menu }}
                </div>
              </div>

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
@endsection