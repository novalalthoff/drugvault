<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StorageLog extends Model
{
  use Uuid, SoftDeletes, HasFactory;

  protected $table = 'tb_storage';
  protected $primaryKey = 'id_storage';
  public $incrementing = false;

  protected $guarded = ['id_storage'];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
  }

  public function drug()
  {
    return $this->belongsTo(Drug::class, 'drug_id', 'id_drug')->withDefault();
  }
}
