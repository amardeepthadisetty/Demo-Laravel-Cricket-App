<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\Teams;
use App\Players;
use App\TeamMappings;
use Session;
use Schema;


class TeamsController extends Controller
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
        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        //$teams_data = new Teams;
        //$teams_data->name = $request->team_name;

         if($request->hasFile('logo_uri')){

                $imageName = getOnlyImageName($request->logo_uri->getClientOriginalName()).'.'.$request->logo_uri->extension();
                

                $imagefolderpath = 'uploads/teams/'.$imageName  ;
                $request->logo_uri->move(public_path('uploads\teams'), $imageName);
                //$product->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');

                //$teams_data->logo_uri = $imagefolderpath;

            }

       //$teams_data->club_status = 1;

       $teams_data = Teams::firstOrNew(
            ['name' => $request->team_name],
            ['logo_uri' => $imagefolderpath, 'club_state' => '1']
        );

        $teams_data->save();
        //echo "inside storeee";die;
        Session::flash('success','Team  has been saved successfully');
        return redirect()->route('teams.index');
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
      $team_data = Teams::findOrFail(decrypt($id));
      $all_players = Players::all();
      $mappedPlayers = TeamMappings::where('team_id', $team_data->id)->get();
      return view('Teams.edit', compact('team_data','all_players','mappedPlayers'));
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
      $teams_data = Teams::findOrFail($id);
      $teams_data->name = $request->team_name;
        if($request->hasFile('logo_uri')){

            $imageName = getOnlyImageName($request->logo_uri->getClientOriginalName()).'.'.$request->logo_uri->extension();
            

            $imagefolderpath = 'uploads/teams/'.$imageName  ;
            $request->logo_uri->move(public_path('uploads\teams'), $imageName);
            //$product->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');

            $teams_data->logo_uri = $imagefolderpath;

        }
        TeamMappings::where('team_id', $id)->delete();
       // echo "<pre>";
        //print_r($request->players);
        //$tm = new TeamMappings;
        foreach ($request->players as $p) {
            TeamMappings::create([
                'team_id' => $id,
                'player_id' => $p
                ]);
        }
       // echo "<br> before update<br>";die;
        $teams_data->update();
        Session::flash('success','Teams has been updated successfully');
        return redirect()->route('teams.index');
        
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
        $coupon = Teams::findOrFail($id);
        if(Teams::destroy($id)){
            //flash('Coupon has been deleted successfully')->success();
            Session::flash('success','Team has been deleted successfully');
            return redirect()->route('teams.index');
        }

        //flash('Something went wrong')->error();
        Session::flash('error','Something went wrong');
        return back();
    }

   

    

}
