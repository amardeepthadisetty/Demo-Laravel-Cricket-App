<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\LocalPickup;
use App\Order;
use App\StatusCode;
use App\Comment;
use Session;
use Schema;


class AdminOrderController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$locations = LocalPickup::orderBy('id','desc')->get();
        return view('localpickup.index', compact('locations'));*/

        $orders = Order::orderBy('code', 'desc')->paginate(10);
        //dd($orders);
        return view('orders.index', compact('orders'));
    }

    public function order_details($orderid){

        //$userid = Auth::user()->id;
        //$orders = Order::where('user_id', Auth::user()->id)->orderBy('code', 'desc')->paginate(9);
        $order = Order::where('id', $orderid)->firstorfail();
        $statusCodes = StatusCode::where('status', 1)->get();
        $comments = Comment::where('order_id', $orderid)->where('show_user',1)->orderBy('id', 'desc')->get();

        
        $orderPaymentRecords = \App\OrderPayments::where('order_id', $orderid)->where('payment_id','!=',0)->get();
        $calculatedAmount = 0;

        //dd($orderPaymentRecords);
        foreach ($orderPaymentRecords as $opr) {
            echo $opr->total_amount."<br>";
           $calculatedAmount += ( float ) $opr->total;
        }
        $ordersAmount = ( float ) $order->grand_total;
        //echo $calculatedAmount;
        //echo "<br>";
        //echo $ordersAmount;
        if ($calculatedAmount === $ordersAmount) {
            $matchStatus = 'Matched';
        }else{
            $matchStatus = 'Not Matched';
        }
        //die;

        $payment = json_decode($order->payment_details, true);
        //dd( $orderinfo );
        return view('orders.order_details', compact('order', 'orders', 'payment','comments','statusCodes', 'matchStatus'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('localpickup.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $lpickup = new LocalPickup;
        $lpickup->location = $request->location_address;
        $lpickup->status = $request->status;
        $lpickup->save();
        Session::flash('success','Location  has been saved successfully');
        return redirect()->route('local_pickup.index');
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
      $lpickup_location = LocalPickup::findOrFail(decrypt($id));
      return view('localpickup.edit', compact('lpickup_location'));
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
      $lpickup = LocalPickup::findOrFail($id);
        $lpickup->location = $request->location_address;
        $lpickup->status = $request->status;
        $lpickup->update();
        Session::flash('success','Location  has been updated successfully');
        return redirect()->route('local_pickup.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      echo "destroy";die;
        $coupon = LocalPickup::findOrFail($id);
        if(LocalPickup::destroy($id)){
            //flash('Coupon has been deleted successfully')->success();
            Session::flash('success','Location has been deleted successfully');
            return redirect()->route('local_pickup.index');
        }

        //flash('Something went wrong')->error();
        Session::flash('error','Something went wrong');
        return back();
    }

    public function postAdminComments(Request $request){

        $commentsArray = array(
            'order_id' => $request->order_id,
            //'user_id' => ( Auth::user() ) ? Auth::user()->id : '0',
            'user_id' => '0',
            'show_user' => $request->show_user,
            'comments' => $request->comments,
            'posted_by' => 3,
            'other' => '',
        );

       /* echo '<pre>';
        print_r($commentsArray);
        echo '</pre>';*/

         //call Comment Section
        if (trim($request->comments)!='') {
           $commentSection = new CommentController;
            $commentSection->saveCommentDetails($commentsArray);
        }

        $order = Order::findOrFail($request->order_id);
        $order->order_status = $request->order_status;

        $order->update();
        

         return back();

    }

    public function ajaxGetStates(Request $request){
       /* echo "<pre>";
        print_r($request->country);die;*/
        $countryName = $request->country;
        $country = \App\Country::where('name', $countryName)->first();
        

        //pull state records now
        $states = \App\State::where('country_id',$country->id)->get();
        //print_r($country->id);
        //echo "\n";
        //print_r($country->name);
        foreach ($states as $s) {
            echo "<option value='".$s->name."'>".$s->name ."</option>";
        }
        //dd($states);
        //die;
    }



    public function updateShippingInfo(Request $request){
        //save the shipping info in order table
        $data['name'] = ( !empty( $request->name ) ) ? $request->name : '';
        $data['email'] = ( !empty( $request->email ) ) ? $request->email : '';
        $data['address'] = ( !empty( $request->address ) ) ? $request->address : '';
        $data['address1'] = ( !empty( $request->address1 ) ) ? $request->address1 : '';
        $data['country'] = ( !empty( $request->country ) ) ? $request->country : '';
        $data['state'] = ( !empty( $request->state ) ) ? $request->state : '';
        $data['city'] = ( !empty( $request->city ) ) ? $request->city : '';
        $data['postal_code'] = ( !empty( $request->postal_code ) ) ? $request->postal_code : '';
        $data['phone'] = ( !empty( $request->phone ) ) ? $request->phone : '';

        $old_shipping_address = array();
        $order = \App\Order::findOrFail($request->order_id);
        $old_shipping_address = $order->shipping_address;
        $order->shipping_address = json_encode($data);
        

        //save the comments
        $commentsArray = array(
            'order_id' => $request->order_id,
            'user_id' => '0',
            'show_user' => 1,
            'posted_by' => 1,
            'comments' => 'Your Shipping Address has been updated',
            'other' => '',
        );

        //call Comment Section
        $commentSection = new CommentController;
        


        $otherComments = 'Address has been updated to '.json_encode($old_shipping_address).'    from       '.json_encode($data);
        //save the change request
        $changeRequestArray = array(
            'order_id' => $request->order_id,
            'user_id' => '0',
            'type' => 'admin',
            'msg_by' => 'admin',
            'comments' => 'User asked to update the address',
            'other' => $otherComments,
        );

        if ($request->has('location_addr')) {
            $order->shipping_status = 2;
            $order->local_pickup= $request->location_addr;
            $changeRequestArray['comments'] = 'User has opted for local pickup';
            $changeRequestArray['other'] = '';

            $commentsArray['comments'] = 'You have been opted for local pickup. Your request has been updated';
            $commentsArray['other'] = '';
           // echo 'locaiooin address seelcted';
        }
        //die;
        $changeRequest = new ChangeRequestController;
        $changeRequest->savechangeRequestDetails($changeRequestArray);
        $order->update();
        $commentSection->saveCommentDetails($commentsArray);

        //return back with session message.
        return back()->with('message','Address has been successfully updated');
    }

   

    

}
