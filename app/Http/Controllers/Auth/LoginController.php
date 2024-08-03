<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

// LIBRARIES
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

// MODELS
use App\Models\User;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  private $url = '/login';
  private $title = 'Welcome to DrugVault !';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  public function index()
  {
    $data = [
      'url'           => $this->url,
      'title'         => $this->title,
    ];

    return view('auth.index', $data);
  }

  public function rules($request)
  {
    $rule = [
      'username' => 'required|string',
      'password' => 'required|string'
    ];
    $pesan = [
      'username.required' => 'Username tidak boleh kosong!',
      'password.required' => 'Password tidak boleh kosong!'
    ];
    return Validator::make($request, $rule, $pesan);
  }

  public function login(Request $request)
  {
    $input = $request->all();
    $validator = $this->rules($input);

    if ($validator->fails()) {
      return response()->json(['status' => false, 'message' => $validator->errors()]);
    } else {
      // $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
      $remember_me  = (!empty($request->remember_me)) ? true : false;

      // Load user from database
      $user = User::where('username', $input['username'])->first();

      if (empty($user)) {
        return response()->json(['status' => false, 'message' => 'Username tidak ditemukan!']);
      } else {
        if ($user && Hash::check($request->password, $user->password)) {
          // if (auth()->attempt(array('username' => $input['username'], 'password' => $input['password']), $check_active)) {
          if ($user->role->is_active == '0') {
            return response()->json(['status' => false, 'message' => 'Role tidak aktif, silahkan hubungi admin kami!']);
          } else if ($user->is_active == '0') {
            return response()->json(['status' => false, 'message' => 'Akun anda tidak aktif, silahkan hubungi admin kami!']);
          } else {
            // return redirect()->route($this->redirectTo);
            Auth::login($user, true);
            return response()->json(['status' => true, 'message' => 'Berhasil Login!'], 200);
          }
        } else {
          return response()->json(['status' => false, 'message' => 'Username atau Password salah!']);
        }
      }

    }
  }

  public function username()
  {
    return 'username';
  }
}
