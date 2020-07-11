<?php
 
namespace App\Http\Controllers;

use DB;
use Auth;
use Hash;
use Session;
use App\Shop;
use App\Brand;
use App\Address;
use App\Product;
use App\Category;
use App\UserImages;
use App\SubCategory;
use App\SubSubCategory;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\SearchController;
use Symfony\Component\Console\Input\Input;

class AddressController extends Controller
{
    public $agent;
    public function __construct(){
        $this->agent = new Agent();
    }


    

    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function address()
    {
        $addresses = \App\Address::where('user_id', Auth::user()->id)->get();
        // Auth::user()->user_type
            
        //echo Auth::user()->id."<br>";
         return view('desktop.frontend.customer.address', compact( 'addresses' ) );
    }

    public function new(){
         return view('desktop.frontend.customer.add_address' );
    }

    public function edit($id){

        
        $address = \App\Address::where('user_id', Auth::user()->id)->where('id', $id)->first();

        if ($address->user_id!= Auth::user()->id) {
           abort(404);
        }
        // Auth::user()->user_type
            
        //echo Auth::user()->id."<br>";

        //dd($address);
         return view('desktop.frontend.customer.edit_address', ['addr' => $address] );
    }

    public function ajaxGetStates(Request $request){
        //echo "<pre>";
        //print_r($request->country);
        $countryName = $request->country;
        $country = \App\Country::where('id', $countryName)->first();
        

        //pull state records now
        $states = \App\State::where('country_id',$country->id)->get();
        //print_r($country->id);
       // echo "\n";
        //print_r($country->name);
        foreach ($states as $s) {
            echo "<option value=".$s->id.">".$s->name ."</option>";
        }
        //dd($states);
        //die;
    }


    public function ajaxgetAddressInfo(Request $request){
       // echo $request->prefilled_addresses."\n\n";

       $address =  Address::where('id', $request->prefilled_addresses)->firstorfail();


       $addressInfo =  $address;


       $addressInfo['country'] = \App\Country::where('id', $address->country)->first()->name;
       $addressInfo['state'] = \App\State::where('id', $address->state)->first()->name;
        echo json_encode($addressInfo);
    }

    public function delete($id){

        $address = \App\Address::where('id', $id)->firstorfail();

        $address->delete();

        return redirect()->route('address');

    }

    public function address_update(Request $request){
        $address = \App\Address::where('id', $request->address_id)->first();
        //dd($request);

        $address->name = $request->name;
        $address->email = $request->email;
        $address->address = $request->address;
        $address->address1 = $request->address1;
        $address->phone = $request->phone;
        $address->country = $request->country;
        $address->state = $request->state;

        $address->city = '';
        if ($request->city!='') {
            $address->city = $request->city;
        }
        
        $address->zip_code = $request->zip_code;
        $address->user_id = Auth::user()->id;
        if ($request->default_one=="1") {
            //first make the rest to zero
             $addresses = \App\Address::where('user_id', Auth::user()->id)->get();
             foreach($addresses as $addrr){
                $addrr->default_address = 0;
                $addrr->save();
             }

           $address->default_address = $request->default_one;
        }else{
            $address->default_address = $request->default_one;
        }

        if( $address->save() ){
            //echo "this is save";
            Session::flash('success','Address has been updated');
            return redirect()->route('address');
        }else{
            Session::flash('error','Sorry! Something went wrong.');
            return back();
        }

        
        

    }


    public function store(Request $request){
        $address = new \App\Address();
        //dd($request);

        $address->name = $request->name;
        $address->email = $request->email;
        $address->address = $request->address;
        $address->address1 = $request->address1;
        $address->phone = $request->phone;
        $address->country = $request->country;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->zip_code = $request->zip_code;
        $address->user_id = Auth::user()->id;
        if ($request->default_one=="1") {
            //first make the rest to zero
             $addresses = \App\Address::where('user_id', Auth::user()->id)->get();
             foreach($addresses as $addrr){
                $addrr->default_address = 0;
                $addrr->save();
             }

           $address->default_address = $request->default_one;
        }else{
            $address->default_address = $request->default_one;
        }

        if( $address->save() ){
            //echo "this is save";
            Session::flash('success','Address has been updated');
            return redirect()->route('address');
        }else{
            Session::flash('error','Sorry! Something went wrong.');
            return back();
        }

        
        

    }


    public function profile(Request $request)
    {
        if(Auth::user()->user_type == 'customer'){
            return view('desktop.frontend.customer.profile');
        }
        elseif(Auth::user()->user_type == 'seller'){
            return view('desktop.frontend.seller.profile');
        }
    }

    
}
