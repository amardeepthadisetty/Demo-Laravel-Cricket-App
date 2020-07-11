<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPayments extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'order_payments';

    protected $guarded =[];
}
