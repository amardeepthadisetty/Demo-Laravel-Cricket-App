<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use Illuminate\Support\Facades\DB;
use MongoDB\Operation\FindOneAndUpdate;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserImages extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'user_images';

    protected $guarded =[];

     //protected $primaryKey = 'ref'; // or null
     // public $incrementing = false;
      public function nextid()
    {
        // ref is the counter - change it to whatever you want to increment
        $this->id  = (string) self::getID();
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
            ['user_images_primary_key' => 'ref'],
            ['$inc' => ['seq' => 1]],
            ['new' => true, 'upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
        );
        return $seq->seq;
    }

}
