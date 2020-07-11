<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'transaction_history';

    protected $guarded =[];
}
