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
use App\Models\Drug;
use App\Models\StorageLog;

class DrugController extends Controller
{
  private $views = 'pages.drug';
  private $url = '/drug';
  private $title = 'Drug';
  private $page = 'Drug';

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
      $datas = Drug::orderBy('created_at', 'DESC')->get();

      return DataTables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name_drug']), Str::lower($request->get('search')))) {
                return true;
              }
              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_menu = get_menu_id('drug');

          //detail
          $btn_detail = '';
          if (isAccess('detail', $id_menu, Auth::user()->role_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('drug.show', $data->id_drug) . '"> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->role_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('drug.edit', $data->id_drug) . '"> Edit</a>';
          }

          //delete
          $btn_delete = '';
          if (isAccess('delete', $id_menu, Auth::user()->role_id)) {
            $btn_delete = '<div class="dropdown-divider"></div><a class="dropdown-item btn-delete text-danger" href="javascript:void(0)" data-id="' . $data->id_drug . '" data-name="' . $data->name_drug . '"> Hapus</a>';
          }

          return '
              <div class="dropleft text-center">
                <button class="btn btn-sm btn-icon" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-h"></i>
                </button>

                <div class="dropdown-menu m-0">
                  ' . $btn_detail . '
                  ' . $btn_edit . '
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
          if (Storage::disk('public')->exists($data->avatar_drug) && $data->avatar_drug != null) {
            $img_url = asset('storage/' . $data->avatar_drug);
          } else {
            $img_url = asset('assets/dist/img/default-drug-avatar.png');
          }
          $set_name_drug = '<img src="' . $img_url . '" border="0" width="40" class="img-rounded mr-3"><span class="text-purple"><b>' . $data->name_drug . '</b></span>';
          return $set_name_drug;
        })
        ->addColumn('set_pharma', function ($data) {
          $set_pharma = $data->pharma->name_pharma;
          return $set_pharma;
        })
        ->addColumn('set_drug_type', function ($data) {
          $set_drug_type = $data->drug_type->name_drug_type;
          return $set_drug_type;
        })
        ->addColumn('set_drug_category', function ($data) {
          $set_drug_category = $data->drug_category->name_drug_category;
          return $set_drug_category;
        })
        ->addColumn('set_qty_drug', function ($data) {
          if ($data->qty_drug > 100) {
            $text = 'success';
          } else if ($data->qty_drug <= 100 && $data->qty_drug > 5) {
            $text = 'warning';
          } else {
            $text = 'danger';
          }
          $set_qty_drug = '<div class="text-right font-weight-bold text-' . $text . '">' . rupiah_format($data->qty_drug) . '</div>';
          return $set_qty_drug;
        })
        ->addColumn('set_status', function ($data) {
          if ($data->is_active == '0') {
            $btn = "danger";
            $status = "Non Aktif";
          } else {
            $btn = "success";
            $status = "Aktif";
          }
          $set_status = '<label class="btn btn-xs btn-block btn-outline-' . $btn . ' text-center btn-status" data-id="' . $data->id_drug . '" data-name="' . $data->name_drug . '">' . $status . '</label>';
          return $set_status;
        })
        ->rawColumns(['action', 'set_admin', 'set_name_drug', 'set_pharma', 'set_drug_type', 'set_drug_category', 'set_qty_drug', 'set_status'])
        ->addIndexColumn() //increment
        ->make(true);
    }

    $data = [
      'url' => $this->url,
      'title' => 'Data ' . $this->title,
      'page' => $this->page,
      'get_menu' => get_menu_id('drug'),
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
      'name_drug' => 'required|string|max:100',
      'pharma_id' => 'required',
      'drug_type_id' => 'required',
      'drug_category_id' => 'required',
      'avatar_drug' => 'max:2048|mimes:png,jpg,jpeg|sometimes|nullable',
    ];
    $message = [
      'name_drug.required' => 'Nama Obat wajib diisi!',
      'name_drug.max' => 'Nama Obat max 100 karakter!',
      'pharma_id.required' => 'Perusahaan Farmasi wajib dipilih!',
      'drug_type_id.required' => 'Tipe Obat wajib dipilih!',
      'drug_category_id.required' => 'Kategori Obat wajib dipilih!',
      'avatar_drug.max' => 'File tidak boleh lebih dari 2Mb!',
      'avatar_drug.mimes' => 'File format hanya .png, .jpg, atau .jpeg!'
    ];
    return Validator::make($request, $rule, $message);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    $data = [
      'url' => $this->url,
      'title' => 'New ' . $this->title,
      'page' => $this->page,
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
    $validator = $this->rules($request->all());
    $check_name_drug = Drug::where('name_drug', $request->name_drug)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else if ($check_name_drug != null) {
      return response()->json(['status' => false, 'message' => $request->name_drug . " telah digunakan. Silahkan gunakan nama lain!"], 200);
    } else {
      DB::beginTransaction();
      try {
        $post = new Drug();

        $post->user_id = Auth::user()->id;

        $post->pharma_id = $request->pharma_id;
        $post->drug_type_id = $request->drug_type_id;
        $post->drug_category_id = $request->drug_category_id;
        $post->name_drug = $request->name_drug;
        $post->qty_drug = 0;
        $post->note_drug = $request->note_drug;
        $request->is_active == '1' ? $post->is_active = '1' : $post->is_active = '0';

        if ($request->hasFile('avatar_drug')) {
          $post->avatar_drug = $request->file('avatar_drug')->store('drug-avatar', 'public');
          $post->avatar_mimetype_drug = $request->file('avatar_drug')->getMimeType();
          $post->avatar_originalfile_drug = $request->file('avatar_drug')->getClientOriginalName();
          $post->avatar_originalmimetype_drug = $request->file('avatar_drug')->getClientOriginalExtension();
        }

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data Obat berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data Obat gagal disimpan!"
          ], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
      }
    }
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function show($id, Request $request)
  {
    $get_data = Drug::findOrFail($id);

    if (request()->ajax()) {
      $datas = StorageLog::where('drug_id', $id)->orderBy('created_at', 'DESC')->get();

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
      'title' => $this->title . ' Detail',
      'page' => $this->page,
      'get_data' => $get_data,
      'get_menu_storage_log' => get_menu_id('storage-log')
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
    $get_data = Drug::findOrFail($id);

    $data = [
      'url' => $this->url,
      'title' => 'Edit Data ' . $this->title,
      'page' => $this->page,
      'get_data' => $get_data,
    ];

    return view($this->views . '.edit', $data);
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Renderable
   */
  public function update(Request $request, $id)
  {
    $validator = $this->rules($request->all());
    $check_name_drug = Drug::where('name_drug', $request->name_drug)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else {
      DB::beginTransaction();
      try {
        $post = Drug::findOrFail($id);

        if ($request->name_drug != $post->name_drug) {
          if ($check_name_drug == null) {
            $post->name_drug = $request->name_drug;
          } else {
            return response()->json(['status' => false, 'message' => $request->name_drug . " telah digunakan. Silahkan gunakan nama lain!"]);
          }
        }

        $post->pharma_id = $request->pharma_id;
        $post->drug_type_id = $request->drug_type_id;
        $post->drug_category_id = $request->drug_category_id;
        $post->note_drug = $request->note_drug;
        $request->is_active == '1' ? $post->is_active = '1' : $post->is_active = '0';

        if ($request->hasFile('avatar_drug')) {
          if (Storage::disk('public')->exists($post->avatar_drug)) {
            Storage::disk('public')->delete($post->avatar_drug);
          }
          $post->avatar_drug = $request->file('avatar_drug')->store('drug-avatar', 'public');
          $post->avatar_mimetype_drug = $request->file('avatar_drug')->getMimeType();
          $post->avatar_originalfile_drug = $request->file('avatar_drug')->getClientOriginalName();
          $post->avatar_originalmimetype_drug = $request->file('avatar_drug')->getClientOriginalExtension();
        }

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data Obat berhasil diperbarui!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data Obat gagal diperbarui!"
          ], 200);
        }
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Renderable
   */
  public function destroy($id)
  {
    $drug = Drug::findOrFail($id);

    if (Storage::disk('public')->exists($drug->avatar_drug)) {
      Storage::disk('public')->delete($drug->avatar_drug);
    }

    $hapus = $drug->delete();

    if ($hapus == true) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  // Ganti Status
  public function changeStatus($id)
  {
    $set = Drug::findOrFail($id);

    if ($set->is_active == '1') {
      $set->is_active = '0';
    } else {
      $set->is_active = '1';
    }

    $set->save();

    if ($set == true) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  public function getDrugBySelect2(Request $request)
  {
    $search = $request->search;

    if ($search == '') {
      $data = Drug::orderby('name_drug', 'ASC')
        ->where('is_active', '1')
        ->limit(10)
        ->get();
    } else {
      $data = Drug::orderby('name_drug', 'ASC')
        ->where('is_active', '1')
        ->where('name_drug', 'like', '%' . $search . '%')
        ->limit(10)
        ->get();
    }

    $response = array();

    foreach ($data as $item) {
      $response[] = array(
        "id" => $item->id_drug,
        "text" => $item->name_drug
      );
    }

    return response()->json($response);
  }

  public function getDrugQty(Request $request)
  {
    $data = Drug::where('id_drug', $request->id_drug)->first();
    $response = array();

    if ($data != null) {
      $response = array(
        "status" => true,
        "qty_drug" => rupiah_format($data->qty_drug)
      );
    } else {
      $response = array(
        "status" => false
      );
    }

    return response()->json($response);
  }

  
  public function getDrugQtyAndExpired(Request $request)
  {
    $id_drug = $request->id_drug;

    $storage_in = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))->where('drug_id', $id_drug)->where('type_storage', 'IN')->where('is_cancelled', '!=', '1')->orderBy('expired_storage', 'ASC')->groupBy('expired_storage')->get();
    $storage_out = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))->where('drug_id', $id_drug)->where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->orderBy('expired_storage', 'ASC')->groupBy('expired_storage')->get();
    $storage_not_out = StorageLog::select('expired_storage', DB::raw('SUM(qty_storage) AS qty_storage'))
                        ->where('drug_id', $id_drug)
                        ->where('type_storage', 'IN')
                        ->where('is_cancelled', '!=', '1')
                        ->whereNotIn('expired_storage', DB::table('tb_storage')->select('expired_storage')->where('drug_id', $id_drug)->where('type_storage', 'OUT')->where('is_cancelled', '!=', '1')->groupBy('expired_storage')->get()->pluck('expired_storage'))
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
              "expired_storage" => $in->expired_storage,
              "qty_storage" => rupiah_format($stock)
            );
          }
        }
      }
    }

    if (count($storage_not_out) > 0) {
      foreach ($storage_not_out as $str) {
        $response[] = array(
          "expired_storage" => $str->expired_storage,
          "qty_storage" => rupiah_format((int)$str->qty_storage)
        );
      }
    }

    usort($response, function ($a, $b) {
      return $a['expired_storage'] > $b['expired_storage'];
    });

    for ($i = 0; $i < count($response); $i++) { 
      $response[$i]['expired_storage'] = Carbon::createFromFormat("Y-m-d", $response[$i]['expired_storage'])->format("d-m-Y");
    }

    if ($response != null) {
      return response()->json(['status' => true, 'storage' => $response]);
    } else {
      return response()->json(['status' => false]);
    }
  }
}
