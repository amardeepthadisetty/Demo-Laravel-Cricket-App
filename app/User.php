<?php

namespace App;

use App\Seller;
use App\Address;
use App\Product;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'mysql';
    protected $table = 'users';
    use Notifiable;
    use HybridRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


  public function seller()
  {
    return $this->hasOne(Seller::class);
  }

  public function shop()
  {
    return $this->hasOne(Shop::class);
  }
  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public function address()
  {
    return $this->hasMany(Address::class);
  }

  
}
