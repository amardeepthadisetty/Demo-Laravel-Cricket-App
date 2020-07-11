<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShippingSetting as SS;
use Session;
class ShippingSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //echo 'hello';die;
        $ss = SS::all();
        return view('shipping_settings.index', compact("ss"));
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
        //$seosetting = SS::all();
        SS::where('s_key', 'free_shipping')->update(array('s_value' =>  $request->free_shipping));
        SS::where('s_key', 'local_pickup')->update(array('s_value' =>  $request->local_pickup));
        SS::where('s_key', 'local_pickup_ship_cost')->update(array('s_value' =>  $request->local_pickup_ship_cost));
        if(true){
            //flash(__('Shipping Settings has been updated successfully'))->success();
            Session::flash('success', 'Shipping settings has been udpated successfully');
            return redirect()->route('shippingsetting.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
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
        //
    }
}
