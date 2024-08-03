<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// LIBRARIES
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

// MODELS
use App\Models\Pharma;

class PharmaController extends Controller
{
  private $views = 'pages.pharma';
  private $url = '/pharma';
  private $title = 'Pharmaceutical Manufacturer';
  private $page = 'Pharmaceutical Manufacturer';

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
      $datas = Pharma::orderBy('created_at', 'DESC')->get();

      return DataTables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name_pharma']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['address_pharma']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['set_country']), Str::lower($request->get('search')))) {
                return true;
              }
              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_menu = get_menu_id('pharma');

          //detail
          $btn_detail = '';
          if (isAccess('detail', $id_menu, Auth::user()->role_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('pharma.show', $data->id_pharma) . '"> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->role_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('pharma.edit', $data->id_pharma) . '"> Edit</a>';
          }

          //delete
          $btn_delete = '';
          if (isAccess('delete', $id_menu, Auth::user()->role_id)) {
            $btn_delete = '<div class="dropdown-divider"></div><a class="dropdown-item btn-delete text-danger" href="javascript:void(0)" data-id="' . $data->id_pharma . '" data-name="' . $data->name_pharma . '"> Hapus</a>';
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
        ->addColumn('set_country', function ($data) {
          $set_country = $data->country->name_country;
          return $set_country;
        })
        ->rawColumns(['action', 'set_admin', 'set_country'])
        ->addIndexColumn() //increment
        ->make(true);
    }

    $data = [
      'url' => $this->url,
      'title' => 'Data ' . $this->title,
      'page' => $this->page,
      'get_menu' => get_menu_id('pharma'),
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
      'name_pharma' => 'required|string|max:100',
      'country_id' => 'required',
    ];
    $message = [
      'name_pharma.required' => 'Nama farmasi wajib diisi!',
      'name_pharma.max' => 'Nama farmasi max 100 karakter!',
      'country_id.required' => 'Negara wajib dipilih!',
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
    $check_name_pharma = Pharma::where('name_pharma', $request->name_pharma)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else if ($check_name_pharma != null) {
      return response()->json(['status' => false, 'message' => $request->name_pharma . " telah digunakan. Silahkan gunakan nama lain!"], 200);
    } else {
      DB::beginTransaction();
      try {
        $post = new Pharma();

        $post->user_id = Auth::user()->id;

        $post->country_id = $request->country_id;
        $post->name_pharma = $request->name_pharma;
        $post->address_pharma = $request->address_pharma;

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data farmasi berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data farmasi gagal disimpan!"
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
  public function show($id)
  {
    $get_data = Pharma::findOrFail($id);

    $data = [
      'url' => $this->url,
      'title' => $this->title . ' Detail',
      'page' => $this->page,
      'get_data' => $get_data,
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
    $get_data = Pharma::findOrFail($id);

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
    $check_name_pharma = Pharma::where('name_pharma', $request->name_pharma)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else {
      DB::beginTransaction();
      try {
        $post = Pharma::findOrFail($id);

        if ($request->name_pharma != $post->name_pharma) {
          if ($check_name_pharma == null) {
            $post->name_pharma = $request->name_pharma;
          } else {
            return response()->json(['status' => false, 'message' => $request->name_pharma . " telah digunakan. Silahkan gunakan nama lain!"]);
          }
        }

        $post->country_id = $request->country_id;
        $post->address_pharma = $request->address_pharma;

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data farmasi berhasil diperbarui!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data farmasi gagal diperbarui!"
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
    $hapus = Pharma::destroy($id);

    if ($hapus == true) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  public function getPharmaBySelect2(Request $request)
  {
    $search = $request->search;

    if ($search == '') {
      $data = Pharma::orderby('name_pharma', 'ASC')
        ->limit(10)
        ->get();
    } else {
      $data = Pharma::orderby('name_pharma', 'ASC')
        ->where('name_pharma', 'like', '%' . $search . '%')
        ->limit(10)
        ->get();
    }

    $response = array();

    foreach ($data as $item) {
      $response[] = array(
        "id" => $item->id_pharma,
        "text" => $item->name_pharma
      );
    }

    return response()->json($response);
  }
}
