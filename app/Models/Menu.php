<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
  use Uuid, SoftDeletes, HasFactory;

  protected $table = 'menu';
  protected $primaryKey = 'id_menu';
  public $incrementing = false;

  protected $guarded = ['id_menu'];

  public function parent_menu()
  {
    return $this->belongsTo(Menu::class, 'upid_menu', 'id_menu')->withDefault();
  }

  public function menus()
  {
    return $this->hasMany(Menu::class, 'upid_menu', 'id_menu');
  }

  public function menu_auth()
  {
    return $this->hasMany(MenuAuth::class, 'id_menu', 'menu_id');
  }
}
