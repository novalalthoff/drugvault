<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// LIBRARIES
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

// MODELS
use App\Models\StorageLog;
use App\Models\Drug;

class StorageLogController extends Controller
{
  private $views = 'pages.storage-log';
  private $url = '/storage-log';
  private $title = 'Storage Log';
  private $page = 'Storage Log';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the form for creating a new resource.
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (request()->ajax()) {
      $datas = StorageLog::orderBy('created_at', 'DESC')->get();

      return DataTables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['set_name_drug']), Str::lower($request->get('search')))) {
                return true;
              }
              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_menu = get_menu_id('storage-log');

          //detail
          $btn_detail = '';
          if (isAccess('detail', $id_menu, Auth::user()->role_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('storage-log.show', $data->id_storage) . '"> Detail</a>';
          }

          //cancel
          $btn_cancel = '';
          if (isAccess('cancel', $id_menu, Auth::user()->role_id)) {
            if ($data->is_cancelled == '0') {
              $btn_cancel = '<div class="dropdown-divider"></div><a class="dropdown-item btn-cancel text-danger" href="javascript:void(0)" data-id="' . $data->id_storage . '" data-name="data-storage-log-[' . $data->created_at . ']" data-action="1"> Cancel</a>';
            } else if ($data->is_cancelled == '1') {
              $btn_cancel = '<div class="dropdown-divider"></div><a class="dropdown-item btn-cancel text-danger" href="javascript:void(0)" data-id="' . $data->id_storage . '" data-name="data-storage-log-[' . $data->created_at . ']" data-action="2"> Revert Cancel</a>';
            }
          }

          //delete
          $btn_delete = '';
          if (isAccess('delete', $id_menu, Auth::user()->role_id)) {
            $btn_delete = '<div class="dropdown-divider"></div><a class="dropdown-item btn-delete text-danger" href="javascript:void(0)" data-id="' . $data->id_storage . '" data-name="data-storage-log-[' . $data->created_at . ']"> Hapus</a>';
          }

          return '
              <div class="dropleft text-center">
                <button class="btn btn-sm btn-icon" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-h"></i>
                </button>

                <div class="dropdown-menu m-0">
                  ' . $btn_detail . '
                  ' . $btn_cancel . '
                  ' . $btn_delete . '
                </div>
              </div>
          ';
        })
        ->addColumn('set_admin', function ($data) {
          $set_admin = '<div class="text-pink text-center">' . $data->user->username . '</div>';
          return $set_admin;
        })
        ->addColumn('set_name_drug', function ($data) {
          $id_menu = get_menu_id('drug');

          // $set_name_drug = '<div class="text-purple font-weight-bold">' . $data->drug->name_drug . '</div>';
          if (Storage::disk('public')->exists($data->drug->avatar_drug) && $data->drug->avatar_drug != null) {
            $img_url = asset('storage/' . $data->drug->avatar_drug);
          } else {
            $img_url = asset('assets/dist/img/default-drug-avatar.png');
          }

          if (isAccess('detail', $id_menu, Auth::user()->role_id)) {
            $set_name_drug = '<div class="text-center"><img src="' . $img_url . '" border="0" width="40" class="img-rounded"><br><a href="' . route('drug.show', $data->drug->id_drug) . '" class="text-purple"><b>' . $data->drug->name_drug . '</b></a></div>';
          } else {
            $set_name_drug = '<div class="text-center"><img src="' . $img_url . '" border="0" width="40" class="img-rounded"><br><span class="text-purple"><b>' . $data->drug->name_drug . '</b></span></div>';
          }

          return $set_name_drug;
        })
        ->addColumn('set_type_storage', function ($data) {
          $data->type_storage == 'IN' ? $type = 'Masuk' : $type = 'Keluar';
          $data->type_storage == 'IN' ? $text = 'success' : $text = 'danger';
          $set_type_storage = '<div class="text-center text-' . $text . '">' . $type . '</div>';
          return $set_type_storage;
        })
        ->addColumn('set_qty', function ($data) {
          $data->type_storage == 'IN' ? $btn = 'success' : $btn = 'danger';
          $set_qty = '<div class="text-' . $btn . ' font-weight-bold text-right">' . rupiah_format($data->qty_storage) . '</div>';
          return $set_qty;
        })
        ->addColumn('set_expired_date', function ($data) {
          $expired_date = Carbon::createFromFormat("Y-m-d", $data->expired_storage)->isoFormat("D MMMM YYYY");
          $set_expired_date = '<div class="text-center">' . $expired_date . '</div>';
          return $set_expired_date;
        })
        ->addColumn('set_note', function ($data) {
          !empty($data->note_storage) ? $set_note = $data->note_storage : $set_note = '-';
          if ($data->is_cancelled == '1') {
            $set_note = '<span class="text-danger">[ Cancelled ]</span> ' . $set_note;
          } else if ($data->is_cancelled == '2') {
            $set_note = '<span class="text-info">[ Cancellation Reverted ]</span> ' . $set_note;
          }
          return $set_note;
        })
        ->addColumn('set_recorded_at', function ($data) {
          $set_recorded_at = Carbon::createFromFormat("Y-m-d H:i:s", $data->created_at)->format("d-m-Y H:i:s");
          $set_recorded_at = '<div class="text-center">' . $set_recorded_at . '</div>';
          return $set_recorded_at;
        })
        ->rawColumns(['action', 'set_admin', 'set_name_drug', 'set_type_storage', 'set_qty', 'set_expired_date', 'set_note', 'set_recorded_at'])
        ->addIndexColumn() //increment
        ->make(true);
    };

    $data = [
      'url' => $this->url,
      'title' => 'Data ' . $this->title,
      'page' => $this->page,
      'get_menu' => get_menu_id('storage-log'),
    ];

    return view($this->views . '.index', $data);
  }

  /**
   * Rules to store a newly created or to update specified resource in storage.
   * @param Request $request
   * @return Renderable
   */
  public function rules($request)
  {
    $rule = [
      'drug_id' => 'required',
      'type_storage' => 'required',
      'qty_storage' => 'required',
      'expired_storage' => 'required',
    ];
    $message = [
      'drug_id.required' => 'Obat wajib dipilih!',
      'type_storage.required' => 'Barang masuk atau keluar wajib diisi!',
      'qty_storage.required' => 'Jumlah barang wajib diisi!',
      'expired_storage.required' => 'Tanggal expired wajib diisi!',
    ];
    return Validator::make($request, $rule, $message);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    $drug = Drug::where('is_active', '1')->orderBy('name_drug', 'ASC')->get();

    $data = [
      'url' => $this->url,
      'title' => 'New ' . $this->title,
      'page' => $this->page,
      'drug' => $drug,
    ];

    return view($this->views . '.create', $data);
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Renderable
   */
  public function store(Request $request)
  {
    DB::beginTransaction();
    try {

      if (count($request->drug_id) > 0) {
        // Validation
        for ($i = 1; $i <= count($request->drug_id); $i++) {
          $drug = Drug::where('id_drug', $request->drug_id[$i])->first();

          if (empty($request->type_storage[$i])) {
            return response()->json(['status' => false, 'message' => "Form-$i: Barang Masuk / Keluar wajib dipilih!"]);
          }
          if (empty($request->drug_id[$i])) {
            return response()->json(['status' => false, 'message' => "Form-$i: Obat wajib dipilih!"]);
          }
          if (empty($request->qty_storage[$i])) {
            return response()->json(['status' => false, 'message' => "Form-$i: Jumlah Barang wajib diisi!"]);
          } else if (!preg_match("/^\d+$/", $request->qty_storage[$i])) {
            return response()->json(['status' => false, 'message' => "Form-$i: Format Jumlah Barang tidak sesuai!"]);
          }
          if ($request->expired_storage_input[$i] == "text") {
            if (empty($request->expired_storage_text[$i])) {
              return response()->json(['status' => false, 'message' => "Form-$i: Tanggal Expired wajib diisi!"]);
            } else if (!preg_match("/(^0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-(\d{4}$)/", $request->expired_storage_text[$i])) {
              return response()->json(['status' => false, 'message' => "Form-$i: Format Tanggal Expired tidak sesuai!<br>Ex: 24-07-2025 (dd-mm-yyyy)"]);
            }
          } else if ($request->expired_storage_input[$i] == "select") {
            if (empty($request->expired_storage_select[$i])) {
              return response()->json(['status' => false, 'message' => "Form-$i: Tanggal Expired wajib diisi!"]);
            }
          }

          // Stock per Expired Date Validation
          $storage_in = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))->where('drug_id', $request->drug_id[$i])->where('type_storage', 'IN')->orderBy('expired_storage', 'ASC')->groupBy('expired_storage')->get();
          $storage_out = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))->where('drug_id', $request->drug_id[$i])->where('type_storage', 'OUT')->orderBy('expired_storage', 'ASC')->groupBy('expired_storage')->get();
          $storage_not_out = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))
                              ->where('drug_id', $request->drug_id[$i])
                              ->where('type_storage', 'IN')
                              ->where('is_cancelled', '!=', '1')
                              ->whereNotIn('expired_storage', DB::table('tb_storage')->select('expired_storage')->where('drug_id', $request->drug_id[$i])->where('type_storage', 'OUT')->groupBy('expired_storage')->get()->pluck('expired_storage'))
                              ->orderBy('expired_storage', 'ASC')
                              ->groupBy('expired_storage')
                              ->get();
          $response = array();
          foreach ($storage_in as $in) {
            foreach ($storage_out as $out) {
              if ($in->expired_storage == $out->expired_storage) {
                $stock = $in->qty_storage - $out->qty_storage;
                if ($stock != 0) {
                  $response[] = array(
                    "expired_storage" => Carbon::createFromFormat("Y-m-d", $in->expired_storage)->format("d-m-Y"),
                    "qty_storage" => $stock
                  );
                }
              }
            }
          }
          if (count($storage_not_out) > 0) {
            foreach ($storage_not_out as $str) {
              $response[] = array(
                "expired_storage" => Carbon::createFromFormat("Y-m-d", $str->expired_storage)->format("d-m-Y"),
                "qty_storage" => (int)$str->qty_storage
              );
            }
          }

          if ($request->type_storage[$i] == 'OUT') {
            foreach ($response as $rs) {
              if ($rs["expired_storage"] == $request->expired_storage_select[$i]) {
                if (($rs["qty_storage"] - $request->qty_storage[$i]) < 0) {
                  if ($rs["qty_storage"] < 2) {
                    return response()->json(['status' => false, 'message' => 'Form-' . $i . ': Stok Exp: <span class="text-danger">' . $request->expired_storage_select[$i] . '</span> hanya tersedia: <span class="text-success font-weight-bold">' . rupiah_format($rs['qty_storage']) . '</span> pc!']);
                  } else {
                    return response()->json(['status' => false, 'message' => 'Form-' . $i . ': Stok Exp: <span class="text-danger">' . $request->expired_storage_select[$i] . '</span> hanya tersedia: <span class="text-success font-weight-bold">' . rupiah_format($rs['qty_storage']) . '</span> pcs!']);
                  }
                }
              }
            }
          }
        }

        // Store Data
        for ($j = 1; $j <= count($request->drug_id); $j++) {
          $post = new StorageLog();
          $drug = Drug::where('id_drug', $request->drug_id[$j])->first();

          // Stock per Expired Date Validation
          $storage_in = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))->where('drug_id', $request->drug_id[$j])->where('type_storage', 'IN')->orderBy('expired_storage', 'ASC')->groupBy('expired_storage')->get();
          $storage_out = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))->where('drug_id', $request->drug_id[$j])->where('type_storage', 'OUT')->orderBy('expired_storage', 'ASC')->groupBy('expired_storage')->get();
          $storage_not_out = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))
                              ->where('drug_id', $request->drug_id[$j])
                              ->where('type_storage', 'IN')
                              ->where('is_cancelled', '!=', '1')
                              ->whereNotIn('expired_storage', DB::table('tb_storage')->select('expired_storage')->where('drug_id', $request->drug_id[$j])->where('type_storage', 'OUT')->groupBy('expired_storage')->get()->pluck('expired_storage'))
                              ->orderBy('expired_storage', 'ASC')
                              ->groupBy('expired_storage')
                              ->get();
          $response = array();
          foreach ($storage_in as $in) {
            foreach ($storage_out as $out) {
              if ($in->expired_storage == $out->expired_storage) {
                $stock = $in->qty_storage - $out->qty_storage;
                if ($stock != 0) {
                  $response[] = array(
                    "expired_storage" => Carbon::createFromFormat("Y-m-d", $in->expired_storage)->format("d-m-Y"),
                    "qty_storage" => $stock
                  );
                }
              }
            }
          }
          if (count($storage_not_out) > 0) {
            foreach ($storage_not_out as $str) {
              $response[] = array(
                "expired_storage" => Carbon::createFromFormat("Y-m-d", $str->expired_storage)->format("d-m-Y"),
                "qty_storage" => (int)$str->qty_storage
              );
            }
          }

          if ($request->type_storage[$j] == 'IN') {
            $drug->qty_drug = $drug->qty_drug + $request->qty_storage[$j];
            $drug->save();
          } else if ($request->type_storage[$j] == 'OUT') {
            foreach ($response as $rs) {
              if ($rs["expired_storage"] == $request->expired_storage_select[$j]) {
                if (($rs["qty_storage"] - $request->qty_storage[$j]) < 0) {
                  if ($rs["qty_storage"] < 2) {
                    return response()->json(['status' => false, 'message' => 'Form-' . $j . ': Stok Exp: <span class="text-danger">' . $request->expired_storage_select[$j] . '</span> hanya tersedia: <span class="text-success font-weight-bold">' . rupiah_format($rs['qty_storage']) . '</span> pc!']);
                  } else {
                    return response()->json(['status' => false, 'message' => 'Form-' . $j . ': Stok Exp: <span class="text-danger">' . $request->expired_storage_select[$j] . '</span> hanya tersedia: <span class="text-success font-weight-bold">' . rupiah_format($rs['qty_storage']) . '</span> pcs!']);
                  }
                } else {
                  $drug->qty_drug = $drug->qty_drug - $request->qty_storage[$j];
                  $drug->save();
                }
              }
            }
          }

          $post->user_id = Auth::user()->id;
          $post->drug_id = $request->drug_id[$j];
          $post->type_storage = $request->type_storage[$j];
          $post->qty_storage = $request->qty_storage[$j];
          if ($request->expired_storage_input[$j] == "text") {
            $post->expired_storage = Carbon::createFromFormat("d-m-Y", $request->expired_storage_text[$j])->format("Y-m-d");
          } else if ($request->expired_storage_input[$j] == "select") {
            $post->expired_storage = Carbon::createFromFormat("d-m-Y", $request->expired_storage_select[$j])->format("Y-m-d");
          }
          !empty($request->note_storage[$j]) ? $post->note_storage = $request->note_storage[$j] : $post->note_storage = null;
          $simpan = $post->save();
        }
      } else {
        return response()->json(['status' => false, 'message' => "Lengkapi form terlebih dahulu!"]);
      }

      if ($simpan == true) {
        DB::commit();
        return response()->json([
          'status' => true,
          'message' => "Data Storage Log berhasil disimpan!"
        ], 200);
      } else {
        return response()->json([
          'status' => false,
          'message' => "Data Storage Log gagal disimpan!"
        ], 200);
      }
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
    }
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function show($id)
  {
    $get_data = StorageLog::findOrFail($id);
    $get_data->expired_storage = Carbon::createFromFormat("Y-m-d", $get_data->expired_storage)->isoFormat("D MMMM YYYY");
    $recorded = Carbon::createFromFormat("Y-m-d H:i:s", $get_data->updated_at)->isoFormat("HH:mm:ss, D MMMM YYYY");

    $data = [
      'url' => $this->url,
      'title' => $this->title . ' Detail',
      'page' => $this->page,
      'get_data' => $get_data,
      'recorded' => $recorded,
    ];

    return view($this->views . '.show', $data);
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Renderable
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Renderable
   */
  public function destroy($id)
  {
    $hapus = StorageLog::destroy($id);

    if ($hapus == true) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  // Cancel Input
  public function cancel($id)
  {
    $set = StorageLog::findOrFail($id);
    $drug = Drug::where('id_drug', $set->drug_id)->first();
    $expired_date = Carbon::createFromFormat("Y-m-d", $set->expired_storage)->format("d-m-Y");

    $storage_in = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))->where('drug_id', $set->drug_id)->where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->orderBy('expired_storage', 'ASC')->groupBy('expired_storage')->get();
    $storage_out = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))->where('drug_id', $set->drug_id)->where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->orderBy('expired_storage', 'ASC')->groupBy('expired_storage')->get();
    $storage_not_out = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))
                        ->where('drug_id', $set->drug_id)
                        ->where('type_storage', 'IN')
                        ->where('is_cancelled', '!=', '1')
                        ->whereNotIn('expired_storage', DB::table('tb_storage')->select('expired_storage')->where('drug_id', $set->drug_id)->where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->groupBy('expired_storage')->get()->pluck('expired_storage'))
                        ->orderBy('expired_storage', 'ASC')
                        ->groupBy('expired_storage')
                        ->get();
    $response = array();
    foreach ($storage_in as $in) {
      foreach ($storage_out as $out) {
        if ($in->expired_storage == $out->expired_storage) {
          $stock = $in->qty_storage - $out->qty_storage;
          if ($stock != 0) {
            $response[] = array(
              "expired_storage" => Carbon::createFromFormat("Y-m-d", $in->expired_storage)->format("d-m-Y"),
              "qty_storage" => rupiah_format($stock)
            );
          }
        }
      }
    }
    if (count($storage_not_out) > 0) {
      foreach ($storage_not_out as $str) {
        $response[] = array(
          "expired_storage" => Carbon::createFromFormat("Y-m-d", $str->expired_storage)->format("d-m-Y"),
          "qty_storage" => rupiah_format((int)$str->qty_storage)
        );
      }
    }


    if ($set->is_cancelled == '0') {
      $set->is_cancelled = '1';
      if ($set->type_storage == 'IN') {
        foreach ($response as $rs) {
          if ($rs["expired_storage"] == $expired_date) {
            if (($rs["qty_storage"] - $set->qty_storage) < 0) {
              return response()->json(['status' => false, 'message' => '<span class="text-warning">[ Stock Conflict ]</span><br>Stok Obat Exp: <span class="text-danger">' . $expired_date . '</span> tidak dapat di-cancel!']);
            }
          }
        }
        $drug->qty_drug = $drug->qty_drug - $set->qty_storage;
      } else {
        $drug->qty_drug = $drug->qty_drug + $set->qty_storage;
      }
    } else if ($set->is_cancelled == '1') {
      $set->is_cancelled = '2';
      if ($set->type_storage == 'IN') {
        $drug->qty_drug = $drug->qty_drug + $set->qty_storage;
      } else {
        $drug->qty_drug = $drug->qty_drug - $set->qty_storage;
      }
    } else if ($set->is_cancelled == '2') {
      return response()->json(['status' => false]);
    }


    $drug->save();
    $set->save();

    if ($set == true && $drug == true) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }
}
