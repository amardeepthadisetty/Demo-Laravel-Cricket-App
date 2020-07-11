<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use App\SubCategory;
use Illuminate\Support\Facades\DB;
use MongoDB\Operation\FindOneAndUpdate;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Category extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'categories';
    protected $primaryKey = "id";
    protected $guarded =[];

     //protected $primaryKey = 'ref'; // or null
     // public $incrementing = false;
      public function nextid()
    {
        // ref is the counter - change it to whatever you want to increment
        $this->id = (string) self::getID();
    }

    public static function bootUseAutoIncrementID()
    {
        static::creating(function ($model) {
            $model->sequencial_id = self::getID($model->getTable());
        });
    }
    public function getCasts()
    {
        return $this->casts;
    }

    private static function getID()
    {
        $seq = DB::connection('mongodb')->getCollection('counters')->findOneAndUpdate(
            ['category_primary_key' => 'ref'],
            ['$inc' => ['seq' => 1]],
            ['new' => true, 'upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
        );
        return $seq->seq;
    }

    public function subcategories(){
    	return $this->hasMany(SubCategory::class);
    }

    public function products(){
    	return $this->hasMany(Product::class);
    }

}
