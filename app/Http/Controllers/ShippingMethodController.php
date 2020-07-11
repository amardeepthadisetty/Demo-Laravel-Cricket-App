<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Category;
//use App\SubCategory;
//use App\SubSubCategory;
//use App\FilterGroup as FG;
//use App\FilterName as FN;
use App\ShippingMethod as SM;
//use App\Template;
use Illuminate\Support\Str;
//use App\ProductMysql;

class ShippingMethodController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_templates()
    {
        $type = 'In House';
        $shipping_methods = SM::where('status','1')->orWhere('status','0')->orderBy('created_at', 'desc')->get();

        //dd($products);
        return view('shipping_methods.index', compact('shipping_methods','type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_shippingmethod_edit($id)
    {
        $sm = SM::findOrFail(decrypt($id));
       
        //$tags = json_decode($template->tags);
        //$categories = Category::all();
        //$template->more_settings = json_decode(json_encode($template->more_settings));
        //print_r($template->more_settings);
        //echo "<br> template is: ".$templates->more_settings->upload_settings->is_upload."<br>";
        return view('shipping_methods.edit', compact('sm'));
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
        return view('shipping_methods.create');
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


    

  


    

    public function store(Request $request){
	    	$sMethod = new SM;
	        //$product->name = preg_replace('/[^A-Za-z0-9\-]/', '', $request->name);
        $sMethod->name = $request->shipping_name;
        $sMethod->status = $request->status;
           
            
	      
         if($sMethod->save()){

	        	//echo "saved <br>";
	            return redirect()->route('shippingmethod.admin')->with('success','Shipping Method has been created successfully');
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
        $sm = SM::findOrFail($id);

        $sm->name = $request->shipping_name;
        $sm->status = $request->status;

        if($sm->update()){
                return redirect()->route('shippingmethod.admin')->with('success', 'Shipping Method has been updated successfully');
            
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
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
