<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// LIBRARIES
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Rules\MatchOldPassword;

// MODELS
use App\Models\User;

class UserController extends Controller
{
  private $views = 'pages.user';
  private $url = '/user';
  private $title = 'User';
  private $page = 'User';

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
      $datas = User::orderBy('created_at', 'DESC')->get();

      return DataTables::of($datas)
        ->filter(function ($instance) use ($request) {
          if (!empty($request->get('search'))) {
            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
              if (Str::contains(Str::lower($row['name']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['username']), Str::lower($request->get('search')))) {
                return true;
              } else if (Str::contains(Str::lower($row['set_role']), Str::lower($request->get('search')))) {
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
          $id_menu = get_menu_id('user');

          //detail
          $btn_detail = '';
          if (isAccess('detail', $id_menu, Auth::user()->role_id)) {
            $btn_detail = '<a class="dropdown-item" href="' . route('user.show', $data->id) . '"> Detail</a>';
          }

          //edit
          $btn_edit = '';
          if (isAccess('update', $id_menu, Auth::user()->role_id)) {
            $btn_edit = '<a class="dropdown-item" href="' . route('user.edit', $data->id) . '"> Edit</a>';
          }

          //reset passwrod
          $btn_reset = '';
          if (isAccess('reset', $id_menu, Auth::user()->role_id)) {
            $btn_reset = '<a class="dropdown-item btn-reset" href="javascript:void(0)" data-id="' . $data->id . '" data-name="' . $data->name . '"> Reset Password</a>';
          }

          //delete
          $btn_delete = '';
          if (isAccess('delete', $id_menu, Auth::user()->role_id)) {
            $btn_delete = '<div class="dropdown-divider"></div><a class="dropdown-item btn-delete text-danger" href="javascript:void(0)" data-id="' . $data->id . '" data-name="' . $data->name . '"> Hapus</a>';
          }

          return '
              <div class="dropleft text-center">
                <button class="btn btn-sm btn-icon" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-h"></i>
                </button>

                <div class="dropdown-menu m-0">
                  ' . $btn_detail . '
                  ' . $btn_edit . '
                  ' . $btn_reset . '
                  ' . $btn_delete . '
                </div>
              </div>
          ';
        })
        ->addColumn('set_status', function ($data) {
          if ($data->is_active == '0') {
            $btn = "danger";
            $status = "Non Aktif";
          } else {
            $btn = "success";
            $status = "Aktif";
          }

          if (Auth::user()->id != $data->id) {
            $set_status = '<label class="btn btn-xs btn-block btn-outline-' . $btn . ' text-center btn-status" data-id="' . $data->id . '" data-name="' . $data->name . '">' . $status . '</label>';
          } else {
            $set_status = '<label class="btn btn-xs btn-block btn-outline-dark text-center">' . $status . '</label>';
          }

          
          return $set_status;
        })
        ->addColumn('set_role', function ($data) {
          return $data->role->name_role ?? "";
        })
        ->rawColumns(['action', 'set_status', 'set_role'])
        ->addIndexColumn() //increment
        ->make(true);
    }

    $data = [
      'url' => $this->url,
      'title' => 'Data ' . $this->title,
      'page' => $this->page,
      'get_menu' => get_menu_id('user'),
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
      'name' => 'required|string|max:100',
      'username' => 'required|string',
      'role_id' => 'required',
    ];
    $message = [
      'name.required' => 'Nama pengguna wajib diisi!',
      'name.max' => 'Nama pengguna max 100 karakter!',
      'username.required' => 'Username wajib diisi!',
      'role_id.required' => 'Role akses wajib dipilih!',
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
    $check_username = User::where('username', $request->username)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else if ($check_username != null) {
      return response()->json(['status' => false, 'message' => "Username " . $request->username . " telah digunakan. Silahkan gunakan username lain!"], 200);
    } else {
      DB::beginTransaction();
      try {
        $post = new User();

        $post->role_id = $request->role_id;
        $post->name = $request->name;
        $post->username = $request->username;
        $post->password = Hash::make('drugvault');
        $post->sandi = 'drugvault';

        $request->is_active == '1' ? $post->is_active = '1' : $post->is_active = '0';

        if ($request->hasFile('avatar')) {
          $post->avatar = $request->file('avatar')->store('user-avatar', 'public');
          $post->avatar_mimetype = $request->file('avatar')->getMimeType();
          $post->avatar_originalfile = $request->file('avatar')->getClientOriginalName();
          $post->avatar_originalmimetype = $request->file('avatar')->getClientOriginalExtension();
        }

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data pengguna berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data pengguna gagal disimpan!"
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
    $get_data = User::findOrFail($id);

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
    $get_data = User::findOrFail($id);
    $get_menu = get_menu_id('user');

    $data = [
      'url' => $this->url,
      'title' => 'Edit Data ' . $this->title,
      'page' => $this->page,
      'get_data' => $get_data,
      'get_menu' => $get_menu,
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
    $check_username = User::where('username', $request->username)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else {
      DB::beginTransaction();
      try {
        $post = User::findOrFail($id);

        if ($request->username != $post->username) {
          if ($check_username == null) {
            $post->username = $request->username;
          } else {
            return response()->json(['status' => false, 'message' => "Username " . $request->username . " telah digunakan. Silahkan gunakan username lain!"]);
          }
        }

        if (!empty($request->verify_password)) {
          if ($request->verify_status == true) {
            $post->password = Hash::make($request->password);
            $post->sandi = $request->password;
          } else {
            return response()->json(['status' => false, 'message' => "Password tidak cocok!"]);
          }
        }

        $post->role_id = $request->role_id;
        $post->name = $request->name;

        $request->is_active == '1' ? $post->is_active = '1' : $post->is_active = '0';

        if ($request->hasFile('avatar')) {
          if (Storage::disk('public')->exists($post->avatar)) {
            Storage::disk('public')->delete($post->avatar);
          }
          $post->avatar = $request->file('avatar')->store('user-avatar', 'public');
          $post->avatar_mimetype = $request->file('avatar')->getMimeType();
          $post->avatar_originalfile = $request->file('avatar')->getClientOriginalName();
          $post->avatar_originalmimetype = $request->file('avatar')->getClientOriginalExtension();
        }

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data pengguna berhasil diperbarui!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data pengguna gagal diperbarui!"
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
    $user = User::findOrFail($id);

    if (Storage::disk('public')->exists($user->avatar)) {
      Storage::disk('public')->delete($user->avatar);
    }

    $hapus = $user->delete();

    if ($hapus == true) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  // Reset Password
  public function resetPass($id)
  {
    $set = User::findOrFail($id);
    $set->password = Hash::make("drugvault");
    $set->save();

    if ($set == true) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  // Ganti Status
  public function changeStatus($id)
  {
    $set = User::findOrFail($id);

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

  public function getUserBySelect2(Request $request)
  {
    $search = $request->search;

    if ($search == '') {
      $data = User::orderby('name', 'ASC')
        ->where('is_active', '1')
        ->limit(10)
        ->get();
    } else {
      $data = User::orderby('name', 'ASC')
        ->where('is_active', '1')
        ->where('name', 'like', '%' . $search . '%')
        ->orwhere('username', 'like', '%' . $search . '%')
        ->limit(10)
        ->get();
    }

    $response = array();

    foreach ($data as $item) {
      $response[] = array(
        "id" => $item->id,
        "text" => $item->name
      );
    }

    return response()->json($response);
  }
}
