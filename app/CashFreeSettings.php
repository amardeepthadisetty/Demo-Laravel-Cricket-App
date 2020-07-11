<?php

namespace App;

use App\Seller;
use App\Product;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Illuminate\Foundation\Auth\User as Authenticatable;

class CashFreeSettings extends Authenticatable
{
    protected $connection = 'mysql';
    protected $table = 'cashfree_settings';
    use Notifiable;
    use HybridRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
    ];

   

  
}
