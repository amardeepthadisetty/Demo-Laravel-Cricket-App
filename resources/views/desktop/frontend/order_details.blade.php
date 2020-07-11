@extends('desktop.frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if(Auth::user()->user_type == 'seller')
                        @include('desktop.frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('desktop.frontend.inc.customer_side_nav')
                    @endif
                </div>

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
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('purchase_history.index') }}">{{__('Purchase History')}}</a></li>
                                        </ul>
                                    </div>
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

         @if($order->shipping_status=="3")
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
                                    {{ \App\LocalPickup::where('id',$order->local_pickup )->first()->location }}
                                </p>
                                @endif


                                 @if($order->delivery_method!=0 && $order->delivery_method!='')
                                <p>  
                                    {{ \App\ShippingMethod::where('id',$order->delivery_method )->first()->name }}
                                </p>
                                @endif
                                    </div>
                            </div>
                            @endif
        
        @endif


        @if($order->shipping_status=="1")
                    <form class="form-default" id="form_submit" data-toggle="validator" action="{{ route('fill_later.fill_later_continue') }}" role="form" method="POST">
                         @csrf
                        <input type="hidden" name="order_id" value="{{$order->id}}">
                             <div class="row add-tab">
                                <div class=" col-md-12">
                                    <h5 class="heading-5">Delivery type : Fill Later</h5>
                                  
                                        <p>
                                        Note: By selecting fill later option, you can pay the shipping charges later.
                                    </p>
                                        
                                    </div >
                                </div>
                                </div>

                                    <button type="submit" class="btn btn-warning">Fill Shipping Info</button>

                    </form>
         @endif           

         <div id="comment_box">
            <form class="form-default" id="form_submit" data-toggle="validator" action="{{ route('purchase_history.post_comment') }}" role="form" method="POST">
                 @csrf
                <input type="hidden" name="order_id" value="{{$order->id}}">
                      <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">{{__('Comments')}}</label>
                            <div class="col-lg-9">
                                <textarea class="form-control" name="comments" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit comments for this order</button>

            </form>
         </div>

         <div id="timeline">
             @include('desktop.frontend.partials.timeline')
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

    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>


 



@endsection

