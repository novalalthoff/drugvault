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
                  @if (Storage::disk('public')->exists($get_data->avatar_drug) && $get_data->avatar_drug != null)
                    <img src="{{ asset('storage/' . $get_data->avatar_drug) }}" class="rounded img-fluid" style="opacity: 0.9; height: 300px;" >
                  @else
                    <img src="{{ asset('assets/dist/img/default-drug-avatar.png') }}" class="rounded img-fluid" style="opacity: 0.9; height: 300px;" >
                  @endif
                </div>
              </div>

              <div class="col-md-7">

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Perusahaan Farmasi</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label text-pink">
                    {{ $get_data->pharma->name_pharma }}
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Nama Obat</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label font-weight-bold text-purple">
                    {{ $get_data->name_drug }}
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Tipe Obat</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label">
                    {{ $get_data->drug_type->name_drug_type }}
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Kategori Obat</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label">
                    {{ $get_data->drug_category->name_drug_category }}
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Jumlah Stok</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label">
                    @php
                      if ($get_data->qty_drug > 100) {
                        $text = 'success';
                      } else if ($get_data->qty_drug <= 100 && $get_data->qty_drug > 5) {
                        $text = 'warning';
                      } else {
                        $text = 'danger';
                      }
                    @endphp
                    <strong class="text-{{ $text }}">{{ rupiah_format($get_data->qty_drug) }}</strong>{{ $get_data->qty_drug > 1 ? ' pcs' : ' pc' }}
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

                <div class="row mb-3">
                  <label class="col-sm-3 col-form-label">Catatan</label>
                  <div class="col-sm-1 col-form-label">:</div>
                  <div class="col-sm-8 col-form-label">
                    @if (!empty($get_data->note_drug))
                      {{ $get_data->note_drug }}
                    @else
                      -
                    @endif
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

      <!-- Drug's Datatable -->
      @if (isAccess('read', $get_menu_storage_log, auth()->user()->role_id))
        <div class="row">
          <div class="col-12">
            <div class="card">
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
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      @endif

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
        var name = '{{ $get_data->name_drug }}';
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
              url: "{{ route('drug.change-status', $get_data->id_drug) }}",
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

      // Drug's Datatable
      var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        fixedHeader: true,
        responsive: true,
        autoWidth: false,
        ajax: {
          url: "{{ route('drug.show', $get_data->id_drug) }}",
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