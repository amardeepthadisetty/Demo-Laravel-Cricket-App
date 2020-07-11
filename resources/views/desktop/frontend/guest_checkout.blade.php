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
                 <div class="di-table active">
                     <a href="{{ route('checkout.guest_checkout') }}">
                          <h5>{{__('Guest Checkout')}}</h5>
                    </a>
                   
                 </div>
                @endif

                <div class="di-table ">
                    <a href="{{ route('checkout.shipping_info') }}">
                         <h5>{{__('Shipping info')}}</h5>
                    </a>
                   
                </div>

              <div class="di-table ">
                    <a href="{{ route('checkout.delivery_info_view') }}">
                        <h5>{{__('Delivery info')}}</h5>
                    </a>
                     
                </div>

                <div class="di-table">
                    <a href="{{ route('checkout.order_confirm_view') }}">
                        <h5>{{__('Confirmation')}}</h5>
                    </a>
                
                </div>
            </div>
            </div>
        </div>
    </section> 


        <section class="gry-bg address-form">
            <div class="container">
                <div class="row cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-lg-8">
                        <form class="form-default" id="user_details" data-toggle="validator" action="{{ route('checkout.store_guestcheckout_infostore') }}" role="form" method="POST">
                            @csrf
                            <div class="card"> 
                                @if(Auth::check())
                                    @php
                                        $user = Auth::user();
                                        //echo $user->name."<br>";
                                        $addresses = \App\Address::where('user_id', Auth::user()->id)->get();
                                        $default_addr = \App\Address::where('user_id', Auth::user()->id)->where('default_address',1)->first();
                                    @endphp

                                        
                                    
                                    
                                @else
                                    <div class="pr-4 pl-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Name')}}</label>
                                                    <input type="text" class="form-control" name="guest_name"  required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Email')}}</label>
                                                    <input type="text" class="form-control" name="guest_email" required>
                                                </div>
                                            </div>
                                        </div>

                                       

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('Phone')}}</label>
                                                    <input type="number" min="0" class="form-control" name="guest_phone" required>
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
                                    <button type="submit" class="btn btn-base-1">{{__('Continue to Shipping Info')}}</a>
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
    
    </script>

@endsection
