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
              <span class="text-muted">{{ $page }}</span>
            </span>
          </div>
          <div class="col-sm-6">
            {{-- <button class="btn btn-default btn-sm float-right" onclick="goBack()"><i class="fas fa-arrow-left mr-2"></i> Kembali</button> --}}
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
        <div class="col-12">
          <!-- jquery validation -->
          <div class="card card-outline card-purple">
            <div class="card-header h3 font-weight-light">
              <span class="align-middle">
                Data <span class="text-pink font-weight-bold">{{ $page }}</span>
                @if (isAccess('create', $get_menu, auth()->user()->role_id))
                  <a href="{{ route('user.create') }}" class="btn bg-purple float-right" style="width: 6rem"><i class="fas fa-plus text-sm mr-1"></i> Create</a>
                @endif
              </span>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="width: 5%">No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Hak Akses</th>
                    <th style="width: 10%" class="text-center">Status</th>
                    <th style="width: 5%" class="text-center">Actions</th>
                  </tr>
                </thead>
                @if (isAccess('read', $get_menu, auth()->user()->role_id))
                  <tbody></tbody>
                @endif
              </table>
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
      var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        fixedHeader: true,
        responsive: true,
        autoWidth: false,
        ajax: {
          url: "{{ route('user.index') }}",
          type: "GET",
          data: function(d) {
            d.search = $('#datatable_filter').find('.form-control').val()
          }
        },
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex',
            orderable: false,
            searchable: false
          },
          {
            data: 'name',
            name: 'name',
            orderable: false
          },
          {
            data: 'username',
            name: 'username',
            orderable: false
          },
          {
            data: 'set_role',
            name: 'set_role',
            orderable: false
          },
          {
            data: 'set_status',
            name: 'set_status',
            orderable: false
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
          }
        ]
      });

      table.on('draw', function() {
        $('[data-toggle="tooltip"]').tooltip();
      });

      // Datatables Responsive
      new $.fn.dataTable(table);
      // new $.fn.dataTable.FixedHeader(table);

      // Delete Data
      $('#datatable').on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        swalCustom.fire({
          title: "Apakah anda yakin?",
          text: "Untuk menghapus data : " + name,
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Ya, Hapus!",
          cancelButtonText: "Cancel",
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "ajax",
              url: "user-destroy/" + id,
              method: "GET",
              async: true,
              dataType: "JSON",
              success: function(response) {
                if (response.status == true) {
                  swalCustom.fire("Success", "Berhasil Menghapus Data.", "success")
                  .then(function() {
                    location.reload(true);
                  });
                } else {
                  swalCustom.fire("[Conflict]", "Gagal Menghapus Data.", "warning");
                }
              },
              error: function() {
                swalCustom.fire("[Bad Request]", "Gagal Menghapus Data.", "error");
              }
            });
          } else if (result.dismiss === swalCustom.DismissReason.cancel) {
            swalCustom.fire("Cancelled", "Hapus Data Dibatalkan.", "error");
          }
        })
      });

      // Reset Password
      $('#datatable').on('click', '.btn-reset', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        swalCustom.fire({
          title: "Apakah anda yakin?",
          text: "Untuk mereset password : " + name,
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Ya, Reset!",
          cancelButtonText: "Cancel",
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "ajax",
              url: 'user-reset/' + id,
              method: "GET",
              async: true,
              dataType: "JSON",
              success: function(response) {
                if (response.status == true) {
                  swalCustom.fire("Success", "Berhasil Mereset Password Menjadi 'drugvault'.", "success")
                  .then(function() {
                    location.reload(true);
                  });
                } else {
                  swalCustom.fire("[Conflict]", "Gagal Mereset Password.", "warning");
                }
              },
              error: function() {
                swalCustom.fire("[Bad Request]", "Gagal Mereset Password.", "error");
              }
            });
          } else if (result.dismiss === swalCustom.DismissReason.cancel) {
            swalCustom.fire("Cancelled", "Reset Password Dibatalkan.", "error");
          }
        })
      });

      // Change Active Status
      $('#datatable').on('click', '.btn-status', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
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
              url: 'user-change-status/' + id,
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