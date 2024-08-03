<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pharma extends Model
{
  use Uuid, SoftDeletes, HasFactory;

  protected $table = 'ms_pharma';
  protected $primaryKey = 'id_pharma';
  public $incrementing = false;

  protected $guarded = ['id_pharma'];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
  }

  public function country()
  {
    return $this->belongsTo(Country::class, 'country_id', 'id_country')->withDefault();
  }
}
