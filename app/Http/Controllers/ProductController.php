<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\Product;
use Illuminate\Support\Str;
use App\ProductMysql;
use Image;

class ProductController extends Controller
{

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_products()
    {
        $type = 'Normal';
        $products = Product::where('added_by', 'admin')->where('is_template','0')->orderBy('created_at', 'desc')->get();

        //dd($products);
        return view('products.index', compact('products','type'));
    }

    

    public function admin_template_products()
    {
        $type = 'Template';
        $products = Product::where('added_by', 'admin')->where('is_template','1')->orderBy('created_at', 'desc')->get();

        //dd($products);
        return view('products.index', compact('products','type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_product_edit($id)
    {
        $product = Product::findOrFail(decrypt($id));
        //dd(json_decode($product->price_variations)->choices_0_S_price);
        //echo $product->choice_options[0];
        //echo "<pre>";
        $product->choice_options = json_decode(json_encode($product->choice_options));
        $product->additional_options = json_decode(json_encode($product->additional_options));
        //print_r($product->choice_options);
        /*foreach ($product->additional_options as $a){

        	echo "<br>name is: ";
        	echo $a->name."<br>";
        	//echo $key['title'];

    	}
        die;*/
        //dd($product);
        //$product->colors = json_decode($product->colors);
        $tags = json_decode($product->tags);
        $categories = Category::all();
        $product->more_settings = json_decode(json_encode($product->more_settings));
        //print_r($product->more_settings);
        //echo "<br> product is: ".$product->more_settings->upload_settings->is_upload."<br>";
        return view('products.edit', compact('product', 'categories', 'tags'));
    }

    //

    public function create(){

        //echo "ah";die;
    	$categories = Category::all();
    	//dd($categories);
    	//$categories = [];
        return view('products.create', compact('categories'));
    }

    public function store(Request $request){
	    	$product = new Product;
	        //$product->name = preg_replace('/[^A-Za-z0-9\-]/', '', $request->name);
            $product->name = $request->name;

            $product->filters = array();
            $product->related_products = array();

            $product->product_type = $request->product_type;
            $product->is_variant = ($request->is_variant=="1") ? $request->is_variant : '0';
            $product->is_template = ($request->is_template=="1") ? $request->is_template : '0';
            $product->model = $request->model;
	        $product->nextid(); // auto-increment
	        $product->added_by = $request->added_by;
	       // $product->user_id = Auth::user()->id;
	        $product->user_id = "1";
           
            $product->more_settings  = $this->moreOptionsObj($request);


            //this is for Additional Options
            $additionalOptions = $this->additionalOptions($request);

            $product->additional_options = $additionalOptions['option_collection'];
            $product->additional_options_variations = $additionalOptions['variations_array'];

            // end of additional Options


            /*$template->products = array();
            if ($request->products_add) {
                $product_IDS = array();
                foreach ($request->products_add as $prods) {
                    array_push($product_IDS, $prods);
                }
                $template->products = $product_IDS;
            }*/


	        $product->current_stock = $request->current_stock;
	        $photos = array();
	        $product->photos = $photos;

            if($request->hasFile('photos')){
            foreach ($request->photos as $key => $photo) {
                //$path = $photo->store('uploads/products/photos');
                //echo "<pre>";
                //print_r($photo);
                //print_r();
                $imageName = getOnlyImageName($photo->getClientOriginalName()).'.'.$photo->extension();
                //echo "<br>photo path is: ".$photo->path()."<Br>";              

                //$destinationPath = public_path('uploads/products/photos/thumbnail');
                          
                //for generating  thumbnail, from tmp location
                generateThumbnails( $photo->path() , public_path('uploads/products/photos/thumbnail'), $imageName, 'thumbnail'  );
                //for generating icon, from tmp location
                generateThumbnails( $photo->path() , public_path('uploads/products/photos/icon'), $imageName, 'icon'  );
                    

                //for saving original image from tmp location.
                $pathToSave = 'uploads/products/photos/original/';
                $imagefolderpath = $pathToSave.$imageName  ;
                $path = $photo->move(public_path( $pathToSave ), $imageName);
                array_push($photos, $imagefolderpath);
                //ImageOptimizer::optimize(base_path('public/').$path);
            }
            $product->photos = $photos;
        }

            

	        $product->thumbnail_img = '';
	        if($request->hasFile('thumbnail_img')){
                $imageName = getOnlyImageName($request->thumbnail_img->getClientOriginalName()).'.'.$request->thumbnail_img->extension();
                $imagefolderpath = 'uploads/products/thumbnail/'.$imageName  ;
                $request->thumbnail_img->move(public_path('uploads\products\thumbnail'), $imageName);
                //$product->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');
                $product->thumbnail_img = $imagefolderpath;
                //ImageOptimizer::optimize(base_path('public/').$product->thumbnail_img);
            }

	        $product->featured_img = '';
            if($request->hasFile('featured_img')){
                $imageName = getOnlyImageName($request->featured_img->getClientOriginalName()).'.'.$request->featured_img->extension();
                $imagefolderpath = 'uploads/products/featured/'.$imageName  ;
                $request->featured_img->move(public_path('uploads\products\featured'), $imageName);
                //$product->featured_img = $request->featured_img->store('uploads/products/featured');
                $product->featured_img = $imagefolderpath;
                //ImageOptimizer::optimize(base_path('public/').$product->featured_img);
            }

	         $product->flash_deal_img = '';
            if($request->hasFile('flash_deal_img')){
                $imageName = getOnlyImageName($request->flash_deal_img->getClientOriginalName()).'.'.$request->flash_deal_img->extension();
                $imagefolderpath = 'uploads/products/flash_deal/'.$imageName  ;
                $request->flash_deal_img->move(public_path('uploads\products\flash_deal'), $imageName);
                //$product->flash_deal_img = $request->flash_deal_img->store('uploads/products/flash_deal');
                $product->flash_deal_img = $imagefolderpath;
                //ImageOptimizer::optimize(base_path('public/').$product->flash_deal_img);
            }

	        $product->unit = $request->unit;
	        $product->tags = implode('|',$request->tags);
	        $product->description = $request->description;
            $product->small_description = $request->small_description;
	        $product->video_provider = $request->video_provider;
	        $product->video_link = $request->video_link;
	        $product->unit_price = $request->unit_price;
	        $product->purchase_price = $request->purchase_price;
	        $product->tax = $request->tax;
	        $product->tax_type = $request->tax_type;
	        $product->discount = $request->discount;
	        $product->discount_type = $request->discount_type;
            $product->flat_rate = ($request->flat_rate=="1") ? $request->flat_rate : '0';
            $product->shipping_cost = $request->flat_shipping_cost;

            $product->meta_title = $request->meta_title;
	        $product->meta_description = $request->meta_description;

	         $product->meta_img = '';
             if($request->hasFile('meta_img')){
                $imageName = getOnlyImageName($request->meta_img->getClientOriginalName()).'.'.$request->meta_img->extension();
                $imagefolderpath = 'uploads/products/meta/'.$imageName  ;
                $request->meta_img->move(public_path('uploads\products\meta'), $imageName);
                //$product->meta_img = $request->meta_img->store('uploads/products/meta');
                $product->meta_img = $imagefolderpath;
                //ImageOptimizer::optimize(base_path('public/').$product->meta_img);
            }

	        $product->pdf = '';
	        if($request->hasFile('pdf')){
	            $product->pdf = $request->pdf->store('uploads/products/pdf');
	        }

	        //$product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name));
            $product->slug = strtolower( str_replace(' ', '-', $request->name) );

	         $product->colors = [];
	        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
	            //$product->colors = json_encode($request->colors);
	            $product->colors = $request->colors;
	        }
	        else {
	            $colors = array();
	            //$product->colors = json_encode($colors);
	            $product->colors = $colors;
	        }

	        $choice_options = array();

	        if($request->has('choice')){
	            foreach ($request->choice_no as $key => $no) {
	                $str = 'choice_options_'.$no;
	                $item['name'] = 'choice_'.$no;
	                $item['title'] = $request->choice[$key];
	                $item['options'] = explode(',', implode('|', $request[$str]));
	                array_push($choice_options, $item);
	            }
	        }

	        //$product->choice_options = json_encode($choice_options);
	        $product->choice_options = $choice_options;

	        $variations = array();

	        //combinations start
	        $options = array();
	        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
	            $colors_active = 1;
	            array_push($options, $request->colors);
	        }

	        if($request->has('choice_no')){
	            foreach ($request->choice_no as $key => $no) {
	                $name = 'choice_options_'.$no;
	                $my_str = implode('|',$request[$name]);
	                array_push($options, explode(',', $my_str));
	            }
	        }


	        $variations_array = [];
	        //Generates the combinations of customer choice options
	        $combinations = combinations($options);
	        if(count($combinations[0]) > 0){
	            foreach ($combinations as $key => $combination){
	                $str = '';
	                foreach ($combination as $key => $item){
	                    if($key > 0 ){
	                        $str .= '-'.str_replace(' ', '', $item);
	                    }
	                    else{
	                        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
	                            $color_name = \App\Color::where('code', $item)->first()->name;
	                            $str .= $color_name;
	                        }
	                        else{
	                            $str .= str_replace(' ', '', $item);
	                        }
	                    }
	                }
                    $str = strtolower($str);
	                $item = array();
	                $item['price'] = $request['price_'.str_replace('.', '_', $str)];
	                $item['sku'] = $request['sku_'.str_replace('.', '_', $str)];
	                $item['qty'] = $request['qty_'.str_replace('.', '_', $str)];
                    $item['weight'] = $request['weight_'.str_replace('.', '_', $str)];
	                $variations[$str] = $item;

	                //array_push($variations_array, $variations);
	                //$variations = array();
	            }
	        }
	        //combinations end

	     

	        $product->variations = $variations;
	        
	       // $product->variations = $variations_array;
	        

	        $data = openJSONFile('en');
	        $data[$product->name] = $product->name;
	        saveJSONFile('en', $data);


	        $product->todays_deal = 0  ;
	        $product->published = 0  ;
	        $product->featured = 0  ;

	        if($product->save()){
	        $p = new ProductMysql;
            $complete_product = Product::where('slug', $product->slug)->firstorfail();
        	$p->obj_id=$complete_product->_id;
            $p->products_dump=json_encode($complete_product);
        	$p->save();
	            return redirect()->route('products.admin')->with('success','Product has been inserted successfully');
	        }
	        else{
	            flash(__('Something went wrong'))->error();
	            return back();
	        }
    }

    public function categoryObj($request){

        $category_obj = array();

        $categories = Category::where('id', $request->category_id)->firstorfail();


        $category_obj['category_inf']['category']['category_id'] = $request->category_id ;
        $category_obj['category_inf']['category']['name'] = $categories->name ;
        $category_obj['category_inf']['category']['slug'] = $categories->slug ;

        $sub_categories = SubCategory::where('id', $request->subcategory_id)->firstorfail();


        $category_obj['category_inf']['sub_category']['sub_category_id'] = $request->subcategory_id;
        $category_obj['category_inf']['sub_category']['name'] = $sub_categories->name;
        $category_obj['category_inf']['sub_category']['category_id'] = $request->category_id;
        $category_obj['category_inf']['sub_category']['slug'] = $sub_categories->slug ;


        $subsub_categories = SubSubCategory::where('id', $request->subsubcategory_id)->firstorfail();
        

        $category_obj['category_inf']['sub_sub_category']['sub_sub_category_id'] = $request->subsubcategory_id;
        $category_obj['category_inf']['sub_sub_category']['sub_category_id'] = $request->subcategory_id;
        $category_obj['category_inf']['sub_sub_category']['name'] = $subsub_categories->name;
       
        $category_obj['category_inf']['sub_sub_category']['slug'] = $subsub_categories->slug ;

        //print_r($categories->name);



       /* echo "<pre>category info array is: ";
        print_r($category_obj);
        echo "</pre>";
        die;*/

        return $category_obj;

    }

    public function moreOptionsObj($request){

        $moreOptions = array();
        $moreOptions['upload_settings']['is_upload'] = isset($request->upload_active) ? $request->upload_active : '0';
        $moreOptions['upload_settings']['upload_limit'] = $request->upload_limit;

        $moreOptions['instructions'] = isset($request->instructions_active) ? $request->instructions_active : '0';
       
        $moreOptions['promotion_settings']['is_promotion'] = isset($request->promotion_active) ? $request->promotion_active : '0';
        $moreOptions['promotion_settings']['promotion_text'] = $request->promotion_text;
        $moreOptions['promotion_settings']['promotion_discount'] = $request->promotion_discount;

        /*echo "<pre>";
        print_r($moreOptions);
        echo "</pre>";
        die;*/

        return $moreOptions;


    }

    public function additionalOptions($request){

       /* echo "<pre>";
        print_r($request->options_no);
        echo "<br><br>";
        print_r($request->option);
       echo "<br><br>";
        print_r($request->option_values_1);
       print_r($request->option_values_2);
       print_r($request->option_type_1);*/
        

        $optionCollection = array();  
        $variations_array = array();  
        if ($request->has('options_no')) {
            for ($i=0; $i < count($request->options_no) ; $i++) {
                $eachOption = array(); 
                $index = $request->options_no[$i];
                $eachOption['name'] = "option_".$request->options_no[$i];
                $eachOption['title'] = $request->option[$i];
                $option_type = 'option_type_'.$index;
                //echo "<br>optionn type is: ".$request->{$option_type}."<br>";
                $eachOption['option_type'] = $request->{$option_type};
                $optionvaluename = 'option_values_'.$index;
                $eachOption['options'] = explode(",", $request->{$optionvaluename}[0]);
                array_push($optionCollection, $eachOption);
                //echo "<br>index is: ".$index."<br>"   ;
                
                 //echo "option values are : "."<br><br>";
                 //print_r($request->{$optionvaluename});

                if ($eachOption['option_type']=="checkbox" || $eachOption['option_type']=="radio") {
                   //now build option variations
                    foreach ($eachOption['options'] as $e) {
                        $option_variation_name = concat_string($eachOption['title'], $e );

                       // echo "<br> option varation name is: ".$option_variation_name."<br><br>";

                        //echo " <Br> price is: ".$request->{'price_'.$option_variation_name}."<br>";
                        //echo " <Br> sort is: ".$request->{'sort_'.$option_variation_name}."<br>";

                        $variations_array[$option_variation_name]['default'] = $request->{'default_'.$option_variation_name};
                        $variations_array[$option_variation_name]['price'] = $request->{'price_'.$option_variation_name};
                        $variations_array[$option_variation_name]['sort'] = $request->{'sort_'.$option_variation_name};
                    }
                }else{
                    //save text and text area default value, price, sort order
                     $option_variation_name = concat_string($eachOption['title'], $eachOption['option_type'] );

                     $variations_array[$option_variation_name]['default'] = $request->{'default_'.$option_variation_name};
                        $variations_array[$option_variation_name]['price'] = $request->{'price_'.$option_variation_name};
                        $variations_array[$option_variation_name]['sort'] = $request->{'sort_'.$option_variation_name};
                }
                
                
            }
        }
        

        /*echo "<br>option collection is: ";
        print_r($optionCollection);
        echo "<br> variation array is: ";
        print_r($variations_array);
        echo "</pre>";    
        die;*/

        return array('option_collection' => $optionCollection, 'variations_array' => $variations_array);
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        //$product->name = preg_replace('/[^A-Za-z0-9\-]/', '', $request->name);
        $product->name = $request->name;
        $product->product_type = $request->product_type;
        $product->is_variant = ($request->is_variant=="1") ? $request->is_variant : '0';
        $product->is_template = ($request->is_template=="1") ? $request->is_template : '0';
        $product->user_id = "1";

        $product->model = $request->model;

        

        $product->more_settings  = $this->moreOptionsObj($request);


        //this is for Additional Options
        $additionalOptions = $this->additionalOptions($request);

        $product->additional_options = $additionalOptions['option_collection'];
        $product->additional_options_variations = $additionalOptions['variations_array'];

        // end of additional Options


        $product->categories = array();
        if ($request->category_ids) {
            $category_IDS = array();
            foreach ($request->category_ids as $catIDS) {
                if(!in_array($catIDS, $category_IDS, true)){
                    array_push($category_IDS, $catIDS);
                }
            }
            $product->categories = $category_IDS;
        }


        $product->filters = array();
        if ($request->filter_ids) {
            $filter_IDS = array();
            foreach ($request->filter_ids as $fIDS) {
                if(!in_array($fIDS, $filter_IDS, true)){
                    array_push($filter_IDS, $fIDS);
                }
            }
            $product->filters = $filter_IDS;

            $templateController = new TemplateController;
            $templateController->saveFiltersFromProducts($product->filters, $product->ref);
        }



        $product->related_products = array();
        if ($request->related_prod_ids) {
            $rProductIDS = array();
            foreach ($request->related_prod_ids as $r_prod_IDS) {
                if(!in_array($r_prod_IDS, $rProductIDS, true)){
                    array_push($rProductIDS, $r_prod_IDS);
                }
            }
            $product->related_products = $rProductIDS;
        }





        /*print_r( $request->related_prod_ids );
        print_r($product->related_products);
        die;*/



        $product->current_stock = $request->current_stock;

        if($request->has('previous_photos')){
            $photos = $request->previous_photos;
        }
        else{
            $photos = array();
        }

        if($request->hasFile('photos')){
            foreach ($request->photos as $key => $photo) {
                //$path = $photo->store('uploads/products/photos');
                //echo "<pre>";
                //print_r($photo);
                //print_r();

                $imageName = getOnlyImageName($photo->getClientOriginalName()).'.'.$photo->extension();
                //echo "<br>photo path is: ".$photo->path()."<Br>";              

                //$destinationPath = public_path('uploads/products/photos/thumbnail');
                          
                //for thumbnail
                generateThumbnails( $photo->path() , public_path('uploads/products/photos/thumbnail'), $imageName, 'thumbnail'  );
                //for icon
                generateThumbnails( $photo->path() , public_path('uploads/products/photos/icon'), $imageName, 'icon'  );
                    


                $pathToSave = 'uploads/products/photos/original/';
                $imagefolderpath = $pathToSave.$imageName  ;
                $path = $photo->move(public_path( $pathToSave ), $imageName);
                array_push($photos, $imagefolderpath);
                //ImageOptimizer::optimize(base_path('public/').$path);
            }
        }
        $product->photos = $photos;

        //echo "<pre>photos are : ";
            //print_r($product->photos);
           // die;

        $product->thumbnail_img = $request->previous_thumbnail_img;
        if($request->hasFile('thumbnail_img')){
                $imageName = getOnlyImageName($request->thumbnail_img->getClientOriginalName()).'.'.$request->thumbnail_img->extension();
                $imagefolderpath = 'uploads/products/thumbnail/'.$imageName  ;
                $request->thumbnail_img->move(public_path('uploads\products\thumbnail'), $imageName);
            //$product->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');
            $product->thumbnail_img = $imagefolderpath;
            //ImageOptimizer::optimize(base_path('public/').$product->thumbnail_img);
        }

        $product->featured_img = $request->previous_featured_img;
        if($request->hasFile('featured_img')){
                $imageName = getOnlyImageName($request->featured_img->getClientOriginalName()).'.'.$request->featured_img->extension();
                $imagefolderpath = 'uploads/products/featured/'.$imageName  ;
                $request->featured_img->move(public_path('uploads\products\featured'), $imageName);
            //$product->featured_img = $request->featured_img->store('uploads/products/featured');
            $product->featured_img = $imagefolderpath;
            //ImageOptimizer::optimize(base_path('public/').$product->featured_img);
        }

        $product->flash_deal_img = $request->previous_flash_deal_img;
        if($request->hasFile('flash_deal_img')){
                $imageName = getOnlyImageName($request->flash_deal_img->getClientOriginalName()).'.'.$request->flash_deal_img->extension();
                $imagefolderpath = 'uploads/products/flash_deal/'.$imageName  ;
                $request->flash_deal_img->move(public_path('uploads\products\flash_deal'), $imageName);
            //$product->flash_deal_img = $request->flash_deal_img->store('uploads/products/flash_deal');
            $product->flash_deal_img = $imagefolderpath;
            //ImageOptimizer::optimize(base_path('public/').$product->flash_deal_img);
        }

        $product->unit = $request->unit;
        $product->tags = implode('|',$request->tags);
        $product->description = $request->description;
        $product->small_description = $request->small_description;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->purchase_price = $request->purchase_price;
        $product->tax = $request->tax;
        $product->tax_type = $request->tax_type;
        $product->discount = $request->discount;
        $product->flat_rate = ($request->flat_rate=="1") ? $request->flat_rate : '0';

        //echo "<br> prdouc flat rate is: ".$product->flat_rate."<br>";die;
        $product->shipping_cost = $request->flat_shipping_cost;
        $product->discount_type = $request->discount_type;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

        $product->meta_img = $request->previous_meta_img;
        if($request->hasFile('meta_img')){
            $imageName = getOnlyImageName($request->meta_img->getClientOriginalName()).'.'.$request->meta_img->extension();
                $imagefolderpath = 'uploads/products/meta/'.$imageName  ;
                $request->meta_img->move(public_path('uploads\products\meta'), $imageName);
            //$product->meta_img = $request->meta_img->store('uploads/products/meta');
            $product->meta_img = $imagefolderpath;
            //ImageOptimizer::optimize(base_path('public/').$product->meta_img);
        }

        if($request->hasFile('pdf')){
            $product->pdf = $request->pdf->store('uploads/products/pdf');
        }

        //$product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name));
        $product->slug = strtolower( str_replace(' ', '-', $request->name)  );


        $product->colors = [];
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $product->colors = $request->colors;
        }
        else {
            $colors = array();
            $product->colors = $colors;
        }

        $choice_options = array();

        if($request->has('choice')){
            foreach ($request->choice_no as $key => $no) {
                $str = 'choice_options_'.$no;
                $item['name'] = 'choice_'.$no;
                $item['title'] = $request->choice[$key];
                $item['options'] = explode(',', implode('|', $request[$str]));
                array_push($choice_options, $item);
            }
        }

        $product->choice_options = $choice_options;

       /* foreach (Language::all() as $key => $language) {
            $data = openJSONFile($language->code);
            unset($data[$product->name]);
            $data[$request->name] = "";
            saveJSONFile($language->code, $data);
        }*/

        $variations = array();
        $variations_array = array();

        //combinations start
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $my_str = implode('|',$request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = combinations($options);
        if(count($combinations[0]) > 0){
            foreach ($combinations as $key => $combination){
                $str = '';
                foreach ($combination as $key => $item){
                    if($key > 0 ){
                        $str .= '-'.str_replace(' ', '', $item);
                    }
                    else{
                        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
                            $color_name = \App\Color::where('code', $item)->first()->name;
                            $str .= $color_name;
                        }
                        else{
                            $str .= str_replace(' ', '', $item);
                        }
                    }
                }
                $str = strtolower($str);
                $item = array();
                $item['price'] = $request['price_'.str_replace('.', '_', $str)];
                $item['sku'] = $request['sku_'.str_replace('.', '_', $str)];
                $item['qty'] = $request['qty_'.str_replace('.', '_', $str)];
                $item['weight'] = $request['weight_'.str_replace('.', '_', $str)];
                
                $variations[$str] = $item;
                //array_push($variations_array, $variations);
	           // $variations = array();
            }
        }
        //combinations end

        /* echo "<pre>";
           print_r($variations);
           die;*/


        $product->variations = $variations;
        //echo "<pre>";
        //print_r($product->variations);
       // die;
       // $product->variations = $variations_array;

        if($product->save()){
            //flash(__('Product has been updated successfully'))->success();
            //if(Auth::user()->user_type == 'admin'){
        	//$p = ProductMysql::where('obj_id', $product->_id)->firstorfail();
            //$p->obj_id=$product->_id;
        	//$p->products_dump=json_encode(Product::findOrFail($id));
        	//$p->save();
        	//echo "products dumped";
        	//die;
                return redirect()->route('products.admin')->with('success', 'Product has been updated successfully');
            //}
           // else{
            //    return redirect()->route('seller.products');
           // }
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function sku_combination(Request $request)
    {
    	//echo "amar";die;
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = combinations($options);
        return view('partials.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'));
    }

    public function more_options_edit(Request $request){
      // 
      // echo "<pre>";
       $actual_data = array();
       parse_str($request->data, $actual_data);
       //print_r($actual_data);
       //die;
       $product = Product::findOrFail($actual_data['id']);

       $product = json_decode($product);
      // echo "<br><br>";
       // print_r($request->data->slug);
       //echo "<br><br>";
       //print_r($request->ref_row);

       $option_values = array();
       $option = $actual_data['option'][$request->ref_row-1];
       if ($actual_data['option_values_'.$request->ref_row][0]!='') {
           $option_values = explode(",", $actual_data['option_values_'.$request->ref_row][0]);
       }

      /* if ($request->option_type=="textarea") {
           echo "\ntextarea\n";die;
       }*/
       //echo "<br>\n";
       //print_r($option_values);

      // echo "</pre>";

       return view('partials.more_options_edit', compact('request','actual_data', 'product','option','option_values'));
    }

    public function more_options(Request $request){
      // 
      // echo "<pre>";
       $actual_data = array();
       parse_str($request->data, $actual_data);
       //print_r($actual_data);
       //die;
      // $product = Product::findOrFail($actual_data['id']);

      // $product = json_decode($product);
      // echo "<br><br>";
       // print_r($request->data->slug);
       //echo "<br><br>";
       //print_r($request->ref_row);
       $option_values = array();
       $option = $actual_data['option'][$request->ref_row-1];
       if ($actual_data['option_values_'.$request->ref_row][0]!='') {
           $option_values = explode(",", $actual_data['option_values_'.$request->ref_row][0]);
       }
       

      /* if ($request->option_type=="textarea") {
           echo "\ntextarea\n";die;
       }*/
       //echo "<br>\n";
       //print_r($option_values);

      // echo "</pre>";

       return view('partials.more_options', compact('request','actual_data', 'product','option','option_values'));
    }


    public function related_product_IDS( Request $request ){

        $final = array();
        if ( false ) {
            //echo "<br> template <br>";
            //first pull is template and suggestion key word products
            $templates = \App\Template::where('name','like', '%'.$request->related_product_name.'%')->get();

            foreach ($templates as $template) {
               if ($template->products) {
                   $products = Product::whereIn('ref', $template->products)->whereNotIn('ref', [$request->product_ref])->get();

                   if ( $products ) {
                       foreach ($products as $prod) {
                            $data['id'] = $template->ref;
                            $data['name'] = $template->name.' '.$prod->name;
                            array_push($final, $data);
                       }
                   }
               }
            }

            //then collect all the resulting IDS.
            //then search those IDS and pull templates
        }else{
            
            $products = Product::where('name','like', '%'.$request->related_product_name.'%')->whereNotIn('ref', [$request->product_ref])->get();
            foreach ($products as $prod) {
                //normal product
                //echo "<br> product <br>";
                $data['id'] = $prod->ref;
                $data['name'] = $prod->name;
                array_push($final, $data);
            }
            
        }

        echo json_encode($final);

    }


    public function sku_combination_edit(Request $request)
    {

        $product = Product::findOrFail($request->id);

        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        else {
            $colors_active = 0;
        }

        $product_name = $request->name;
        $unit_price = $request->unit_price;

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }
        
        $product->variations = json_encode($product->variations);
        //echo "</pre>";
        //die;
        $combinations = combinations($options);
        return view('partials.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product'));
    }


    public function updateTodaysDeal(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->todays_deal = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function slug_check(Request $request){

        //echo $request->slug_check."\n";
        //echo $request->slug_value."\n";
        $cnt = Product::where('slug', $request->slug_value)->count();
        if ($request->slug_check=="create") {
            //echo $cnt;
            if ($cnt>0) {
                echo 'Slug Already exists. Use a different one';
            }else{
                echo 'Slug seems good. Go ahead.';
            }
        }else{
            //this is for edit
            if ($cnt>1) {
                echo 'Slug Already exists. Use a different one';
            }else{
                echo 'Slug seems good. Go ahead.';
            }

        }

    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }
}
