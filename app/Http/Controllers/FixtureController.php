<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\SubSubCategory;
use App\Teams;
use App\Fixtures;
use App\Players;
use App\TeamMappings;
use Session;
use Schema;


class FixtureController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo 'teams';die;
        $fixtures = Fixtures::orderBy('id','desc')->get();
        return view('fixtures.index', compact('fixtures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_teams = Teams::all();

        return view('fixtures.create' ,compact('all_teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
       // $fixture_data = new Fixtures;
        //$teams_data->name = $request->team_name;

        //$match_date = strtotime($request->match_date, date('Y-m-d'));
        $match_date = date("Y-m-d", strtotime($request->match_date));

       $fixture_data = Fixtures::firstOrNew(
            ['team_a' => $request->team_a, 'team_b' => $request->team_b],
            ['match_date' => $match_date, 'venue' => $request->venue]
        );

        $fixture_data->save();
        //echo "inside storeee";die;
        Session::flash('success','Fixture has been saved successfully');
        return redirect()->route('fixtures.index');
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
      $fixtures_data = Fixtures::findOrFail(decrypt($id));
      //$all_players = Players::all();
     // $mappedPlayers = TeamMappings::where('team_id', $team_data->id)->get();
      $all_teams = Teams::all();
      return view('fixtures.edit', compact('all_teams', 'fixtures_data'));
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
          $fixtures_data = Fixtures::findOrFail($id);
          $fixtures_data->team_a = $request->team_a;
          $fixtures_data->team_b = $request->team_b;
         // dd($request);
          $match_date = date("Y-m-d", strtotime($request->match_date));
          $fixtures_data->match_date = $match_date;
          $fixtures_data->venue = $request->venue;
          if ($request->has('winner')) {
               $fixtures_data->winner = $request->winner;
          }
          $fixtures_data->status = $request->status;
          $fixtures_data->update();
        Session::flash('success','Fixtures has been updated successfully');
        return redirect()->route('fixtures.index');
        
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
        $coupon = Fixtures::findOrFail($id);
        if(Fixtures::destroy($id)){
            //flash('Coupon has been deleted successfully')->success();
            Session::flash('success','Team has been deleted successfully');
            return redirect()->route('fixtures.index');
        }

        //flash('Something went wrong')->error();
        Session::flash('error','Something went wrong');
        return back();
    }

   

    

}
