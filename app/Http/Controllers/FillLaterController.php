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
use App\BusinessSetting;
use App\Coupon;
use App\CouponUsage;
use Session;
use CashFree;
use DB;

class FillLaterController extends Controller
{

    public function __construct()
    {
        //
    }

    public function fill_later_store(Request $request){
        //echo $request->order_id."<br>";

        $request->session()->put('OrderID', $request->order_id);
        //echo "fill_later";
        //$categories = Category::all();
        return redirect()->route('fill_later.shipping_info');
    }

    

     public function get_shipping_info(Request $request){

        $categories = Category::all();
        return view('desktop.frontend.fill_later.shipping_info', compact('categories'));
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
        $delivery_type = ( !empty( $request->delivery_type ) ) ? $request->delivery_type : '';

        //print_r($data);
        //die;

        $shipping_info = $data;
        $request->session()->put('shipping_info', $shipping_info);
        $request->session()->put('delivery_type', $delivery_type);

        return redirect()->route('fill_later.delivery_method_view');
        
        
        //
        // return view('desktop.frontend.payment_select', compact('total'));
    }


     public function delivery_method_view(Request $request){
        $shippingMethods = \App\ShippingMethod::where('status','1')->get();
        $locations = \App\LocalPickup::where('status','1')->get();
        $isLocalPickUpAvailable = \App\ShippingSetting::where('s_key','local_pickup')->first()->s_value;
        return view('desktop.frontend.fill_later.delivery_method', compact('shippingMethods', 'locations', 'isLocalPickUpAvailable'));
    }


     public function store_delivery_method_info(Request $request){

         $shipping_method = ( !empty( $request->shipping_method ) ) ? $request->shipping_method : '';

         $location_addr = ( !empty( $request->location_addr ) ) ? $request->location_addr : '';

          if ($shipping_method=='' && $location_addr=='') {
             Session::flash('message', 'Please select any one among them, to proceed');
             return back();
          }


          $request->session()->put('shipping_method_id', $shipping_method);
          //$request->session()->put('location_addr', $location_addr);

          if ($location_addr=='') {
               //this if condition is if the shipping cost is zero, for the selected method, no need to send it to payment gateway.
               if ($shipping_method!='') {
                   $res = showPriceForDeliveryMethods_filllater($shipping_method);
                   if ($res['shipping_cost']<1) {

                      $shipMethodName = \App\ShippingMethod::where('id', $shipping_method)->first()->name;
                      //change the shipping status to 2 in order table.
                      //add comments in table.
                      $order = new OrderController;
                      $order->updateShippingStatus($location_addr, 3,'door_delivery'); 
                      $order_id = Session::get('OrderID');
                      //add comments here 
                      $commentsArray = array(
                        'order_id' => $order_id,
                        'user_id' => ( Auth::user() ) ? Auth::user()->id : '0',
                        'show_user' => 1,
                        'other' => '',
                        'comments' => 'You have selected Shipping Method as: '.$shipMethodName.' and the ship cost for it is: '.single_price($res['shipping_cost'])
                      );

                      //call Comment Section
                      $commentSection = new CommentController;
                      $commentSection->saveCommentDetails($commentsArray);
                      
                      
                      //clear shipping_method_id
                      //clear OrderID

                      Session::forget('OrderID');
                      Session::forget('shipping_method_id');

                      //redirect to respective Order ID details page.
                      return redirect()->route('purchase_history.order_details.orderid', $order_id)->with('message', 'Location Address has been updated successfully');
                   }
               }
              
          }else{
              //this else part is, for if the user selectes local pick up, then no need of payment gateway.
              //change the shipping status to 2 in order table.
              //add comments in table.
              $order = new OrderController;
              $order->updateShippingStatus($location_addr, 2, 'local_pickup'); 
              $order_id = Session::get('OrderID');
              //add comments here 
              $commentsArray = array(
                'order_id' => $order_id,
                'user_id' => ( Auth::user() ) ? Auth::user()->id : '0',
                'show_user' => 1,
                'other' => '',
                'comments' => 'You have choosen a local pick up, when you tried to pay the shipping charges.'
              );

              //call Comment Section
              $commentSection = new CommentController;
              $commentSection->saveCommentDetails($commentsArray);
              
              
              //clear shipping_method_id
              //clear OrderID

              Session::forget('OrderID');
              Session::forget('shipping_method_id');

              //redirect to respective Order ID details page.
              return redirect()->route('purchase_history.order_details.orderid', $order_id)->with('message', 'Location Address has been updated successfully');
          }

          return redirect()->route('fill_later.delivery_info_view');
          

    }

     public function delivery_info_view(Request $request){
            return view('desktop.frontend.fill_later.delivery_info');
    }


    public function store_delivery_info(Request $request)
    {
        if( !empty( $request->t_n_c ) ){
            //echo $request->t_n_c."<br>";
        }else{
            //t and c not checked so set a session and return back
            Session::flash('message', 'Please agree terms and conditions to proceed');
            return back();
            //echo $request->t_n_c."<br>";
        }
        

        if(Session::has('coupon_discount')){
                $total -= Session::get('coupon_discount');
        }


       $orderController = new OrderController;
       $orderController->store_shipping_pending($request);

        $t_n_c = ( !empty( $request->t_n_c ) ) ? 'true' : 'false';

        $request->session()->put('payment_type', 'cart_payment');
        $request->session()->put('payment_option', $request->payment_option);
        //$request->session()->put('total', $total);
        $request->session()->put('t_n_c', $t_n_c);

       /*  echo "<br>";
        echo "after order and order details insertion<br>";
        echo "<br>".Session::get('fill_later_id');
        echo $request->payment_option;
        die; */

        if ($request->session()->get('payment_option') == 'cash_free') {
                $cashfreereference = new CashFreeController;
                return $cashfreereference->ship_cost_payment($request);
            }

        return redirect()->route('checkout.order_confirm_view');
        //return view('desktop.frontend.order_confirm', compact('total'));
    }

   
}
