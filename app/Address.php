<?php

namespace App;

use App\State;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $connection = 'mysql';
    protected $table = 'address';

    protected $guarded =[];

    public function user(){
        $this->belongsTo(User::class);
    }
}
