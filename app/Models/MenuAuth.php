<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuAuth extends Model
{
  use Uuid, HasFactory;

  protected $table = 'menu_auth';
  protected $primaryKey = 'id_menu_auth';
  public $incrementing = false;

  protected $guarded = ['id_menu_auth'];

  public function menu()
  {
    return $this->hasOne(Menu::class, 'menu_id', 'id_menu');
  }

  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id', 'id_role')->withDefault();
  }
}
