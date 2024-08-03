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
                <label class="col-sm-3 col-form-label">Hak Akses</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-8 col-form-label">
                  {{ $get_data->role->name_role }}
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-8 col-form-label">
                  {{ $get_data->name }}
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-8 col-form-label">
                  {{ $get_data->username }}
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-1 col-form-label">:</div>
                <div class="col-sm-8 col-form-label">
                  @if ($get_data->is_active == '0')
                    <label class="btn btn-xs btn-outline-danger btn-status">Non Aktif</label>
                  @else
                    <label class="btn btn-xs btn-outline-success btn-status">Aktif</label>
                  @endif
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
  <script>
    // Document Ready Function
    $(function() {
      // Change Active Status
      $('.btn-status').click(function() {
        var name = '{{ $get_data->name }}';
        swalCustom.fire({
          title: "Apakah anda yakin?",
          text: "Untuk mengubah status : " + name,
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Ya, Ubah!",
          cancelButtonText: "Cancel",
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "ajax",
              url: "{{ route('user.change-status', $get_data->id) }}",
              method: "GET",
              async: true,
              dataType: "JSON",
              success: function(response) {
                if (response.status == true) {
                  swalCustom.fire("Success", "Berhasil Mengubah Status.", "success")
                  .then(function() {
                    location.reload(true);
                  });
                } else {
                  swalCustom.fire("[Conflict]", "Gagal Mengubah Status.", "warning");
                }
              },
              error: function() {
                swalCustom.fire("[Bad Request]", "Gagal Mengubah Status.", "error");
              }
            });
          } else if (result.dismiss === swalCustom.DismissReason.cancel) {
            swalCustom.fire("Cancelled", "Perubahan Status Dibatalkan.", "error");
          }
        })
      });
    });
  </script>
@endsection