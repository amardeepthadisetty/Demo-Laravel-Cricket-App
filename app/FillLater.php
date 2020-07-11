<?php

namespace App;

use Order;
use Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class FillLater extends Model
{
    protected $connection = 'mysql';
    protected $table = 'fill_later';
    use Notifiable;
    //use HybridRelations;

    protected $guarded =[];
    
    

    /* public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    } */
}
