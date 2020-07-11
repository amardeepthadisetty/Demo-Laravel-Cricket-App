<?php

namespace App;

use App\Country;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $connection = 'mysql';
    protected $table = 'states'; 

    protected $guarded =[];

    public function country(){
        $this->belongsTo(Country::class,'id');
    }
}
