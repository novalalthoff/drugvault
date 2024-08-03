@extends( 'pages.layouts.main' )

@section('css-library')
@endsection

@section('css-custom')
  <style>
    .sortable>li>div {
      margin-bottom: 10px;
      border-bottom: 1px solid #ddd;
    }

    .sortable,
    .sortable>li>div {
      display: block;
      width: 100%;
      float: left;
    }

    .sortable>li {
      display: block;
      width: 100%;
      margin-bottom: 5px;
      float: left;
      border: 1px solid #ddd;
      background: #fff;
      padding: 5px;
    }

    .sortable ul {
      padding: 5px;
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
                Master <span class="text-pink font-weight-bold">{{ $page }}</span>
                @if (isAccess('create', $get_menu, auth()->user()->role_id))
                  <a href="{{ route('menu.create') }}" class="btn bg-purple float-right" style="width: 6rem"><i class="fas fa-plus text-sm mr-1"></i> Create</a>
                @endif
              </span>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <ul class="sortable list-unstyled" id="sortable">
                @foreach ($get_data as $menu)
                  @php
                    $id_menu = get_menu_id('role');

                    $detailButton = '<a class="" href="' . route('menu.show', $menu->id_menu) . '">Detail</a>';

                    $editButton = '';
                    if (isAccess('update', $id_menu, auth()->user()->role_id)) {
                      $editButton = '<a href="' . route('menu.edit', $menu->id_menu) . '" class="">Edit</a>';
                    }

                    $deleteButton = '';
                    if (isAccess('delete', $id_menu, auth()->user()->role_id)) {
                      $deleteButton = '<a class="btn-delete" href="javascript:void(0)" data-id="' . $menu->id_menu . '" data-name="' . $menu->name_menu . '">Hapus</a>';
                    }

                    $action = '
                      ' . $editButton . '
                      ' .  $detailButton . '
                      ' . $deleteButton . '
                      ';
                  @endphp

                  <li id="mdl-{{ $menu->id_menu }}">
                    <div class="block block-title">
                      <i class="fa fa-sort text-muted"></i>
                      <i class="{{ $menu->icon_menu }} ml-2"></i> {{ $menu->name_menu }} {!! $action !!}
                    </div>

                    <ul class="sortable list-unstyled">
                      @foreach ($menu->menus as $submenu)
                        @php
                          $id_menu = get_menu_id('role');

                          $detailButton = '<a class="" href="' . route('menu.show', $submenu->id_menu) . '">Detail</a>';

                          $editButton = '';
                          if (isAccess('update', $id_menu, auth()->user()->role_id)) {
                            $editButton = '<a href="' . route('menu.edit', $submenu->id_menu) . '" class="">Edit</a>';
                          }

                          $deleteButton = '';
                          if (isAccess('delete', $id_menu, auth()->user()->role_id)) {
                            $deleteButton = '<a class="btn-delete" href="javascript:void(0)" data-id="' . $submenu->id_menu . '" data-name="' . $submenu->name_menu . '">Hapus</a>';
                          }

                          $action = '
                            ' . $editButton . '
                            ' .  $detailButton . '
                            ' . $deleteButton . '
                            ';
                        @endphp

                        <li id="mdl-{{ $submenu->id_menu }}">
                          <div class="block block-title">
                            <i class="fa fa-sort text-muted"></i>
                            <i class="{{ $submenu->icon_menu }} ml-2"></i> {{ $submenu->name_menu }} {!! $action !!}
                          </div>
                          <ul class="sortable list-unstyled"></ul>
                        </li>
                      @endforeach
                    </ul>
                    <!-- /.menu-sortable -->
                  </li>
                @endforeach
              </ul>
              <!-- /.menu-sortable -->

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endsection

@section('js-custom')
  <script>
    // Document Ready Function
    $(function() {
      // Sortable
      $('.sortable').sortable({
        connectWith: '.sortable',
        placeholder: 'placeholder',
        update: function(event, ui) {
          var struct = [];
          var i = 0;
          $(".sortable").each(function(ind, el) {
            struct[ind] = {
              index: i,
              class: $(el).attr("class"),
              count: $(el).children().length,
              parent: $(el).parent().is("li") ? $(el).parent().attr("id") : "",
              parentIndex: $(el).parent().is("li") ? $(el).parent().index() : "",
              array: $(el).sortable("toArray"),
              serial: $(el).sortable("serialize")
            };
            i++;
          });

          var orderData = {};
          $(struct).each(function(k, v) {
            var main = v.array[0];
            orderData[v.parent] = v.array;
          });

          $.ajax({
            url: "menu/sort",
            method: "POST",
            data: {
              'main': orderData,
              '_token': '{{ csrf_token() }}'
            },
            success: function(data) {
              // alert('Data berhasil diperbarui');
            }
          });
        }
      }).disableSelection();

      // Delete Data
      $('#sortable').on('click', '.btn-delete', function() {
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
              url: "menu-destroy/" + id,
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