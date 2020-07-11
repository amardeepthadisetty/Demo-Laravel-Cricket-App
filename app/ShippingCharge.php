<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    protected $connection = 'mysql';
    protected $table = 'shipping_charges';

    protected $guarded =[];
}
