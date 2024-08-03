<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DrugCategory extends Model
{
  use Uuid, SoftDeletes, HasFactory;

  protected $table = 'ms_drug_category';
  protected $primaryKey = 'id_drug_category';
  public $incrementing = false;

  protected $guarded = ['id_drug_category'];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
  }

  public function drug()
  {
    return $this->hasMany(Drug::class, 'id_drug_category', 'drug_category_id');
  }
}
