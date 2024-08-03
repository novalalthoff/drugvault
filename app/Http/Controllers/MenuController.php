<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// LIBRARIES
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// MODELS
use App\Models\Menu;
use App\Models\MenuAuth;

class MenuController extends Controller
{
  private $views = 'pages.menu';
  private $url = '/menu';
  private $title = 'Menu';
  private $page = 'Menu';

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
  public function index()
  {
    $get_data = Menu::where('upid_menu', '0')->orderBy('name_menu', 'ASC')->get();

    $data = [
      'url' => $this->url,
      'title' => 'Data ' . $this->title,
      'page' => $this->page,
      'get_data' => $get_data,
      'get_menu' => get_menu_id('menu'),
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
      'code_menu' => 'required|string|max:15',
      'name_menu' => 'required|string|max:100',
      'link_menu' => 'required',
      'icon_menu' => 'max:50',
      'action_menu' => 'required',
    ];
    $message = [
      'code_menu.required' => 'Kode Menu wajib diisi!',
      'code_menu.max' => 'Kode menu max 15 karakter!',
      'name_menu.required' => 'Nama Menu wajib diisi!',
      'name_menu.max' => 'Nama menu max 100 karakter!',
      'link_menu.required' => 'Link Menu wajib diisi!',
      'icon_menu.max' => 'Icon menu max 50 karakter!',
      'action_menu.required' => 'Aksi Menu wajib diisi!',
    ];
    return Validator::make($request, $rule, $message);
  }

  /**
   * Show the form for creating a new resource.
   * @return Renderable
   */
  public function create()
  {
    $menu = Menu::where('upid_menu', '0')->get();

    $data = [
      'url' => $this->url,
      'title' => 'New ' . $this->title,
      'page' => $this->page,
      'menu' => $menu,
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
    $check_code_menu = Menu::where('code_menu', $request->code_menu)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else if ($check_code_menu != null) {
      return response()->json(['status' => false, 'message' => "Kode Menu " . $request->code_menu . " telah digunakan. Silahkan gunakan kode Menu lain!"], 200);
    } else {
      DB::beginTransaction();
      try {
        $post = new Menu();

        $post->upid_menu = $request->upid_menu;
        $post->code_menu = $request->code_menu;
        $post->name_menu = $request->name_menu;
        $post->link_menu = $request->link_menu;
        $post->icon_menu = $request->icon_menu;
        $post->action_menu = $request->action_menu;

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data menu berhasil disimpan!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data menu gagal disimpan!"
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
    $get_data = Menu::findOrFail($id);

    $data = [
      'url' => $this->url,
      'title' => 'Detail ' . $this->title,
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
    $get_data = Menu::findOrFail($id);
    $menu = Menu::where('upid_menu', '0')->get();

    $data = [
      'url' => $this->url,
      'title' => 'Edit ' . $this->title,
      'page' => $this->page,
      'get_data' => $get_data,
      'menu' => $menu,
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
    $check_code_menu = Menu::where('code_menu', $request->code_menu)->first();

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else {
      DB::beginTransaction();
      try {
        $post = Menu::findOrFail($id);

        if ($request->code_menu != $post->code_menu) {
          if ($check_code_menu == null) {
            $post->code_menu = $request->code_menu;
          } else {
            return response()->json(['status' => false, 'message' => "Kode Menu " . $request->code_menu . " telah digunakan. Silahkan gunakan Kode Menu lain!"]);
          }
        }

        $post->upid_menu = $request->upid_menu;
        $post->name_menu = $request->name_menu;
        $post->link_menu = $request->link_menu;
        $post->icon_menu = $request->icon_menu;
        $post->action_menu = $request->action_menu;

        $simpan = $post->save();

        if ($simpan == true) {
          DB::commit();
          return response()->json([
            'status' => true,
            'message' => "Data menu berhasil diperbarui!"
          ], 200);
        } else {
          return response()->json([
            'status' => false,
            'message' => "Data menu gagal diperbarui!"
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
    $parent_menu = Menu::findOrFail($id);

    if (count($parent_menu->menus) > 0) {
      foreach ($parent_menu->menus as $submenu) {
        $menu_auth = MenuAuth::where('menu_id', $submenu->id_menu)->get();
        if (count($menu_auth) > 0) {
          foreach ($menu_auth as $ma) {
            $ma->delete();
          }
        }
        $submenu->delete();
      }
    }

    $menu_auth = MenuAuth::where('menu_id', $parent_menu->id_menu)->get();
    if (count($menu_auth) > 0) {
      foreach ($menu_auth as $ma) {
        $ma->delete();
      }
    }

    $hapus = $parent_menu->delete();

    if ($hapus == true) {
      return response()->json(['status' => true]);
    } else {
      return response()->json(['status' => false]);
    }
  }

  // Sort Menu
  public function sort()
  {
    // $sortData = array();
    $sort = 1;
    foreach (request('main') as $key => $main) {
      if (is_array($main)) {
        $no = 1;
        foreach ($main as $a => $b) {
          $sortData[$b]['parent'] = $key;
          $sortData[$b]['sort'] = $no;
          $no++;
        }
      } else {
        // echo $main."<br>";
        $sortData[$main]['parent'] = "0";
        $sortData[$main]['sort'] = $sort;
        $sort++;
      }
    }

    foreach ($sortData as $id => $data) {
      $id = str_replace("mdl-", "", $id);
      $parent = str_replace("mdl-", "", $data['parent']);

      $set = Menu::find($id);
      $set->upid_menu = $parent;
      $set->save();
    }
  }
}
