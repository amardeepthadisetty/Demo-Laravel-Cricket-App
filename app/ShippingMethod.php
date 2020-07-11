<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $connection = 'mysql';
    protected $table = 'shipping_method';

    protected $guarded =[];
}
