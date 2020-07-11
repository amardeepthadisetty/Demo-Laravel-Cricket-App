<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Category;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\CashFreeController;
use App\Http\Controllers\InstamojoController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PublicSslCommerzPaymentController;
use App\Http\Controllers\OrderController;
use App\Order;
use App\OrderPayments;
use App\PaymentHistory;
use App\BusinessSetting;
use App\Coupon;
use App\CouponUsage;
use Session;
use CashFree;
use DB;

class CheckoutController extends Controller
{

    public function __construct()
    {
        //
    }

    //check the selected payment gateway and redirect to that controller accordingly
   /*  public function checkout(Request $request)
    {

       
        $orderController = new OrderController;
        $orderController->store($request);

        $request->session()->put('payment_type', 'cart_payment');


        if($request->session()->get('order_id') != null){
            if($request->payment_option == 'paypal'){
                $paypal = new PaypalController;
                return $paypal->getCheckout();
            }
            elseif ($request->payment_option == 'cash_free') {
                $cashfreereference = new CashFreeController;
                return $cashfreereference->getCheckout();
            }
            elseif ($request->payment_option == 'stripe') {
                $stripe = new StripePaymentController;
                return $stripe->stripe();
            }
            elseif ($request->payment_option == 'sslcommerz') {
                $sslcommerz = new PublicSslCommerzPaymentController;
                return $sslcommerz->index($request);
            }
            elseif ($request->payment_option == 'instamojo') {
                $instamojo = new InstamojoController;
                return $instamojo->pay($request);
            }
            elseif ($request->payment_option == 'razorpay') {
                $razorpay = new RazorpayController;
                return $razorpay->payWithRazorpay($request);
            }
            elseif ($request->payment_option == 'paystack') {
                $paystack = new PaystackController;
                return $paystack->redirectToGateway($request);
            }
            elseif ($request->payment_option == 'voguepay') {
                $voguePay = new VoguePayController;
                return $voguePay->customer_showForm();
            }
            elseif ($request->payment_option == 'cash_on_delivery') {
                $order = Order::findOrFail($request->session()->get('order_id'));
                $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                foreach ($order->orderDetails as $key => $orderDetail) {
                    if($orderDetail->product->user->user_type == 'seller'){
                        $seller = $orderDetail->product->user->seller;
                        $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price*$commission_percentage)/100;
                        $seller->save();
                    }
                }

                $request->session()->put('cart', collect([]));
                $request->session()->forget('order_id');
                $request->session()->forget('delivery_info');
                $request->session()->forget('coupon_id');
                $request->session()->forget('coupon_discount');

                flash("Your order has been placed successfully")->success();
            	return redirect()->route('home');
            }
            elseif ($request->payment_option == 'wallet') {
                $user = Auth::user();
                $user->balance -= Order::findOrFail($request->session()->get('order_id'))->grand_total;
                $user->save();
                return $this->checkout_done($request->session()->get('order_id'), null);
            }
        }
    } */

    //redirects to this method after a successfull checkout
    public function checkout_done($order_id, $payment)
    {
        //echo "<br>before echoing session flash <Br>".$order_id;die;
        $order = Order::findOrFail($order_id);
        $purchaseHistory = PaymentHistory::findOrFail(Session::get('purchase_history_id'));
        $orderPayments = OrderPayments::findOrFail(Session::get('order_payments_id'));

        
        

        /*$purchaseHistoryArray = array(
            'order_id' => $order_id,
            'user_id' => ( Auth::user() ) ? Auth::user()->id : '0',
            'payment_type' => Session::get('payment_option'),
            'payment_request' => Session::get('payment_request'),
            'payment_res' => json_encode(  $payment ),
            'total_amount' =>  $order->grand_total,
        );*/

        $purchaseHistory->payment_res =json_encode(  $payment );

        $commentsArray = array(
            'order_id' => $order_id,
            'user_id' => ( Auth::user() ) ? Auth::user()->id : '0',
            'show_user' => 1,
            'other' => '',
        );
        if ( $payment['txStatus']=="SUCCESS" ) {
            $order->payment_status = 'paid';
            if ($order->delivery_type=="fill_later") {
                $order->payment_status = 'partially_paid';
            }
            //$purchaseHistoryArray['status']  = 'success';
            $purchaseHistory->status = 'success';
            $commentsArray['comments']  = 'You have paid the payment of the order, pertaining amount '.single_price($order->grand_total).' successfully';

            //update purchaseHistory id in OrderPayments table
            $orderPayments->payment_id = $purchaseHistory->id;
            
            
        }else{
            
            $order->payment_status = 'failed';
            $purchaseHistory->status = 'failed';
            $commentsArray['comments']  = 'Your payment of this order, pertaining amount '.single_price($order->grand_total).' has failed due to unknown reasons';
        }

        //call PurchaseHistory
       // $purchaseHistory = new PurchaseHistoryController;
       // $purchaseHistory->savePurchaseHistoryDetails($purchaseHistoryArray);

        //call Comment Section
        $commentSection = new CommentController;
        $commentSection->saveCommentDetails($commentsArray);
        
        $order->payment_details = json_encode(  $payment );
        $order->payment_response = json_encode(  $payment );
        if (Session::get('coupon_discount')) {
             $order->coupon_code = Coupon::where('id', Session::get('coupon_id') )->first()->code;
        }
        $order->save();
        $purchaseHistory->update();
        $orderPayments->update();
        
        $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
        
        foreach ($order->orderDetails as $key => $orderDetail) {
            if ( $payment['txStatus']=="SUCCESS" ) {
                $orderDetail->payment_status = 'paid';
            }else{
                $orderDetail->payment_status = 'failed';
            }
            $orderDetail->save();

            $p_id = $orderDetail->product_id;
            
            $product = \App\Product::where('ref', (string) $p_id)->first();
            //echo "p_id is: ".$p_id."<br>";
            //echo "user id is: ".$product->user_id."<br>";
            
            $user_id = $product->user_id;
            
            $user = \App\User::where('id', $user_id )->first();
            
            if( $user->user_type == 'seller'){
                $seller = $product->user->seller;
                $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price*(100-$commission_percentage))/100;
                $seller->save();
            }
        }
        
         if ( $payment['txStatus']=="SUCCESS" ) {
            Session::put('cart', collect([]));
            Session::forget('order_id');


            Session::forget('purchase_history_id');
            Session::forget('order_payments_id');


            Session::forget('payment_type');
            Session::forget('payment_option');
            Session::forget('delivery_info');
            Session::forget('coupon_id');
            Session::forget('coupon_discount'); 
            Session::forget('gst'); 
            Session::forget('t_n_c'); 
            Session::forget('payment_request'); 
            Session::forget('shipping_method'); 
            Session::forget('location_addr'); 
            Session::forget('shipping_info'); 
            Session::forget('fill_later'); 
         }
        //flash(__('Payment completed'))->success();
        //$request->session()->flash('success', 'Payment completed');
        //Session::flash('success', 'Payment completed'); 
        //return redirect()->route('home');
        //retreive the order info again.
        

        //echo "<br> ord eri is: <br>";
        //$url = 'orderstatus/'.encrypt($order_id)."<br>";
       // echo "all session cleared";
       // die;

        return redirect()->route('order.status', ['orderid' => encrypt($order_id)]);

       
    }


     public function ship_cost_checkout_done($order_id, $payment)
    {
        //echo "<br>before echoing session flash <Br>".$order_id;die;
        $fill_later = \App\FillLater::findOrFail($order_id);
        $order = Order::findOrFail($fill_later->order_id);
        $purchaseHistory = PaymentHistory::findOrFail(Session::get('purchase_history_id'));
        $orderPayments = OrderPayments::findOrFail(Session::get('order_payments_id'));

        $purchaseHistory->payment_res =json_encode(  $payment );

        $commentsArray = array(
            'order_id' => $fill_later->order_id,
            'user_id' => ( Auth::user() ) ? Auth::user()->id : '0',
            'show_user' => 1,
            'other' => '',
        );
        if ( $payment['txStatus']=="SUCCESS" ) {
            $order->payment_status = 'paid';
            $fill_later->payment_status = 'paid';
            if (Session::get('delivery_type')=="fill_later") {
                $order->payment_status = 'partially_paid';
            }


            //make it empty, since user has come this long way ,and paid shipping cost for door delivery.
            $order->delivery_type = '';
            $purchaseHistory->status = 'success';
            $commentsArray['comments']  = 'You have paid the payment for shipping cost of '.single_price($fill_later->shipping_cost).' successfully';

            //save order info, as the transaction is success : 
           // $order = Order::where('id',Session::get('OrderID'))->first();
            $order->shipping_address = json_encode(Session::get('shipping_info'));
            $order->delivery_method = ( !empty( Session::get('shipping_method_id') ) ) ? Session::get('shipping_method_id') : '0';


            $order->shipping_cost = $fill_later->shipping_cost;
            $order->shipping_status = 3;

            $grandTotal = ( float ) $order->grand_total + (float) $fill_later->shipping_cost;
            $order->grand_total = $grandTotal;
            //update purchaseHistory id in OrderPayments table
            $orderPayments->payment_id = $purchaseHistory->id;
            
            
            
        }else{
            $purchaseHistory->status = 'failed';
            $order->payment_status = 'failed';
            $fill_later->payment_status = 'failed';
            $commentsArray['comments']  = 'Your payment for the shipping cost pertaining to this order,  '.single_price($fill_later->shipping_cost).' has failed due to unknown reasons';
        }

        //call PurchaseHistory
        //$purchaseHistory = new PurchaseHistoryController;
        //$purchaseHistory->savePurchaseHistoryDetails($purchaseHistoryArray);

        //call Comment Section
        $commentSection = new CommentController;
        $commentSection->saveCommentDetails($commentsArray);
        
        
        $fill_later->payment_response = json_encode(  $payment );
        if (Session::get('coupon_discount')) {
             $order->coupon_code = Coupon::where('id', Session::get('coupon_id') )->first()->code;
        }
        $fill_later->update();
        $order->update();
        $purchaseHistory->update();
        $orderPayments->update();
        
        
        $msg = '';
         if ( $payment['txStatus']=="SUCCESS" ) {
            Session::put('cart', collect([]));
            Session::forget('OrderID');
            Session::forget('shipping_method_id'); 
            Session::forget('delivery_type'); 


            Session::forget('order_id');
            Session::forget('purchase_history_id');
            Session::forget('order_payments_id');

            Session::forget('payment_type');
            Session::forget('payment_request');
            Session::forget('payment_option');
            Session::forget('delivery_info');
            Session::forget('coupon_id');
            Session::forget('coupon_discount'); 
            Session::forget('gst'); 
            Session::forget('t_n_c'); 
            Session::forget('shipping_method'); 
            
            Session::forget('location_addr'); 
            Session::forget('shipping_info'); 
            Session::forget('fill_later'); 
            $msg = 'Shipping payment has been done successfully';

         }else{
            $msg = 'Something went wrong with the shipping Payment. You can try again, later.';
         }
        

        //return redirect()->route('order.status', ['orderid' => encrypt($order_id)]);

        //redirect to respective Order ID details page.
        return redirect()->route('purchase_history.order_details.orderid', $fill_later->order_id)->with('message', $msg);

       
    }


    public function order_status($order_id){
        $order = Order::findOrFail( decrypt($order_id) );

        //echo "order is: ". decrypt($order_id);

        $payment = json_decode( $order->payment_response, true);
        return view('desktop.frontend.order_status', compact('payment', 'order'));
    }

    public function get_shipping_info(Request $request)
    {
        //echo "this is it";die;
        if(Session::has('cart') && count(Session::get('cart')) > 0){
            $categories = Category::all();

            $redirection = $this->checkForRedirection();

            if ($redirection=="true") {
               return redirect()->route('checkout.delivery_info_view');
            }else{
                //return redirect()->route('checkout.shipping_info');
                return view('desktop.frontend.shipping_info', compact('categories'));
            }


            //
        }
        //flash(__('Your cart is empty'))->success();
        $request->session()->flash('success', 'Your cart is empty');
        return back();
    }


    /*

    This method is used to check if selected option has 'soft copy'.
    If Yes, then no need of taking shipping info , directly redirect to delivery info page.
    This method will work, if multiple orders added to cart too.

    If no, then normal flow
    */
    public function checkForRedirection(){
        //redirect to delivery info by default
        //condition like if the name doesn't have soft copy
        $redirection = "true";
        foreach (Session::get('cart') as $key => $cartItem){
            $product = \App\Product::find($cartItem['id']);
            $product_name_with_choice = $product->name;
            if(isset($cartItem['color'])){
                $product_name_with_choice .= ' - '.\App\Color::where('code', $cartItem['color'])->first()->name;
            }
            foreach (json_decode( json_encode($product->choice_options) ) as $choice){
                $str = $choice->name; // example $str =  choice_0
                $product_name_with_choice .= ' - '.$cartItem['options'][$str];
            }

            //echo strtolower($product_name_with_choice)."<br>";
            if ( (strpos(strtolower($product_name_with_choice), 'soft copy') !== false ) ) {
                   // echo '<br>soft copy found';
                    
                }else{
                   // echo '<br>soft copy not found';
                    $redirection = "false";
                    break;
                }
        }

        return $redirection;
        //die;
    }

    

    public function guest_checkout(Request $request)
    {
        //echo "this is it";die;
        if(Session::has('cart') && count(Session::get('cart')) > 0){
            $categories = Category::all();


            return view('desktop.frontend.guest_checkout', compact('categories'));
        }
        //flash(__('Your cart is empty'))->success();
        $request->session()->flash('success', 'Your cart is empty');
        return back();
    }

    public function ajaxGetStates(Request $request){
        //echo "<pre>";
        //print_r($request->country);
        $countryName = $request->country;
        $country = \App\Country::where('name', $countryName)->first();
        

        //pull state records now
        $states = \App\State::where('country_id',$country->id)->get();
        //print_r($country->id);
       // echo "\n";
        //print_r($country->name);
        foreach ($states as $s) {
            echo "<option value='".$s->name."'>".$s->name ."</option>";
        }
        //dd($states);
        //die;
    }

     public function store_guestcheckout_info(Request $request)
    {
        

        //echo "<br>it is new address, have to save it<br>";die;
        $data['guest_name'] = $request->guest_name;
        $data['guest_email'] = $request->guest_email;
       
        $data['guest_phone'] = $request->guest_phone;
        $data['checkout_type'] = $request->checkout_type;

        $guest_info = $data;
        $request->session()->put('guest_info', $guest_info);

        $subtotal = 0;
        $tax = 0;
        $shipping = 0;
        foreach (Session::get('cart') as $key => $cartItem){
            $subtotal += $cartItem['price']*$cartItem['quantity'];
            $tax += $cartItem['tax']*$cartItem['quantity'];
            $shipping += $cartItem['shipping']*$cartItem['quantity'];
        }

        $total = $subtotal + $tax + $shipping;

        if(Session::has('coupon_discount')){
                $total -= Session::get('coupon_discount');
        }

        $redirection = $this->checkForRedirection();
        //echo "<br>before die<br>";
        //die;

        if ($redirection=="true") {
            $data['name'] =  '';
            $data['email'] = '';
            $data['address'] = '';
            $data['address1'] = '';
            $data['country'] =  '';
            $data['state'] =  '';
            $data['city'] = '';
            $data['postal_code'] =  '';
            $data['phone'] = '';
            $data['checkout_type'] = '';
            $data['fill_later'] =  'fill_later' ;
            
            $shipping_info = $data;
            $request->session()->put('shipping_info', $shipping_info);
           return redirect()->route('checkout.delivery_info_view');
       }else{
            return redirect()->route('checkout.shipping_info');
        }
        //return view('desktop.frontend.delivery_info');
        
        // return view('desktop.frontend.payment_select', compact('total'));
    }

    public function store_shipping_info(Request $request)
    {
        if (Auth::user()) {
            $user = Auth::user();
            $numberOfAddresses = \App\Address::where('user_id', $user->id)->where('email', $request->email)->count();

            if ($numberOfAddresses==0) {

                //new address, so insert and make it default
                $add = new \App\Address;
                $add->name = $request->name;
                $add->email = $request->email;
                $add->phone = $request->phone;
                $add->address = $request->address;
                $add->address1 = $request->address1;
                //$add->country = $request->country;
                $add->country = \App\Country::where('name', $request->country)->first()->id;
                $add->state = \App\State::where('name', $request->state)->first()->id;
                $add->city = $request->city;
                $add->zip_code = $request->postal_code;
                $add->default_address = 1;
                $add->user_id = $user->id;

                //DB::enableQueryLog();
                DB::update('update address set default_address = 0 where user_id = ?', [$user->id]);


                //$queries = DB::getQueryLog();
                 $add->save();
            }
        }

        //echo "<br>it is new address, have to save it<br>";die;
        $data['name'] = ( !empty( $request->name ) ) ? $request->name : '';
        $data['email'] = ( !empty( $request->email ) ) ? $request->email : '';
        $data['address'] = ( !empty( $request->address ) ) ? $request->address : '';
        $data['address1'] = ( !empty( $request->address1 ) ) ? $request->address1 : '';
        $data['country'] = ( !empty( $request->country ) ) ? $request->country : '';
        $data['state'] = ( !empty( $request->state ) ) ? $request->state : '';
        $data['city'] = ( !empty( $request->city ) ) ? $request->city : '';
        $data['postal_code'] = ( !empty( $request->postal_code ) ) ? $request->postal_code : '';
        $data['phone'] = ( !empty( $request->phone ) ) ? $request->phone : '';
        $data['checkout_type'] = ( !empty( $request->checkout_type ) ) ? $request->checkout_type : '';
        $data['fill_later'] = ( !empty( $request->fill_later ) ) ? $request->fill_later : '';

        //print_r($data);
        //die;

        $shipping_info = $data;
        $request->session()->put('shipping_info', $shipping_info);
        $request->session()->put('fill_later', $data['fill_later']);

        $subtotal = 0;
        $tax = 0;
        $shipping = 0;
        foreach (Session::get('cart') as $key => $cartItem){
            $subtotal += $cartItem['price']*$cartItem['quantity'];
            $tax += $cartItem['tax']*$cartItem['quantity'];
            $shipping += $cartItem['shipping']*$cartItem['quantity'];
        }

        $total = $subtotal + $tax + $shipping;

        if(Session::has('coupon_discount')){
                $total -= Session::get('coupon_discount');
        }

        if ($data['fill_later']=="fill_later") {
            return redirect()->route('checkout.delivery_info_view');
        }elseif($data['fill_later']=="local_pickup"){
            return redirect()->route('checkout.delivery_method_view');
        }else{
            return redirect()->route('checkout.delivery_method_view');
        }
        
        //
        // return view('desktop.frontend.payment_select', compact('total'));
    }

    public function store_delivery_method_info(Request $request){

         $shipping_method = ( !empty( $request->shipping_method ) ) ? $request->shipping_method : '';

          $location_addr = ( !empty( $request->location_addr ) ) ? $request->location_addr : '';

          if ($shipping_method=='' && $location_addr=='') {
             Session::flash('message', 'Please select any one among them, to proceed');
             return back();
          }


          $request->session()->put('shipping_method', $shipping_method);
          $request->session()->put('location_addr', $location_addr);


          return redirect()->route('checkout.delivery_info_view');

    }

    

     public function delivery_method_view(Request $request){
        $shippingMethods = \App\ShippingMethod::where('status','1')->get();
        $locations = \App\LocalPickup::where('status','1')->get();
        $isLocalPickUpAvailable = \App\ShippingSetting::where('s_key','local_pickup')->first()->s_value;
        return view('desktop.frontend.delivery_method', compact('shippingMethods', 'locations', 'isLocalPickUpAvailable'));
    }

    public function delivery_info_view(Request $request){
            return view('desktop.frontend.delivery_info');
    }

    public function initiateTransaction(Request $request){
       // echo "Initiate Transaction";

        $cashfreereference = new CashFreeController;
        return $cashfreereference->getCheckout();
    }

    public function store_delivery_info(Request $request)
    {
        //dd($request->all());
        if( !empty( $request->t_n_c ) ){
            //echo $request->t_n_c."<br>";
        }else{
            //t and c not checked so set a session and return back
            Session::flash('message', 'Please agree terms and conditions to proceed');
            return back();
            //echo $request->t_n_c."<br>";
        }
        
        $subtotal = 0;
        $tax = 0;
        $shipping = 0;

        $cart = $request->session()->get('cart', collect([]));
        $cart = $cart->map(function ($object, $key) use ($request, $subtotal, $shipping, $tax) {

            $subtotal += $object['price']*$object['quantity'];
            $tax += $object['tax']*$object['quantity'];

            if(\App\Product::find($object['id'])->added_by == 'admin'){
                if($request['shipping_type_admin'] == 'home_delivery'){
                    $object['shipping_type'] = 'home_delivery';
                    $object['shipping'] = \App\Product::find($object['id'])->shipping_cost;
                    //$shipping += \App\Product::find($object['id'])->shipping_cost*$object['quantity'];
                }
                else{
                    $object['shipping_type'] = 'pickup_point';
                    $object['pickup_point'] = $request->pickup_point_id_admin;
                }
            }
            else{
                if($request['shipping_type_'.\App\Product::find($object['id'])->user_id] == 'home_delivery'){
                    $object['shipping_type'] = 'home_delivery';
                    $object['shipping'] = \App\Product::find($object['id'])->shipping_cost;
                   // $shipping += \App\Product::find($object['id'])->shipping_cost*$object['quantity'];
                }
                else{
                    $object['shipping_type'] = 'pickup_point';
                    $object['pickup_point'] = $request['pickup_point_id_'.\App\Product::find($object['id'])->user_id];
                }
            }
            return $object;
        });

        $s_data = showPriceForDeliveryMethods();

        $total = $subtotal + $tax + $s_data['shipping_cost'];

        $request->session()->put('cart', $cart);

        //dd($cart);

        if(Session::has('coupon_discount')){
                $total -= Session::get('coupon_discount');
        }


       $orderController = new OrderController;
       $orderController->store($request);

        $t_n_c = ( !empty( $request->t_n_c ) ) ? 'true' : 'false';

        $request->session()->put('payment_type', 'cart_payment');
        $request->session()->put('payment_option', $request->payment_option);
        $request->session()->put('total', $total);
        $request->session()->put('t_n_c', $t_n_c);

        /* echo "<br>";
        echo "after order and order details insertion<br>";
        echo $request->payment_option;
        die; */

        return redirect()->route('checkout.order_confirm_view');
        //return view('desktop.frontend.order_confirm', compact('total'));
    }

    public function order_confirm_view(Request $request){

        $total = 0;
        if ( !empty( Session::get('total') ) ) {
            $total = Session::get('total');
        }
        

        return view('desktop.frontend.order_confirm', compact('total'));
    }

    

    public function order_submit(Request $request)
    {
        //dd($request->all());

        //echo "payment_option is: ".$request->session()->get('payment_option')."<br>";die;

        if($request->session()->get('order_id') != null){
            if($request->payment_option == 'paypal'){
                $paypal = new PaypalController;
                return $paypal->getCheckout();
            }
            //elseif ($request->payment_option == 'cash_free') {
            elseif ($request->session()->get('payment_option') == 'cash_free') {
                $cashfreereference = new CashFreeController;
                return $cashfreereference->getCheckout($request);
            }elseif ($request->session()->get('payment_option') == 'paytm') {
                $paytmreference = new PaytmController;
                return $paytmreference->getCheckout($request);
            }
            elseif ($request->payment_option == 'stripe') {
                $stripe = new StripePaymentController;
                return $stripe->stripe();
            }
            elseif ($request->payment_option == 'sslcommerz') {
                $sslcommerz = new PublicSslCommerzPaymentController;
                return $sslcommerz->index($request);
            }
            elseif ($request->payment_option == 'instamojo') {
                $instamojo = new InstamojoController;
                return $instamojo->pay($request);
            }
            elseif ($request->payment_option == 'razorpay') {
                $razorpay = new RazorpayController;
                return $razorpay->payWithRazorpay($request);
            }
            elseif ($request->payment_option == 'paystack') {
                $paystack = new PaystackController;
                return $paystack->redirectToGateway($request);
            }
            elseif ($request->payment_option == 'voguepay') {
                $voguePay = new VoguePayController;
                return $voguePay->customer_showForm();
            }
            elseif ($request->payment_option == 'cash_on_delivery') {
                $order = Order::findOrFail($request->session()->get('order_id'));
                $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                foreach ($order->orderDetails as $key => $orderDetail) {
                    if($orderDetail->product->user->user_type == 'seller'){
                        $seller = $orderDetail->product->user->seller;
                        $seller->admin_to_pay = $seller->admin_to_pay - ($orderDetail->price*$commission_percentage)/100;
                        $seller->save();
                    }
                }

                $request->session()->put('cart', collect([]));
                $request->session()->forget('order_id');
                $request->session()->forget('delivery_info');
                $request->session()->forget('coupon_id');
                $request->session()->forget('coupon_discount');
                $request->session()->forget('shipping_method');
                $request->session()->forget('location_addr');

                flash("Your order has been placed successfully")->success();
                return redirect()->route('home');
            }
            elseif ($request->payment_option == 'wallet') {
                $user = Auth::user();
                $user->balance -= Order::findOrFail($request->session()->get('order_id'))->grand_total;
                $user->save();
                return $this->checkout_done($request->session()->get('order_id'), null);
            }
        }

    

        /* echo "<br>";
        echo "after order and order details insertion<br>";
        echo $request->payment_option;
        die; */

        
        //return view('desktop.frontend.order_confirm', compact('total'));
    }

    public function get_payment_info(Request $request)
    {
        $subtotal = 0;
        $tax = 0;
        $shipping = 0;
        foreach (Session::get('cart') as $key => $cartItem){
            $subtotal += $cartItem['price']*$cartItem['quantity'];
            $tax += $cartItem['tax']*$cartItem['quantity'];
            $shipping += $cartItem['shipping']*$cartItem['quantity'];
        }

        $total = $subtotal + $tax + $shipping;

        if(Session::has('coupon_discount')){
                $total -= Session::get('coupon_discount');
        }

        return view('desktop.frontend.payment_select', compact('total'));
    }

    public function apply_coupon_code(Request $request){
        //dd($request->all());

        
        $coupon = Coupon::where('code', $request->code)->first();

        if($coupon != null){
            if(strtotime(date('d-m-Y')) >= $coupon->start_date && strtotime(date('d-m-Y')) <= $coupon->end_date){
               // if(CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->first() == null){
                    $coupon_details = json_decode($coupon->details);

                    
                    if($coupon->repeat_type == 'normal_limit'){
                        //get number of times the coupon is used
                        $numberOfTimesUsed = \App\CouponUsage::where('coupon_id', $coupon->id)->get()->count();
                        if ($numberOfTimesUsed >= $coupon->limit_number) {
                            Session::flash('warning', 'Coupon expired'); 
                            return back();
                        }
                    }elseif($coupon->repeat_type == 'user_limit'){
                        //get number of times a user has used a coupon
                        if (Auth::check()) {
                            $user_id = Auth::user()->id;
                            $numberOfTimesUsed = \App\CouponUsage::where('coupon_id', $coupon->id)->where('user_id', $user_id)->get()->count();
                            if ($numberOfTimesUsed >= $coupon->limit_number) {
                                Session::flash('warning', 'You have already used this coupon!'); 
                                return back();
                            }

                        }
                    }



                    if ($coupon->type == 'cart_base')
                    {
                        $subtotal = 0;
                        $tax = 0;
                        $shipping = 0;
                        foreach (Session::get('cart') as $key => $cartItem)
                        {
                            $subtotal += $cartItem['price']*$cartItem['quantity'];
                            $tax += $cartItem['tax']*$cartItem['quantity'];
                            $shipping += $cartItem['shipping']*$cartItem['quantity'];
                        }

                       
                        $sum = $subtotal+$tax+$shipping;

                        if ($sum > $coupon_details->min_buy) {
                            if ($coupon->discount_type == 'percent') {
                                $coupon_discount =  ($sum * $coupon->discount)/100;
                                if ($coupon_discount > $coupon_details->max_discount) {
                                    $coupon_discount = $coupon_details->max_discount;
                                }
                            }
                            elseif ($coupon->discount_type == 'amount') {
                                $coupon_discount = $coupon->discount;
                            }
                            $request->session()->put('coupon_id', $coupon->id);
                            $request->session()->put('coupon_discount', $coupon_discount);

                             
                            //flash('Coupon has been applied')->success();
                            Session::flash('success', 'Coupon has been applied'); 
                        }
                        
                    }
                    elseif ($coupon->type == 'product_base')
                    {
                        $invalid = 'true';
                        $coupon_discount = 0;
                        //echo "<pre>";
                        //print_r(Session::get('cart'));
                        //echo "<br>";
                        $min_buy  = 0;
                        foreach (Session::get('cart') as $key => $cartItem){
                            foreach ($coupon_details as $key => $coupon_detail) {
                                $product = \App\Product::find($cartItem['id']);

                                $prod_ref = $product->ref;
                                if($coupon_detail->product_id == $prod_ref){
                                    $invalid = 'false';
                                    $min_buy += $cartItem['price'];
                                    if ($coupon->discount_type == 'percent') {
                                        $coupon_discount += $cartItem['price']*$coupon->discount/100;
                                    }
                                    elseif ($coupon->discount_type == 'amount') {
                                        $coupon_discount += $coupon->discount;
                                    }
                                }
                            }
                        }

                         if ($invalid=="true") {
                           //Session::flash('warning', 'This coupon is not applicable for this product.'); 
                           //return back();
                        }
                        //echo "<br>coupon amount is: ".$coupon_discount."<br>";
                        //echo '<br>applying product based coupon code<br>';die;
                         if ($min_buy > $coupon->min_buy) {

                            if ($coupon_discount > $coupon->max_discount) {
                                    $coupon_discount = $coupon->max_discount;
                            }

                            $request->session()->put('coupon_id', $coupon->id);
                            $request->session()->put('coupon_discount', $coupon_discount);
                            //flash('Coupon has been applied')->success();
                            Session::flash('success', 'Coupon has been applied'); 

                        }

                        
                    }
                    elseif ($coupon->type == 'category_base')
                    {
                        $coupon_discount = 0;
                        //echo "<pre>";
                        //print_r(Session::get('cart'));
                        //echo "<br>";
                        $invalid = 'true';
                        $min_buy  = 0;
                        foreach (Session::get('cart') as $key => $cartItem){

                            foreach ($coupon_details as $key => $coupon_detail) {
                                $product = \App\Product::find($cartItem['id']);
                                $prod_ref = $product->ref;
                                $cat_array = $product->categories;
                                //print_r($cat_array);
                                //if($coupon_detail->category_id == $prod_ref){
                                if( in_array($coupon_detail->category_id, $cat_array ) ){
                                    $invalid = 'false';
                                    $min_buy += $cartItem['price'];
                                    if ($coupon->discount_type == 'percent') {

                                        $coupon_discount += $cartItem['price']*$coupon->discount/100;
                                    }
                                    elseif ($coupon->discount_type == 'amount') {
                                        $coupon_discount += $coupon->discount;
                                    }
                                }
                            }
                        }

                        if ($invalid=="true") {
                           //Session::flash('warning', 'This coupon is not applicable in this category'); 
                           //return back();
                        }
                        //echo "<br>coupon amount is: ".$coupon_discount."<br>";
                        //echo '<br>applying category based coupon code<br>';die;

                        if ($min_buy > $coupon->min_buy) {

                            if ($coupon_discount > $coupon->max_discount) {
                                    $coupon_discount = $coupon->max_discount;
                            }

                            $request->session()->put('coupon_id', $coupon->id);
                            $request->session()->put('coupon_discount', $coupon_discount);
                            //flash('Coupon has been applied')->success();
                            Session::flash('success', 'Coupon has been applied'); 

                        }
                        
                    }elseif ($coupon->type == 'shipping_base')
                    {

                        $res = showPriceForDeliveryMethods();

                        $scost = $res['shipping_cost'];

                        //echo "<br>ship cost is: ".$scost."<br>";
                       // echo $coupon->type."<br>";
                        //die;
                        if ($scost > $coupon_details->min_buy) {
                            if ($coupon->discount_type == 'percent') {
                                $coupon_discount =  ($scost * $coupon->discount)/100;
                                if ($coupon_discount > $coupon_details->max_discount) {
                                    $coupon_discount = $coupon_details->max_discount;
                                }
                            }
                            elseif ($coupon->discount_type == 'amount') {
                                $coupon_discount = $coupon->discount;
                            }
                           // echo "<br>min buy amount is: ".$coupon_details->min_buy."<br>";
                           // die;
                            $request->session()->put('coupon_id', $coupon->id);
                            $request->session()->put('coupon_discount', $coupon_discount);

                             
                            //flash('Coupon has been applied')->success();
                            Session::flash('success', 'Coupon has been applied'); 
                        }
                        
                    }
                //}
               // else{
                    //flash('You already used this coupon!')->warning();
                 //   Session::flash('warning', 'You already used this coupon'); 
               // }
            }
            else{
               // flash('Coupon expired!')->warning();
                Session::flash('warning', 'Coupon expired'); 
            }
        }
        else {
           // flash('Invalid coupon!')->warning();
            Session::flash('warning', 'Invalid coupon! '); 
        }

         
        return back();
        //return redirect()->route('checkout.store_shipping_infostore');
    }

    public function remove_coupon_code(Request $request){
        $request->session()->forget('coupon_id');
        $request->session()->forget('coupon_discount');
        //return back();
        return redirect()->route('checkout.delivery_info_view');
    }
}
