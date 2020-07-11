<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'payment_type';

    protected $guarded =[];
}
