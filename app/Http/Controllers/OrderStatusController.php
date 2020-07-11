<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\StatusCode;
use Session;
use Schema;


class OrderStatusController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status_codes = StatusCode::orderBy('id','desc')->get();
        return view('statuscode.index', compact('status_codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('statuscode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $statusCode = new StatusCode;
        $statusCode->status_code = $request->status_code;
        $statusCode->display_name = $request->display_name;
        $statusCode->description = $request->description;
        $statusCode->status = $request->status;
        $statusCode->save();
        Session::flash('success','Status code  has been saved successfully');
        return redirect()->route('status_code.index');
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
      $statusCode = StatusCode::findOrFail(decrypt($id));
      return view('statuscode.edit', compact('statusCode'));
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
        $statusCode = StatusCode::findOrFail($id);
        $statusCode->status_code = $request->status_code;
        $statusCode->display_name = $request->display_name;
        $statusCode->description = $request->description;
        $statusCode->status = $request->status;
        $statusCode->update();
        Session::flash('success','Status code has been updated successfully');
        return redirect()->route('status_code.index');
        
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
        $coupon = StatusCode::findOrFail($id);
        if(StatusCode::destroy($id)){
            //flash('Coupon has been deleted successfully')->success();
            Session::flash('success','Status code has been deleted successfully');
            return redirect()->route('status_code.index');
        }

        //flash('Something went wrong')->error();
        Session::flash('error','Something went wrong');
        return back();
    }

   

    

}
