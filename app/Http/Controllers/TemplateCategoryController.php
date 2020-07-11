<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\TemplateCategories as TC;
use App\Product;
use App\Template;
use Illuminate\Support\Str;
use App\ProductMysql;

class TemplateCategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_templates()
    {
        $type = 'In House';
        $templates = TC::where('active','1')->orderBy('created_at', 'desc')->get();

        //dd($products);
        return view('templatecategories.index', compact('templates','type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_templatecategories_edit($id)
    {
        $template = TC::findOrFail(decrypt($id));
       
        $tags = json_decode($template->tags);
        //$categories = Category::all();
        //$template->more_settings = json_decode(json_encode($template->more_settings));
        //print_r($template->more_settings);
        //echo "<br> template is: ".$templates->more_settings->upload_settings->is_upload."<br>";
        return view('templatecategories.edit', compact('template',  'tags'));
    }

    //

    public function create(){

        //echo "ah";die;
    	//$categories = Category::all();
    	//dd($categories);
    	//$categories = [];
    	//$products = Product::where('is_template','1')->get();
    	//echo "<pre>";
    	//print_r($products);
    	//echo "</pre>";
        return view('templatecategories.create');
    }

    public function ajax_getCategories(Request $request){

        //echo $request->parent_id."\n";

        $categoryName = $request->parent_id_name;

        $categories = TC::where('name','like','%'.$categoryName.'%');

        if( !empty( $request->category_id ) ){
           //$categories = $categories->where('_id','!=',$request->category_id);
        }
       



        $categories = $categories->where('active','1')->get();

        $result = array();
        if ($categories) {
            $name = '';
            $data = array();
            $firstName = '';
            $secondName = '';
            $thirdName = '';
            $data['name'] = '';
           foreach ($categories as $firstLevel) {
              $data['name'] = '';
              $name = $firstLevel->name;
              if ($firstLevel->parent_id=="0") {
                //this if is to stop searching for parents , if parent id is 0.
                  $data['id'] = $firstLevel->ref;
                  $data['name'] = $name;
                  array_push($result, $data);
              }else{

                  $secondLevel = TC::where('ref',$firstLevel->parent_id)->where('active','1')->first();
                  if ($secondLevel) {
                     $secondName = $secondLevel->name;

                      $thirdLevel = TC::where('ref',$secondLevel->parent_id)->where('active','1')->first();
                      if ($thirdLevel) {
                        $thirdName = $thirdLevel->name;
                      }
                  }//end of secondLevel if
                  $data['id'] = $firstLevel->ref;
                  //$data['name'] = $name;
                  $firstName = $name;


                  if ($thirdName!='') {
                     $data['name'] = $thirdName;
                  }


                  if ($secondName!='') {
                     $data['name'] .= ' > '.$secondName;
                  }

                  if ($firstName!='') {
                     $data['name'] .= ' > '.$firstName;
                  }

                  $data['name'] = ltrim($data['name'],' > ');
                  array_push($result, $data);

              }



           }//end of foreach
        }//end of if categories

        //echo "<pre>";
        //print_r($result);

        echo json_encode($result);

        //dd($request);
    }


    

    public function ajax_getCategories_formenu(Request $request){

        //echo $request->parent_id."\n";

        $categoryName = $request->parent_id_name;

        $categories = TC::where('name','like','%'.$categoryName.'%');

        if( !empty( $request->category_id ) ){
           //$categories = $categories->where('_id','!=',$request->category_id);
        }
       



        $categories = $categories->where('active','1')->get();

        $result = array();
        if ($categories) {
            $name = '';
            $data = array();
            $firstName = '';
            $secondName = '';
            $thirdName = '';
            $data['name'] = '';
           foreach ($categories as $firstLevel) {
              $data['name'] = '';
              $name = $firstLevel->name;
              if ($firstLevel->parent_id=="0") {
                //this if is to stop searching for parents , if parent id is 0.
                  $data['id'] = $firstLevel->slug;
                  $data['name'] = $name;
                  array_push($result, $data);
              }else{

                  $secondLevel = TC::where('ref',$firstLevel->parent_id)->where('active','1')->first();
                  if ($secondLevel) {
                     $secondName = $secondLevel->name;

                      $thirdLevel = TC::where('ref',$secondLevel->parent_id)->where('active','1')->first();
                      if ($thirdLevel) {
                        $thirdName = $thirdLevel->name;
                      }
                  }//end of secondLevel if
                  $data['id'] = $firstLevel->slug;
                  //$data['name'] = $name;
                  $firstName = $name;


                  if ($thirdName!='') {
                     $data['name'] = $thirdName;
                  }


                  if ($secondName!='') {
                     $data['name'] .= ' > '.$secondName;
                  }

                  if ($firstName!='') {
                     $data['name'] .= ' > '.$firstName;
                  }

                  $data['name'] = ltrim($data['name'],' > ');
                  array_push($result, $data);

              }



           }//end of foreach
        }//end of if categories

        //echo "<pre>";
        //print_r($result);

        echo json_encode($result);

        //dd($request);
    }



    public function ajax_getTemplates_formenu(Request $request){

        //echo $request->parent_id."\n";

        $templateSuggestions = $request->template;

        $templates = Template::where('name','like','%'.$templateSuggestions.'%')->get();

        $result = array();
        if ($templates) {
            $data = array();
           foreach ($templates as $template) {
                $data['name'] = $template->name;
                $data['id'] = $template->slug;
              
                array_push($result, $data);

              }
        }//end of if templates

        //echo "<pre>";
        //print_r($result);

        echo json_encode($result);

    }

    public function store(Request $request){
	    	$template = new TC;
	        //$product->name = preg_replace('/[^A-Za-z0-9\-]/', '', $request->name);
            $template->name = $request->name;
           $template->filters = array();
            
	        $template->nextid(); // auto-increment
	       // $product->user_id = Auth::user()->id;
	        $template->user_id = "1";
            
            $template->parent_id = "0";

            $template->is_template = ($request->is_template=="1") ? $request->is_template : '0';

            if ($request->parent_id!="0") {
                 $template->parent_id = $request->parent_id;
            }
            
	        $photos = array();
	        $template->photos = $photos;

            if($request->hasFile('photos')){
            foreach ($request->photos as $key => $photo) {
                //$path = $photo->store('uploads/products/photos');
                //echo "<pre>";
                //print_r($photo);
                //print_r();
                $imageName = getOnlyImageName($photo->getClientOriginalName()).'.'.$photo->extension();
                //echo "<br>photo path is: ".$photo->path()."<Br>";              

                $destinationPath = public_path('uploads/template_categories/photos/thumbnail');
                          
                //for thumbnail
                generateThumbnails( $photo->path() , public_path('uploads/template_categories/photos/thumbnail'), $imageName, 'thumbnail'  );
                //for icon
                generateThumbnails( $photo->path() , public_path('uploads/template_categories/photos/icon'), $imageName, 'icon'  );

                $pathToSave = 'uploads/template_categories/photos/original/';
                $imagefolderpath = $pathToSave.$imageName;
                $path = $photo->move(public_path( $pathToSave ), $imageName);
                array_push($photos, $imagefolderpath);
                //ImageOptimizer::optimize(base_path('public/').$path);
            }
            $template->photos = $photos;
        }

            

	        $template->thumbnail_img = '';
	        if($request->hasFile('thumbnail_img')){
                $imageName = getOnlyImageName($request->thumbnail_img->getClientOriginalName()).'_'.time().'.'.$request->thumbnail_img->extension();
                $imagefolderpath = 'uploads/template_categories/thumbnail/'.$imageName  ;
                $request->thumbnail_img->move(public_path('uploads\template_categories\thumbnail'), $imageName);
                //$product->thumbnail_img = $request->thumbnail_img->store('uploads/template_categories/thumbnail');
                $template->thumbnail_img = $imagefolderpath;
                //ImageOptimizer::optimize(base_path('public/').$product->thumbnail_img);
            }

	        $template->featured_img = '';
            if($request->hasFile('featured_img')){
                $imageName = getOnlyImageName($request->featured_img->getClientOriginalName()).'_'.time().'.'.$request->featured_img->extension();
                $imagefolderpath = 'uploads/template_categories/featured/'.$imageName  ;
                $request->featured_img->move(public_path('uploads\template_categories\featured'), $imageName);
                //$product->featured_img = $request->featured_img->store('uploads/template_categories/featured');
                $template->featured_img = $imagefolderpath;
                //ImageOptimizer::optimize(base_path('public/').$product->featured_img);
            }

	         $template->flash_deal_img = '';
            if($request->hasFile('flash_deal_img')){
                $imageName = getOnlyImageName($request->flash_deal_img->getClientOriginalName()).'_'.time().'.'.$request->flash_deal_img->extension();
                $imagefolderpath = 'uploads/template_categories/flash_deal/'.$imageName  ;
                $request->flash_deal_img->move(public_path('uploads\template_categories\flash_deal'), $imageName);
                //$product->flash_deal_img = $request->flash_deal_img->store('uploads/template_categories/flash_deal');
                $template->flash_deal_img = $imagefolderpath;
                //ImageOptimizer::optimize(base_path('public/').$product->flash_deal_img);
            }

	        
	        $template->tags = implode('|',$request->tags);
	       
	       
	        $template->meta_title = $request->meta_title;
	        $template->meta_description = $request->meta_description;

	         $template->meta_img = '';
             if($request->hasFile('meta_img')){
                $imageName = getOnlyImageName($request->meta_img->getClientOriginalName()).'_'.time().'.'.$request->meta_img->extension();
                $imagefolderpath = 'uploads/template_categories/meta/'.$imageName  ;
                $request->meta_img->move(public_path('uploads\template_categories\meta'), $imageName);
                //$product->meta_img = $request->meta_img->store('uploads/templates/meta');
                $template->meta_img = $imagefolderpath;
                //ImageOptimizer::optimize(base_path('public/').$product->meta_img);
            }

	       

	        //$template->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name));
            $template->slug = strtolower( str_replace(' ', '-', $request->name)  );

	        

	       
	        

	        $data = openJSONFile('en');
	        $data[$template->name] = $template->name;
	        saveJSONFile('en', $data);


	        $template->active ="1"  ;
	        

	        /*echo "<pre>";
	        print_r($template);
	        echo "</pre>";
	        die;*/

	        if($template->save()){

	        	//echo "saved <br>";
	            return redirect()->route('templatecategories.admin')->with('success','Category has been created successfully');
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

        //$moreOptions['instructions'] = isset($request->instructions_active) ? $request->instructions_active : '0';
       
       // $moreOptions['promotion_settings']['is_promotion'] = isset($request->promotion_active) ? $request->promotion_active : '0';
        //$moreOptions['promotion_settings']['promotion_text'] = $request->promotion_text;
        //$moreOptions['promotion_settings']['promotion_discount'] = $request->promotion_discount;

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
        $template = TC::findOrFail($id);
        //$template->name = preg_replace('/[^A-Za-z0-9\-]/', '', $request->name);
        $template->name = $request->name;
        
        $template->user_id = "1";

        $template->parent_id = "0";
        if ( $request->has('parent_id') ) {
           $template->parent_id = $request->parent_id;

        }

        $template->filters = array();
        if ($request->filter_ids) {
            $filter_IDS = array();
            foreach ($request->filter_ids as $fIDS) {
                if(!in_array($fIDS, $filter_IDS, true)){
                    array_push($filter_IDS, $fIDS);
                }
            }
            $template->filters = $filter_IDS;
        }


        $template->is_template = ($request->is_template=="1") ? $request->is_template : '0';

        



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

                $destinationPath = public_path('uploads/template_categories/photos/thumbnail');
                          
                //for thumbnail
                generateThumbnails( $photo->path() , public_path('uploads/template_categories/photos/thumbnail'), $imageName, 'thumbnail'  );
                //for icon
                generateThumbnails( $photo->path() , public_path('uploads/template_categories/photos/icon'), $imageName, 'icon'  );

                $pathToSave = 'uploads/template_categories/photos/original/';
                $imagefolderpath = $pathToSave.$imageName;
                $path = $photo->move(public_path( $pathToSave ), $imageName);
                array_push($photos, $imagefolderpath);
                //ImageOptimizer::optimize(base_path('public/').$path);
            }
        }
        $template->photos = $photos;

        //echo "<pre>photos are : ";
           /// print_r($template->photos);
            //die;

        $template->thumbnail_img = $request->previous_thumbnail_img;
        if($request->hasFile('thumbnail_img')){
                $imageName = getOnlyImageName($request->thumbnail_img->getClientOriginalName()).'_'.time().'.'.$request->thumbnail_img->extension();
                $imagefolderpath = 'uploads/templates/thumbnail/'.$imageName  ;
                $request->thumbnail_img->move(public_path('uploads\templates\thumbnail'), $imageName);
            //$template->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');
            $template->thumbnail_img = $imagefolderpath;
            //ImageOptimizer::optimize(base_path('public/').$template->thumbnail_img);
        }

        $template->featured_img = $request->previous_featured_img;
        if($request->hasFile('featured_img')){
                $imageName = getOnlyImageName($request->featured_img->getClientOriginalName()).'_'.time().'.'.$request->featured_img->extension();
                $imagefolderpath = 'uploads/templates/featured/'.$imageName  ;
                $request->featured_img->move(public_path('uploads\templates\featured'), $imageName);
            //$template->featured_img = $request->featured_img->store('uploads/products/featured');
            $template->featured_img = $imagefolderpath;
            //ImageOptimizer::optimize(base_path('public/').$template->featured_img);
        }

        $template->flash_deal_img = $request->previous_flash_deal_img;
        if($request->hasFile('flash_deal_img')){
                $imageName = getOnlyImageName($request->flash_deal_img->getClientOriginalName()).'_'.time().'.'.$request->flash_deal_img->extension();
                $imagefolderpath = 'uploads/templates/flash_deal/'.$imageName  ;
                $request->flash_deal_img->move(public_path('uploads\templates\flash_deal'), $imageName);
            //$template->flash_deal_img = $request->flash_deal_img->store('uploads/products/flash_deal');
            $template->flash_deal_img = $imagefolderpath;
            //ImageOptimizer::optimize(base_path('public/').$template->flash_deal_img);
        }

        
        $template->tags = implode('|',$request->tags);
       
        
        $template->meta_title = $request->meta_title;
        $template->meta_description = $request->meta_description;

        $template->meta_img = $request->previous_meta_img;
        if($request->hasFile('meta_img')){
            $imageName = getOnlyImageName($request->meta_img->getClientOriginalName()).'_'.time().'.'.$request->meta_img->extension();
                $imagefolderpath = 'uploads/products/meta/'.$imageName  ;
                $request->meta_img->move(public_path('uploads\products\meta'), $imageName);
            //$template->meta_img = $request->meta_img->store('uploads/products/meta');
            $template->meta_img = $imagefolderpath;
            //ImageOptimizer::optimize(base_path('public/').$template->meta_img);
        }

        

        //$template->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name));
        $template->slug = strtolower( str_replace(' ', '-', $request->name)  );

       
        //echo "<pre>";
        //print_r($template->variations);
       // die;
       // $template->variations = $variations_array;

        if($template->save()){
                return redirect()->route('templatecategories.admin')->with('success', 'Template Category has been updated successfully');
            
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
       $template = Template::findOrFail($actual_data['id']);

       $template = json_decode($template);
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

       return view('partials.templatecategories.more_options_edit', compact('request','actual_data', 'template','option','option_values'));
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

       return view('partials.more_options', compact('request','actual_data','option','option_values'));
    }

     public function slug_check(Request $request){
        $cnt = TC::where('slug', $request->slug_value)->count();
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
        $template = TC::findOrFail($request->id);
        $template->active = $request->status;
        if($template->save()){
            return 1;
        }
        return 0;
    }

    public function updatePublished(Request $request)
    {
        $template = Template::findOrFail($request->id);
        $template->published = $request->status;
        if($template->save()){
            return 1;
        }
        return 0;
    }

    public function updateFeatured(Request $request)
    {
        $template = Template::findOrFail($request->id);
        $template->featured = $request->status;
        if($template->save()){
            return 1;
        }
        return 0;
    }
}
