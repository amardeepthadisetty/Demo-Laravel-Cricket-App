<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\Teams;
use App\Players;
use Session;
use Schema;


class PointsController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo 'teams';die;
        $teams = Teams::orderBy('id','desc')->get();
        return view('points.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('points.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         if($request->hasFile('image_uri')){

                $imageName = getOnlyImageName($request->image_uri->getClientOriginalName()).'.'.$request->image_uri->extension();
                

                $imagefolderpath = 'uploads/players/'.$imageName  ;
                $request->image_uri->move(public_path('uploads\players'), $imageName);
                //$product->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');

                //$teams_data->logo_uri = $imagefolderpath;

            }

            $players_data = Players::firstOrNew(
            ['jersey_number' => $request->jersey_number],
            [
             'first_name' => $request->first_name,
             'last_name' => $request->last_name,
             'jersey_number' => $request->jersey_number,
             'country' => $request->country,
             'image_uri' => $imagefolderpath,
            ]
        );

        $players_data->save();
        //echo "inside storeee";die;
        Session::flash('success','Player has been added');
        return redirect()->route('points.index');
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
      $player_data = Players::findOrFail(decrypt($id));
      return view('points.edit', compact('player_data'));
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
      $player_data = Players::findOrFail($id);
      $player_data->first_name = $request->first_name;
      $player_data->last_name = $request->last_name;
      $player_data->jersey_number = $request->jersey_number;
      $player_data->country = $request->country;
      $player_data->matches = $request->matches;
      $player_data->runs = $request->runs;
      $player_data->highest_score = $request->highest_score;
      $player_data->fifties = $request->fifties;
      $player_data->hundreds = $request->hundreds;
        if($request->hasFile('image_uri')){

            $imageName = getOnlyImageName($request->image_uri->getClientOriginalName()).'.'.$request->image_uri->extension();
            

            $imagefolderpath = 'uploads/players/'.$imageName  ;
            $request->image_uri->move(public_path('uploads\players'), $imageName);
            //$product->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');

            $player_data->image_uri = $imagefolderpath;

        }
        $player_data->update();
        Session::flash('success','Player data has been updated successfully');
        return redirect()->route('points.index');
        
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
        $coupon = Players::findOrFail($id);
        if(Players::destroy($id)){
            //flash('Coupon has been deleted successfully')->success();
            Session::flash('success','Location has been deleted successfully');
            return redirect()->route('points.index');
        }

        //flash('Something went wrong')->error();
        Session::flash('error','Something went wrong');
        return back();
    }

   

    

}
