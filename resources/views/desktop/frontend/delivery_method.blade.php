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

                <div class="di-table ">
                    <a href="{{ route('checkout.shipping_info') }}">
                         <h5>{{__('Shipping info')}}</h5>
                    </a>
                   
                </div>

                 <div class="di-table  active">
                   <a href="{{ route('checkout.delivery_method_view') }}">
                         <h5>{{__('Delivery Methods')}}</h5>
                    </a>
                   
                </div>

              <div class="di-table ">
                    <a href="{{ route('checkout.delivery_info_view') }}">
                        <h5>{{__('Delivery info')}}</h5>
                    </a>
                     
                </div>

                <div class="di-table">
                    <!-- <a href="{{ route('checkout.order_confirm_view') }}"> -->
                        <h5>{{__('Confirmation')}}</h5>
                    <!-- </a> -->
                
                </div>
            </div>
            </div>
        </div>
    </section> 


        <section class="gry-bg" id="cart-summary">
            <div class="container">
                <div class="row cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-xl-8">
                         @if(Session::has('message'))
                            <div class="alert alert-warning">
                              <strong>Warning!</strong> {{ Session::get('message') }}
                            </div>
                        @endif
                        <form class="form-default" id="form_submit" data-toggle="validator" action="{{ route('checkout.store_delivery_method_info') }}" role="form" method="POST">
                            @csrf
                            @php
                                $admin_products = array();
                                $seller_products = array();
                                foreach (Session::get('cart') as $key => $cartItem){
                                    if(\App\Product::find($cartItem['id'])->added_by == 'admin'){
                                        array_push($admin_products, $cartItem['id']);
                                    }
                                    else{
                                        $product_ids = array();
                                        if(array_key_exists(\App\Product::find($cartItem['id'])->user_id, $seller_products)){
                                            $product_ids = $seller_products[\App\Product::find($cartItem['id'])->user_id];
                                        }
                                        array_push($product_ids, $cartItem['id']);
                                        $seller_products[\App\Product::find($cartItem['id'])->user_id] = $product_ids;
                                    }
                                }
                            @endphp

                            @if (!empty($admin_products))
                            <div class="card mb-3" >
                                <!-- <div class="card-header bg-white py-3">
                                    <h5 class="heading-6 mb-0">{{ \App\GeneralSetting::first()->site_name }} Products</h5>
                                </div> -->
                                <div class="form-default bg-white pr-4">
                               
                                        
                                @if(Session::get('fill_later')!="local_pickup")
                                @php  
                                    //$shipping_info = Session::get('shipping_info');
                                   //print_r($shipping_info);
                                @endphp
                                    @if(Session::has('shipping_info'))
                                   
                                    <div class="row">



                                         <div class=" col-md-12">
                                                <div class="add-tab">
                                     
                                                <h5 class="heading-5">
                                                Shipping Info
                                                </h5>

                                                    <p>
                                                    @php  
                                                        $shipping_info = Session::get('shipping_info');
                                                       
                                                    @endphp

                                                    @if($shipping_info['email'])  
                                                      <strong>{{ $shipping_info['name']  }}</strong> <br>
                                                    @endif
                                                   
                                                 

                                                    @if($shipping_info['address'])  
                                                     {{ $shipping_info['address'] }}<br>
                                                    @endif


                                                    @if($shipping_info['address1'])  
                                                     {{ $shipping_info['address1'] }}  <br>
                                                    @endif

                                                   

                                                     @if($shipping_info['city'])  
                                                        {{ $shipping_info['city'] }}<br>
                                                    @endif

                                                  

                                                  

                                                    @if($shipping_info['state'])  
                                                   {{ $shipping_info['state'] }}  <br>
                                                    @endif

                                               

                                                    @if($shipping_info['postal_code'])  
                                                     {{ $shipping_info['postal_code'] }} <br>
                                                    @endif

                                                  

                                                    </p>

                                                    <p>  @if($shipping_info['phone'])  
                                                        Phone : <span > {{ $shipping_info['phone'] }}  </span> 
                                                    @endif</p>
                                                    
                                                    <p>  @if($shipping_info['fill_later']=="fill_later")  
                                                         <span > Fill Later   </span> 
                                                         @elseif($shipping_info['fill_later']=="local_pickup") 
                                                         <span > Local Pickup   </span> 
                                                    @endif</p>
                                                </div>
                                         </div>


                                @if( $shippingMethods )
                                <div class="col-md-12 add-tab">
                                    <h5 class="heading-5">
                                        Select a Delivery Method
                                    </h5>
                                    @foreach( $shippingMethods as $sm)
                                        @php 
                                        $res='';
                                        $res = showPriceForDeliveryMethods( $sm->id );                                        
                                        $FREESHIPPING =  \App\ShippingSetting::where('s_key', 'free_shipping')->first()->s_value;

                                                    $show=false;
                                                     if($sm->id!=1){
                                                        if( $res['shipping_cost'] >0  ){
                                                            $show = true;
                                                        }
                                                     }else{
                                                        $show = true;
                                                    }
                                        @endphp

                                        @if($show)

                                            <div class="pay-div">
                                                        <label class="payment_option mb-1 active" >
                                                            <input type="radio" id="" name="shipping_method"  value="{{$sm->id}}" class="shipping_method" >
                                                            
                                                            <span class="dp-in">
                                                                {{$sm->name}}
                                                            </span>

                                                            <div>
                                                                @if($FREESHIPPING=="1")
                                                                    FREE SHIPPING
                                                                @elseif($FREESHIPPING=="0")  
                                                                {{ single_price($res['shipping_cost']) }}  
                                                                @endif
                                                            </div>
                                                        </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                @endif




                                    </div>
                                    @endif
                @endif
                               
                                    <div class="row">
                                        <div class="col-md-12 py-3 payment-op">
                                            
                                            @if($isLocalPickUpAvailable=="1")
                                                <div>
                                                    <h5 class="heading-5">
                                                        {{__('Select a Location for Local Pickup')}}
                                                    </h5>



                                                  
                                                    @if($locations)
                                                        @foreach( $locations as $loc)

                                                        <div class="pay-div">
                                                            <label class="payment_option mb-1 active" >
                                                                <input type="radio" id="" name="location_addr" class="location_addr"  value="{{$loc->id}}" >
                                                                
                                                                <span class="dp-in">
                                                                    {{$loc->location}}
                                                                </span>
                                                            </label>
                                                        </div>

                                                        @endforeach

                                                    @endif
                                                   

                                               </div>    
                                                    
                                            @endif 

                                            

                                            <div class="row align-items-center pt-4">
                                                <div class="col-6">
                                                    <a href="{{ route('home') }}" class="link link--style-3">
                                                        <i class="ion-android-arrow-back"></i>
                                                        {{__('Return to shop')}}
                                                    </a>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button type="submit" class="btn btn-base-1 ">{{__('Continue')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if (!empty($seller_products))
                                @foreach ($seller_products as $key => $seller_product)
                                    <div class="card mb-3">
                                        <div class="card-header bg-white py-3">
                                            <h5 class="heading-6 mb-0">{{ \App\Shop::where('user_id', $key)->first()->name }} Products</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row no-gutters">
                                                <div class="col-md-6">
                                                    <table class="table-cart">
                                                        <tbody>
                                                            @foreach ($seller_product as $id)
                                                            <tr class="cart-item">
                                                                <td class="product-image" width="25%">
                                                                    <a href="{{ route('product', \App\Product::find($id)->slug) }}" target="_blank">
                                                                        <img loading="lazy"  src="{{ asset(\App\Product::find($id)->thumbnail_img) }}">
                                                                    </a>
                                                                </td>
                                                                <td class="product-name strong-600">
                                                                    <a href="{{ route('product', \App\Product::find($id)->slug) }}" target="_blank" class="d-block c-base-2">
                                                                        {{ \App\Product::find($id)->name }}
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="d-flex align-items-center p-3 border rounded gry-bg c-pointer">
                                                                <input type="radio" name="shipping_type_{{ $key }}" value="home_delivery" checked class="d-none" onchange="show_pickup_point(this)" data-target=".pickup_point_id_{{ $key }}">
                                                                <span class="radio-box"></span>
                                                                <span class="d-block ml-2 strong-600">
                                                                    {{ __('Home Delivery') }}
                                                                </span>
                                                            </label>
                                                        </div>
                                                        @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                            @if (is_array(json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id)))
                                                                <div class="col-6">
                                                                    <label class="d-flex align-items-center p-3 border rounded gry-bg c-pointer">
                                                                        <input type="radio" name="shipping_type_{{ $key }}" value="pickup_point" class="d-none" onchange="show_pickup_point(this)" data-target=".pickup_point_id_{{ $key }}">
                                                                        <span class="radio-box"></span>
                                                                        <span class="d-block ml-2 strong-600">
                                                                            {{ __('Local Pickup') }}
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>

                                                    @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                        @if (is_array(json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id)))
                                                            @foreach (json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id) as $pick_up_point)
                                                                @if (\App\PickupPoint::find($pick_up_point) != null)
                                                                    <div class="mt-3 pickup_point_id_{{ $key }} d-none">
                                                                        <select class="pickup-select form-control-lg w-100" name="pickup_point_id_{{ $key }}" data-placeholder="Select a pickup point">
                                                                            <option>Select your nearest pickup point</option>
                                                                            <option value="{{ \App\PickupPoint::find($pick_up_point)->id }}" data-address="{{ \App\PickupPoint::find($pick_up_point)->address }}" data-phone="{{ \App\PickupPoint::find($pick_up_point)->phone }}">
                                                                                {{ \App\PickupPoint::find($pick_up_point)->name }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            
                        </form>
                    </div>
                    <div class="col-lg-4 ml-lg-auto cart-bg">
                        @include('desktop.frontend.partials.cart_summary')
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $('document').ready(function(){
            
        });

        function display_option(key){

        }
        function show_pickup_point(el) {
        	var value = $(el).val();
        	var target = $(el).data('target');

            console.log(value);

        	if(value == 'home_delivery'){
        		$(target).addClass('d-none');
        	}else{
        		$(target).removeClass('d-none');
        	}
        }



        $('.shipping_method').on('change', function(){
                var smvalue = this.value;
                //alert(smvalue);
                 $(".location_addr").removeAttr("checked");
        });

        $('.location_addr').on('change', function(){
                var lpvalue = this.value;
                //alert(lpvalue);
                $(".shipping_method").removeAttr("checked");
        });


       
       



         function removeFromCartView(e, key){
                e.preventDefault();
                removeFromCart(key);
            }

            function updateQuantity(key, element){
                $.post('{{ route('cart.updateQuantity') }}', { _token:'{{ csrf_token() }}', key:key, quantity: element.value, ajax_request_from_delivery_info: 'true' }, function(data){
                    updateNavCart();
                    $('#cart-summary').html(data);
                });
            }

            function showCheckoutModal(){
                $('#GuestCheckout').modal();
            }

           
    </script>
@endsection
