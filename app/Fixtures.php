<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fixtures extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'fixtures';

    protected $guarded =[];
}
