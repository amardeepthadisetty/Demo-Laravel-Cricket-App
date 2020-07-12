<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'players';

    protected $guarded =[];
}
