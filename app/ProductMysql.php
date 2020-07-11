<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductMysql extends Model
{
    protected $connection = 'mysql';
    protected $table = 'products_sql';

    protected $guarded =[];
}
