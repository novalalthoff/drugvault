<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use Uuid, SoftDeletes, HasFactory, Notifiable, HasApiTokens;

  protected $table = 'ms_user';
  protected $primaryKey = 'id';
  public $incrementing = false;

  /**
   * The attributes that are unassignable.
   *1
   * @var array<int, string>
   */
  protected $guarded = ['id'];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'sandi',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  // protected $casts = [
  //   'email_verified_at' => 'datetime',
  // ];

  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id', 'id_role')->withDefault();
  }

  public function country()
  {
    return $this->hasMany(Country::class, 'id', 'user_id');
  }

  public function pharma()
  {
    return $this->hasMany(Pharma::class, 'id', 'user_id');
  }

  public function drug_type()
  {
    return $this->hasMany(DrugType::class, 'id', 'user_id');
  }

  public function drug_category()
  {
    return $this->hasMany(DrugCategory::class, 'id', 'user_id');
  }

  public function drug()
  {
    return $this->hasMany(Drug::class, 'id', 'user_id');
  }

  public function storage_log()
  {
    return $this->hasMany(StorageLog::class, 'id', 'user_id');
  }
}
