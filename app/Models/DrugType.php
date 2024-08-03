<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DrugType extends Model
{
  use Uuid, SoftDeletes, HasFactory;

  protected $table = 'ms_drug_type';
  protected $primaryKey = 'id_drug_type';
  public $incrementing = false;

  protected $guarded = ['id_drug_type'];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
  }

  public function drug()
  {
    return $this->hasMany(Drug::class, 'id_drug_type', 'drug_type_id');
  }
}
