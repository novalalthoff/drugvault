<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Drug extends Model
{
  use Uuid, SoftDeletes, HasFactory;

  protected $table = 'ms_drug';
  protected $primaryKey = 'id_drug';
  public $incrementing = false;

  protected $guarded = ['id_drug'];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
  }

  public function pharma()
  {
    return $this->belongsTo(Pharma::class, 'pharma_id', 'id_pharma')->withDefault();
  }

  public function drug_type()
  {
    return $this->belongsTo(DrugType::class, 'drug_type_id', 'id_drug_type')->withDefault();
  }

  public function drug_category()
  {
    return $this->belongsTo(DrugCategory::class, 'drug_category_id', 'id_drug_category')->withDefault();
  }

  public function storage_log()
  {
    return $this->hasMany(StorageLog::class, 'id_drug', 'drug_id');
  }
}
