<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\FillLater;
use App\Product;
use App\ChangeRequest;
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

class ChangeRequestController extends Controller
{
    public function savechangeRequestDetails($changeArray=''){
        $cRequest = new ChangeRequest();
        $cRequest->order_id = $changeArray['order_id'];
        $cRequest->user_id = $changeArray['user_id'];
        $cRequest->type = $changeArray['type'];
        $cRequest->msg_by = $changeArray['msg_by'];
        $cRequest->comments = $changeArray['comments'];
        $cRequest->other = $changeArray['other'];

        $cRequest->save();
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
