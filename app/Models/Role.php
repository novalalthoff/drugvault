<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
  use Uuid, SoftDeletes, HasFactory;

  protected $table = 'ms_role';
  protected $primaryKey = 'id_role';
  public $incrementing = false;

  protected $guarded = ['id_role'];

  public function user()
  {
    return $this->hasMany(User::class, 'id_role', 'role_id');
  }

  public function menu_auth()
  {
    return $this->hasMany(MenuAuth::class, 'id_role', 'role_id');
  }
}
