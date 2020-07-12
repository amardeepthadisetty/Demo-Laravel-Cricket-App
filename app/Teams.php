<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teams extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'teams';

    protected $guarded =[];
}
