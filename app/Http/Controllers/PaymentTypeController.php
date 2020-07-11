<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\PaymentType;
use Session;
use Schema;


class PaymentTypeController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_types = PaymentType::orderBy('id','desc')->get();
        return view('payment_type.index', compact('payment_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $PaymentType = new PaymentType;
        $PaymentType->type = $request->type;
        $PaymentType->code = $request->code;
        $PaymentType->description = $request->description;
        $PaymentType->status = $request->status;
        $PaymentType->save();
        Session::flash('success','Payment type  has been saved successfully');
        return redirect()->route('payment_type.index');
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
      $paymentType = PaymentType::findOrFail(decrypt($id));
      return view('payment_type.edit', compact('paymentType'));
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
        $PaymentType = PaymentType::findOrFail($id);
        $PaymentType->type = $request->type;
        $PaymentType->code = $request->code;
        $PaymentType->description = $request->description;
        $PaymentType->status = $request->status;
        $PaymentType->update();
        Session::flash('success','Status code has been updated successfully');
        return redirect()->route('payment_type.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //echo "destroy";die;
        $coupon = PaymentType::findOrFail($id);
        if(PaymentType::destroy($id)){
            //flash('Coupon has been deleted successfully')->success();
            Session::flash('success','Status code has been deleted successfully');
            return redirect()->route('payment_type.index');
        }

        //flash('Something went wrong')->error();
        Session::flash('error','Something went wrong');
        return back();
    }

   

    

}
