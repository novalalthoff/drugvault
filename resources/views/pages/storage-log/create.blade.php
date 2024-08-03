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
                New <span class="text-pink font-weight-bold">{{ $page }}</span>
              </span>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
              <form id="form" action="{{ route('storage-log.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                  <div class="row">
                    <div class="table-responsive">
                      <table id="table-storage-log" class="table">
                        <thead>
                          <tr>
                            <th style="width: 3%; vertical-align: middle;">No</th>
                            <th></th>
                            <th style="width: 10%; vertical-align: middle;" class="text-center">
                              <span class="text-success">Masuk</span> / <span class="text-danger">Keluar</span> <span style="color: red">*</span>
                            </th>
                            <th style="width: 15%; vertical-align: middle;" class="text-center">Nama Obat <span style="color: red">*</span></th>
                            <th style="width: 15%; vertical-align: middle;" class="text-center">Jumlah <span style="color: red">*</span></th>
                            <th style="width: 15%; vertical-align: middle;" class="text-center">Expired <span style="color: red">*</span></th>
                            <th style="vertical-align: middle" class="text-center">Notes</th>
                            <th style="width: 10%; vertical-align: middle;" class="text-center">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr id="row_1" class="tr_row">
                            <td>
                              <div class="col-form-label font-weight-bold">1.</div>
                            </td>
                            <td>
                              <div class="btn-group">
                                <button type="button" class="btn btn-success font-weight-bold" onclick="btnMasuk(1)">Masuk</button>
                                <button type="button" class="btn btn-danger font-weight-bold" onclick="btnKeluar(1)">Keluar</button>
                              </div>
                              <input type="hidden" class="form-control" name="type_storage[1]" id="type_storage_1" value="">
                            </td>
                            <td>
                              <div class="col-form-label font-weight-bold text-center" id="type_storage_text_1">-</div>
                            </td>
                            <td>
                              <select class="form-control select2-purple" name="drug_id[1]" id="drug_id_1" data-dropdown-css-class="select2-purple" style="width: 100%;" onchange="qtyDrug(1)">
                                <option value="">Pilih Obat</option>
                                @foreach ($drug as $d)
                                  <option value="{{ $d->id_drug }}">{{ $d->name_drug }}</option>
                                @endforeach
                              </select>
                              <div class="text-center" id="qty_drug_1">
                                <small class="font-weight-bold text-danger">Pilih Obat!</small>
                              </div>
                            </td>
                            <td>
                              <input type="text" class="form-control qty_storage" name="qty_storage[1]" id="qty_storage_1" placeholder="Masukkan Jumlah">
                              <div class="text-center"><small class="font-weight-light text-danger">Number Only</small></div>
                            </td>
                            <td>
                              <div class="input-group" id="expired_storage_text_1">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control expired_storage expired_storage_text_1" name="expired_storage_text[1]" placeholder="dd-mm-yyyy">
                              </div>
                              <div id="expired_storage_select_1" style="display: none;">
                                <select class="form-control select2-purple expired_storage_select_1" name="expired_storage_select[1]" data-dropdown-css-class="select2-purple" style="width: 100%;"></select>
                              </div>
                              <input type="hidden" class="form-control" name="expired_storage_input[1]" id="expired_storage_input_1" value="text">
                              <div class="text-center"><small class="font-weight-light">Ex: 24-07-2025</small></div>
                            </td>
                            <td>
                              <input type="text" class="form-control" name="note_storage[1]" id="note_storage_1" placeholder="Catatan..">
                            </td>
                            <td>
                              <div class="text-center">
                                <button type="button" class="btn bg-purple btn-add-row btn_1" data-row="1" onclick="addRow(1)">
                                  <i class="fas fa-plus"></i>
                                </button>
                                {{-- <button type="button" class="btn bg-pink btn-remove-row btn_1" data-row="1" onclick="removeRow(1)">
                                  <i class="fas fa-trash-alt"></i>
                                </button> --}}
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <button type="submit" class="btn btn-success btn-submit"><i class="fas fa-check-square text-sm mr-1"></i> Submit</button>
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
      $('#drug_id_1').select2({ placeholder: "Pilih Obat" });
      $('.expired_storage_select_1').select2({ placeholder: "Pilih Tgl Exp" });

      // Number only input on qty_storage
      $('.qty_storage').on("input", function() {
        this.value = this.value.replace(/[^\d]+|^0+/g, '');
      });

      $('.expired_storage').on('input', function(e) {
        this.type = 'text';
        var input = this.value;
        if (/\D\/$/.test(input)) input = input.substr(0, input.length - 3);
        var values = input.split('-').map(function(v) {
          return v.replace(/\D/g, '')
        });
        if (values[0]) values[0] = checkValue(values[0], 31);
        if (values[1]) values[1] = checkValue(values[1], 12);
        var output = values.map(function(v, i) {
          return v.length == 2 && i < 2 ? v + '-' : v;
        });
        this.value = output.join('').substr(0, 10);
      });

      $('.expired_storage').on('blur', function(e) {
        this.type = 'text';
        var input = this.value;
        var values = input.split('-').map(function(v, i) {
          return v.replace(/\D/g, '')
        });
        var output = '';
        if (values.length == 3) {
          var year = values[2].length !== 4 ? parseInt(values[2]) + 2000 : parseInt(values[2]);
          var month = parseInt(values[0]) - 1;
          var day = parseInt(values[1]);
          var d = new Date(year, month, day);
          if (!isNaN(d)) {
            document.getElementById('result').innerText = d.toString();
            var dates = [d.getMonth() + 1, d.getDate(), d.getFullYear()];
            output = dates.map(function(v) {
              v = v.toString();
              return v.length == 1 ? '0' + v : v;
            }).join('-');
          };
        };
        this.value = output;
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
                document.location = "{{ route('storage-log.index') }}";
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

    // FUNGSI BUTTON MASUK
    function btnMasuk(row) {
      showExpiredText(row);
      if($('#type_storage_text_' + row).hasClass('text-danger')){
        $('#type_storage_text_' + row).removeClass('text-danger');
      }
      $('#type_storage_text_' + row).addClass('text-success');
      $('#type_storage_text_' + row).text('Masuk');
      $('#type_storage_' + row).val('IN');
    }

    // FUNGSI BUTTON KELUAR
    function btnKeluar(row) {
      showExpiredSelect(row);
      if($('#type_storage_text_' + row).hasClass('text-success')){
        $('#type_storage_text_' + row).removeClass('text-success');
      }
      $('#type_storage_text_' + row).addClass('text-danger');
      $('#type_storage_text_' + row).text('Keluar');
      $('#type_storage_' + row).val('OUT');
    }

    // FUNGSI UNTUK MENAMPILKAN JUMLAH OBAT DAN TANGGAL KADALUARSA TERSEDIA
    function qtyDrug(row) {
      $.ajax({
        url: "{{ route('getDrugQtyAndExpired') }}",
        type: "POST",
        data: {
          id_drug: $('#drug_id_' + row).val(),
        },
        dataType: "JSON",
        success: function(response) {
          $('.expired_storage_select_' + row).empty();
          if (response.status == true) {
            var storage = "";
            var data_storage = response.storage;

            if (typeof(data_storage) == 'object') {
              storage = '<small>Stok Tersedia</small>';
              jQuery.each(data_storage, function(key, value) {
                storage += '<br><small class="font-weight-light">Exp <span class="font-weight-bolder text-danger">' + value.expired_storage + '</span>: <span class="text-olive font-weight-bold">' + value.qty_storage + '</span> pcs</small>';
              });
            } else {
              storage = '<small>Stok Tersedia</small>';
              storage += '<br><small class="font-weight-light">Exp <span class="font-weight-bolder text-danger">' + data_storage.expired_storage + '</span>: <span class="text-olive font-weight-bold">' + data_storage.qty_storage + '</span> pcs</small>';
            }

            $('#qty_drug_' + row).html(storage);

            jQuery.each(data_storage, function(key, value) {
              $('.expired_storage_select_' + row).append($("<option></option>").attr("value", value.expired_storage).text(value.expired_storage));
            });

            if ($('#type_storage_' + row).val() == 'OUT') {
              showExpiredSelect(row);
            } else {
              showExpiredText(row);
            }
          } else {
            storage = '<small>Stok Tersedia</small><br><small class="font-weight-bold text-danger">None!</small>';
            $('#qty_drug_' + row).html(storage);
            showExpiredText(row);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          var err = eval("(" + jqXHR.responseText + ")");
          $('#qty_drug_' + row).text(err.Message);
        }
      });
    }

    function showExpiredSelect(row) {
      $('#expired_storage_text_' + row).hide();
      $('#expired_storage_select_' + row).show();
      $('#expired_storage_input_' + row).val("select");
      $('.expired_storage_text_' + row).val(null);
    }

    function showExpiredText(row) {
      $('#expired_storage_select_' + row).hide();
      $('#expired_storage_text_' + row).show();
      $('#expired_storage_input_' + row).val("text");
    }

    function checkValue(str, max) {
      if (str.charAt(0) !== '0' || str == '00') {
        var num = parseInt(str);
        if (isNaN(num) || num <= 0 || num > max) num = 1;
        str = num > parseInt(max.toString().charAt(0)) && num.toString().length == 1 ? '0' + num : num.toString();
      };
      return str;
    };

    // function qtyDrug(row) {
    //   $.ajax({
    //     url: "{{ route('getDrugQty') }}",
    //     type: "POST",
    //     data: {
    //       id_drug: $('#drug_id_' + row).val(),
    //     },
    //     dataType: "JSON",
    //     success: function(response) {
    //       if (response.status == false) {
    //         $('#qty_drug_' + row).text('Not Found!');
    //       } else {
    //         $('#qty_drug_' + row).text(response.qty_drug);
    //       }
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) {
    //       var err = eval("(" + jqXHR.responseText + ")");
    //       $('#qty_drug_' + row).text(err.Message);
    //     }
    //   });
    // }

    // FUNGSI ADD ROW DEVICE NAME
    function addRow(row) {
      var table_name_device_length = $("#table-storage-log tbody .tr_row").length;
      for (x = 0; x < table_name_device_length; x++) {
        var tr = $("#table-storage-log tbody tr")[x];
        var count = $(tr).attr('id');
        count = Number(count.substring(4));
      }
      $('.btn_' + count).hide();
      id_html = count + 1;
      var dom_html = `<tr id="row_${id_html}" class="tr_row">
                        <td>
                          <div class="col-form-label font-weight-bold">${id_html}.</div>
                        </td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-success font-weight-bold" onclick="btnMasuk(${id_html})">Masuk</button>
                            <button type="button" class="btn btn-danger font-weight-bold" onclick="btnKeluar(${id_html})">Keluar</button>
                          </div>
                          <input type="hidden" class="form-control" name="type_storage[${id_html}]" id="type_storage_${id_html}" value="">
                        </td>
                        <td>
                          <div class="col-form-label font-weight-bold text-center" id="type_storage_text_${id_html}">-</div>
                        </td>
                        <td>
                          <select class="form-control select-form select2-purple" name="drug_id[${id_html}]" id="drug_id_${id_html}" data-dropdown-css-class="select2-purple" style="width: 100%;" onchange="qtyDrug(${id_html})">
                            <option value="">Pilih Obat</option>
                            @foreach ($drug as $d)
                              <option value="{{ $d->id_drug }}">{{ $d->name_drug }}</option>
                            @endforeach
                          </select>
                          <div class="text-center" id="qty_drug_${id_html}">
                            <small class="font-weight-bold text-danger">Pilih Obat!</small>
                          </div>
                        </td>
                        <td>
                          <input type="text" class="form-control qty_storage" name="qty_storage[${id_html}]" id="qty_storage_${id_html}" placeholder="Masukkan Jumlah">
                          <div class="text-center"><small class="font-weight-light text-danger">Number Only</small></div>
                        </td>
                        <td>
                          <div class="input-group" id="expired_storage_text_${id_html}">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" class="form-control expired_storage expired_storage_text_${id_html}" name="expired_storage_text[${id_html}]" placeholder="dd-mm-yyyy">
                          </div>
                          <div id="expired_storage_select_${id_html}" style="display: none;">
                            <select class="form-control select-form select2-purple expired_storage_select_${id_html}" name="expired_storage_select[${id_html}]" data-dropdown-css-class="select2-purple" style="width: 100%;"></select>
                          </div>
                          <input type="hidden" class="form-control" name="expired_storage_input[${id_html}]" id="expired_storage_input_${id_html}" value="text">
                          <div class="text-center"><small class="font-weight-light">Ex: 24-07-2025</small></div>
                        </td>
                        <td>
                          <input type="text" class="form-control" name="note_storage[${id_html}]" id="note_storage_${id_html}" placeholder="Catatan..">
                        </td>
                        <td>
                          <div class="text-center">
                            <button type="button" class="btn bg-purple btn-add-row btn_${id_html}" data-row="${id_html}" onclick="addRow(${id_html})">
                              <i class="fas fa-plus"></i>
                            </button>
                            <button type="button" class="btn bg-pink btn-remove-row btn_${id_html}" data-row="${id_html}" onclick="removeRow(${id_html})">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </div>
                        </td>
                      </tr>`;
      if (table_name_device_length >= 1) {
        $("#table-storage-log tbody .tr_row:last").after(dom_html);
      } else {
        $("#table-storage-log tbody").html(dom_html);
      }
      // Additional Document Ready Function
      $('.select-form').select2({ placeholder: "Pilih" });
      $('.qty_storage').on("input", function() {
        this.value = this.value.replace(/[^\d]+|^0+/g, '');
      });
      $('.expired_storage').on('input', function(e) {
        this.type = 'text';
        var input = this.value;
        if (/\D\/$/.test(input)) input = input.substr(0, input.length - 3);
        var values = input.split('-').map(function(v) {
          return v.replace(/\D/g, '')
        });
        if (values[0]) values[0] = checkValue(values[0], 31);
        if (values[1]) values[1] = checkValue(values[1], 12);
        var output = values.map(function(v, i) {
          return v.length == 2 && i < 2 ? v + '-' : v;
        });
        this.value = output.join('').substr(0, 10);
      });
      $('.expired_storage').on('blur', function(e) {
        this.type = 'text';
        var input = this.value;
        var values = input.split('-').map(function(v, i) {
          return v.replace(/\D/g, '')
        });
        var output = '';
        if (values.length == 3) {
          var year = values[2].length !== 4 ? parseInt(values[2]) + 2000 : parseInt(values[2]);
          var month = parseInt(values[0]) - 1;
          var day = parseInt(values[1]);
          var d = new Date(year, month, day);
          if (!isNaN(d)) {
            document.getElementById('result').innerText = d.toString();
            var dates = [d.getMonth() + 1, d.getDate(), d.getFullYear()];
            output = dates.map(function(v) {
              v = v.toString();
              return v.length == 1 ? '0' + v : v;
            }).join('-');
          };
        };
        this.value = output;
      });
    }

    // FUNGSI REMOVE ROW DEVICE NAME
    function removeRow(row) {
      var table_name_device_length = $("#table-storage-log tbody .tr_row").length;
      $('.btn_' + (row - 1)).show();
      if (table_name_device_length > 1) {
        $("#table-storage-log tbody .tr_row#row_" + row).remove();
      }
    }
  </script>
@endsection
