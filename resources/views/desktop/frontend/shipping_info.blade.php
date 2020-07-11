@extends('desktop.frontend.layouts.app')

@section('content')


<link type="text/css" href="{{ asset('frontend/css/cart.css') }}" rel="stylesheet" media="screen"> 


    <div id="page-content">
       


                   
<section class="slice-xs">
        <div class="container container-sm">
            <div class="row ">
                <div class="col-md-12">
                <div class="di-table ">
                    <a href="{{ route('cart') }}">
                         <h5>{{__('My Cart')}}</h5>
                    </a>
                   
                </div>

                @if(!Auth::check())
                 <div class="di-table">
                     <a href="{{ route('checkout.guest_checkout') }}">
                          <h5>{{__('Guest Checkout')}}</h5>
                    </a>
                   
                 </div>
                @endif

                <div class="di-table active ">
                    <a href="{{ route('checkout.shipping_info') }}">
                         <h5>{{__('Shipping info')}}</h5>
                    </a>
                   
                </div>


                <div class="di-table  ">
                   <a href="{{ route('checkout.delivery_method_view') }}">
                         <h5>{{__('Delivery Methods')}}</h5>
                    </a>
                   
                </div>

              <div class="di-table ">
                   <!--  <a href="{{ route('checkout.delivery_info_view') }}"> -->
                        <h5>{{__('Delivery info')}}</h5>
                    <!-- </a> -->
                     
                </div>

                <div class="di-table">
                    <!-- <a href="{{ route('checkout.order_confirm_view') }}"> -->
                        <h5>{{__('Confirmation')}}</h5>
                   <!--  </a> -->
                
                </div>
            </div>
            </div>
        </div>
    </section> 


        <section class="gry-bg address-form">
            <div class="container">
                <div class="row cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-lg-8">
                        <form class="form-default" id="user_details" data-toggle="validator" action="{{ route('checkout.store_shipping_infostore') }}" role="form" method="POST">
                            @csrf
                            <div class="card"> 
                                @if(Auth::check())
                                    @php
                                        $user = Auth::user();
                                        //echo $user->name."<br>";
                                        $addresses = \App\Address::where('user_id', Auth::user()->id)->get();
                                        $default_addr = \App\Address::where('user_id', Auth::user()->id)->where('default_address',1)->first();
                                    @endphp

                                        
                                    
                                    <div class="pr-4 pl-2">

                                         @if( $addresses )
                                          <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <!-- <label class="control-label">{{__('Select An Address')}}</label>
                                                    <select class="form-control prefilled_addresses" name="prefilled_addresses"  >
                                                    @foreach( $addresses as $addr )
                                                        <option value="{{ $addr->id}}" @php if($addr->default_address=="1"){ echo 'selected'; } 
                                                            @endphp>{{ $addr->name }}, 
                                                            {{ $addr->email }}, {{ $addr->address }}, {{ $addr->phone }}</option>
                                                    @endforeach  -->

                                                    @foreach( $addresses as $addr )

                                                         <div class="add-div address_box @if( $addr->default_address=='1') active  @endif" id="addr_{{ $addr->id }}">
                                                           <b> {{ $addr->name }} </b><br>
                                                           <input type="hidden" id="addr_name_{{$addr->id}}" value="{{ $addr->name }}">
                                                           <input type="hidden" id="addr_email_{{$addr->id}}" value="{{ $addr->email }}">
                                                           <input type="hidden" id="addr_address_{{$addr->id}}" value="{{ $addr->address }}">
                                                           <input type="hidden" id="addr_address1_{{$addr->id}}" value="{{ $addr->address1 }}">
                                                           <input type="hidden" id="addr_phone_{{$addr->id}}" value="{{ $addr->phone }}">
                                                           <input type="hidden" id="addr_country_{{$addr->id}}" value="{{ \App\Country::where('id', $addr->country)->first()->name }}">
                                                           <input type="hidden" id="addr_state_{{$addr->id}}" value="{{ \App\State::where('id', $addr->state)->first()->name }}">
                                                           <input type="hidden" id="addr_city_{{$addr->id}}" value="{{ $addr->city }}">
                                                           <input type="hidden" id="addr_zip_code_{{$addr->id}}" value="{{ $addr->zip_code }}">
                                                            {{ $addr->address }}<br>
                                                            {{ $addr->address1}}<br>
                                                            {{ $addr->city }}<br>
                                                            {{ \App\State::where('id', $addr->state)->first()->name }}<br>
                                                            {{ \App\Country::where('id', $addr->country)->first()->name }}
                                                        </div>

                                                    @endforeach

                                                   

                                                   <!--  <div class="add-div">
                                                       <b> Chinthala Kondalu </b><br>
                                                        29-1104/ kothapet, kalavakatta<br>
                                                        karampudi road<br>
                                                        Hyderabad 500049<br>
                                                        Telangana<br>
                                                        India
                                                    </div> -->
                                                
                                                </div>
                                            </div>
                                        </div>
                                        
                                         @endif
                                        

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Name')}}</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $default_addr->name }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Email')}}</label>
                                                    <input type="email" id="email" class="form-control" name="email" value="{{ $default_addr->email }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group address-feld" >
                                                    <label class="control-label">{{__('Address')}}</label>
                                                    <input type="text" id="address" class="form-control" name="address" value="{{ $default_addr->address }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group address-feld">
                                                    <label class="control-label">{{__('Address 1')}}</label>  
                                                    <input type="text" id="address1" class="form-control" name="address1" value="{{ $default_addr->address1 }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('Phone')}}</label>
                                                    <input type="number" id="phone" min="0" class="form-control" value="{{ $default_addr->phone }}" name="phone" required>
                                                </div>
                                            </div>
                                        </div>

                                        @php 
                                            
                                            $cntry = \App\Country::where('id', $default_addr->country)->first();
                                            $statee = \App\State::where('id', $default_addr->state)->first();
                                        @endphp
                                         

                                        <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Select your country')}}</label>
                                                    <select class="form-control custome-control country_name" id="country" data-live-search="true" name="country">
                                                        @foreach (\App\Country::all() as $key => $country)
                                                            <option value="{{ $country->name }}"  @php if($cntry->name==$country->name){ echo 'selected'; } @endphp >{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Select your state')}}</label>
                                                    <select class="form-control custome-control state-fill" data-live-search="true" id="state" name="state">
                                                         @foreach (\App\State::all() as $key => $country)
                                                            <option value="{{ $country->name }}" @php if($statee->name==$country->name){ echo 'selected'; } @endphp >{{ $country->name }}</option>
                                                        @endforeach 
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('City')}}</label>
                                                    <input type="text" class="form-control" id="city" value="{{ $default_addr->city }}" name="city" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('Postal code')}}</label>
                                                    <input type="number" min="0" id="zip_code" class="form-control" value="{{ $default_addr->zip_code }}" name="postal_code" required>
                                                </div>
                                            </div>
                                           
                                        </div>

                                         <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                   
                                                    
                                                     <label class="control-label">{{__('Fill Later')}}
                                                        <input type="radio" class="form-control fill_later_checkbox" name="fill_later" value="fill_later" >
                                                     </label>
                                                </div>
                                            </div>
                                             <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                   
                                                    
                                                     <label class="control-label">{{__('Local Pickup')}}
                                                     <input type="radio" class="form-control " name="fill_later" value="local_pickup" >

                                                     </label>
                                                </div>
                                            </div>
                                        </div>


                                        <input type="hidden" name="checkout_type" value="logged">
                                    </div>
                                @else
                                    <div class="pr-4 pl-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Name')}}</label>
                                                    <input type="text" class="form-control" name="name"  required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Email')}}</label>
                                                    <input type="text" class="form-control" name="email" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group address-feld">
                                                    <label class="control-label">{{__('Address')}}</label>
                                                    <input type="text" class="form-control" name="address"  required>
                                                </div>
                                            </div>
                                        </div>


                                         <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group address-feld">
                                                    <label class="control-label">{{__('Address 1')}}</label>
                                                    <input type="text" class="form-control" name="address1"   required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('Phone')}}</label>
                                                    <input type="number" min="0" class="form-control" name="phone" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Select your country')}}</label>
                                                    <select class="form-control custome-control country_name" data-live-search="true" name="country">
                                                        @foreach (\App\Country::all() as $key => $country)
                                                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Select your state')}}</label>
                                                    <select class="form-control custome-control state-fill" data-live-search="true" name="state">
                                                        <!-- @foreach (\App\State::all() as $key => $country)
                                                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                        @endforeach -->
                                                    </select>
                                                </div>
                                            </div>


                                           
                                        </div>

                                        <div class="row">

                                             <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('City')}}</label>
                                                    <input type="text" class="form-control"  name="city" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('Postal code')}}</label>
                                                    <input type="number" min="0" class="form-control"  name="postal_code" required>
                                                </div>
                                            </div>
                                           
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                   
                                                    <input type="radio" class="form-control fill_later_checkbox" name="fill_later" value="fill_later" >
                                                     <label class="control-label">{{__('Fill Later')}}</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                   
                                                    
                                                     <label class="control-label">{{__('Local Pickup')}}
                                                     <input type="radio" class="form-control " name="fill_later" value="local_pickup" >

                                                     </label>
                                                </div>
                                            </div>
                                        </div>

                                        

                                        <input type="hidden" name="checkout_type" value="guest">
                                    </div>
                                @endif
                            </div>

                            <div class="row align-items-center mb-4 pr-4">
                                <div class="col-md-6">
                                    <a href="{{ route('home') }}" class="link link--style-3">
                                        <i class="ion-android-arrow-back"></i>
                                        {{__('Return to shop')}}
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-base-1">{{__('Continue to Delivery Info')}}</a>
                                </div>
                            </div>
                            {{-- <div class="row align-items-center pt-4">
                                <div class="col-6">
                                    <a href="{{ route('home') }}" class="link link--style-3">
                                        <i class="ion-android-arrow-back"></i>
                                        {{__('Return to shop')}}
                                    </a>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="submit" class="btn btn-base-1 ">{{__('Continue to Delivery Info')}}</a>
                                </div>
                            </div> --}}
                        </form>
                    </div>

                    <div class="col-lg-4 ml-lg-auto cart-bg">
                        @include('desktop.frontend.partials.cart_summary')
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
    loadStates();
    $('.country_name').on('change', function(){
        //console.log(this.value);
        loadStates();
        
    });


    $('.fill_later_checkbox').on('change', function(){
           var a =  $(this).val();
           
           if ($(this).prop('checked')==true){ 
                //alert('checked');
                $("#user_details input").removeAttr("required");
            }else{
                $("#user_details input").attr("required", true);
                $('.fill_later_checkbox').removeAttr("required");
            }
    });

@if( Auth::check() )
    $('.prefilled_addresses').on('change', function(){
        //console.log(this.value);
        loadPrefilledAddress();
        
    });

    $('.address_box').on('click', function(){
        $('.address_box').removeClass('active');
        $(this).addClass('active');
        var boxID = this.id.split("_");
        var addressBoxID = boxID['1'];
        
        var name_div = 'addr_name_'+addressBoxID;
        var email_div = 'addr_email_'+addressBoxID;
        var address_div = 'addr_address_'+addressBoxID;
        var address1_div = 'addr_address1_'+addressBoxID;
        var phone_div = 'addr_phone_'+addressBoxID;
        var country_div = 'addr_country_'+addressBoxID;
        var state_div = 'addr_state_'+addressBoxID;
        var city_div = 'addr_city_'+addressBoxID;
        var zip_code_div = 'addr_zip_code_'+addressBoxID;
        //alert( $('#'+email_div).val() );

        //now fill in the selected box values in the address input box fields, which are visible to user
        $('#name').val( $('#'+name_div).val() );
        $('#email').val( $('#'+email_div).val() );
        $('#address').val( $('#'+address_div).val() );
        $('#address1').val( $('#'+address1_div).val() );
        $('#phone').val( $('#'+phone_div).val() );
        $('#country').val( $('#'+country_div).val() );
        $('#state').val( $('#'+state_div).val() );
        $('#city').val( $('#'+city_div).val() );
        $('#zip_code').val( $('#'+zip_code_div).val() );
    });

     function loadPrefilledAddress(){
         $.ajax({
               type:"POST",
               url: '{{ route('ajax.getAddressInfo') }}',
               data: $('#user_details').serializeArray(),
               success: function(data){
                  console.log(data);
                  var d = JSON.parse(data);
                  if (d!=null) {
                      $("input[name='name']").val(d.name);
                      $("input[name='email']").val(d.email);
                      $("input[name='address']").val(d.address);
                      $("input[name='address1']").val(d.address1);
                      $("input[name='phone']").val(d.phone);
                      $('.country_name').val(d.country);
                      $('.state-fill').val(d.state);
                      $("input[name='city']").val(d.city);
                      $("input[name='postal_code']").val(d.zip_code);
                  }
                  //$('.state-fill').html(data);
               }
           });
    }
@endif
    

    function loadStates(){
         $.ajax({
               type:"POST",
               url: '{{ route('ajax.getStates') }}',
               data: $('#user_details').serializeArray(),
               success: function(data){
                  //console.log(data);
                  $('.state-fill').html(data);
               }
           });
    }
    </script>

@endsection
