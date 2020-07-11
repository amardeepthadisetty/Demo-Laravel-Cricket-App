<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\Product;
use App\Menu;
use Illuminate\Support\Str;
use App\ProductMysql;
use Image;

class MenuController extends Controller
{

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_products()
    {
        $type = 'Normal';
        $menu = Menu::where('ref','2')->firstorfail();
        $json_output = $menu->menu;

        //echo $json_output."<br>";

        $json = json_decode( $json_output );
        //print_r( $json );
        //echo "<br>";

        //dd($products);
        //return view('menu.index', compact('products','type'));
        return view('menu.edit', compact('json', 'menu'));
    }

    

    public function admin_template_products()
    {
        $type = 'Template';
        $products = Product::where('added_by', 'admin')->where('is_template','1')->orderBy('created_at', 'desc')->get();

        //dd($products);
        return view('products.index', compact('products','type'));
    }

   

    //

    public function create(){

        //echo "ah";die;
    	$categories = Category::all();
    	//dd($categories);
    	//$categories = [];
        return view('products.create', compact('categories'));
    }

    public function update(Request $request, $id ){
        
            $menu = Menu::where('ref',$id)->firstorfail();
	        $json_output = $request->JSON_output;

            $menu->menu = ( $json_output );
           

            /*echo "<pre>";
            print_r( json_encode( $json_output )  );
            die;*/

	        if($menu->save()){
	       
	            return redirect()->route('products.admin')->with('success','Menu has been inserted successfully');
	        }
	        else{
	            flash(__('Something went wrong'))->error();
	            return back();
	        }
    }

   

    

   
}
