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
          <div class="col-sm-12">
            <span class="align-middle">
              <a href="{{ route('home') }}" class="text-purple"><i class="fas fa-home"></i> Home</a> &nbsp;/&nbsp;
              <span class="text-muted">{{ $page }}</span>
            </span>
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
                  <a href="{{ route('storage-log.create') }}" class="btn bg-purple float-right" style="width: 6rem"><i class="fas fa-plus text-sm mr-1"></i> Create</a>
                @endif
              </span>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="width: 5%">No</th>
                    <th>Nama Obat</th>
                    <th style="width: 5%" class="text-center">Barang</th>
                    <th style="width: 10%" class="text-center">Jumlah</th>
                    <th style="width: 15%" class="text-center">Expired</th>
                    <th>Notes</th>
                    <th style="width: 10%" class="text-center">Recorded At</th>
                    <th style="width: 10%" class="text-center">Operator</th>
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
          url: "{{ route('storage-log.index') }}",
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
            data: 'set_name_drug',
            name: 'set_name_drug',
            orderable: false
          },
          {
            data: 'set_type_storage',
            name: 'set_type_storage',
            orderable: false
          },
          {
            data: 'set_qty',
            name: 'set_qty',
            orderable: false
          },
          {
            data: 'set_expired_date',
            name: 'set_expired_date',
            orderable: false
          },
          {
            data: 'set_note',
            name: 'set_note',
            orderable: false
          },
          {
            data: 'set_recorded_at',
            name: 'set_recorded_at',
            orderable: false
          },
          {
            data: 'set_admin',
            name: 'set_admin',
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

      // Cancel Input
      $('#datatable').on('click', '.btn-cancel', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var action = $(this).data('action');
        var text1 = "";
        var text2 = "";
        var text3 = "";
        if (action == '1') {
          text1 = "membatalkan";
          text2 = "Membatalkan";
          text3 = "dibatalkan";
        } else if (action == '2') {
          text1 = "mengembalikan";
          text2 = "Mengembalikan";
          text3 = "dikembalikan";
        }
        swalCustom.fire({
          title: "Apakah anda yakin?",
          text: "Untuk " + text1 + " log : " + name,
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Ya!",
          cancelButtonText: "Kembali",
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "ajax",
              url: 'storage-log-cancel/' + id,
              method: "GET",
              async: true,
              dataType: "JSON",
              success: function(response) {
                if (response.status == true) {
                  swalCustom.fire("Success", "Berhasil " + text2 + " Log.", "success")
                  .then(function() {
                    location.reload(true);
                  });
                } else {
                  if (response.message != null) {
                    swalCustom.fire("Error", response.message, "warning");
                  } else {
                    swalCustom.fire("[Conflict]", "Gagal " + text2 + " Log.", "warning");
                  }
                }
              },
              error: function() {
                swalCustom.fire("[Bad Request]", "Gagal " + text2 + " Log.", "error");
              }
            });
          } else if (result.dismiss === swalCustom.DismissReason.cancel) {
            swalCustom.fire("Cancelled", "Record Log tidak " + text3 + ".", "error");
          }
        })
      });

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
              url: "storage-log-destroy/" + id,
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
    });
  </script>
@endsection