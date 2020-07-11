<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Order;
use App\OrderPayments;
use App\BusinessSetting;
use App\Seller;
use Session;
use Auth;
use App\Product;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\WalletController;


class CashFreeController extends Controller
{
    private $_apiContext;

    public function __construct()
    {
       /*  if(Session::has('payment_type')){

            if(BusinessSetting::where('type', 'paypal_sandbox')->first()->value == 1){
                $mode = 'sandbox';
                $endPoint = 'https://api.sandbox.paypal.com';
            }
            else{
                $mode = 'live';
                $endPoint = 'https://api.paypal.com';
            }

            if(Session::get('payment_type') == 'cart_payment' || Session::get('payment_type') == 'wallet_payment'){
                $this->_apiContext = PayPal::ApiContext(
                    env('PAYPAL_CLIENT_ID'),
                    env('PAYPAL_CLIENT_SECRET'));

        		$this->_apiContext->setConfig(array(
        			'mode' => $mode,
        			'service.EndPoint' => $endPoint,
        			'http.ConnectionTimeOut' => 30,
        			'log.LogEnabled' => true,
        			'log.FileName' => public_path('logs/paypal.log'),
        			'log.LogLevel' => 'FINE'
        		));
            }
            elseif (Session::get('payment_type') == 'seller_payment') {
                $seller = Seller::findOrFail(Session::get('payment_data')['seller_id']);
                $this->_apiContext = PayPal::ApiContext(
                    $seller->paypal_client_id,
                    $seller->paypal_client_secret);

        		$this->_apiContext->setConfig(array(
        			'mode' => $mode,
        			'service.EndPoint' => 'https://api.paypal.com',
        			'http.ConnectionTimeOut' => 30,
        			'log.LogEnabled' => true,
        			'log.FileName' => public_path('logs/paypal.log'),
        			'log.LogLevel' => 'FINE'
        		));
            }
        } */
    }

    public function getCheckout($request)
    {
            $OrderID = "Order-".Session::get('order_id').'-'.date('Ymdhis');
    	    $apiEndpoint = "https://test.cashfree.com";
            $opUrl = $apiEndpoint."/api/v1/order/create";


            $order = Order::find(Session::get('order_id'));


           

            $cashfree_settings = \App\CashFreeSettings::where('id',1)->first();
            $cf_request = array();
           // $cf_request["appId"] = "60459f84be523c5f6e11ff2b5406";
            $cf_request["appId"] = $cashfree_settings->app_id;
            $cf_request["secretKey"] = $cashfree_settings->secret_key;
            //$cf_request["orderId"] = "ORDER-104"; 
            $cf_request["orderId"] = $OrderID ; 
            $cf_request["orderAmount"] = $order->grand_total;
            $cf_request["orderCurrency"] = "INR";
            $cf_request["orderNote"] = "Subscription";
            //echo "<br> phone is: ".Auth::user()->phone."<br>";
            if (Auth::check()) {
                if (Auth::user()->phone!='') {
                    $cf_request["customerPhone"] = Auth::user()->phone;
                }else{
                    $cf_request["customerPhone"] = '9000012345';
                }
                
                $cf_request["customerName"] = Auth::user()->name;
                $cf_request["customerEmail"] = Auth::user()->email;
            }else{
                $cf_request["customerPhone"] = '9000012345';
                $cf_request["customerName"] = '';
                $cf_request["customerEmail"] = '';
            }
            /*echo "<br>";
            print_r($cf_request);
            echo "<br>";*/
            
            $cf_request["returnUrl"] = url('/')."/cashfree/payment/done?Orderid=".Session::get('order_id');
            //$cf_request["returnUrl"] = "http://localhost/laramongo/public/cashfree/payment/done?Orderid=".Session::get('order_id');
            //$cf_request["notifyUrl"] = "http://localhost/laramongo/public/cashfree/payment/done?Orderid=".Session::get('order_id');
            $cf_request["notifyUrl"] = url('/')."/cashfree/payment/done?Orderid=".Session::get('order_id');

            //$request->session()->put('payment_request', $cf_request);


            // print_r($cf_request); die;  
            $timeout = 10;
            
            $request_string = "";
            foreach($cf_request as $key=>$value) {
                $request_string .= $key.'='.rawurlencode($value).'&';
            }


            $purchaseHistoryArray = array(
                'order_id' => Session::get('order_id'),
                'fill_later_id' => '0',
                'user_id' => ( Auth::user() ) ? Auth::user()->id : '0',
                'payment_type' => Session::get('payment_option'),
                'payment_request' => json_encode(  $cf_request ),
                'payment_res' => '',
                'total_amount' =>  $order->grand_total,
                'status' =>  '',
            );

            $purchaseHistory = new PurchaseHistoryController;
            $purchaseHistoryID = $purchaseHistory->savePurchaseHistoryDetails($purchaseHistoryArray);

            $request->session()->put('purchase_history_id', $purchaseHistoryID);

            
            //this is order payments code for reports generation as well as tallying 
            //whether the payment made matches correctly or not.
            $total_discount_amount = (float) $order->coupon_discount + (float) $order->promotion_discount;
            $orderPayment = OrderPayments::updateOrCreate(
                ['order_id' => Session::get('order_id'), 'payment_type' => 'order'],
                [ 'amount' => $order->sub_total,
                  'discount' => $total_discount_amount,
                  'total' => $order->grand_total,
                  'created_by' => 1,
                  'payment_id' => '0' ]
            );

            $request->session()->put('order_payments_id', $orderPayment->id);

          /*   $headers = array();
            $headers[] = "Cookie: X-CSRF-Token=$csrfToken";
            $headers[] = "Cookie: X-CSRF-Token=$cookie"; */
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"$opUrl?");
            curl_setopt($ch,CURLOPT_POST, count($cf_request));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $request_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $curl_result=curl_exec ($ch);
            curl_close ($ch);

            $jsonResponse = json_decode($curl_result);
           /* echo "<pre>";
           echo  Session::get('order_id');
           echo "<br> response from cash free is: ";
           print_r($jsonResponse);
           echo "</pre>"; */
            //die;
            if ($jsonResponse->{'status'} == "OK") {
                $paymentLink = $jsonResponse->{"paymentLink"};
                //Send this payment link to customer over email/SMS OR redirect to this link on browser
            } else {
                //Log request, $jsonResponse["reason"]
            }

            //echo "<br> payment link is: ".$paymentLink."<br>";
            return redirect( $paymentLink);
    	//return Redirect::to( $paymentLink );
    }


    public function getCancel()
    {
        // Curse and humiliate the user for cancelling this most sacred payment (yours)
        $request->session()->forget('order_id');
        $request->session()->forget('payment_data');
        flash(__('Payment cancelled'))->success();
    	return redirect()->url()->previous();
    }

    public function getDone(Request $request)
    {
        //echo $request->txStatus."<br>";
        //dd($request);
       // if ($request->txStatus=="SUCCESS") {
            //if($request->session()->get('payment_type') == 'cart_payment'){
                $checkoutController = new CheckoutController;
                $paymentArray = array(
                    'orderId' => $request->orderId,
                    'orderAmount' => $request->orderAmount,
                    'referenceId' => $request->referenceId,
                    'txStatus' => $request->txStatus,
                    'paymentMode' => $request->paymentMode,
                    'txMsg' => $request->txMsg,
                    'txTime' => $request->txTime,
                    'signature' => $request->signature,


                );
                return $checkoutController->checkout_done($request->session()->get('order_id'), $paymentArray);
            //}
            /* elseif ($request->session()->get('payment_type') == 'seller_payment') {
                $commissionController = new CommissionController;
                return $commissionController->seller_payment_done($request->session()->get('payment_data'), $payment);
            }
            elseif ($request->session()->get('payment_type') == 'wallet_payment') {
                $walletController = new WalletController;
                return $walletController->wallet_payment_done($request->session()->get('payment_data'), $payment);
            } */
       // }else{
          //  echo "transaction failed";
          //  die;
       // }
        //echo "<br> get done";die;
        /* 
    	$payment_id = $request->get('paymentId');
    	$token = $request->get('token');
    	$payer_id = $request->get('PayerID');

        $payment = '';

        
    	// $payment = PayPal::getById($payment_id, $this->_apiContext);
    	// $paymentExecution = PayPal::PaymentExecution();
    	// $paymentExecution->setPayerId($payer_id);
    	// $executePayment = $payment->execute($paymentExecution, $this->_apiContext);

        if($request->session()->has('payment_type')){
            if($request->session()->get('payment_type') == 'cart_payment'){
                $checkoutController = new CheckoutController;
                return $checkoutController->checkout_done($request->session()->get('order_id'), $payment);
            }
            elseif ($request->session()->get('payment_type') == 'seller_payment') {
                $commissionController = new CommissionController;
                return $commissionController->seller_payment_done($request->session()->get('payment_data'), $payment);
            }
            elseif ($request->session()->get('payment_type') == 'wallet_payment') {
                $walletController = new WalletController;
                return $walletController->wallet_payment_done($request->session()->get('payment_data'), $payment);
            }
        } */
    }

    public function ship_cost_payment($request)
    {
            $OrderID = "SHIPPAYMENT-".Session::get('fill_later_id').'-'.date('Ymdhis');
            $apiEndpoint = "https://test.cashfree.com";
            $opUrl = $apiEndpoint."/api/v1/order/create";


            $order = \App\Order::find(Session::get('OrderID'));
            $fillLater = \App\FillLater::find(Session::get('fill_later_id'));
           

            $cashfree_settings = \App\CashFreeSettings::where('id',1)->first();
            $cf_request = array();
           // $cf_request["appId"] = "60459f84be523c5f6e11ff2b5406";
            $cf_request["appId"] = $cashfree_settings->app_id;
            $cf_request["secretKey"] = $cashfree_settings->secret_key;
            //$cf_request["orderId"] = "ORDER-104"; 
            $cf_request["orderId"] = $OrderID ; 
            $cf_request["orderAmount"] = $fillLater->shipping_cost;
            $cf_request["orderCurrency"] = "INR";
            $cf_request["orderNote"] = "Subscription";
            if (Auth::check()) {
                if (Auth::user()->phone!='') {
                    $cf_request["customerPhone"] = Auth::user()->phone;
                }else{
                    $cf_request["customerPhone"] = '9000012345';
                }
                
                $cf_request["customerName"] = Auth::user()->name;
                $cf_request["customerEmail"] = Auth::user()->email;
            }else{
                $cf_request["customerPhone"] = '9000012345';
                $cf_request["customerName"] = '';
                $cf_request["customerEmail"] = '';
            }
            $cf_request["returnUrl"] = url('/')."/cashfree/ship_cost/payment/done?fill_later_id=".Session::get('fill_later_id');
            //$cf_request["returnUrl"] = "http://localhost/laramongo/public/cashfree/payment/done?fill_later_id=".Session::get('order_id');
            //$cf_request["notifyUrl"] = "http://localhost/laramongo/public/cashfree/payment/done?fill_later_id=".Session::get('order_id');
            $cf_request["notifyUrl"] = url('/')."/cashfree/ship_cost/payment/done?fill_later_id=".Session::get('fill_later_id');

            
            // print_r($cf_request); die;  
            $timeout = 10;
            
            $request_string = "";
            foreach($cf_request as $key=>$value) {
                $request_string .= $key.'='.rawurlencode($value).'&';
            }


            //this is purchase history
            $purchaseHistoryArray = array(
                'order_id' => $order->id,
                'fill_later_id' => Session::get('fill_later_id'),
                'user_id' => ( Auth::user() ) ? Auth::user()->id : '0',
                'payment_type' => Session::get('payment_option'),
                'payment_request' => json_encode(  $cf_request ),
                'payment_res' => '',
                'total_amount' =>  $fillLater->shipping_cost,
                'status' =>  '',
            );

            $purchaseHistory = new PurchaseHistoryController;
            $purchaseHistoryID = $purchaseHistory->savePurchaseHistoryDetails($purchaseHistoryArray);

            $request->session()->put('purchase_history_id', $purchaseHistoryID);

            
            //this is order payments code for reports generation as well as tallying 
            //whether the payment made matches correctly or not.
            $total_discount_amount = 0;
            $orderPayment = OrderPayments::updateOrCreate(
                ['order_id' => $order->id, 'payment_type' => 'shipping'],
                [ 'amount' => 0,
                  'discount' => $total_discount_amount,
                  'total' => $fillLater->shipping_cost,
                  'created_by' => 1,
                  'payment_id' => '0' ]
            );

            $request->session()->put('order_payments_id', $orderPayment->id);

          /*   $headers = array();
            $headers[] = "Cookie: X-CSRF-Token=$csrfToken";
            $headers[] = "Cookie: X-CSRF-Token=$cookie"; */
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"$opUrl?");
            curl_setopt($ch,CURLOPT_POST, count($cf_request));
            curl_setopt($ch,CURLOPT_POSTFIELDS, $request_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $curl_result=curl_exec ($ch);
            curl_close ($ch);

            $jsonResponse = json_decode($curl_result);
           echo "<pre>";
           echo  Session::get('order_id');
           echo "<br> response from cash free is: ";
           print_r($jsonResponse);
           echo "</pre>"; 
            //die;
            if ($jsonResponse->{'status'} == "OK") {
                $paymentLink = $jsonResponse->{"paymentLink"};
                //Send this payment link to customer over email/SMS OR redirect to this link on browser
            } else {
                //Log request, $jsonResponse["reason"]
            }

            //echo "<br> payment link is: ".$paymentLink."<br>";
            return redirect( $paymentLink);
        //return Redirect::to( $paymentLink );
    }


    public function ship_cost_getDone(Request $request)
    {
       // echo $request->txStatus."<br>";die;
        //dd($request);
       // if ($request->txStatus=="SUCCESS") {
            //if($request->session()->get('payment_type') == 'cart_payment'){
                $checkoutController = new CheckoutController;
                $paymentArray = array(
                    'orderId' => $request->fill_later_id,
                    'orderAmount' => $request->orderAmount,
                    'referenceId' => $request->referenceId,
                    'txStatus' => $request->txStatus,
                    'paymentMode' => $request->paymentMode,
                    'txMsg' => $request->txMsg,
                    'txTime' => $request->txTime,
                    'signature' => $request->signature,


                );
                return $checkoutController->ship_cost_checkout_done($request->session()->get('fill_later_id'), $paymentArray);
            
    }
}
