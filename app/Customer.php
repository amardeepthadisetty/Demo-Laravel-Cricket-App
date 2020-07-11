<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use User;

class Customer extends Model
{
    protected $connection = 'mysql';
    protected $table = 'customers';

    protected $guarded =[];
    public function user(){
    	return $this->belongsTo(User::class);
    }
}
