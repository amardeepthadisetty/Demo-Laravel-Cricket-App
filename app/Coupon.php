<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'coupons';

    protected $guarded =[];
}
