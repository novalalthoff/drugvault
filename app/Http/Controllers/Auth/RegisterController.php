<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

// LIBRARIES
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// MODELS
use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\MenuAuth;

class RegisterController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\Models\User
   */
  protected function create(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);
  }

  // public function forceStoreRole()
  // {
  //   DB::beginTransaction();
  //   try {
  //     $post = new Role();

  //     $post->code_role = 'ADM';
  //     $post->name_role = 'Admin';
  //     $post->is_active = '1';

  //     $simpan = $post->save();

  //     if ($simpan == true) {
  //       DB::commit();
  //       return response()->json([
  //         'status' => true,
  //         'pesan' => "Data berhasil disimpan!"
  //       ], 200);
  //     } else {
  //       return response()->json([
  //         'status' => false,
  //         'pesan' => "Data tidak berhasil disimpan!"
  //       ], 200);
  //     }
  //   } catch (\Exception $e) {
  //     DB::rollback();
  //     return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
  //   }
  // }

  // public function forceStoreUser()
  // {
  //   DB::beginTransaction();
  //   try {
  //     $role = Role::where('code_role', 'ADM')->first();
  //     $post = new User();

  //     $post->role_id = $role->id_role;
  //     $post->name = 'DrugVault Dev';
  //     $post->username = 'drugvault-dev';
  //     $post->password = Hash::make('drugvault');
  //     $post->sandi = 'drugvault';
  //     $post->is_active = '1';

  //     $simpan = $post->save();

  //     if ($simpan == true) {
  //       DB::commit();
  //       return response()->json([
  //         'status' => true,
  //         'pesan' => "Data berhasil disimpan!"
  //       ], 200);
  //     } else {
  //       return response()->json([
  //         'status' => false,
  //         'pesan' => "Data tidak berhasil disimpan!"
  //       ], 200);
  //     }
  //   } catch (\Exception $e) {
  //     DB::rollback();
  //     return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
  //   }
  // }

  // public function forceStoreMenu()
  // {
  //   DB::beginTransaction();
  //   try {
  //     $master_menu = Menu::where('code_menu', 'USM')->first();
  //     $post = new Menu();

  //     // $post->upid_menu = $master_menu->id_menu;
  //     $post->upid_menu = '0';

  //     $post->code_menu = 'MM';
  //     $post->name_menu = 'Master Menu';
  //     $post->link_menu = 'menu';
  //     $post->icon_menu = 'fas fa-list-alt';

  //     $post->action_menu = 'create,read,update,delete,detail,list';
  //     //$post->action_menu = 'create,read,update,delete,detail,list,privilege';
  //     // $post->action_menu = 'read,list';

  //     $simpan = $post->save();

  //     if ($simpan == true) {
  //       DB::commit();
  //       return response()->json([
  //         'status' => true,
  //         'pesan' => "Data berhasil disimpan!"
  //       ], 200);
  //     } else {
  //       return response()->json([
  //         'status' => false,
  //         'pesan' => "Data tidak berhasil disimpan!"
  //       ], 200);
  //     }
  //   } catch (\Exception $e) {
  //     DB::rollback();
  //     return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
  //   }
  // }

  public function forceStoreMenuAuth()
  {
    DB::beginTransaction();
    try {
      $role = Role::where('code_role', 'ADM')->first();
      $menu = Menu::where('code_menu', 'MM')->first();
      $post = new MenuAuth();

      $post->role_id = $role->id_role;
      $post->menu_id = $menu->id_menu;
      $post->action_menu_auth = 'create,read,update,delete,detail,list';
      // $post->action_menu_auth = 'create,read,update,delete,detail,list,privilege';
      // $post->action_menu_auth = 'read,list';
      $post->is_active = '1';

      $simpan = $post->save();

      if ($simpan == true) {
        DB::commit();
        return response()->json([
          'status' => true,
          'pesan' => "Data berhasil disimpan!"
        ], 200);
      } else {
        return response()->json([
          'status' => false,
          'pesan' => "Data tidak berhasil disimpan!"
        ], 200);
      }
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(['status' => false, 'pesan' => $e->getMessage()], 200);
    }
  }
}
