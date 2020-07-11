<?php
 
namespace App\Http\Controllers;

use DB;
use Auth;
use Hash;
use Session;
use App\Shop;
use App\User;
use App\Brand;
use App\Product;
use App\Menu;
use App\Template;
use App\Category;
use App\UserImages;
use App\SubCategory;
use App\SubSubCategory;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\SearchController;
use Symfony\Component\Console\Input\Input;

class HomeController extends Controller
{
    public $agent;
    public function __construct(){
        $this->agent = new Agent();
    }

    public function cart_login(Request $request)
    {
        $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->first();
        if($user != null){
            updateCartSetup();
            if(Hash::check($request->password, $user->password)){
                if($request->has('remember')){
                    auth()->login($user, true);
                }
                else{
                    auth()->login($user, false);
                }
            }
        }
        return back();
    }


     /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard()
    {
        return view('dashboard');
    }

    public function login()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('desktop.frontend.user_login');
    }

    public function registration()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('desktop.frontend.user_registration');
    }
    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $files = scandir(base_path('public/uploads/categories'));
        // foreach($files as $file) {
        //     ImageOptimizer::optimize(base_path('public/uploads/categories/').$file);
        // }

        $categories = \App\TemplateCategories::where('parent_id','0')->where('active', '1')->get();

        
       

        //print_r($agent->isMobile());die;

        if($this->agent->isMobile()){
            echo "<h1>This is mobile screen, please load mobile view<h1>";
        }else{
            return view('desktop.frontend.index', compact('categories'));
        }
        
    }

    public function pull_filter_data_in_templates( Request $request ){

        $filter_output_array = json_decode( $request->filter_output_array );
        if ($filter_output_array) {
            $filterIDS_array = [];
            foreach ($filter_output_array as $foa) {
                //echo $foa->filter_group_name.'<br>';
                $fG = \App\FilterGroup::where('slug', $foa->filter_group_name)->first();
                if ( !empty($fG) ) {
                    $fNames = \App\FilterName::whereIn('ref',$fG->filters)->get();
                    if ( count($fNames)>0 ) {
                        foreach ($fNames as $fN) {
                            //echo "<br>".$fN->slug."<br>";
                            if ($fN->slug==$foa->filter_name) {
                                $filterIDS_array[] = $fN->ref;
                            }
                        }
                    }
                    
                }
                
                //echo "<br>after if <br>";die;
            }
        }
        
        
        $template = \App\Template::where('ref', $request->template_ref)->first();

        if ( !empty( $template->products ) ) {
            $products = \App\Product::whereIn('ref', $template->products)->where('is_template','1');
        }

        

        //print_r($filterIDS_array);
        if ( !empty( $filterIDS_array )  ) {
            $products = $products->whereIn('filters',$filterIDS_array);
            //$templates = $templates->whereIn('filters',$filterIDS_array);
        }

        $product_array = $products->get();
        //$templates = $templates->get();

        //dd($products);

        return view('desktop.frontend.partials.filter_template_products', compact('product_array','template'));
   }

    public function pull_filter_data( Request $request ){

        $filter_output_array = json_decode( $request->filter_output_array );
        if ($filter_output_array) {
            $filterIDS_array = [];
            foreach ($filter_output_array as $foa) {
                //echo $foa->filter_group_name.'<br>';
                $fG = \App\FilterGroup::where('slug', $foa->filter_group_name)->first();
                if ( !empty($fG) ) {
                    $fNames = \App\FilterName::whereIn('ref',$fG->filters)->get();
                    if ( count($fNames)>0 ) {
                        foreach ($fNames as $fN) {
                            //echo "<br>".$fN->slug."<br>";
                            if ($fN->slug==$foa->filter_name) {
                                $filterIDS_array[] = $fN->ref;
                            }
                        }
                    }
                    
                }
                
                //echo "<br>after if <br>";die;
            }
        }
        
        $products = \App\Product::where('categories', $request->category_ref)->where('is_template','0');
        $templates = \App\Template::where('categories', $request->category_ref);
        //print_r($filterIDS_array);
        if ( !empty( $filterIDS_array )  ) {
            $products = $products->whereIn('filters',$filterIDS_array);
            $templates = $templates->whereIn('filters',$filterIDS_array);
        }

        $products = $products->get();
        $templates = $templates->get();

        //dd($products);

        return view('desktop.frontend.partials.filter_products', compact('products','templates'));
   }

    public function categories( Request $request,$slug){

        //echo $slug;

        //echo '<br>';
        $filter_url =  $request->url();
        //echo $filter_url."<br>";
        $filter_slugs = get_FilterSlugs( $filter_url );

        $cat_url = '/category/'.$slug;

        $category = \App\TemplateCategories::where('slug', $slug)->firstorfail();

        $categories = \App\TemplateCategories::where('parent_id', $category->ref)->get();

        $templates = \App\Template::where('categories', $category->ref)->get();

        $products = \App\Product::where('categories', $category->ref)->where('is_template','0')->get();

       
       $filterName_IDS = array();

       //if products exists then, collect all filter names
        if ( $products ) {
           foreach ($products as $product) {
               if (  !empty( $product->filters )  ) {
                    foreach ($product->filters as $filterID) {
                       array_push( $filterName_IDS, $filterID);
                    }
                    
               }
           }
        }

        //if templates exists then, collect all filter names
        if ( $templates ) {
           foreach ($templates as $template) {
               if (  !empty( $template->filters )  ) {
                    foreach ($template->filters as $filterID) {
                       array_push( $filterName_IDS, $filterID);
                    }
                    
               }
           }
        }

        $filter_output_array = getAllFilterNames_n_FilterGroupsInAnArray($filterName_IDS);
        /*echo "<br>";
        echo "<pre>";
        print_r( $filter_output_array );
        echo "</pre>";*/

        return view('desktop.frontend.categories_listing', compact('category', 'categories', 'templates','products','filter_output_array', 'cat_url', 'filter_slugs'));

    }

    public function categories_with_filter( Request $request){

        echo "this is filter options";die;
    }

    public function templates( Request $request,$slug){
        $filterName_IDS = array();
        $temp_url = '/template/'.$slug;

        $template = \App\Template::where('slug', $slug)->firstorfail();

        $product_ids = $template->products;

        if (  !empty( $template->filters )  ) {
            foreach ($template->filters as $filterID) {
               array_push( $filterName_IDS, $filterID);
            }
            
        }
       
        
        $product_array = [];
        if ($product_ids) {
            foreach ($product_ids as $pid) {
                //echo $pid."<br>";
                $p = Product::where('ref',$pid)->first();
                if (  !empty( $p->filters )  ) {
                    foreach ($p->filters as $filterID) {
                       array_push( $filterName_IDS, $filterID);
                    }
                    
               }
                array_push($product_array, $p);
            }
        }

        $filter_url =  $request->url();
        //echo $filter_url."<br>";
        $filter_slugs = get_FilterSlugs( $filter_url );

        $filter_output_array = getAllFilterNames_n_FilterGroupsInAnArray($filterName_IDS);
        return view('desktop.frontend.template_product_listing', compact('template','product_array','temp_url','filter_output_array','filter_slugs'));

    }


    public function template_product( Request $request,$tmpslug, $prodslug){

        //echo $prodslug;

        $product  = Product::where('slug', $prodslug)->firstorfail();

        $related_products = array();
        //print_r( $product->related_products );
        if ( !empty( $product->related_products ) ) {
            if (count( $product->related_products )>0) {
                $related_products  = Product::whereIn('ref', $product->related_products)->where('is_template','0')->get();
                }
        }


        $template  = Template::where('slug', $tmpslug)->firstorfail();

        $product_ids = $template->products;
        $product_array = [];
        if ($product_ids) {
            foreach ($product_ids as $pid) {
                //echo $pid."<br>";
                $p = Product::where('ref',$pid)->first();
                
                array_push($product_array, $p);
            }
        }

        $sesArray = [];
        if($product!=null && $template!=null){
            //updateCartSetup();
            if ($request->session()->has('cart')) {
                //echo "session is set<Br>";
                 $sessionValues = $request->session()->get('cart');
                 //echo "<pre>";
                 foreach($sessionValues as $cart){
                    //echo "<br> cart id is: ".$cart['id']."<br>";
                    if ($product->_id==$cart['id']) {
                        $sesArray = $cart;
                        //break;
                    }
                    //print_r($cart);
                 }
                /*  echo "<pre>";
                 print_r($sesArray);
                 echo "</pre>"; */
                 //echo "</pre>";
            } else{
                //echo "no session set";
            } 
            return view('desktop.frontend.template_product_details', compact('product','template','sesArray','related_products', 'product_array'));
        }
        abort(404);

        

    }

    public function all_categories(Request $request)
    {
        $categories = Category::all();

         if($this->agent->isMobile()){
            echo "<h1>This is mobile screen, please load mobile view<h1>";
        }else{
            return view('desktop.frontend.all_category', compact('categories'));
        }
        
    }


    public function ajax_search(Request $request)
    {
        $keywords = array();
        $products = Product::where('published', '1')->where('tags', 'like', '%'.$request->search.'%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',',$product->tags) as $key => $tag) {
                if(stripos($tag, $request->search) !== false){
                    if(sizeof($keywords) > 5){
                        break;
                    }
                    else{
                        if(!in_array(strtolower($tag), $keywords)){
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }
 
        $products = filter_products(Product::where('published', '1')->where('name', 'like', '%'.$request->search.'%'))->get()->take(3);

        $subsubcategories = SubSubCategory::where('name', 'like', '%'.$request->search.'%')->get()->take(3);

        $shops = Shop::where('name', 'like', '%'.$request->search.'%')->get()->take(3);

        if(sizeof($keywords)>0 || sizeof($subsubcategories)>0 || sizeof($products)>0 || sizeof($shops) >0){
            return view('desktop.frontend.partials.search_content', compact('products', 'subsubcategories', 'keywords', 'shops'));
        }
        return '0';
    }

    public function product(Request $request,$slug)
    {
        $product  = Product::where('slug', $slug)->first();
        //echo ."<br>";
        $related_products = array();
        //print_r( $product->related_products );
        if ( !empty( $product->related_products ) ) {
            if (count( $product->related_products )>0) {
                $related_products  = Product::whereIn('ref', $product->related_products)->where('is_template','0')->get();
                }
        }

        $sesArray = [];
        if($product!=null){
            updateCartSetup();
            if ($request->session()->has('cart')) {
                //echo "session is set<Br>";
                 $sessionValues = $request->session()->get('cart');
                 //echo "<pre>";
                 foreach($sessionValues as $cart){
                    //echo "<br> cart id is: ".$cart['id']."<br>";
                    if ($product->_id==$cart['id']) {
                        $sesArray = $cart;
                        //break;
                    }
                    //print_r($cart);
                 }
                /*  echo "<pre>";
                 print_r($sesArray);
                 echo "</pre>"; */
                 //echo "</pre>";
            } else{
                //echo "no session set";
            } 
            return view('desktop.frontend.product_details', compact('product','sesArray', 'related_products'));
        }
        abort(404);
    }

    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if(Auth::user()->user_type == 'seller'){
            return view('desktop.frontend.seller.dashboard');
        }
        elseif(Auth::user()->user_type == 'customer'){
            $addresses = \App\Address::where('user_id', Auth::user()->id)->where('default_address','1')->first();
            return view('desktop.frontend.customer.dashboard', ['addr' => $addresses ] );
        }
        else {
            abort(404);
        }
    }


    public function profile(Request $request)
    {
        if(Auth::user()->user_type == 'customer'){
            return view('desktop.frontend.customer.profile');
        }
        elseif(Auth::user()->user_type == 'seller'){
            return view('desktop.frontend.seller.profile');
        }
    }

    public function customer_update_profile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }

        if($request->hasFile('photo')){
            $user->avatar_original = $request->photo->store('uploads/users');
        }

        if($user->save()){
            //flash(__('Your Profile has been updated successfully!'))->success();
            Session::flash('success','Your Profile has been updated successfully!');
            return back();
        }

        //flash(__('Sorry! Something went wrong.'))->error();
        Session::flash('error','Sorry! Something went wrong.');
        return back();
    }


    public function seller_update_profile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }

        if($request->hasFile('photo')){
            $user->avatar_original = $request->photo->store('uploads');
        }

        $seller = $user->seller;
        $seller->cash_on_delivery_status = $request->cash_on_delivery_status;
        $seller->sslcommerz_status = $request->sslcommerz_status;
        $seller->ssl_store_id = $request->ssl_store_id;
        $seller->ssl_password = $request->ssl_password;
        $seller->paypal_status = $request->paypal_status;
        $seller->paypal_client_id = $request->paypal_client_id;
        $seller->paypal_client_secret = $request->paypal_client_secret;
        $seller->stripe_status = $request->stripe_status;
        $seller->stripe_key = $request->stripe_key;
        $seller->stripe_secret = $request->stripe_secret;
        $seller->instamojo_status = $request->instamojo_status;
        $seller->instamojo_api_key = $request->instamojo_api_key;
        $seller->instamojo_token = $request->instamojo_token;
        $seller->razorpay_status = $request->razorpay_status;
        $seller->razorpay_api_key = $request->razorpay_api_key;
        $seller->razorpay_secret = $request->razorpay_secret;
        $seller->paystack_status = $request->paystack_status;
        $seller->paystack_public_key = $request->paystack_public_key;
        $seller->paystack_secret_key = $request->paystack_secret_key;
        $seller->voguepay_status = $request->voguepay_status;
        $seller->voguepay_merchand_id = $request->voguepay_merchand_id;

        if($user->save() && $seller->save()){
            flash(__('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function file_upload(Request $request){
        //echo "<pre>";
        //print_r(Input::get('upload'));
        $file = $request->file('fileupload');
       // print_r(($file));
        $photos = array();
        if ($request->hasFile('fileupload')) {
                $imageRules = array(
                    'file' => 'image|mimes:jpeg,png|max:12000',
                    
                );
           foreach ($request->fileupload as $key => $photo) {
               $file = array('file' => $photo);

               $imageValidator = Validator::make($file, $imageRules);
               $messages = '';
                if ($imageValidator->fails()) {
                     $messages = $imageValidator->messages();
                    }else{
                    /*$imageName = getOnlyImageName($photo->getClientOriginalName()).'_'.time().'.'.$photo->extension();
                    $imagefolderpath = 'uploads/user_uploaded_images/new'.$imageName  ;
                    $path = $photo->move(public_path('uploads\user_uploaded_images\new'), $imageName);
                    array_push($photos, $imageName);*/

                    $imageName = getOnlyImageName($photo->getClientOriginalName()).'.'.$photo->extension();
                    //for thumbnail
                    generateThumbnails( $photo->path() , public_path('uploads/user_uploaded_images/new/thumbnail'), $imageName, 'thumbnail'  );
                    //for icon
                    generateThumbnails( $photo->path() , public_path('uploads/user_uploaded_images/new/icon'), $imageName, 'icon'  );
                        


                    $pathToSave = 'uploads/user_uploaded_images/new/original/';
                    $imagefolderpath = $pathToSave.$imageName  ;
                    $path = $photo->move(public_path( $pathToSave ), $imageName);
                    array_push($photos, $imagefolderpath);

                    //insert image
                    $im = new UserImages();
                    $im->nextid();
                    $im->image_name = $imageName;
                    $im->product_id = $request->product_id;
                    $im->save();
                }

              
            }
        }
        
        if ($messages=='') {
           return response()->json(['status'=>'Success', 'messages' => $messages, 'photos' => $photos]);
        }else{
             return response()->json(['status'=>'Failure', 'messages' => $messages, 'photos' => $photos]);
        }

        
    }

    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = ''; 
        $quantity = 0;
        $template = '';

        if( $request['template_id'] != "0"){
           $template = \App\Template::where('ref', $request['template_id'])->first();
        }


        
        if ($product->is_variant=="1") {
            if($request->has('color')){
                $data['color'] = $request['color'];
                $str = Color::where('code', $request['color'])->first()->name;
            }

            foreach (json_decode(json_encode($product->choice_options)) as $key => $choice) {
                if($str != null){
                    $str .= '-'.str_replace(' ', '', $request[$choice->name]);
                }
                else{
                    $str .= str_replace(' ', '', $request[$choice->name]);
                }
            }
            $str = strtolower($str);

             if($str != null){
                    $price = json_decode(json_encode($product->variations))->$str->price;
                }   $quantity = json_decode(json_encode($product->variations))->$str->qty;
        }else{
            $price = $product->unit_price;
            $quantity = $product->current_stock;
        }


        //additional options
        if ( json_decode(json_encode($product->additional_options))  ) {
            foreach( json_decode(json_encode($product->additional_options)) as $aopt){
                //echo $aopt->name."<br>";
                foreach($aopt->options as $opt){
                    //echo $opt."\n";
                    $concated_name = concat_string($aopt->title, $opt);
                   // echo "\n\nrequest is: ";
                    
                    if ($request->has($concated_name)) {
                       //echo $request->$concated_name."\n\n\n";
                       $additional_options_variations = json_decode( json_encode($product->additional_options_variations) );
                       $price += ( float ) $additional_options_variations->$concated_name->price;

                    }
                    

                }
            }
            
        }

        if( $request['template_id'] != "0"){
            //additional options
            if ( json_decode(json_encode($template->additional_options))  ) {
                foreach( json_decode(json_encode($template->additional_options)) as $aopt){
                    //echo $aopt->name."<br>";
                    foreach($aopt->options as $opt){
                        //echo $opt."\n";
                        $concated_name = concat_string($aopt->title, $opt);
                       // echo "\n\nrequest is: ";
                        
                        if ($request->has($concated_name)) {
                           //echo $request->$concated_name."\n\n\n";
                           $additional_options_variations = json_decode( json_encode($template->additional_options_variations) );
                           $price += ( float ) $additional_options_variations->$concated_name->price;

                        }
                        

                    }
                }
                
            }
        }


        if( $request['template_id'] != "0"){
            $price += (float) $template->base_price;
        }
        
        //add tax to the price
        if ($product->tax_type=="amount") {
           $price += $product->tax;
        }else{
            $price += ($price*$product->tax)/100;
        }


        //apply discount as well
        if ($product->discount_type=="amount") {
           $price -= $product->discount;
        }else{
            $price -= ($price*$product->discount)/100;
        }
        

        //discount calculation
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
            $price += ($price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $price += $product->tax;
        }

        /* echo "<pre>str is: ";
        print_r($price);
        echo "<br>";
        print_r($quantity);
        
        echo "</pre>";
        die; */
        return array('price' => single_price($price*$request->quantity), 'quantity' => $quantity);
    }

    public function search_post( Request $request ){

        //echo "<br>this is search post request is: ".$request->q."<br>";die;



        return redirect()->route('suggestion.search', ['q' => $request->q ])->withCookie('search_type', $request->search_type,50000);
    }

    public function search(Request $request, $slug)
    {
        //echo "searc type is: ".request()->cookie('search_type')."<br>";
        //echo "<br>search request is: ".$request->q."<br>";die;

        $query = $request->q;
        $templates = '';
        $products = '';
       

        //$conditions = ['published' => '1', 'published' => '0'];
        $conditions = [];

        $search_type = request()->cookie('search_type');
        if ( $search_type == "template_products") {
            //write search for template products
            $templates = Template::where($conditions);
            if($query != null){
                $searchController = new SearchController;
                $searchController->store($request);
                $templates = $templates->where('tags','like', '%'.$query.'%');
                $templates = $templates->orWhere('name','like', '%'.$query.'%');
            }

            //$products = filter_products($products)->paginate(12)->appends(request()->query());
            $templates = $templates->paginate(12)->appends(request()->query());

        }else if( $search_type == "normal_products" ){
            //this is for normal products
            $products = Product::where($conditions);

            if($query != null){
                $searchController = new SearchController;
                $searchController->store($request);
                $products = $products->where('tags','like', '%'.$query.'%');
                $products = $products->orWhere('name','like', '%'.$query.'%');
                //$products = $products->where('name','=',$query)->orwhere('name','regexp','/.*'.$query.'/');
               
            }

            //$products = filter_products($products)->paginate(12)->appends(request()->query());
            $products = $products->paginate(12)->appends(request()->query());

        }else{

            $templates = Template::where($conditions);
            $products = Product::where($conditions);
            if($query != null){
                $searchController = new SearchController;
                $searchController->store($request);
                $templates = $templates->where('tags','like', '%'.$query.'%');
                $templates = $templates->orWhere('name','like', '%'.$query.'%');

                $products = $products->where('tags','like', '%'.$query.'%');
                $products = $products->orWhere('name','like', '%'.$query.'%');
            }

            //$products = filter_products($products)->paginate(12)->appends(request()->query());
            $templates = $templates->paginate(12)->appends(request()->query());

            $products = $products->paginate(12)->appends(request()->query());

        }

        $filter_url =  $request->url();
        //echo $filter_url."<br>";
        $filter_slugs = get_FilterSlugs( $filter_url );

        $filterName_IDS = array();
        //if products exists then, collect all filter names
        if ( $products ) {
           foreach ($products as $product) {
               if (  !empty( $product->filters )  ) {
                    foreach ($product->filters as $filterID) {
                       array_push( $filterName_IDS, $filterID);
                    }
                    
               }
           }
        }

        //if templates exists then, collect all filter names
        if ( $templates ) {
           foreach ($templates as $template) {
               if (  !empty( $template->filters )  ) {
                    foreach ($template->filters as $filterID) {
                       array_push( $filterName_IDS, $filterID);
                    }
                    
               }
           }
        }

        $filter_output_array = getAllFilterNames_n_FilterGroupsInAnArray($filterName_IDS);
        $search_url = '/search/'.$slug;
         
        //dd( $products );

        return view('desktop.frontend.product_listing', compact('products', 'query', 'category_id', 'subcategory_id', 'subsubcategory_id', 'brand_id', 'sort_by', 'seller_id','min_price', 'max_price', 'search_type','templates','filter_output_array','filter_slugs','search_url'));
    }

    public function pull_search_filter_data( Request $request ){
        $query = $request->search_param;
        $products = [];
        $templates = [];
        $filter_output_array = json_decode( $request->filter_output_array );
        if ($filter_output_array) {
            $filterIDS_array = [];
            foreach ($filter_output_array as $foa) {
                //echo $foa->filter_group_name.'<br>';
                $fG = \App\FilterGroup::where('slug', $foa->filter_group_name)->first();
                if ( !empty($fG) ) {
                    $fNames = \App\FilterName::whereIn('ref',$fG->filters)->get();
                    if ( count($fNames)>0 ) {
                        foreach ($fNames as $fN) {
                            //echo "<br>".$fN->slug."<br>";
                            if ($fN->slug==$foa->filter_name) {
                                $filterIDS_array[] = $fN->ref;
                            }
                        }
                    }
                    
                }
                
                //echo "<br>after if <br>";die;
            }
        }
        

        $conditions = [];
        $search_type = request()->cookie('search_type');
        if ( $search_type == "template_products") {
            //write search for template products
            $templates = Template::where($conditions);
            if($query != null){
                $searchController = new SearchController;
                $searchController->store($request);
                $templates = $templates->where('tags','like', '%'.$query.'%');
                $templates = $templates->orWhere('name','like', '%'.$query.'%');
            }

            

        }else if( $search_type == "normal_products" ){
            //this is for normal products
            $products = Product::where($conditions);

            if($query != null){
                $searchController = new SearchController;
                $searchController->store($request);
                $products = $products->where('tags','like', '%'.$query.'%');
                $products = $products->orWhere('name','like', '%'.$query.'%');
                //$products = $products->where('name','=',$query)->orwhere('name','regexp','/.*'.$query.'/');
               
            }


        }else{

            $templates = Template::where($conditions);
            $products = Product::where($conditions);
            if($query != null){
                $searchController = new SearchController;
                $searchController->store($request);
                $templates = $templates->where('tags','like', '%'.$query.'%');
                $templates = $templates->orWhere('name','like', '%'.$query.'%');

                $products = $products->where('tags','like', '%'.$query.'%');
                $products = $products->orWhere('name','like', '%'.$query.'%');
            }

            

        }
        //print_r($filterIDS_array);
        if ( !empty( $filterIDS_array )  ) {
            $products = $products->whereIn('filters',$filterIDS_array);
            $templates = $templates->whereIn('filters',$filterIDS_array);
        }

        if ($products) {
            $products = $products->get();
        }

        if ( $templates ) {
             $templates = $templates->get();
        }
        
       

        //dd($products);

        return view('desktop.frontend.partials.filter_products', compact('products','templates'));
   }


     public function listing(Request $request)
    {
        $products = filter_products(Product::orderBy('created_at', 'desc'))->paginate(12);
        return view('desktop.frontend.product_listing', compact('products'));
    }
}
