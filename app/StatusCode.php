<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusCode extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'status_codes';

    protected $guarded =[];
}
