<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // 
    protected $connection = 'mysql';
    protected $table = 'comment_system';

    protected $guarded =[];
}
