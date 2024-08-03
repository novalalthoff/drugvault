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
            <div class="card-body row">

              <div class="col-md-5">
                <div class="text-center">
                  @if (Storage::disk('public')->exists($get_data->drug->avatar_drug) && $get_data->drug->avatar_drug != null)
                    <img src="{{ asset('storage/' . $get_data->drug->avatar_drug) }}" class="rounded img-fluid" style="opacity: 0.9; height: 300px;" >
                  @else
                    <img src="{{ asset('assets/dist/img/default-drug-avatar.png') }}" class="rounded img-fluid" style="opacity: 0.9; height: 300px;" >
                  @endif
                </div>
              </div>

              <div class="col-md-5">

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Nama Obat</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label font-weight-bold text-purple">
                    {{ $get_data->drug->name_drug }}
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Jumlah</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label">
                    @if ($get_data->type_storage == 'IN')
                      <span class="text-success">Masuk </span><span class="text-success font-weight-bold">{{ rupiah_format($get_data->qty_storage) }}</span> pcs
                    @else
                      <span class="text-danger">Keluar </span><span class="text-danger font-weight-bold">{{ rupiah_format($get_data->qty_storage) }}</span> pcs
                    @endif
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Expired Date</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label">
                    {{ $get_data->expired_storage }}
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Notes</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label">
                    @if ($get_data->is_cancelled == '1')
                      <span class="text-danger">[ Cancelled ]</span>
                    @elseif ($get_data->is_cancelled == '2')
                      <span class="text-info">[ Cancellation Reverted ]</span>
                    @endif
                    @if ($get_data->note_storage == null || $get_data->note_storage == "")
                      -
                    @else
                      {{ $get_data->note_storage }}
                    @endif
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Operator</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label text-pink">
                    {{ $get_data->user->username }}
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Recorded</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label">
                    {{ $recorded }}
                  </div>
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