<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Category;
//use App\SubCategory;
//use App\SubSubCategory;
use App\ShippingCharge;
use Session;
use Schema;


class ShippingChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$sCharges = ShippingCharge::orderBy('id','asc')->get();


        $shippingStations = ShippingCharge::groupBy('ship_station_id')->orderBy('id','asc')->get();

        $ssArray = [];
        if ($shippingStations) {
            foreach ($shippingStations as $s) {
                //echo $s->id."<br>";
                $d['row_id'] = $s->id;
                $d['ship_station_id'] = $s->ship_station_id;
                $d['name'] = \App\State::where('id', $s->ship_station_id)->first()->name;
                $ssArray[] = $d;
                //array_push($ssArray, $s);
            }
        }

        //dd($shippingStations);
        //echo "<pre>";
        //print_r($ssArray);
        //die;

        return view('shipping_charge.index', compact('','ssArray'));
    }

    public function sendShipCharges(Request $request){
        $allIDS = $request->allIDS;
        $allIDS = explode("||", $allIDS);
        //dd( $allIDS );

         $sMethods = \App\ShippingMethod::all();
        return view('shipping_charge.getShipCharges', compact('allIDS', 'sMethods'));

    }

    public function saveShippingcharges(Request $request){

        $request->id;
        for ($i=0; $i < count($request->id) ; $i++) { 
           $id = $request->id[$i];
           $shipping_method_id = $request->shipping_method_id[$i];
           $price = $request->price[$i];
           $status = $request->status[$i];


            $sc = ShippingCharge::findOrFail($id);
            $sc->min = $request->min;
            $sc->max = $request->max;
            $sc->shipping_method_id = $shipping_method_id;
            $sc->price = $price;
            $sc->status = $status;
              
            if ($sc->update()) {
                    //flash('Coupon has been saved successfully')->success();
                    
            }


        }

        Session::flash('success','Ship Charge has been updated successfully');
        return redirect()->route('shipping_charge.index');
        /*dd($request);

        echo "entered inside saveshipping charges";
        die;*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = \App\State::where('country_id',98)->where('active','1')->get();
        //$sMethods = \App\ShippingMethod::where('status','1')->get();
        $sMethods = \App\ShippingMethod::all();
        return view('shipping_charge.create', compact('states','sMethods'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $sc = new ShippingCharge;
        $sc->ship_station_id = $request->shipping_station_id;
        $sc->state_id = $request->state_id;
        $sc->min = $request->min;
        $sc->max = $request->max;
        $sc->shipping_method_id = $request->shipping_method_id;
        $sc->price = $request->price;
        $sc->status = $request->status;
          
          if ($sc->save()) {
                  //flash('Coupon has been saved successfully')->success();
                  Session::flash('success','Ship Charge has been saved successfully');
                  return redirect()->route('shipping_charge.index');
              }
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
      $states = \App\State::where('country_id',98)->where('active','1')->get();
      //$sMethods = \App\ShippingMethod::where('status','1')->get();
      $sMethods = \App\ShippingMethod::all();
      $sc = ShippingCharge::findOrFail(decrypt($id));
      return view('shipping_charge.edit', compact('sc','states','sMethods'));
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
        $sc = ShippingCharge::findOrFail($id);
        $sc->ship_station_id = $request->shipping_station_id;
        $sc->state_id = $request->state_id;
        $sc->min = $request->min;
        $sc->max = $request->max;
        $sc->shipping_method_id = $request->shipping_method_id;
        $sc->price = $request->price;
         $sc->status = $request->status;
          
        if ($sc->update()) {
                //flash('Coupon has been saved successfully')->success();
                Session::flash('success','Ship Charge has been updated successfully');
                return redirect()->route('shipping_charge.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon = ShippingCharge::findOrFail($id);
        if(ShippingCharge::destroy($id)){
            //flash('Coupon has been deleted successfully')->success();
            Session::flash('success','Coupon has been deleted successfully');
            return redirect()->route('coupon.index');
        }

        //flash('Something went wrong')->error();
        Session::flash('error','Something went wrong');
        return back();
    }

    public function get_coupon_form(Request $request)
    {
        if($request->coupon_type == "product_base") {
            return view('partials.product_base_coupon');
        }
        elseif($request->coupon_type == "cart_base"){
            return view('partials.cart_base_coupon');
        }
    }

    public function get_coupon_form_edit(Request $request)
    {
        if($request->coupon_type == "product_base") {
            $coupon = ShippingCharge::findOrFail($request->id);
            return view('partials.product_base_coupon_edit',compact('coupon'));
        }
        elseif($request->coupon_type == "cart_base"){
            $coupon = ShippingCharge::findOrFail($request->id);
            return view('partials.cart_base_coupon_edit',compact('coupon'));
        }
    }

}
