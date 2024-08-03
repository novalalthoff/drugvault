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
                  <a href="{{ route('drug.create') }}" class="btn bg-purple float-right" style="width: 6rem"><i class="fas fa-plus text-sm mr-1"></i> Create</a>
                @endif
              </span>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="datatable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th style="width: 5%">No</th>
                    <th>Farmasi</th>
                    <th>Nama Obat</th>
                    <th>Tipe</th>
                    <th>Kategori</th>
                    <th class="text-center">Stok</th>
                    <th style="width: 10%" class="text-center">Status</th>
                    <th style="width: 15%" class="text-center">Created by</th>
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
          url: "{{ route('drug.index') }}",
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
            data: 'set_pharma',
            name: 'set_pharma',
            orderable: false
          },
          {
            data: 'set_name_drug',
            name: 'set_name_drug',
            orderable: false
          },
          {
            data: 'set_drug_type',
            name: 'set_drug_type',
            orderable: false
          },
          {
            data: 'set_drug_category',
            name: 'set_drug_category',
            orderable: false
          },
          {
            data: 'set_qty_drug',
            name: 'set_qty_drug',
            orderable: false
          },
          {
            data: 'set_status',
            name: 'set_status',
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
              url: "drug-destroy/" + id,
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
              url: 'drug-change-status/' + id,
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