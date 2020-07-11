<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Imports\ProductsImport;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\Product;
use App\ProductMysql;

class ExcelImportController extends Controller
{
    //

    public function index(){

    	return view('import.importexcel');
    }

    public function categoryObj($request){

        $category_obj = array();

        $categories = Category::where('slug', $request['category_slug'])->firstorfail();


        $category_obj['category_info']['category']['category_id'] = $categories->id ;
        $category_obj['category_info']['category']['name'] = $categories->name ;
        $category_obj['category_info']['category']['slug'] = $categories->slug ;



        $sub_categories = SubCategory::where('slug', $request['sub_category_slug'])->firstorfail();


        $category_obj['category_info']['sub_category']['sub_category_id'] = $sub_categories->id;
        $category_obj['category_info']['sub_category']['name'] = $sub_categories->name;
        $category_obj['category_info']['sub_category']['category_id'] = $categories->id ;
        $category_obj['category_info']['sub_category']['slug'] = $sub_categories->slug ;
        
        //echo "<Br>";
        //print_r($category_obj);die;

        $subsub_categories = SubSubCategory::where('slug', $request['sub_sub_category_slug'])->firstorfail();
        

        $category_obj['category_info']['sub_sub_category']['sub_sub_category_id'] = $subsub_categories->id;
        $category_obj['category_info']['sub_sub_category']['sub_category_id'] = $sub_categories->id;
        $category_obj['category_info']['sub_sub_category']['name'] = $subsub_categories->name;
       
        $category_obj['category_info']['sub_sub_category']['slug'] = $subsub_categories->slug ;

        //print_r($categories->name);



       /* echo "<pre>category info array is: ";
        print_r($category_obj);
        echo "</pre>";
        die;*/

        return $category_obj;

    }

    public function store(Request $request){

    	// $path = $request->file('select_file')->getRealPath();

    	 //echo "<br>path is: ".$path."<br>";
    	 echo "<pre>";
    	   $skus = array();
    	  if($request->hasFile('select_file')){
            $collection = (new ProductsImport)->toArray(request()->file('select_file'))[0];
            $mainArray = array();
            
            foreach ($collection as $c) {
            	
            	//print_r($c);
            	if ($c['slug']!='') {
            		$mainArray[$c['slug']]['slug']  = $c['slug'];

            		if ($c['product_name']!='') {
            			$mainArray[$c['slug']]['name']  = $c['product_name'];
            		}

                    if (trim($c['product_type'])!='') {
                        $mainArray[$c['slug']]['product_type']  = $c['product_type'];
                    }

                    if (trim($c['is_variant'])!='') {
                        $mainArray[$c['slug']]['is_variant']  = (string) $c['is_variant'];
                    }

                     if (trim($c['is_template'])!='') {
                        $mainArray[$c['slug']]['is_template']  = (string) $c['is_template'];
                    }

            		//if (trim($c['added_by'])!='') {
            			$mainArray[$c['slug']]['added_by']  = 'admin';
            		//}

            		$mainArray[$c['slug']]['user_id']  = '1';

                    if ($c['category_ids']!='') {

                        if ( trim(  $c['category_ids'] ) ) {
                            $mainArray[$c['slug']]['categories'][] = ( string ) $c['category_ids'];
                        }
                        
                    }

                    //current stock
                    //if (trim($c['current_stock'])!='') {
                        //echo "<br>inside<br>";
                        $current_stock = '10000';
                        $mainArray[$c['slug']]['current_stock'] = (string) $current_stock;
                    //}


                    //photos
                    if (trim($c['photos'])!='') {
                        
                        //echo "<br> end of resize<Br>";
                        //die;
                        $mainArray[$c['slug']]['photos'][] = $this->resizeMainImages( $c['photos'] );
                    }

                    //thumbnail_img
                    //if (trim($c['thumbnail_img'])!='') {
                        $c['thumbnail_img'] ='';
                        $mainArray[$c['slug']]['thumbnail_img'] = $c['thumbnail_img'];
                    //}

                    //featured_img
                    //if (trim($c['featured_img'])!='') {
                        //echo "<br> featured img is: ".$c['featured_img']."<br>";die;
                         $c['featured_img'] ='';
                         $mainArray[$c['slug']]['featured_img'] = $c['featured_img'];
                   // }

                    //flash_deal_img
                    //if (trim($c['flash_deal_img'])!='') {
                         $c['flash_deal_img'] = '';
                         $mainArray[$c['slug']]['flash_deal_img'] = $c['flash_deal_img'];
                    //}

                    //kg
                    if (trim($c['unit'])!='') {
                         $mainArray[$c['slug']]['unit'] = $c['unit'];
                    }

                    //tags
                    if (trim($c['tags'])!='') {
                         $mainArray[$c['slug']]['tags'] = $c['tags'];
                    }

                    //description
                    if (trim($c['description'])!='') {
                         $mainArray[$c['slug']]['description'] = $c['description'];
                    }

                    //unit_price
                     if (trim($c['unit_price'])!='') {
                         $mainArray[$c['slug']]['unit_price'] = (string) $c['unit_price'];
                    }

                    //purchase_price
                     //if (trim($c['purchase_price'])!='') {
                        $c['purchase_price'] = '0';
                         $mainArray[$c['slug']]['purchase_price'] = (string) $c['purchase_price'];
                    //}


                    //tax
                    if (trim($c['tax'])!='') {
                         $mainArray[$c['slug']]['tax'] = (string) $c['tax'];
                    }

                    //tax_type
                    if (trim($c['tax_type'])!='') {
                         $mainArray[$c['slug']]['tax_type'] = $c['tax_type'];
                    }


                    //discount
                    //if (trim($c['discount'])!='') {
                        $c['discount'] = '0';
                         $mainArray[$c['slug']]['discount'] = (string) $c['discount'];
                    //}

                     //discount_type
                    //if (trim($c['discount_type'])!='') {
                         $c['discount_type'] = '0';
                         $mainArray[$c['slug']]['discount_type'] = $c['discount_type'];
                    //}


                      //shipping_type
                    if (trim($c['flat_rate'])!='') {
                         $mainArray[$c['slug']]['flat_rate'] = $c['flat_rate'];
                    }

                    //shipping_cost
                    if (trim($c['shipping_cost'])!='') {
                         $mainArray[$c['slug']]['shipping_cost'] = (string) $c['shipping_cost'];
                    }


                     //meta_title
                    if (trim($c['meta_title'])!='') {
                         $mainArray[$c['slug']]['meta_title'] = $c['meta_title'];
                    }


                      //meta_description
                    if (trim($c['meta_description'])!='') {
                         $mainArray[$c['slug']]['meta_description'] = $c['meta_description'];
                    }

                    

                    //meta_img
                    if (trim($c['meta_img'])!='') {
                         $mainArray[$c['slug']]['meta_img'] = $c['meta_img'];
                    }

                    //pdf
                    /*if (trim($c['pdf'])!='') {
                         $mainArray[$c['slug']]['pdf'] = $c['pdf'];
                    }*/

                    //todays_deal
                    if (trim($c['todays_deal'])!='') {
                         $mainArray[$c['slug']]['todays_deal'] = (string) $c['todays_deal'];
                    }

                    //published
                    if (trim($c['published'])!='') {
                         $mainArray[$c['slug']]['published'] = (string) $c['published'];
                    } 

                    //featured
                    if (trim($c['featured'])!='') {
                         $mainArray[$c['slug']]['featured'] = (string) $c['featured'];
                    }

                    //model
                    if (trim($c['model'])!='') {
                         $mainArray[$c['slug']]['model'] = $c['model'];
                    }

                    //small_description
                    if (trim($c['small_description'])!='') {
                         $mainArray[$c['slug']]['small_description'] = $c['small_description'];
                    }

                    //upload_settings_is_upload
                    if (trim($c['upload_settings_is_upload'])!='') {
                         $mainArray[$c['slug']]['more_settings']['upload_settings']['is_upload'] = (string) $c['upload_settings_is_upload'];

                         //upload_limit
                         $mainArray[$c['slug']]['more_settings']['upload_settings']['upload_limit'] = (string) $c['upload_limit'];

                         //instructions
                         $mainArray[$c['slug']]['more_settings']['instructions'] = (string) $c['instructions'];

                        //is_promotion
                        $mainArray[$c['slug']]['more_settings']['promotion_settings']['is_promotion'] = (string) $c['is_promotion'];

                        //promotion_text
                        $mainArray[$c['slug']]['more_settings']['promotion_settings']['promotion_text'] = $c['promotion_text'];

                        

                        //promotion_discount
                        $mainArray[$c['slug']]['more_settings']['promotion_settings']['promotion_discount'] = (string) $c['promotion_discount'];
                    }



                    //choice_options
                    if (trim($c['choice_options_name'])!='') {
                        $mainArray[$c['slug']]['choice_options'][$c['choice_options_name'].'-'.$c['choice_options_title']]['name'] = $c['choice_options_name'];

                        $mainArray[$c['slug']]['choice_options'][$c['choice_options_name'].'-'.$c['choice_options_title']]['title'] = $c['choice_options_title'];

                        $mainArray[$c['slug']]['choice_options'][$c['choice_options_name'].'-'.$c['choice_options_title']]['options'][] = $c['choice_options_options'];
                    }

                    //variations name
                    if (trim($c['variations_name'])!='') {
                       $variations_name = strtolower($c['variations_name']);
                       $mainArray[$c['slug']]['variations'][$variations_name]['price'] = (string) $c['variations_price'];
                       
                       
                       $mainArray[$c['slug']]['variations'][$variations_name]['sku'] = $c['variations_sku'];
                       
                      
                       $mainArray[$c['slug']]['variations'][$variations_name]['qty'] = (string) $c['variations_qty'];
                       
                       $mainArray[$c['slug']]['variations'][$variations_name]['weight'] = (string) $c['variations_weight'];
                    }


                    //additional options
                    if (trim($c['additional_options_name'])!='') {
                        $mainArray[$c['slug']]['additional_options'][$c['additional_options_name'].'-'.$c['additional_options_title'].'-'.$c['additional_options_option_type']]['name'] = $c['additional_options_name'];

                         $mainArray[$c['slug']]['additional_options'][$c['additional_options_name'].'-'.$c['additional_options_title'].'-'.$c['additional_options_option_type']]['title'] = $c['additional_options_title'];
                         

                         $mainArray[$c['slug']]['additional_options'][$c['additional_options_name'].'-'.$c['additional_options_title'].'-'.$c['additional_options_option_type']]['option_type'] = $c['additional_options_option_type'];
                         

                         $mainArray[$c['slug']]['additional_options'][$c['additional_options_name'].'-'.$c['additional_options_title'].'-'.$c['additional_options_option_type']]['options'][] = ($c['additional_options_options']!='') ? $c['additional_options_options'] : '';
                    }


                    //additional option variations
                    if (trim($c['additional_options_mapping_title'])!='') {
                        $mainArray[$c['slug']]['additional_options_variations'][$c['additional_options_mapping_title']]['default'] = $c['additional_options_mapping_default_name'];
                        
                        $mainArray[$c['slug']]['additional_options_variations'][$c['additional_options_mapping_title']]['price'] = (string) $c['additional_options_mapping_price'];
                        

                        $mainArray[$c['slug']]['additional_options_variations'][$c['additional_options_mapping_title']]['sort'] = (string) $c['additional_options_mapping_sort'];
                    }



                    //check if product slug exists or not
                    //if slug not exists, insert
                    //else update the mainArray
                     
                    if ( Product::where('slug','=', trim($c['slug']))->count() > 0) {
                       
                       $product = Product::where('slug', $c['slug'])->firstorfail();
                       $product = $this->mapToProduct($product, $mainArray, $c, "false");
                       
                       //choice options are 
                       if ( !empty( $mainArray[$c['slug']]['choice_options'] ) ) {
                           $choice_options = array();
                           foreach ($mainArray[$c['slug']]['choice_options'] as $key => $value) {
                              //echo "<br>key is: ".$key."<br>";
                              $choice_options[] = $value;
                           }

                           
                           $product->choice_options = $choice_options;
                       }

                       //additional options are
                       if ( !empty( $mainArray[$c['slug']]['additional_options'] ) ) {
                           $additional_options = array();
                           foreach ($mainArray[$c['slug']]['additional_options'] as $key => $value) {
                            $additional_options[] = $value;
                           }
                           $product->additional_options = $additional_options;
                       }else{
                            $product->additional_options = [];
                       }
                       
                       $product->colors = [];
                       $product->save();


                        $p = ProductMysql::where('obj_id', $product->_id)->firstorfail();
                        $p->obj_id=$product->_id;
                        $p->products_dump=json_encode(Product::findOrFail($p->obj_id));
                        $p->save();

                        if( !in_array($c['slug'],$skus)){
                            //new values
                            array_push($skus,$c['slug']);
                            echo "<br>Updated : ". $c['slug']."<br>";
                        }else{
                            //already inserted

                        } 


                    }else{
                        echo "<br>Inserted new product  : ". $c['slug']."<br>";
                        $product = new Product;
                        $product = $this->mapToProduct($product, $mainArray, $c, "true");
                        $product->save();


                        $p = new ProductMysql;
                        $complete_product = Product::where('slug', $product->slug)->firstorfail();
                        $p->obj_id=$complete_product->_id;
                        $p->products_dump=json_encode($complete_product);
                        $p->save();
                    }

                    
            		 
            		
            	}
            	
            	
            }

            //echo "<br><br><br>";
            //print_r($mainArray);

        }

      //  print_r($rows);

    
    	//echo "All done<br>";die;
    }

    public function mapToProduct($product, $mainArray, $c, $new_product){

            if ( !empty( $mainArray[$c['slug']]['name'] )  ) {
               $product->name = $mainArray[$c['slug']]['name'];
            }else{
                echo "<br> Product name seems to be missing for your slug: ".$c['slug']."<br>";
            }
            
            $product->product_type = $mainArray[$c['slug']]['product_type'];
            $product->is_variant = $mainArray[$c['slug']]['is_variant'];
            $product->is_template = $mainArray[$c['slug']]['is_template'];
            //$c['slug'] = strtolower($c['slug']);
            $product->slug = $c['slug'];
            if ($new_product=="true") {
                $product->nextid();
            }

            $product->added_by = $mainArray[$c['slug']]['added_by'];
            $product->user_id = $mainArray[$c['slug']]['user_id'];
            //$product->category_info = $mainArray[$c['slug']]['category_info'];
           /* $product->category_id = $mainArray[$c['slug']]['category_id'];
            $product->subcategory_id = $mainArray[$c['slug']]['subcategory_id'];
            $product->subsubcategory_id = $mainArray[$c['slug']]['subsubcategory_id'];
            $product->brand_id = '1';*/
            
            $product->current_stock = $mainArray[$c['slug']]['current_stock'];
           
            //die;
            $product->categories = $mainArray[$c['slug']]['categories'];
            $product->photos = $mainArray[$c['slug']]['photos'];
            //$product->thumbnail_img = $mainArray[$c['slug']]['thumbnail_img'];
            //$product->featured_img = $mainArray[$c['slug']]['featured_img'];
            //$product->flash_deal_img = $mainArray[$c['slug']]['flash_deal_img'];
            $product->unit = $mainArray[$c['slug']]['unit'];
            $product->tags =  !empty ( $mainArray[$c['slug']]['tags'] ) ? $mainArray[$c['slug']]['tags'] : '';
            $product->description = $mainArray[$c['slug']]['description'];
            $product->unit_price = $mainArray[$c['slug']]['unit_price'];
            $product->purchase_price = $mainArray[$c['slug']]['purchase_price'];
            $product->tax = $mainArray[$c['slug']]['tax'];
            $product->tax_type = $mainArray[$c['slug']]['tax_type'];
            $product->discount = $mainArray[$c['slug']]['discount'];
            $product->discount_type = $mainArray[$c['slug']]['discount_type'];
            $product->shipping_type = $mainArray[$c['slug']]['shipping_type'];
            $product->shipping_cost = $mainArray[$c['slug']]['shipping_cost'];
            $product->meta_title = $mainArray[$c['slug']]['meta_title'];
            $product->meta_description = !empty( $mainArray[$c['slug']]['meta_description'] ) ? $mainArray[$c['slug']]['meta_description'] : '';
            $product->meta_img = $mainArray[$c['slug']]['meta_img'];
            $product->pdf = $mainArray[$c['slug']]['pdf'];
            $product->todays_deal = $mainArray[$c['slug']]['todays_deal'];
            $product->published = $mainArray[$c['slug']]['published'];
            $product->featured = $mainArray[$c['slug']]['featured'];
            $product->model = $mainArray[$c['slug']]['model'];
            $product->small_description = $mainArray[$c['slug']]['small_description'];
            
            $product->more_settings = $mainArray[$c['slug']]['more_settings'];
            $product->more_settings = $mainArray[$c['slug']]['more_settings'];
            $product->variations = !empty( $mainArray[$c['slug']]['variations'] ) ? $mainArray[$c['slug']]['variations'] : '' ;
            $product->additional_options_variations = !empty( $mainArray[$c['slug']]['additional_options_variations']  ) ? $mainArray[$c['slug']]['additional_options_variations']: '' ;

            return $product;
    }

    public function resizeMainImages($pics){
       // echo "<br>";
        //print_r($pics);
        $chunk_urls = ( explode('/',$pics) );
        $imageName = end( $chunk_urls );

        if ( $this->fileExists( public_path('uploads/tmp_images/'.$imageName ) ) ) {
            //echo "<br>IMage name is: ".$imageName."<br>";
            //echo public_path('uploads/tmp_images/'.$imageName)."<br>";

            //If file doesn't exists, then generate thumbnail and icon images. If already exists, just ignore generation of images
            if ( !$this->fileExists( public_path('uploads/products/photos/thumbnail/'.$imageName) ) ) {

                //for thumbnail
                generateThumbnails( public_path('uploads/tmp_images/'.$imageName) , public_path('uploads/products/photos/thumbnail'), $imageName, 'thumbnail'  );
                //for icon
                generateThumbnails( public_path('uploads/tmp_images/'.$imageName) , public_path('uploads/products/photos/icon'), $imageName, 'icon'  );

                $pathToSave = 'uploads/products/photos/original/';
                $imagefolderpath = $pathToSave.$imageName  ;
                //$path = $photo->move(public_path( $pathToSave ), $imageName);

                if ( copy( public_path('uploads/tmp_images/'.$imageName), public_path('uploads/products/photos/original/'. $imageName) ) )
                {
                    //echo "copied...";
                    echo "         Images generated and copied to respective folders: ".$imageName."<br>";
                    //unlink( public_path('uploads/tmp_images/'.$imageName) );
                }

            }

            
        }
        

        $originalImage = 'uploads/products/photos/original/'. $imageName;

        return $originalImage;

        //echo "<br>";

    }

    public function fileExists($filePath)
    {
          return is_file($filePath) && file_exists($filePath);
    }
}
