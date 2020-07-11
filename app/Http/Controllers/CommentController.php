<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\FillLater;
use App\Product;
use App\Color;
use App\OrderDetail;
use App\CouponUsage;
use App\Coupon;
use Auth;
use Session;
use DB;
use PDF;
use Mail;
use App\Mail\InvoiceEmailManager;

class CommentController extends Controller
{
    

    public function saveCommentDetails($commentsArray){
        $c = new \App\Comment();
        $c->order_id = $commentsArray['order_id'];
        $c->user_id = $commentsArray['user_id'];

        //whether to show this comment row to user or not.
        //1 is active, 0 is inactive.
        $c->show_user = $commentsArray['show_user'];
        //status is success or failure
        $c->comments = $commentsArray['comments'];

        if (!empty( $commentsArray['posted_by'] )) {
           $c->posted_by = $commentsArray['posted_by'];
        }
        
        $c->other = '';

        $c->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('orders.show', compact('order'));
    }

     public function store_shipping_pending(Request $request)
    {
        //echo "<br> Order ID is: ".Session::get('OrderID')."<br>";die;
        $order = Order::where('id',Session::get('OrderID'))->first();
        

        if($order->update()){
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            $promotion_discount = 0;
            
                $fill_later = new FillLater;
                $fill_later->order_id  =$order->id;
                $fill_later->shipping_address = json_encode($request->session()->get('shipping_info'));
                $fill_later->delivery_id = ( !empty( $request->session()->get('shipping_method_id') ) ) ? $request->session()->get('shipping_method_id') : '0';

                $fill_later->payment_type = $request->payment_option;

                $s_data = showPriceForDeliveryMethods_filllater( $request->session()->get('shipping_method_id') );

                $total =  $s_data['shipping_cost'];

                

                //dd($cart);

                if(Session::has('coupon_discount')){
                        $total -= Session::get('coupon_discount');
                }
                $fill_later->shipping_cost = $total;
                $fill_later->date = strtotime('now');
               // $fill_later->shipping_type = $cartItem['shipping_type'];

                $fill_later->save();


            

            

           

            //stores the pdf for invoice
           /* $pdf = PDF::setOptions([
                            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
                            'logOutputFile' => storage_path('logs/log.htm'),
                            'tempDir' => storage_path('logs/')
                        ])->loadView('invoices.customer_invoice', compact('order'));
            $output = $pdf->output();
            file_put_contents(public_path().'\invoices\\'.'Order#'.$order->code.'.pdf', $output);

            $array['view'] = 'emails.invoice';
            $array['subject'] = 'Order Placed - '.$order->code;
            $array['from'] = env('MAIL_USERNAME');
            $array['content'] = 'Hi. Your order has been placed';
            $array['file'] = public_path().'\invoices\Order#'.$order->code.'.pdf';
            $array['file_name'] = 'Order#'.$order->code.'.pdf';*/

            //sends email to customer with the invoice pdf attached
            if(env('MAIL_USERNAME') != null && env('MAIL_PASSWORD') != null){
                //Mail::to($request->session()->get('shipping_info')['email'])->queue(new InvoiceEmailManager($array));
            }
            //unlink($array['file']);

            $request->session()->put('fill_later_id', $fill_later->id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if($order != null){
            foreach($order->orderDetails as $key => $orderDetail){
                $orderDetail->delete();
            }
            $order->delete();
            flash('Order has been deleted successfully')->success();
        }
        else{
            flash('Something went wrong')->error();
        }
        return back();
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        //$order->viewed = 1;
        $order->save();
        return view('desktop.partials.order_details_seller', compact('order'));
    }

    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        $order->save();
        if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'seller'){
            foreach($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail){
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();
            }
        }
        else{
            foreach($order->orderDetails->where('seller_id', \App\User::where('user_type', 'admin')->first()->id) as $key => $orderDetail){
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();
            }
        }
        return 1;
    }

    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status_viewed = '0';
        $order->save();

        if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'seller'){
            foreach($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail){
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        }
        else{
            foreach($order->orderDetails->where('seller_id', \App\User::where('user_type', 'admin')->first()->id) as $key => $orderDetail){
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        }

        $status = 'paid';
        foreach($order->orderDetails as $key => $orderDetail){
            if($orderDetail->payment_status != 'paid'){
                $status = 'unpaid';
            }
        }
        $order->payment_status = $status;
        $order->save();
        return 1;
    }
}
