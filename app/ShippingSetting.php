<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingSetting extends Model
{
    protected $connection = 'mysql';
    protected $table = 'shipping_settings';

    protected $guarded =[];
}
