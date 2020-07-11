<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\FilterGroup as FG;
use App\FilterName as FN;
use App\Product;
use App\Template;
use Illuminate\Support\Str;
use App\ProductMysql;

class FilterGroupController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_templates()
    {
        $type = 'In House';
        $filtergroups = FG::where('active','1')->orderBy('created_at', 'desc')->get();

        //dd($products);
        return view('filtergroups.index', compact('filtergroups','type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_filtergroups_edit($id)
    {
        $fg = FG::findOrFail(decrypt($id));
       
        //$tags = json_decode($template->tags);
        //$categories = Category::all();
        //$template->more_settings = json_decode(json_encode($template->more_settings));
        //print_r($template->more_settings);
        //echo "<br> template is: ".$templates->more_settings->upload_settings->is_upload."<br>";
        return view('filtergroups.edit', compact('fg'));
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
        return view('filtergroups.create');
    }

    public function ajax_getFilterNames(Request $request){

        //echo $request->parent_id."\n";

        $filterSuggestion = $request->filter_name;

        $filterNames = FN::where('name','like','%'.$filterSuggestion.'%')->get();
        $data = array();
        if ($filterNames) {
          foreach ($filterNames as $f) {
            $fId = $f->ref;
            $filterGroup = FG::where('filters',$fId)->first();
            if ($filterGroup) {
               $result['name'] = $filterGroup->name.' >  '.$f->name;
               $result['id'] = $f->ref;
               array_push($data, $result);
            }
          
          }
        }
        
        //echo "<pre>";
        //print_r($result);

        echo json_encode($data);

        //dd($request);
    }


    

    public function ajax_geFGategories_formenu(Request $request){

        //echo $request->parent_id."\n";

        $categoryName = $request->parent_id_name;

        $categories = FG::where('name','like','%'.$categoryName.'%');

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

                  $secondLevel = FG::where('ref',$firstLevel->parent_id)->where('active','1')->first();
                  if ($secondLevel) {
                     $secondName = $secondLevel->name;

                      $thirdLevel = FG::where('ref',$secondLevel->parent_id)->where('active','1')->first();
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
	    	$filterGroup = new FG;
	        //$product->name = preg_replace('/[^A-Za-z0-9\-]/', '', $request->name);
        $filterGroup->name = $request->filter_group_name;
        $filterGroup->sort_order = $request->sort_order;
           
            
	      $filterGroup->nextid(); // auto-increment
	       // $product->user_id = Auth::user()->id;
        $filterGroup->slug = strtolower( str_replace(' ', '-', $request->filter_group_name)  );
	    

	      $filterGroup->active ="1";

        $filterNames = $request->filter_name;
        $filterSorts = $request->filter_sort;

        //echo "<pre>";
        //print_r($filterNames);
        //echo "<br>";
        //print_r($filterSorts);
        //echo "</pre>";
        $filterNameArray = [];
        if ($filterNames  ) {
          
          for ($i=0; $i < count( $filterNames ) ; $i++) {
            $fNameClass = new FN; 
            $filterName = $filterNames[$i];
            $filterSort = $filterSorts[$i];

            $fNameClass->name = $filterName;
            $fNameClass->sort = $filterSort;
            $filterNameArray[] = $fNameClass->nextid(); // auto-increment
            $fNameClass->slug = strtolower( str_replace(' ', '-', $filterName)  );

            $fNameClass->save();

          }
         // print_r($filterNameArray);
          //echo "<br>";
        }

        $filterGroup->filters = $filterNameArray;

        /*echo "filter groups have been created<br>";
        die;*/
         if($filterGroup->save()){

	        	//echo "saved <br>";
	            return redirect()->route('filtergroups.admin')->with('success','Filter group has been created successfully');
	        }
	        else{
	            flash(__('Something went wrong'))->error();
	            return back();
	        }
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
        $fg = FG::findOrFail($id);


        $fg->name = $request->filter_group_name;
        $fg->sort_order = $request->sort_order;
           
            
        $fg->nextid(); // auto-increment
         // $product->user_id = Auth::user()->id;
        $fg->slug = strtolower( str_replace(' ', '-', $request->filter_group_name)  );
      

        $fg->active ="1";

        $filterNames = $request->filter_name;
        $filterSorts = $request->filter_sort;

        //echo "<pre>";
        //print_r($filterNames);
        //echo "<br>";
        //print_r($filterSorts);
        //echo "</pre>";
        $filterNameArray = [];
        if ($filterNames  ) {
          
          for ($i=0; $i < count( $filterNames ) ; $i++) {
            $filterName = $filterNames[$i];
            $filterSort = $filterSorts[$i];
            //check if filter name already exists
            //if exists, then put the ref in array
            //if not , then create one
            $filterNameRecords = FN::where('name', $filterName)->get()->count();
            if ($filterNameRecords>0) {
              //filter name exists, so update it
              $record = FN::where('name', $filterName)->first();
              $record->name = $filterName;
              $record->sort = $filterSort;
              $filterNameArray[] = $record->ref; // auto-increment
              $record->slug = strtolower( str_replace(' ', '-', $filterName)  );
              $record->update();

              //echo "<br> record :".$filterName." has been updated<br>";

            }else{
              //record does not exists, so create one
              $fNameClass = new FN; 

              $fNameClass->name = $filterName;
              $fNameClass->sort = $filterSort;
              $filterNameArray[] = $fNameClass->nextid(); // auto-increment
              $fNameClass->slug = strtolower( str_replace(' ', '-', $filterName)  );

              $fNameClass->save();
              //echo "<br> record :".$filterName." has been created<br>";

            }

            

          }//for loop
         /* print_r($filterNameArray);
          echo "<br>";*/
        }//if condition

        $fg->filters = $filterNameArray;

       /* echo "filter groups have been updated<br>";
        die;*/
        
        $fg->slug = strtolower( str_replace(' ', '-', $request->filter_group_name)  );

       
        //echo "<pre>";
        //print_r($template->variations);
       // die;
       // $template->variations = $variations_array;

        if($fg->save()){
                return redirect()->route('filtergroups.admin')->with('success', 'Filter Group has been updated successfully');
            
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

       return view('partials.filtergroups.more_options_edit', compact('request','actual_data', 'template','option','option_values'));
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
        $cnt = FG::where('slug', $request->slug_value)->count();
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
        $template = FG::findOrFail($request->id);
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
