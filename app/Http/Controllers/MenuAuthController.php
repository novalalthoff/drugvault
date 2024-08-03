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
use App\Models\Menu;
use App\Models\MenuAuth;
use App\Models\Role;

class MenuAuthController extends Controller
{
  private $views = 'pages.menu-auth';
  private $url = '/role';
  private $title = 'Menu Authorization';
  private $page = 'Menu Authorization';

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
  public function index($id)
  {
    $menu_auth = new MenuAuth;
    $get_data = Menu::where('upid_menu', '0')->orderBy('name_menu', 'ASC')->get();
    $role = Role::findOrFail($id);

    $data = [
      'url' => $this->url,
      'title' => 'Configure ' . $this->title,
      'page' => $this->page,
      'menu_auth' => $menu_auth,
      'get_data' => $get_data,
      'role' => $role,
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
      //
    ];
    $message = [
      //
    ];
    return Validator::make($request, $rule, $message);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    //
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
      $post = new MenuAuth();

      foreach ($request->action_menu_auth as $id_menu_auth => $menu_auth) {
        $post = MenuAuth::firstOrNew(['role_id' => $request->role_id, 'menu_id' => $id_menu_auth]);
        $post->role_id = $request->role_id;
        $post->menu_id = $id_menu_auth;
        $post->action_menu_auth = $menu_auth;
        $post->is_active = $request->is_active[$id_menu_auth] ?? '0';
        $simpan = $post->save();
      }

      if ($simpan == true) {
        DB::commit();
        return response()->json([
          'status' => true,
          'message' => "Data authorization berhasil disimpan!"
        ], 200);
      } else {
        return response()->json([
          'status' => false,
          'message' => "Data authorization gagal disimpan!"
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
    //
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
    //
  }
}
