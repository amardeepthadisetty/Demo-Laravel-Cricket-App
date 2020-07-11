<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mysql';
    protected $table = 'orders';

    protected $guarded =[];

    
    public function orderDetails()
    { 
        return $this->hasMany(OrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* public function pickup_point()
    {
        return $this->belongsTo(PickupPoint::class);
    } */
}