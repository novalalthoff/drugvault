<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    $user = Auth::user();
    $role = Role::get();
    $get_role = array();

    foreach ($role as $key => $value) {
      array_push($get_role, $value->id_role);
    }

    if (in_array($user->role_id, $get_role)) {
      return $next($request);
    }

    abort(401);
  }
}
