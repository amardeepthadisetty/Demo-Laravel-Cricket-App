<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Comment;
use App\OrderDetail;
use Auth;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('code', 'desc')->paginate(9);
        return view('desktop.frontend.purchase_history', compact('orders'));
    }

    public function order_details($orderid){

        $userid = Auth::user()->id;
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('code', 'desc')->paginate(9);
        $order = Order::where('user_id', $userid)->where('id', $orderid)->firstorfail();
        $comments = Comment::where('order_id', $orderid)->where('show_user',1)->orderBy('id', 'desc')->get();

        //dd($comments);

        $payment = json_decode($order->payment_details, true);
        //dd( $orderinfo );
        return view('desktop.frontend.order_details', compact('order', 'orders', 'payment','comments'));

    }

    public function purchase_history_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = 1;
        $order->payment_status_viewed = 1;
        $order->save();
        return view('desktop.frontend.partials.order_details_customer', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }


    public function savePurchaseHistoryDetails($purchaseHistoryArray){

        $p = new \App\PaymentHistory();
        $p->order_id = $purchaseHistoryArray['order_id'];
        $p->fill_later_id = $purchaseHistoryArray['fill_later_id'];
        $p->user_id = $purchaseHistoryArray['user_id'];

        //payment type could be cashree or paytm.
        $p->payment_type = $purchaseHistoryArray['payment_type'];
        //status is success or failure
        $p->status = $purchaseHistoryArray['status'];
        $p->payment_req = $purchaseHistoryArray['payment_request'];
        $p->payment_res =  $purchaseHistoryArray['payment_res'];
        $p->total_amount = $purchaseHistoryArray['total_amount'];

        $p->save();

        return $p->id;

    }

    public function post_comment(Request $request){

         $commentsArray = array(
            'order_id' => $request->order_id,
            'user_id' => ( Auth::user() ) ? Auth::user()->id : '0',
            'show_user' => 1,
            'comments' => $request->comments,
            'posted_by' => 2,
            'other' => '',
        );

         //call Comment Section
        $commentSection = new CommentController;
        $commentSection->saveCommentDetails($commentsArray);

         return back();

    }
}
