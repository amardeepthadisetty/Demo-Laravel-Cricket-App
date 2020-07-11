<link type="text/css" href="{{ asset('frontend/css/cart.css') }}" rel="stylesheet" media="screen"> 


<div class="container">
    <div class="row cols-xs-space cols-sm-space cols-md-space">
        <div class="col-xl-8">
            <!-- <form class="form-default bg-white p-4" data-toggle="validator" role="form"> -->

    @if( !empty( $ajax_request_from_delivery_info )  )
        @if($ajax_request_from_delivery_info=="true")
        <form class="form-default" data-toggle="validator" action="{{ route('checkout.store_delivery_info') }}" role="form" method="POST">
        @endif
    @endif
           
            <div class="form-default bg-white pr-4">
               
                        <table class="table-cart border-bottom">
                            <thead>
                                <tr>
                                    <th class="product-image"></th>
                                    <th class="product-name">{{__('Product')}}</th>
                                    <!-- <th class="product-price d-none d-lg-table-cell">{{__('Price')}}</th>  -->
                                    <th class="product-quanity d-none d-md-table-cell">{{__('Quantity')}}</th>
                                    <th class="product-total">{{__('Total')}}</th>
                                    <!-- <th class="product-remove"></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total = 0;
                                $template = '';
                                @endphp
                                @foreach (Session::get('cart') as $key => $cartItem)
                                    @php
                                    $product = \App\Product::find($cartItem['id']);
                                    $total = $total + $cartItem['price']*$cartItem['quantity'];
                                    $product_name_with_choice = $product->name;
                                    if(isset($cartItem['color'])){
                                        $product_name_with_choice .= ' - '.\App\Color::where('code', $cartItem['color'])->first()->name;
                                    }
                                    foreach (json_decode( json_encode( $product->choice_options ) ) as $choice){
                                        $str = $choice->name; // example $str =  choice_0
                                        $product_name_with_choice .= ' - '.$cartItem['options'][$str];
                                    }


                                    $user_uploaded_images = '';
                                    //attach template name if template id is not zero
                                    if( $cartItem['template_id'] != "0"  ){
                                        $template = \App\Template::where('ref', $cartItem['template_id'] )->first();
                                        $product_name_with_choice = $template->name. ' '. $product_name_with_choice;


                                        //now attach if any uploaded images exists 
                                        if ( json_decode( json_encode($template->more_settings) )->upload_settings->is_upload == "1" ) {
                                            foreach($cartItem['uploaded_images'] as $img){
                                                if($img!=''){
                                                        $user_uploaded_images .= '<img width="30px" height="30px" src="'.asset( getImageURL( $img, 'icon' ) ).'" >';
                                                    }
                                            }
                                            
                                        }

                                    }

                                    
                                    if ( json_decode( json_encode($product->more_settings) )->upload_settings->is_upload == "1" ) {
                                            foreach($cartItem['uploaded_images'] as $img){
                                                if($img!=''){
                                                $user_uploaded_images .= '<img width="30px" height="30px" src="'.asset( getImageURL( $img, 'icon' ) ).'" >';
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
                                            <div class="remove-link"> 
                                                    <a href="#" onclick="removeFromCartView(event, {{ $key }})">
                                                       Remove
                                                    </a>
                                                    </div>
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

                                        <!-- <td class="product-price d-none d-lg-table-cell">
                                            <span class="pr-3 d-block">{{ single_price($cartItem['price']) }}</span>
                                        </td> -->

                                        <td class="product-quantity d-none d-md-table-cell">
                                            <div class="input-group input-group--style-2 pr-4" style="width: 130px;">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-number" type="button" data-type="minus" data-field="quantity[{{ $key }}]">
                                                        <i class="la la-minus"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="quantity[{{ $key }}]" class="form-control input-number" placeholder="1" value="{{ $cartItem['quantity'] }}" min="1" max="10" onchange="updateQuantity({{ $key }}, this)">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-number" type="button" data-type="plus" data-field="quantity[{{ $key }}]">
                                                        <i class="la la-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="product-total">
                                            <span>{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                                        </td>
                                        <!-- <td class="product-remove">
                                            <a href="#" onclick="removeFromCartView(event, {{ $key }})" class="text-right pl-4">
                                                <i class="la la-trash"></i>
                                            </a>
                                        </td> -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                 
            @if( !empty( $ajax_request_from_delivery_info )  )        
                @if($ajax_request_from_delivery_info=="true")
                          @if(Session::has('shipping_info'))
                                     <div class="row">
                                        <div class=" col-md-12">
                                                <div class="add-tab">
                                     
                                                    <h5 class="heading-5">
                                                    Shipping Info
                                                    </h3>

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
                                                </div>
                                        </div>
                                      </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-md-12 py-3 payment-op">
                                         
                                                    <h5 class="heading-5">
                                                        {{__('Select a payment option')}}
                                                    </h5>



                                                    @if(\App\BusinessSetting::where('type', 'cash_payment')->first()->value == 1)
                                                    <div class="pay-div">
                                                        <label class="payment_option mb-1 active" >
                                                            <input type="radio" id="" name="payment_option" value="cash_free" checked >
                                                            <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/card.png')}}" class="img-fluid"> 
                                                            
                                                            <span class="dp-in">
                                                                Card/Net Banking/Wallet/UPI - CashFree
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endif



                                                
                                                    <div class="pay-div">
                                                        <label class="payment_option mb-1" >
                                                            <input type="radio" id="" name="payment_option" value="cash_free" >
                                                            <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/paytm.png')}}" class="img-fluid"> 
                                                            
                                                            <span class="dp-in">
                                                                PayTM
                                                            </span>
                                                        </label>
                                                    </div>
                                             



                                            

                                            <div class="row align-items-center pt-4">
                                                <div class="col-6">
                                                    <a href="{{ route('home') }}" class="link link--style-3">
                                                        <i class="ion-android-arrow-back"></i>
                                                        {{__('Return to shop')}}
                                                    </a>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button type="submit" class="btn btn-base-1">{{__('Complete Order')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                             
                 
                @endif
            @endif
        </div>
    </form>
    

        <div class="col-xl-4 ml-lg-auto cart-bg">
            @include('desktop.frontend.partials.cart_summary')
        </div>
    </div>
</div>

<script type="text/javascript">
    cartQuantityInitialize();
</script>