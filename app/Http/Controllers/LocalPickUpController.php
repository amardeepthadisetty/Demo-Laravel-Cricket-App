<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\LocalPickup;
use Session;
use Schema;


class LocalPickUpController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = LocalPickup::orderBy('id','desc')->get();
        return view('localpickup.index', compact('locations'));
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

   

    

}
