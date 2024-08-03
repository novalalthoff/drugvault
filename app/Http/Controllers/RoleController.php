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
use App\Models\Role;
use App\Models\MenuAuth;

class RoleController extends Controller
{
  private $views = 'pages.role';
  private $url = '/role';
  private $title = 'Role';
  private $page = 'Role';

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
      $datas = Role::orderBy('created_at', 'DESC')->get();

      return DataTables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['code_role']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['name_role']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['set_status']), Str::lower($request->get('search')))) {
                return true;
              }
              return false;
            });
          }
        })
        ->addColumn('action', function ($data) {
          //get module akses
          $id_menu = get_menu_id('role');

          //detail
          $btn_detail = '';
          if (isAccess('detail', $id_menu, Auth::user()->role_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('role.show', $data->id_role) . '"> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->role_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('role.edit', $data->id_role) . '"> Edit</a>';
          }

          //delete
          $btn_delete = '';
          if (isAccess('delete', $id_menu, Auth::user()->role_id)) {
            $btn_delete = '<div class="dropdown-divider"></div><a class="dropdown-item btn-delete text-danger" href="javascript:void(0)" data-id="' . $data->id_role . '" data-name="' . $data->name_role . '"> Hapus</a>';
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
        ->addColumn('menu_auth', function ($data) {
          $menu_auth = '<a href="' . route('role.menu-auth', $data->id_role) . '" class="btn btn-xs btn-block bg-pink text-center font-weight-bold">Hak Akses</a>';
          return $menu_auth;
        })
        ->addColumn('set_status', function ($data) {
          if ($data->is_active == '0') {
            $btn = "danger";
            $status = "Non Aktif";
          } else {
            $btn = "success";
            $status = "Aktif";
          }

          if (Auth::user()->role_id != $data->id_role) {
            $set_status = '<label class="btn btn-xs btn-block btn-outline-' . $btn . ' text-center btn-status" data-id="' . $data->id_role . '" data-name="' . $data->name_role . '">' . $status . '</label>';
          } else {
            $set_status = '<label class="btn btn-xs btn-block btn-outline-dark text-center">' . $status . '</label>';
          }

          return $set_status;
        })
        ->rawColumns(['action', 'menu_auth', 'set_status'])
        ->addIndexColumn() //increment
        ->make(true);
    }

    $data = [
      'url' => $this->url,
      'title' => 'Data ' . $this->title,
      'page' => $this->page,
      'get_menu' => get_menu_id('role'),
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
      'code_role' => 'required|string|max:20',
      'name_role' => 'required|string|max:50',
    ];
    $message = [
      'code_role.required' => 'Kode akses wajib diisi!',
      'code_role.max' => 'Kode akses max 20 karakter!',
      'name_role.required' => 'Nama akses wajib diisi!',
      'name_role.max' => 'Nama akses max 50 karakter!',
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
    $check_code_role = Role::where('code_role', $request->code_role)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else if ($check_code_role != null) {
      return response()->json(['status' => false, 'message' => "Kode Akses " . $request->code_role . " telah digunakan. Silahkan gunakan Kode Akses lain!"], 200);
    } else {
      DB::beginTransaction();
      try {
        $post = new Role();

        $post->code_role = $request->code_role;
        $post->name_role = $request->name_role;

        $request->is_active == '1' ? $post->is_active = '1' : $post->is_active = '0';

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data hak akses berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data hak akses gagal disimpan!"
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
    $get_data = Role::findOrFail($id);

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
    $get_data = Role::findOrFail($id);

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
    $check_code_role = Role::where('code_role', $request->code_role)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else {
      DB::beginTransaction();
      try {
        $post = Role::findOrFail($id);

        if ($request->code_role != $post->code_role) {
          if ($check_code_role == null) {
            $post->code_role = $request->code_role;
          } else {
            return response()->json(['status' => false, 'message' => "Kode Akses " . $request->code_role . " telah digunakan. Silahkan gunakan Kode Akses lain!"]);
          }
        }

        $post->name_role = $request->name_role;

        $request->is_active == '1' ? $post->is_active = '1' : $post->is_active = '0';

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data hak akses berhasil diperbarui!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data hak akses gagal diperbarui!"
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
    $role = Role::findOrFail($id);
    $menu_auth = MenuAuth::where('role_id', $role->id_role)->get();

    if (count($menu_auth) > 0) {
      foreach ($menu_auth as $ma) {
        $ma->delete();
      }
    }

    $hapus = $role->delete();

    if ($hapus == true) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  // Ganti Status
  public function changeStatus($id)
  {
    $set = Role::findOrFail($id);

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

  public function getRoleBySelect2(Request $request)
  {
    $search = $request->search;

    if ($search == '') {
      $data = Role::orderby('name_role', 'ASC')
        ->where('is_active', '1')
        ->limit(10)
        ->get();
    } else {
      $data = Role::orderby('name_role', 'ASC')
        ->where('is_active', '1')
        ->where('code_role', 'like', '%' . $search . '%')
        ->orwhere('name_role', 'like', '%' . $search . '%')
        ->limit(10)
        ->get();
    }

    $response = array();

    foreach ($data as $item) {
      $response[] = array(
        "id" => $item->id_role,
        "text" => $item->name_role
      );
    }

    return response()->json($response);
  }
}
