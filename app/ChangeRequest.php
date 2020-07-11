<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'change_request';

    protected $guarded =[];
}
