<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocalPickup extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'localpickup_addresses';

    protected $guarded =[];
}
