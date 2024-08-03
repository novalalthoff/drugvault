<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
  use Uuid, SoftDeletes, HasFactory;

  protected $table = 'ms_country';
  protected $primaryKey = 'id_country';
  public $incrementing = false;

  protected $guarded = ['id_country'];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
  }

  public function pharma()
  {
    return $this->hasMany(Pharma::class, 'id_country', 'country_id');
  }
}
