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


class PaytmController extends Controller
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
            


            $data_for_request = $this->handlePaytmRequest( $OrderID, $order->grand_total );


            $paytm_txn_url = 'https://securegw-stage.paytm.in/theia/processTransaction';
            $paramList = $data_for_request['paramList'];
            $checkSum = $data_for_request['checkSum'];


            $purchaseHistoryArray = array(
                'order_id' => Session::get('order_id'),
                'fill_later_id' => '0',
                'user_id' => ( Auth::user() ) ? Auth::user()->id : '0',
                'payment_type' => Session::get('payment_option'),
                'payment_request' => json_encode(  $paramList ),
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


            //$this->callNewAPI($paytm_txn_url, $paramList);
            return view( 'desktop.frontend.paytm.paytm-merchant-form', compact( 'paytm_txn_url', 'paramList', 'checkSum' ) );

            //echo "<br> payment link is: ".$paymentLink."<br>";
            //return redirect( $paytm_txn_url);
    	//return Redirect::to( $paymentLink );
    }


    public function handlePaytmRequest( $order_id, $amount ) {
        // Load all functions of encdec_paytm.php and config-paytm.php
        $this->getAllEncdecFunc();
        $this->getConfigPaytmSettings();

        $checkSum = "";
        $paramList = array();

        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = 'mArQhd77072728301869';
        $paramList["ORDER_ID"] = $order_id;
        $paramList["CUST_ID"] = $order_id;
        $paramList["INDUSTRY_TYPE_ID"] = 'Retail';
        $paramList["CHANNEL_ID"] = 'WEB';
        $paramList["TXN_AMOUNT"] = $amount;
        $paramList["WEBSITE"] = 'WEBSTAGING';
        $paramList["CALLBACK_URL"] = url( '/paytm-callback' );
        $paytm_merchant_key = 'mzwHOz6lmlKouVZ0';

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );

        return array(
            'checkSum' => $checkSum,
            'paramList' => $paramList
        );
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


    /**
     * Get all the functions from encdec_paytm.php
     */
    function getAllEncdecFunc() {
        function encrypt_e($input, $ky) {
            $key   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
            return $data;
        }

        function decrypt_e($crypt, $ky) {
            $key   = html_entity_decode($ky);
            $iv = "@@@@&&&&####$$$$";
            $data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
            return $data;
        }

        function pkcs5_pad_e($text, $blocksize) {
            $pad = $blocksize - (strlen($text) % $blocksize);
            return $text . str_repeat(chr($pad), $pad);
        }

        function pkcs5_unpad_e($text) {
            $pad = ord($text{strlen($text) - 1});
            if ($pad > strlen($text))
                return false;
            return substr($text, 0, -1 * $pad);
        }

        function generateSalt_e($length) {
            $random = "";
            srand((double) microtime() * 1000000);

            $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
            $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
            $data .= "0FGH45OP89";

            for ($i = 0; $i < $length; $i++) {
                $random .= substr($data, (rand() % (strlen($data))), 1);
            }

            return $random;
        }

        function checkString_e($value) {
            if ($value == 'null')
                $value = '';
            return $value;
        }

        function getChecksumFromArray($arrayList, $key, $sort=1) {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function getChecksumFromString($str, $key) {

            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }

        function verifychecksum_e($arrayList, $key, $checksumvalue) {
            $arrayList = removeCheckSumParam($arrayList);
            ksort($arrayList);
            $str = getArray2StrForVerify($arrayList);
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);

            $finalString = $str . "|" . $salt;

            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;

            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }

        function verifychecksum_eFromStr($str, $key, $checksumvalue) {
            $paytm_hash = decrypt_e($checksumvalue, $key);
            $salt = substr($paytm_hash, -4);

            $finalString = $str . "|" . $salt;

            $website_hash = hash("sha256", $finalString);
            $website_hash .= $salt;

            $validFlag = "FALSE";
            if ($website_hash == $paytm_hash) {
                $validFlag = "TRUE";
            } else {
                $validFlag = "FALSE";
            }
            return $validFlag;
        }

        function getArray2Str($arrayList) {
            $findme   = 'REFUND';
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pos = strpos($value, $findme);
                $pospipe = strpos($value, $findmepipe);
                if ($pos !== false || $pospipe !== false)
                {
                    continue;
                }

                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }

        function getArray2StrForVerify($arrayList) {
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }

        function redirect2PG($paramList, $key) {
            $hashString = getchecksumFromArray($paramList, $key);
            $checksum = encrypt_e($hashString, $key);
        }

        function removeCheckSumParam($arrayList) {
            if (isset($arrayList["CHECKSUMHASH"])) {
                unset($arrayList["CHECKSUMHASH"]);
            }
            return $arrayList;
        }

        function getTxnStatus($requestParamList) {
            return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
        }

        function getTxnStatusNew($requestParamList) {
            return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
        }

        function initiateTxnRefund($requestParamList) {
            $CHECKSUM = getRefundChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
            $requestParamList["CHECKSUM"] = $CHECKSUM;
            return callAPI(PAYTM_REFUND_URL, $requestParamList);
        }

        function callAPI($apiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postData))
            );
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }

        
        function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
            if ($sort != 0) {
                ksort($arrayList);
            }
            $str = getRefundArray2Str($arrayList);
            $salt = generateSalt_e(4);
            $finalString = $str . "|" . $salt;
            $hash = hash("sha256", $finalString);
            $hashString = $hash . $salt;
            $checksum = encrypt_e($hashString, $key);
            return $checksum;
        }
        function getRefundArray2Str($arrayList) {
            $findmepipe = '|';
            $paramStr = "";
            $flag = 1;
            foreach ($arrayList as $key => $value) {
                $pospipe = strpos($value, $findmepipe);
                if ($pospipe !== false)
                {
                    continue;
                }

                if ($flag) {
                    $paramStr .= checkString_e($value);
                    $flag = 0;
                } else {
                    $paramStr .= "|" . checkString_e($value);
                }
            }
            return $paramStr;
        }
        function callRefundAPI($refundApiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_URL, $refundApiURL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }
    }


    public function callNewAPI($apiURL, $requestParamList) {
            $jsonResponse = "";
            $responseParamList = array();
            $JsonData =json_encode($requestParamList);
            $postData = 'JsonData='.urlencode($JsonData);
            $ch = curl_init($apiURL);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postData))
            );
            $jsonResponse = curl_exec($ch);
            $responseParamList = json_decode($jsonResponse,true);
            return $responseParamList;
        }

    /**
     * Config Paytm Settings from config_paytm.php file of paytm kit
     */
    function getConfigPaytmSettings() {
        define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
        define('PAYTM_MERCHANT_KEY', 'mzwHOz6lmlKouVZ0'); //Change this constant's value with Merchant key downloaded from portal
        define('PAYTM_MERCHANT_MID', 'mArQhd77072728301869'); //Change this constant's value with MID (Merchant ID) received from Paytm
        define('PAYTM_MERCHANT_WEBSITE', 'WEBSTAGING'); //Change this constant's value with Website name received from Paytm

        $PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
        $PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
        if (PAYTM_ENVIRONMENT == 'PROD') {
            $PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
            $PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
        }
        define('PAYTM_REFUND_URL', '');
        define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
        define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
        define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
    }

    public function paytmCallback( Request $request ) {
        //dd($request);
        //echo "this is callback<br>"; die;
        $order_id = $request['ORDERID'];


        $checkoutController = new CheckoutController;
        $paymentArray = array(
            'orderId' => $request['ORDERID'],
            'orderAmount' => $request['TXNAMOUNT'],
            'referenceId' => $request['BANKTXNID'],
            'txStatus' => $request['STATUS'],
            'paymentMode' => '',
            'txMsg' => $request['RESPMSG'],
            'txTime' => date('Y-m-d H:i:s'),
            'signature' => $request['CHECKSUMHASH'],


        );
        return $checkoutController->checkout_done($request->session()->get('order_id'), $paymentArray);

        /*if ( 'TXN_SUCCESS' === $request['STATUS'] ) {
            $transaction_id = $request['TXNID'];
            $order = Order::where( 'order_id', $order_id )->first();
            $order->status = 'complete';
            $order->transaction_id = $transaction_id;
            $order->save();
            return view( 'order-complete', compact( 'order', 'status' ) );

        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
            return view( 'payment-failed' );
        }*/
    }

}
