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
use App\Models\Country;

class CountryController extends Controller
{
  private $views = 'pages.country';
  private $url = '/country';
  private $title = 'Country';
  private $page = 'Country';

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
      $datas = Country::orderBy('created_at', 'DESC')->get();

      return DataTables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name_country']), Str::lower($request->get('search')))) {
                return true;
              }
              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_menu = get_menu_id('country');

          //detail
          $btn_detail = '';
          if (isAccess('detail', $id_menu, Auth::user()->role_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('country.show', $data->id_country) . '"> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->role_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('country.edit', $data->id_country) . '"> Edit</a>';
          }

          //delete
          $btn_delete = '';
          if (isAccess('delete', $id_menu, Auth::user()->role_id)) {
            $btn_delete = '<div class="dropdown-divider"></div><a class="dropdown-item btn-delete text-danger" href="javascript:void(0)" data-id="' . $data->id_country . '" data-name="' . $data->name_country . '"> Hapus</a>';
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
        ->rawColumns(['action', 'set_admin'])
        ->addIndexColumn() //increment
        ->make(true);
    }

    $data = [
      'url' => $this->url,
      'title' => 'Data ' . $this->title,
      'page' => $this->page,
      'get_menu' => get_menu_id('country'),
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
      'name_country' => 'required|string|max:100',
    ];
    $message = [
      'name_country.required' => 'Nama Negara wajib diisi!',
      'name_country.max' => 'Nama Negara max 100 karakter!',
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
    $check_name_country = Country::where('name_country', $request->name_country)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else if ($check_name_country != null) {
      return response()->json(['status' => false, 'message' => $request->name_country . " telah digunakan. Silahkan gunakan nama lain!"], 200);
    } else {
      DB::beginTransaction();
      try {
        $post = new Country();

        $post->user_id = Auth::user()->id;

        $post->name_country = $request->name_country;

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data negara berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data negara gagal disimpan!"
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
    $get_data = Country::findOrFail($id);

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
    $get_data = Country::findOrFail($id);

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
    $check_name_country = Country::where('name_country', $request->name_country)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else {
      DB::beginTransaction();
      try {
        $post = Country::findOrFail($id);

        if ($request->name_country != $post->name_country) {
          if ($check_name_country == null) {
            $post->name_country = $request->name_country;
          } else {
            return response()->json(['status' => false, 'message' => $request->name_country . " telah digunakan. Silahkan gunakan nama lain!"]);
          }
        }

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data negara berhasil diperbarui!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data negara gagal diperbarui!"
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
    $hapus = Country::destroy($id);

    if ($hapus == true) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  public function getCountryBySelect2(Request $request)
  {
    $search = $request->search;

    if ($search == '') {
      $data = Country::orderby('name_country', 'ASC')
        ->limit(10)
        ->get();
    } else {
      $data = Country::orderby('name_country', 'ASC')
        ->where('name_country', 'like', '%' . $search . '%')
        ->limit(10)
        ->get();
    }

    $response = array();

    foreach ($data as $item) {
      $response[] = array(
        "id" => $item->id_country,
        "text" => $item->name_country
      );
    }

    return response()->json($response);
  }
}
