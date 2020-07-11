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
use App\Template as TC;

class TemplatesImportController extends Controller
{
     protected $finalObject = array();
    //

    public function index(){

    	return view('import.templatesimportexcel');
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

            		if ($c['template_name']!='') {
            			$mainArray[$c['slug']]['name']  = $c['template_name'];
            		}

                    if (trim($c['template_type'])!='') {
                        $mainArray[$c['slug']]['template_type']  = $c['template_type'];
                    }

                    

            		//if (trim($c['added_by'])!='') {
            			$mainArray[$c['slug']]['added_by']  = 'admin';
            		//}

            		$mainArray[$c['slug']]['user_id']  = '1';

                    if ($c['category_ids']!='') {

                        $mainArray[$c['slug']]['categories'][] = ( string ) $c['category_ids'];
                    }

                    if ($c['product_ids']!='') {

                        $mainArray[$c['slug']]['products'][] = ( string ) $c['product_ids'];
                    }

                  

                     //photos
                    if (trim($c['product_images'])!='') {
                        
                        //echo "<br> end of resize<Br>";
                        //die;
                        $mainArray[$c['slug']]['product_images'] = $this->resizeProductMainImages( $c['product_ids'], $c['product_images'] );
                        //$mainArray[$c['slug']]['product_images'] = array();

                        //array_push( $mainArray[$c['slug']]['product_images'] , $this->resizeProductMainImages( $c['product_ids'], $c['product_images'] ) ) ;
                    }

                    //photos
                    if (trim($c['photos'])!='') {
                        
                        //echo "<br> end of resize<Br>";
                        //die;
                        $mainArray[$c['slug']]['photos'][] = $this->resizeTemplateMainImages( $c['photos'] );
                    }

                    

                    //base price is going to be added to product variant price
                    if (trim($c['base_price'])!='') {
                         $mainArray[$c['slug']]['base_price'] = $c['base_price'];
                    }

                    //base price is going to be added to product variant price
                    if (trim($c['display_price'])!='') {
                         $mainArray[$c['slug']]['display_price'] = $c['display_price'];
                    }

                    //tags
                    if (trim($c['tags'])!='') {
                         $mainArray[$c['slug']]['tags'] = $c['tags'];
                    }

                    //description
                    if (trim($c['description'])!='') {
                         $mainArray[$c['slug']]['description'] = $c['description'];
                    }

                    //small_description
                     if (trim($c['small_description'])!='') {
                         $mainArray[$c['slug']]['small_description'] = $c['small_description'];
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

                    

                    //todays_deal
                    if (trim($c['todays_deal'])!='') {
                         $mainArray[$c['slug']]['todays_deal'] = $c['todays_deal'];
                    }

                    //published
                    if (trim($c['published'])!='') {
                         $mainArray[$c['slug']]['published'] = $c['published'];
                    } 

                    //featured
                    if (trim($c['featured'])!='') {
                         $mainArray[$c['slug']]['featured'] = $c['featured'];
                    }

                    //model
                    if (trim($c['model'])!='') {
                         $mainArray[$c['slug']]['model'] = $c['model'];
                    }

                    //upload_settings_is_upload
                    if (trim($c['upload_settings_is_upload'])!='') {
                         $mainArray[$c['slug']]['more_settings']['upload_settings']['is_upload'] = (string) $c['upload_settings_is_upload'];

                         //upload_limit
                         $mainArray[$c['slug']]['more_settings']['upload_settings']['upload_limit'] = (string) $c['upload_limit'];

                        
                    }


                    //additional options
                    if (trim($c['additional_options_name'])!='') {
                        $mainArray[$c['slug']]['additional_options'][$c['additional_options_name'].'-'.strtolower( $c['additional_options_title'] ).'-'.$c['additional_options_option_type']]['name'] = $c['additional_options_name'];

                         $mainArray[$c['slug']]['additional_options'][$c['additional_options_name'].'-'.strtolower( $c['additional_options_title'] ).'-'.$c['additional_options_option_type']]['title'] =  $c['additional_options_title'];
                         

                         $mainArray[$c['slug']]['additional_options'][$c['additional_options_name'].'-'.strtolower( $c['additional_options_title'] ).'-'.$c['additional_options_option_type']]['option_type'] = $c['additional_options_option_type'];
                         

                         $mainArray[$c['slug']]['additional_options'][$c['additional_options_name'].'-'.strtolower( $c['additional_options_title'] ).'-'.$c['additional_options_option_type']]['options'][] = ($c['additional_options_options']!='') ? $c['additional_options_options'] : '';
                    }


                    //additional option variations
                    if (trim($c['additional_options_mapping_title'])!='') {
                        $mainArray[$c['slug']]['additional_options_variations'][$c['additional_options_mapping_title']]['default'] = $c['additional_options_mapping_default_name'];
                        
                        $mainArray[$c['slug']]['additional_options_variations'][$c['additional_options_mapping_title']]['price'] = (string) $c['additional_options_mapping_price'];
                        

                        $mainArray[$c['slug']]['additional_options_variations'][$c['additional_options_mapping_title']]['sort'] = (string) $c['additional_options_mapping_sort'];
                    }



                    //check if template slug exists or not
                    //if slug not exists, insert
                    //else update the mainArray
                    if ( TC::where('slug','=', trim($c['slug']))->count() > 0) {
                       
                           $template = TC::where('slug', $c['slug'])->firstorfail();
                           $template = $this->mapToProduct($template, $mainArray, $c, "false");
                           
                           

                           //additional options are
                           if ($mainArray[$c['slug']]['additional_options']) {
                               $additional_options = array();
                               foreach ($mainArray[$c['slug']]['additional_options'] as $key => $value) {
                                $additional_options[] = $value;
                               }
                               $template->additional_options = $additional_options;
                           }
                           
                          
                           $template->save();


                            //$p = templateMysql::where('obj_id', $product->_id)->firstorfail();
                           // $p->obj_id=$product->_id;
                            //$p->products_dump=json_encode(Product::findOrFail($p->obj_id));
                            //$p->save();

                            if( !in_array($c['slug'],$skus)){
                                //new values
                                array_push($skus,$c['slug']);
                                echo "<br>Updated : ". $c['slug']."<br>";
                            }else{
                                //already inserted

                            } 


                        }else{
                            echo "<br>Inserted new Template  : ". $c['slug']."<br>";
                            $template = new TC;
                            $template = $this->mapToProduct($template, $mainArray, $c, "true");
                            $template->save();
                           
                        }
                     
                    

                    
            		 
            		
            	}
            	
            	
            }

            //echo "<br><br><br>";
            print_r($mainArray);

        }

      //  print_r($rows);

    
    	//echo "All done<br>";die;
    }

    public function mapToProduct($template, $mainArray, $c, $new_product){
            $template->name = $mainArray[$c['slug']]['name'];
            $template->template_type = $mainArray[$c['slug']]['template_type'];
            //$template->is_variant = $mainArray[$c['slug']]['is_variant'];
            //$template->is_template = $mainArray[$c['slug']]['is_template'];
            $template->slug = $c['slug'];
            if ($new_product=="true") {
                $template->nextid();
            }

            $template->added_by = $mainArray[$c['slug']]['added_by'];
            $template->user_id = $mainArray[$c['slug']]['user_id'];
            //$template->category_info = $mainArray[$c['slug']]['category_info'];
           /* $template->category_id = $mainArray[$c['slug']]['category_id'];
            $template->subcategory_id = $mainArray[$c['slug']]['subcategory_id'];
            $template->subsubcategory_id = $mainArray[$c['slug']]['subsubcategory_id'];
            $template->brand_id = '1';*/
            
            //$template->current_stock = $mainArray[$c['slug']]['current_stock'];
           
            //die;
            $template->categories = $mainArray[$c['slug']]['categories'];
            $template->photos = $mainArray[$c['slug']]['photos'];
            
            $template->tags = $mainArray[$c['slug']]['tags'];

            $template->description = $mainArray[$c['slug']]['description'];
            $template->small_description = $mainArray[$c['slug']]['small_description'];

            $template->base_price = (string) $mainArray[$c['slug']]['base_price'];
            $template->display_price = (string) $mainArray[$c['slug']]['display_price'];
            
            $template->meta_title = $mainArray[$c['slug']]['meta_title'];
            $template->meta_description = $mainArray[$c['slug']]['meta_description'];
            $template->meta_img = $mainArray[$c['slug']]['meta_img'];
            
            $template->todays_deal = $mainArray[$c['slug']]['todays_deal'];
            $template->published = $mainArray[$c['slug']]['published'];
            $template->featured = $mainArray[$c['slug']]['featured'];
            $template->model = $mainArray[$c['slug']]['model'];
            
            
            $template->more_settings = $mainArray[$c['slug']]['more_settings'];
            
            //$template->variations = $mainArray[$c['slug']]['variations'];
            $template->additional_options_variations = $mainArray[$c['slug']]['additional_options_variations'];

            return $template;
    }

    public function resizeTemplateMainImages($pics){
       // echo "<br>";
        //print_r($pics);
        $chunk_urls = ( explode('/',$pics) );
        $imageName = end( $chunk_urls );

       
        //echo "<br>IMage name is: ".$imageName."<br>";
        //echo public_path('uploads/tmp_images/'.$imageName)."<br>";

        //for thumbnail
        generateThumbnails( public_path('uploads/tmp_images/'.$imageName) , public_path('uploads/templates/photos/thumbnail'), $imageName, 'thumbnail'  );
        //for icon
        generateThumbnails( public_path('uploads/tmp_images/'.$imageName) , public_path('uploads/templates/photos/icon'), $imageName, 'icon'  );

        $pathToSave = 'uploads/templates/photos/original/';
        $imagefolderpath = $pathToSave.$imageName  ;
        //$path = $photo->move(public_path( $pathToSave ), $imageName);

        if ( copy( public_path('uploads/tmp_images/'.$imageName), public_path('uploads/templates/photos/original/'. $imageName) ) ) {
            //echo "copied...";
            echo "<br>Images generated and copied to respective folders: ".$imageName."<br>";
            //unlink( public_path('uploads/tmp_images/'.$imageName) );
        }

        $originalImage = 'uploads/templates/photos/original/'. $imageName;

        return $originalImage;

        //echo "<br>";

    }


    //pics will be comma seperated values
   public function resizeProductMainImages($product_id='', $pics=''){

        $productImages = explode(",", $pics);
        $this->finalObject[$product_id.'_images'] = array();
        if ($productImages) {
            foreach ($productImages as $img) {
                // echo "<br>";
                //print_r($pics);
                $chunk_urls = ( explode('/',$img) );
                $imageName = end( $chunk_urls );

               
                //echo "<br>IMage name is: ".$imageName."<br>";
                //echo public_path('uploads/tmp_images/'.$imageName)."<br>";

                //for thumbnail
                generateThumbnails( public_path('uploads/tmp_images/'.$imageName) , public_path('uploads/products/photos/thumbnail'), $imageName, 'thumbnail'  );
                //for icon
                generateThumbnails( public_path('uploads/tmp_images/'.$imageName) , public_path('uploads/products/photos/icon'), $imageName, 'icon'  );

                $pathToSave = 'uploads/products/photos/original/';
                $imagefolderpath = $pathToSave.$imageName  ;
                //$path = $photo->move(public_path( $pathToSave ), $imageName);

                if ( copy( public_path('uploads/tmp_images/'.$imageName), public_path('uploads/products/photos/original/'. $imageName) ) ) {
                    //echo "copied...";
                    echo "<br>Images generated and copied to respective folders: ".$imageName."<br>";
                    //unlink( public_path('uploads/tmp_images/'.$imageName) );
                }

                $originalImage = 'uploads/products/photos/original/'. $imageName;

                $this->finalObject[$product_id.'_images'][] =  $originalImage;
            }
        }
        

        return $this->finalObject;

    }
}
