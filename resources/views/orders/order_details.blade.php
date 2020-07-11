@extends('layouts.app')

@section('content')

    <div class="row">
        
    </div><br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Order details Information')}}</h3>
        </div>
        <div class="panel-body">
              <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('Purchase Order Details')}}
                                    </h2>
                                </div>
                               
                            </div>
                        </div>


                        @if ( $payment['txStatus']=="SUCCESS" ) 
           
      
                            <div class="container">
                                <div class="alert alert-primary" role="alert">
                                    {{__('Your order has been successfully placed !!! ')}}
                                </div>
                            </div>
                        @endif

                        

                        @if ( Session::get('message') ) 
           
      
                            <div class="container">
                                <div class="alert alert-primary" role="alert">
                                    {{ Session::get('message') }}
                                </div>
                            </div>
                        @endif



                        @if ( $payment['txStatus']!="SUCCESS" ) 
           
                        
                            <div class="container">
                                <div class="alert alert-danger" role="alert">
                                    {{__('Your order did not confirm !!! ')}}
                                </div>
                            </div>

                        @endif

                        <div>
                            @php 
                            
                            $complete_order =  json_decode(  $order->complete_order, true ) ;
                            
                            @endphp

                            <section class="py-4 gry-bg" id="cart-summary">
                                <div class="container">
                                    @if( $complete_order )
                                        <div class="row cols-xs-space cols-sm-space cols-md-space">
                                        <div class="col-xl-8">

                                            <div class="form-default bg-white p-4">
                                                <div class="">
                                                    <div class="">
                                                        <table class="table-cart border-bottom">
                                                            <thead>
                                                                <tr>
                                                                    <th class="product-image"></th>
                                                                    <th class="product-name">{{__('Product')}}</th>
                                                                    <th class="product-price d-none d-lg-table-cell">{{__('Price')}}</th>
                                                                    <th class="product-quanity d-none d-md-table-cell">{{__('Quantity')}}</th>
                                                                    <th class="product-total">{{__('Total')}}</th>
                                                                    <th class="product-remove"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                $total = 0;
                                                                

                                                                
                                                                @endphp
                                                                @foreach ($complete_order as $cartItem)
                                                                    @php
                                                                    $user_uploaded_images = '';
                                                                    $product = \App\Product::find($cartItem['id']);
                                                                    
                                                                    $total = $total + $cartItem['price']*$cartItem['quantity'];
                                                                    $product_name_with_choice = $product->name;
                                                                    if(isset($cartItem['color'])){
                                                                        $product_name_with_choice .= ' - '.\App\Color::where('code', $cartItem['color'])->first()->name;
                                                                    }
                                                                    foreach (json_decode( json_encode($product->choice_options) ) as $choice){
                                                                        $str = $choice->name; // example $str =  choice_0
                                                                        $product_name_with_choice .= ' - '.$cartItem['options'][$str];
                                                                    }

                                                                    //attach template name if template id is not zero
                                                                    if( $cartItem['template_id'] != "0"  ){
                                                                        $template = \App\Template::where('ref', $cartItem['template_id'] )->first();
                                                                        $product_name_with_choice = $template->name. ' '. $product_name_with_choice;


                                                                        //now attach if any uploaded images exists 
                                                                        if ( json_decode( json_encode($template->more_settings) )->upload_settings->is_upload == "1" ) {
                                                                            foreach($cartItem['uploaded_images'] as $img){
                                                                                if($img!=''){
                                                                                $user_uploaded_images .= '<img width="50px" height="50px" src="'.asset( getImageURL( $img, 'icon' ) ).'" >';
                                                                                }
                                                                            }
                                                                            
                                                                        }

                                                                    }

                                                                
                                                                    if ( json_decode( json_encode($product->more_settings) )->upload_settings->is_upload == "1" ) {
                                                                        foreach($cartItem['uploaded_images'] as $img){
                                                                            if($img!=''){
                                                                            $user_uploaded_images .= '<img width="50px" height="50px" src="'.asset( getImageURL( $img, 'icon' ) ).'" >';
                                                                            }
                                                                        }
                                                                        
                                                                    }
                                                                    @endphp
                                                                    <tr class="cart-item">
                                                                        <td class="product-image">
                                                                            <a href="#" class="mr-3">
                                                                                @php 
                                                                                    $imageURL = '';
                                                                                    if( !empty( ($product->photos)[0] ) )
                                                                                        $imageURL = ($product->photos)[0];                               

                                                                                @endphp
                                                                                <img loading="lazy"  src="{{ asset( getImageURL($imageURL, 'icon') ) }}">
                                                                            </a>
                                                                        </td>

                                                                        <td class="product-name">
                                                                            <span class="pr-4 d-block">{{ $product_name_with_choice }}</span>
                                                                            @if( $user_uploaded_images!='')
                                                                            <div> Your Image is: 
                                                                                {!! $user_uploaded_images !!}
                                                                            </div>
                                                                            @endif

                                                                            @php
                                                                            if( json_decode( json_encode( $product->additional_options ) ) )
                                                                            {
                                                                                $addopt = json_decode( json_encode( $product->additional_options ) );
                                                                                foreach($addopt as $aopt){
                                                                                    switch($aopt->option_type){
                                                                                        case 'text':
                                                                                            echo '<div>';
                                                                                            $name = $aopt->name;    
                                                                                            echo $aopt->title.' : '. $cartItem['additional_options'][$name];
                                                                                            echo '</div>'; 
                                                                                            break;
                                                                                        case 'textarea':
                                                                                            echo '<div>';
                                                                                            $name = $aopt->name;    
                                                                                            echo $aopt->title.' : '. $cartItem['additional_options'][$name];
                                                                                            echo '</div>'; 
                                                                                            break;
                                                                                        case 'radio':
                                                                                            foreach($aopt->options as $o){
                                                                                                $name = concat_string($aopt->title , $o);
                                                                                                echo '<div>';
                                                                                                if( isset( $cartItem['additional_options'][$name] ) ){
                                                                                                    if( $cartItem['additional_options'][$name]=="yes" ){
                                                                                                        echo $aopt->title.' : '. $o;
                                                                                                    }
                                                                                                }    
                                                                                                
                                                                                                echo '</div>'; 
                                                                                            }
                                                                                            break;
                                                                                        case 'checkbox':
                                                                                                foreach($aopt->options as $o){
                                                                                                $name = concat_string($aopt->title , $o);
                                                                                                echo '<div>';
                                                                                                if( isset( $cartItem['additional_options'][$name] ) ){
                                                                                                    if( $cartItem['additional_options'][$name]=="yes" ){
                                                                                                        echo $aopt->title.' : '. $o;
                                                                                                    }
                                                                                                }    
                                                                                                
                                                                                                echo '</div>'; 
                                                                                            }
                                                                                            break;            
                                                                                        default :

                                                                                        break;
                                                                                    }
                                                                                    
                                                                                }
                                                                            }



                                                                            //this is for template additional options 
                                                                            if( $cartItem['template_id'] != "0"  ){

                                                                                if( json_decode( json_encode( $template->additional_options ) ) )
                                                                                {
                                                                                    $addopt = json_decode( json_encode( $template->additional_options ) );
                                                                                    foreach($addopt as $aopt){
                                                                                        switch($aopt->option_type){
                                                                                            case 'text':
                                                                                                echo '<div>';
                                                                                                $name = $aopt->name;    
                                                                                                echo $aopt->title.' : '. $cartItem['additional_options'][$name];
                                                                                                echo '</div>'; 
                                                                                                break;
                                                                                            case 'textarea':
                                                                                                echo '<div>';
                                                                                                $name = $aopt->name;    
                                                                                                echo $aopt->title.' : '. $cartItem['additional_options'][$name];
                                                                                                echo '</div>'; 
                                                                                                break;
                                                                                            case 'radio':
                                                                                                foreach($aopt->options as $o){
                                                                                                    $name = concat_string($aopt->title , $o);
                                                                                                    echo '<div>';
                                                                                                    if( isset( $cartItem['additional_options'][$name] ) ){
                                                                                                        if( $cartItem['additional_options'][$name]=="yes" ){
                                                                                                            echo $aopt->title.' : '. $o;
                                                                                                        }
                                                                                                    }    
                                                                                                    
                                                                                                    echo '</div>'; 
                                                                                                }
                                                                                                break;
                                                                                            case 'checkbox':
                                                                                                    foreach($aopt->options as $o){
                                                                                                    $name = concat_string($aopt->title , $o);
                                                                                                    echo '<div>';
                                                                                                    if( isset( $cartItem['additional_options'][$name] ) ){
                                                                                                        if( $cartItem['additional_options'][$name]=="yes" ){
                                                                                                            echo $aopt->title.' : '. $o;
                                                                                                        }
                                                                                                    }    
                                                                                                    
                                                                                                    echo '</div>'; 
                                                                                                }
                                                                                                break;            
                                                                                            default :

                                                                                            break;
                                                                                        }
                                                                                        
                                                                                    }
                                                                                }

                                                                            }


                                                                            //instructions
                                                                            if( json_decode( json_encode( $product->more_settings ) )->instructions=="1" ){
                                                                                if( isset( $cartItem['instructions'] )  ){
                                                                                    echo '<div>';
                                                                                    echo 'Instructions :'.$cartItem['instructions'];
                                                                                    echo '</div>';
                                                                                }
                                                                            }

                                                                            //Promotion selected or not
                                                                            if( json_decode( json_encode( $product->more_settings ) )->promotion_settings->is_promotion=="1" ){
                                                                                if( isset( $cartItem['promotion'] )  ){
                                                                                    echo '<div>';
                                                                                    $promotion_text = json_decode( json_encode( $product->more_settings ) )->promotion_settings->promotion_text;    
                                                                                    if( $cartItem['promotion']=="true"  ){
                                                                                        echo $promotion_text.' : Yes';
                                                                                    }
                                                                                    
                                                                                    echo '</div>';
                                                                                }
                                                                            }

                                                                            @endphp



                                                                        </td>

                                                                        <td class="product-price d-none d-lg-table-cell">
                                                                            <span class="pr-3 d-block">{{ single_price($cartItem['price']) }}</span>
                                                                        </td>

                                                                        <td class="product-quantity d-none d-md-table-cell">
                                                                            <div class="input-group input-group--style-2 pr-4" style="width: 130px;">
                                                                            

                                                                                {{ $cartItem['quantity'] }}
                                                                            </div>
                                                                        </td>
                                                                        <td class="product-total">
                                                                            <span>{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                                                                        </td>
                                                                        <td class="product-remove">
                                                                        
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>

        @if($order->shipping_status!="3")
            @php  
            $shipping_info =  json_decode(  $order->shipping_address, true ) ;
            
            @endphp

                         @if($shipping_info)
                            
                            <div class="row">
                        
                                <div class="col-md-6">
                                    <h5>User Shipping Info</h5>
                                        <p>

                                        @if($shipping_info['email'])  
                                            Name : <span>{{ $shipping_info['name']  }}   </span> <br>
                                        @endif
                                    
                                        @if($shipping_info['email'])  
                                            Email : <span> {{ $shipping_info['email'] }}  </span> <br>
                                        @endif

                                        @if($shipping_info['address'])  
                                            Address : <span> {{ $shipping_info['address'] }}  </span> <br>
                                        @endif


                                        @if($shipping_info['address1'])  
                                            Address 1 : <span> {{ $shipping_info['address1'] }}  </span> <br>
                                        @endif

                                        @if($shipping_info['phone'])  
                                            Phone : <span> {{ $shipping_info['phone'] }}  </span> <br>
                                        @endif

                                        @if($shipping_info['country'])  
                                            Country : <span> {{ $shipping_info['country'] }}  </span> <br>
                                        @endif

                                        @if($shipping_info['state'])  
                                        State : <span> {{ $shipping_info['state'] }}  </span> <br>
                                        @endif

                                        @if($shipping_info['city'])  
                                            City : <span> {{ $shipping_info['city'] }}  </span> <br>
                                        @endif

                                        @if($shipping_info['postal_code'])  
                                            Postal Code : <span> {{ $shipping_info['postal_code'] }}  </span> <br>
                                        @endif
                                        <input type="hidden" id="shipping_address_array" name="shipping_info" value="{{ json_encode($shipping_info) }}">
                                        <button type="submit" class="btn btn-danger edit_shipping_info">Edit Shipping Info</button>
                                        </p>

                                         <p> 
                                     @if($order->delivery_type=="fill_later")  
                                         <span > Fill Later   </span> 
                                         @elseif($order->delivery_type=="local_pickup") 
                                         <span > Local Pickup   </span> 
                                    @endif
                                </p>

                                @if($order->local_pickup!=0 && $order->local_pickup!='')
                                <p>
                                   Local Pickup :  {{ \App\LocalPickup::where('id',$order->local_pickup )->first()->location }}
                                </p>
                                @endif



                                    </div>
                            </div>
                            @endif
        
        @endif

        @if($order->shipping_status=="3")
            @if($order->delivery_method!=0 && $order->delivery_method!='')
            <p>
                {{ \App\ShippingMethod::where('id',$order->delivery_method )->first()->name }}
            </p>
            @endif
        @endif

          

         <div id="comment_box">
                <form class="form-default" id="form_submit" data-toggle="validator" action="{{ route('admin.orders.postAdminComments') }}" role="form" method="POST">
                     @csrf
                    <input type="hidden" name="order_id" value="{{$order->id}}">

                    		<div class="form-group">
                                <label class="col-lg-3 control-label" for="name">{{__('Order Status')}}</label>
                                <div class="col-lg-9">
                                    <select name="order_status" class="form-control" required>
                                        @foreach($statusCodes as $sc)
                                            <option value="{{ $sc->id }}" @php if($order->order_status== $sc->id) echo 'selected'; @endphp>{{ $sc->display_name }}</option>
                                        @endforeach
                                    	
                                    </select>
                                </div>
                            </div>

                          <div class="form-group">
                                <label class="col-lg-3 control-label" for="name">{{__('Comments')}}</label>
                                <div class="col-lg-9">
                                    <textarea class="form-control" name="comments" ></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="name">{{__('Show above comment to user')}}</label>
                                <div class="col-lg-9">
                                    <select name="show_user" class="form-control" required>
                                    	<option value="1" selected>Yes</option>
                                    	<option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit comments for this order</button>

                </form>
         </div>

        <div id="timeline">
                @include('orders.timeline')
        </div>



                        </div>
                    </div>

                                                <div class="row align-items-center pt-4">
                                                    <div class="col-6">
                                                        <a href="{{ route('home') }}" class="link link--style-3">
                                                            <i class="la la-mail-reply"></i>
                                                            {{__('Return to shop')}}
                                                        </a>
                                                    </div>
                                                    <div class="col-6 text-right">
                                                    <!--  @if(Auth::check())
                                                            <a href="{{ route('checkout.shipping_info') }}" class="btn btn-styled btn-base-1">{{__('Continue to Shipping')}}</a>
                                                        @else
                                                            <button class="btn btn-styled btn-base-1" onclick="showCheckoutModal()">{{__('Continue to Shipping')}}</button>
                                                        @endif -->


                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>

                                        <div class="col-xl-4 ml-lg-auto">
                                            @include('desktop.frontend.partials.cart_summary_status')
                                        </div>
                                    </div>
                                    @else
                                        <div class="dc-header">
                                            <h3 class="heading heading-6 strong-700">{{__('Your Cart is empty')}}</h3>
                                        </div>
                                    @endif
                                </div>
                            </section>
                        </div>

                        

                       
                    </div>
                </div>
            </div>
        </div>
    </section>

        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Shipping Info</h4>
          </div>
          <form id="user_details" method="POST" action="{{ route('ajax.orders.updateShippingInfo') }}">
          @csrf
          <div class="modal-body">
                <div class="row">
                                        <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Name')}}</label>
                                                    <input type="text" id="name" class="form-control" name="name"  required>
                                                   <input type="hidden" name="order_id" value="{{$order->id}}">
                                                </div>
                                            </div>
                                        </div>


                                         <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Email')}}</label>
                                                    <input type="text" id="email" class="form-control" name="email" required>
                                                </div>
                                            </div>
                                        </div>

                                         <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group address-feld">
                                                    <label class="control-label">{{__('Address')}}</label>
                                                    <input type="text" id="address" class="form-control" name="address"  required>
                                                </div>
                                            </div>
                                        </div>


                                           <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group address-feld">
                                                    <label class="control-label">{{__('Address 1')}}</label>
                                                    <input type="text" id="address1" class="form-control" name="address1"   required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('Phone')}}</label>
                                                    <input type="number" min="0" class="form-control" id="phone" name="phone" required>
                                                </div>
                                            </div>
                                        </div>

                                          <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Select your country')}}</label>
                                                    <select class="form-control custome-control country_name" data-live-search="true" id="country" name="country">
                                                        @foreach (\App\Country::all() as $key => $country)
                                                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">{{__('Select your state')}}</label>
                                                    <select class="form-control custome-control state-fill" data-live-search="true" id="state" name="state">
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">

                                             <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('City')}}</label>
                                                    <input type="text" class="form-control"  name="city" id="city" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label">{{__('Postal code')}}</label>
                                                    <input type="number" min="0" class="form-control" id="postal_code"  name="postal_code" required>
                                                </div>
                                            </div>
                                           
                </div>

                <div class="row">

                    @php
                    $isLocalPickUpAvailable = \App\ShippingSetting::where('s_key','local_pickup')->first()->s_value;

                    @endphp

                        <div class="col-md-12 py-3 payment-op">
                                            
                                @if($isLocalPickUpAvailable=="1")
                                  @php 
                                  $locations = \App\LocalPickup::where('status','1')->get();
                                  @endphp
                                    <div>
                                        ( OR )
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

                        </div>              

                                          
                    
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>



    <script>
        
        $('.edit_shipping_info').on('click', function(){
            $('#myModal').modal('show');
            var data = JSON.parse($('#shipping_address_array').val());
           // console.log(data.name);
            //console.table(data);
            
            $('#name').val( data.name  );
            $('#email').val( data.email  );
            $('#address').val( data.address  );
            $('#address1').val( data.address1  );
            $('#country').val( data.country  );
            $('#state').val( data.state  );
            $('#city').val( data.city  );
            $('#postal_code').val( data.postal_code  );
            $('#phone').val( data.phone  );
            loadStates();
            
        });



         function loadStates(){
         $.ajax({
               type:"POST",
               url: '{{ route('ajax.orders.getStates') }}',
               data: $('#user_details').serializeArray(),
               success: function(data){
                  console.log(data);
                  
                  $('.state-fill').html(data);

                  var shippingstuff = JSON.parse($('#shipping_address_array').val());
                  $('#state').val( shippingstuff.state  );
               }
           });
    }
    </script>

@endsection
