<?php

namespace App;

use Order;
use Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class OrderDetail extends Model
{
    protected $connection = 'mysql';
    protected $table = 'order_details';
    use Notifiable;
    use HybridRelations;

    protected $guarded =[];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'ref');
    }

    /* public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    } */
}
