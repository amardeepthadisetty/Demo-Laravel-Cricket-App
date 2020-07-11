<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    //
    protected $connection = 'mysql';
    protected $table = 'coupon_usages';

    protected $guarded =[];
}
