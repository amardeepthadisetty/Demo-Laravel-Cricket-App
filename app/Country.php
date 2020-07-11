<?php

namespace App;

use App\State;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $connection = 'mysql';
    protected $table = 'countries';

    protected $guarded =[];

    public function state()
    {
        return $this->hasMany(State::class, 'country_id', 'id');
    }
}
