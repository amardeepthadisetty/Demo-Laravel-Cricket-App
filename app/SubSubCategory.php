<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\SubCategory;
use Illuminate\Support\Facades\DB;
use MongoDB\Operation\FindOneAndUpdate;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SubSubCategory extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'sub_sub_categories';

    protected $guarded =[];

     protected $primaryKey = 'id'; // or null
     // public $incrementing = false;
      public function nextid()
    {
        // ref is the counter - change it to whatever you want to increment
        $this->ref = self::getID();
    }

    public function subcategory(){
  	return $this->belongsTo(SubCategory::class, 'sub_category_id');
  }

  public function products(){
  	return $this->hasMany(Product::class, 'subsubcategory_id');
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
            ['sub_sub_categories_primary_key' => 'ref'],
            ['$inc' => ['seq' => 1]],
            ['new' => true, 'upsert' => true, 'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER]
        );
        return $seq->seq;
    }

}
