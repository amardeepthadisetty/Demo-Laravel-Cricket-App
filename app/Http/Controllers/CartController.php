<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SubSubCategory;
use App\Category;
use Session;
use App\Color;

class CartController extends Controller
{
    public function index(Request $request)
    {
        //dd($cart->all());
        $categories = Category::all();
        return view('desktop.frontend.view_cart', compact('categories'));
    }

    public function showCartModal(Request $request)
    {
        $product = Product::find($request->id);
        return view('desktop.frontend.partials.addToCart', compact('product'));
    }

    public function updateNavCart(Request $request)
    {
        return view('desktop.frontend.partials.cart');
    }

    public function validateProduct($product, $request){
        $errors = array();

        $template = '';
        $template_id = "0";
        if($request->has('template_id')){
            $template_id = $request['template_id'];
        }

        


        $more_settings = json_decode( json_encode( $product->more_settings ) );
        if ($more_settings->upload_settings->is_upload=="1") {
            //check if atleast one image is uploaded
            if ( trim($request->user_photos)=='' ) {
                  //$errors->push();
                  array_push($errors, array("idValue" => "upload_error", "message" => "Upload Required"));
            }
        }


        if(  $template_id != "0"){
            $template = \App\Template::where('ref',  $template_id )->first();

            $more_settings = json_decode( json_encode( $template->more_settings ) );
            if ($more_settings->upload_settings->is_upload=="1") {
                //check if atleast one image is uploaded
                if ( trim($request->user_photos)=='' ) {
                      //$errors->push();
                      array_push($errors, array("idValue" => "upload_error", "message" => "Upload Required"));
                }
            }
         }



        return $errors;


    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        $validateStatus = $this->validateProduct($product, $request);
        if ( !$validateStatus ) {

                $additional_options = array();
                $options = array();
                $data = array();
                $data['id'] = $product->id;
                $data['template_id'] = "0";
                $str = '';
                $tax = 0;
                $template = '';

                //check the color enabled or disabled for the product
                if($request->has('color')){
                    $data['color'] = $request['color'];
                    $str = Color::where('code', $request['color'])->first()->name;
                }

                
                if($request->has('template_id')){
                    $data['template_id'] = $request['template_id'];
                }

                if( $data['template_id'] != "0"){
                    $template = \App\Template::where('ref', $data['template_id'])->first();
                }

                //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
                foreach (json_decode(json_encode(Product::find($request->id)->choice_options)) as $key => $choice) {
                    $options[$choice->name] = $request[$choice->name];
                    if($str != null){
                        $str .= '-'.str_replace(' ', '', $request[$choice->name]);
                    }
                    else{
                        $str .= str_replace(' ', '', $request[$choice->name]);
                    }
                }

                //Check the string and decreases quantity for the stock
                if($str != null){
                    $str = strtolower($str);
                    $variations = json_decode(json_encode($product->variations));
                    $price = $variations->$str->price;
                    if($variations->$str->qty >= $request['quantity']){
                        // $variations->$str->qty -= $request['quantity'];
                        // $product->variations = json_encode($variations);
                        // $product->save();
                    }
                    else{
                        return view('desktop.frontend.partials.outOfStockCart');
                    }
                }
                else{
                    $price = $product->unit_price;
                }


                
                //advanced options
                if ( json_decode( json_encode($product->additional_options) ) ) {
                    $add_options = json_decode(json_encode($product->additional_options));
                    foreach($add_options as $opt){
                        switch (trim($opt->option_type)) {
                            case 'text':
                                $optioname = $opt->name;
                                $additional_options[$opt->name] = $request->$optioname;
                                break;
                            case 'textarea':
                                $optioname = $opt->name;
                                $additional_options[$opt->name] = $request->$optioname;
                                break;
                            case 'radio':
                            foreach($opt->options as $o){
                                    $concated_name = concat_string($opt->title, $o);
                                    if ($request->has($concated_name)) {
                                        $additional_options[$concated_name] = $request->$concated_name;
                                    }
                                }
                                break;
                            case 'checkbox':
                                foreach($opt->options as $o){
                                    $concated_name = concat_string($opt->title, $o);
                                    if ($request->has($concated_name)) {
                                        $additional_options[$concated_name] = $request->$concated_name;
                                        $additional_options_variations = json_decode( json_encode($product->additional_options_variations) );
                                        $price += ( float ) $additional_options_variations->$concated_name->price;
                                    }
                                }
                                break;            
                            
                            default:
                                # code...
                                break;
                        }
                    }
                }


                if( $data['template_id'] != "0"){
                    //template advance options
                    if ( json_decode( json_encode($template->additional_options) ) ) {
                        $add_options = json_decode(json_encode($template->additional_options));
                        foreach($add_options as $opt){
                            switch (trim($opt->option_type)) {
                                case 'text':
                                    $optioname = $opt->name;
                                    $additional_options[$opt->name] = $request->$optioname;
                                    break;
                                case 'textarea':
                                    $optioname = $opt->name;
                                    $additional_options[$opt->name] = $request->$optioname;
                                    break;
                                case 'radio':
                                foreach($opt->options as $o){
                                        $concated_name = concat_string($opt->title, $o);
                                        if ($request->has($concated_name)) {
                                            $additional_options[$concated_name] = $request->$concated_name;
                                        }
                                    }
                                    break;
                                case 'checkbox':
                                    foreach($opt->options as $o){
                                        $concated_name = concat_string($opt->title, $o);
                                        if ($request->has($concated_name)) {
                                            $additional_options[$concated_name] = $request->$concated_name;
                                            $additional_options_variations = json_decode( json_encode($template->additional_options_variations) );
                                            $price += ( float ) $additional_options_variations->$concated_name->price;
                                        }
                                    }
                                    break;            
                                
                                default:
                                    # code...
                                    break;
                            }
                        }
                    }
                }

                $uploaded_images = [];
                //more options
                if ( json_decode( json_encode($product->more_settings) )->upload_settings->is_upload == "1" ) {
                    if ( $request->has('user_photos') ) {
                    // var_dump( $request->user_photos );
                        if ( trim($request->user_photos)!='' ) {
                            //echo "\n user photos not empty \n";
                            $uploaded_images = explode(",", $request->user_photos );
                        }
                        
                    }
                    
                }

                if( $data['template_id'] != "0"){
                    //upload for template
                    if ( json_decode( json_encode($template->more_settings) )->upload_settings->is_upload == "1" ) {
                        if ( $request->has('user_photos') ) {
                        // var_dump( $request->user_photos );
                            if ( trim($request->user_photos)!='' ) {
                                //echo "\n user photos not empty \n";
                                $uploaded_images = explode(",", $request->user_photos );
                            }
                            
                        }
                        
                    }   
                }



                $instructions = '';
                //more options instructions
                if ( json_decode( json_encode($product->more_settings) )->instructions == "1" ) {
                    if ( $request->has('instructions') ) {
                        $instructions =  $request->instructions;
                    }
                    
                }


                $promotion = 'false';
                //more options promotion
                if ( json_decode( json_encode($product->more_settings) )->promotion_settings->is_promotion == "1" ) {
                    if ($request->has('promotion')) {
                        if ($request->promotion=="yes") {
                            $promotion = true;
                        }
                    
                    }
                    
                }

                //discount calculation based on flash deal and regular discount
                //calculation of taxes
                $flash_deal = \App\FlashDeal::where('status', '1')->first();
                if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                    $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                    if($flash_deal_product->discount_type == 'percent'){
                        $price -= ($price*$flash_deal_product->discount)/100;
                    }
                    elseif($flash_deal_product->discount_type == 'amount'){
                        $price -= $flash_deal_product->discount;
                    }
                }
                else{
                    if($product->discount_type == 'percent'){
                        $price -= ($price*$product->discount)/100;
                    }
                    elseif($product->discount_type == 'amount'){
                        $price -= $product->discount;
                    }
                }

                if($product->tax_type == 'percent'){
                    $tax = ($price*$product->tax)/100;
                    $price += $tax;
                }
                elseif($product->tax_type == 'amount'){
                    $tax = $product->tax;
                    $price += $tax;
                }


                if( $data['template_id'] != "0"){
                    $price += (float) $template->base_price;
                }

                $data['quantity'] = $request['quantity'];
                $data['price'] = $price;
                $data['calculated_price'] = $price;
                $data['tax'] = $tax;
                $data['shipping'] = 0;

                //$data['shipping_type'] = $product->shipping_type;

                // if($product->shipping_type == 'free'){
                //
                // }
                // else{
                //     $data['shipping'] = $product->shipping_cost;
                // }

                if($request->session()->has('cart')){
                    $cart = $request->session()->get('cart', collect([]));
                    $is_id_duplicate = false;
                    foreach($cart as $key=> $c){
                        if ($c['id'] == $request->id && $c['template_id'] == $request->template_id) {
                        $is_id_duplicate=true;
                        break;
                        }
                    }
                    
                    if ($is_id_duplicate) {
                        //modifying object
                        $cart = $cart->map(function ($object, $key) use ($request,$additional_options, $uploaded_images, $instructions, $promotion, $options, $price ) {
                            if($object['id'] == $request->id  && $object['template_id'] == $request->template_id ){
                                $object['options'] = $options;
                                $object['price'] = $price;
                                $object['quantity'] = $request->quantity;
                                $object['calculated_price'] =  $object['price'] * $request->quantity;
                                $object['additional_options'] = $additional_options;
                                $object['uploaded_images'] = $uploaded_images;
                                $object['instructions'] = $instructions;
                                $object['promotion'] = $promotion;
                                
                            }
                            return $object;
                        });
                        $request->session()->put('cart', $cart);


                    }else{
                        //pushing additional cart items
                        $data['additional_options'] = $additional_options;
                        $data['uploaded_images'] = $uploaded_images;
                        $data['instructions'] = $instructions;
                        $data['promotion'] = $promotion;
                        $data['options'] = $options;
                        $cart->push($data);
                    } 
                }
                else{
                    //first insert
                    $data['additional_options'] = $additional_options;
                    $data['uploaded_images'] = $uploaded_images;
                    $data['instructions'] = $instructions;
                    $data['promotion'] = $promotion;
                    $data['options'] = $options;
                    $cart = collect([$data]);
                    $request->session()->put('cart', $cart);
                }
                /* echo "<br><pre>";
                    print_r($cart);
                    echo "</pre>"; */
                //die;
                //return view('desktop.frontend.partials.addedToCart', compact('product', 'data'));
           return array('status'=>"success",'message' =>'Successfully added to cart', 'url' => route('cart') );
        }else{
            return array('status'=>"failure",'errors' => $validateStatus);
        }

        
        
        
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart', collect([]));
            $cart->forget($request->key);
            $request->session()->put('cart', $cart);
        }

        return view('desktop.frontend.partials.cart_details');;
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $cart = $request->session()->get('cart', collect([]));
        $cart = $cart->map(function ($object, $key) use ($request) {
            if($key == $request->key){
                $object['quantity'] = $request->quantity;
            }
            return $object;
        });
        $request->session()->put('cart', $cart);

        if (!empty( $request->ajax_request_from_delivery_info ) ) {
            $ajax_request_from_delivery_info = $request->ajax_request_from_delivery_info;
        }else{
            $ajax_request_from_delivery_info   = "false";
        }

        return view('desktop.frontend.partials.cart_details', compact('ajax_request_from_delivery_info'));
    }
}
