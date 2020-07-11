<div class="card sticky-top">
    <div class="card-title">
        <div class="row align-items-center">
            <div class="col-12 border-bottom">
                <h3 class="heading-3  mb-0">
                    <span>{{__('Summary')}}</span>
                </h3> 
            </div>

            <!-- <div class="col-6 text-right">
                <span class="badge badge-md badge-success">{{ count(Session::get('cart')) }} {{__('Items')}}</span>
            </div> -->
        </div>
    </div>


    @php
                    $subtotal = 0;
                    $template = '';
                    $tax = 0;
                    $shipping = 0;
                    $promotion = 0;
                @endphp
                @foreach (Session::get('cart') as $key => $cartItem)
                    @php
                    $product = \App\Product::find($cartItem['id']);
                    $subtotal += $cartItem['price']*$cartItem['quantity'];
                    $tax += $cartItem['tax']*$cartItem['quantity'];
                    //$shipping += $cartItem['shipping']*$cartItem['quantity'];
                    $product_name_with_choice = $product->name;
                    if(isset($cartItem['color'])){
                        $product_name_with_choice .= ' - '.\App\Color::where('code', $cartItem['color'])->first()->name;
                    }
                    foreach (json_decode(json_encode($product->choice_options)) as $choice){
                        $str = $choice->name; // example $str =  choice_0
                        $product_name_with_choice .= ' - '.$cartItem['options'][$str];
                    }


                    //attach template name if template id is not zero
                    if( $cartItem['template_id'] != "0"  ){
                        $template = \App\Template::where('ref', $cartItem['template_id'] )->first();
                        $product_name_with_choice = $template->name. ' '. $product_name_with_choice;


                        /*//now attach if any uploaded images exists 
                        if ( json_decode( json_encode($template->more_settings) )->upload_settings->is_upload == "1" ) {
                            foreach($cartItem['uploaded_images'] as $img){
                                if($img!=''){
                                $user_uploaded_images .= '<img width="50px" height="50px" src="'.asset('uploads/user_uploaded_images/new/'.$img).'" >';
                                }
                            }
                            
                        }*/

                    }

                    $promotion = 0;
                    //Promotion selected or not
                    if( json_decode( json_encode( $product->more_settings ) )->promotion_settings->is_promotion=="1" ){
                        if( isset( $cartItem['promotion'] )  ){
                            
                            $promotion_obj = json_decode( json_encode( $product->more_settings ) );    
                            if( $cartItem['promotion']=="true"  ){
                                $promotion += ( float ) $promotion_obj->promotion_settings->promotion_discount;
                            }
                        }
                    }
                    @endphp
                {{-- <tr class="cart_item">
                    <td class="product-name">
                        {{ $product_name_with_choice }}
                        <strong class="product-quantity">× {{ $cartItem['quantity'] }}</strong>
                    </td>
                    <td class="product-total text-right">
                        <span class="pl-4">{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                    </td>
                </tr> --}}
                @endforeach

    <?php /*
        <table class="table-cart table-cart-review my-4">
            <thead>
                <tr>
                    <th class="product-name">{{__('Product Shipping charge')}}</th>
                    <th class="product-total text-right">{{__('Amount')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach (Session::get('cart') as $key => $cartItem)
                    @php 
                        $prod_name = \App\Product::find($cartItem['id'])->name;

                         //attach template name if template id is not zero
                        if( $cartItem['template_id'] != "0"  ){
                            $template = \App\Template::where('ref', $cartItem['template_id'] )->first();
                            $prod_name = $template->name. ' '. $product_name_with_choice;
                        }
                   @endphp
                    <tr class="cart_item">
                        <td class="product-name">
                            {{ $prod_name }}
                            <strong class="product-quantity">× {{ $cartItem['quantity'] }}</strong>
                        </td>
                        <td class="product-total text-right">
                            <span class="pl-4">{{ single_price($cartItem['shipping']*$cartItem['quantity']) }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> */ ?>

        <table class="table-cart table-cart-review">

            <tfoot>
                <tr class="cart-subtotal">
                    <th>{{__('Subtotal')}}</th>
                    <td class="text-right">
                        <span class="strong-600">{{ single_price($subtotal) }}</span>
                    </td>
                </tr>

                @if($promotion!=0)
                    <tr class="cart-subtotal">
                        <th>{{__('Promotion')}}</th>
                        <td class="text-right">
                           {{ single_price($promotion) }}
                        </td>
                    </tr>
                @endif

               <!--  <tr class="cart-shipping">
                    <th>{{__('Tax')}}</th>
                    <td class="text-right">
                        <span class="text-italic">{{ single_price($tax) }}</span>
                    </td>
                </tr> -->

                
        @if( Session::get('fill_later')!='fill_later')

                 @if( 
                request()->segment(1)!='cart' && 
                request()->segment(1)!='guest_checkout' &&
                request()->segment(1)!='checkout' &&
                request()->segment(1)!='delivery_method' 
                 )
                <tr class="cart-shipping">
                    <th>{{__('Shipping Cost')}}</th>
                    <td class="text-right">
                         @php 
                            $shipping = 0;
                            $FREESHIPPING =  \App\ShippingSetting::where('s_key', 'free_shipping')->first()->s_value;
                            $res='';
                            if ($FREESHIPPING=="0") {
                            $delivery_method_id = Session::get('shipping_method');
                            $res = showPriceForDeliveryMethods( $delivery_method_id );
                            $shipping = $res['shipping_cost'];
                            }
                        @endphp

                        @if($FREESHIPPING=="1")
                            FREE SHIPPING
                        @elseif($FREESHIPPING=="0")   
                        <span class="text-italic">{{ single_price($res['shipping_cost']) }}  </span>
                        @endif
                        
                    </td>
                </tr>
                @endif

        @endif

                @php
                    $total = $subtotal+$tax+$shipping;
                    
                @endphp

                <tr class="cart-total">
                    <th><span class="strong-600">{{__('Total')}}</span></th>
                    <td class="text-right">
                        <strong><span>{{ single_price($total) }}</span></strong>
                    </td>
                </tr>



                @if (Session::has('coupon_discount'))
                    <tr class="cart-shipping coupon">
                        <th>
                            {{__('Coupon Discount')}}
                            ( {{ \App\Coupon::find(Session::get('coupon_id'))->name }} Applied) 
                        </th>
                        <td class="text-right">
                            <span class="text-italic">{{ single_price(Session::get('coupon_discount')) }}</span>
                        </td>
                    </tr>
                @endif

                @php
                    $total = $subtotal+$tax+$shipping;
                    if(Session::has('coupon_discount')){
                        $total -= Session::get('coupon_discount');
                    }

                    if($promotion!=0){
                        $total -= (float) $promotion;
                    }
                @endphp

                <tr class="cart-total">
                    <th><span class="strong-600">{{__('Grand Total')}}</span></th>
                    <td class="text-right">
                        <strong><span>{{ single_price($total) }}</span></strong>
                    </td>
                </tr>
            </tfoot>
        </table>
        
                
        @if ( \App\BusinessSetting::where('type', 'coupon_system')->first()->value == 1)
            @if (Session::has('coupon_discount'))
                  
                <div class="mt-4 mb-3">
                    <form class="form-inline" action="{{ route('checkout.remove_coupon_code') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group flex-grow-1">
                            <div class="coupon-input">{{ \App\Coupon::find(Session::get('coupon_id'))->code }}</div>
                        </div>
                        <button type="submit" class="coupon-bt">{{__('Change Coupon')}}</button>
                    </form>
                </div>
                
            @else
                @if( 
                //Route::current()->getName()!='checkout.delivery_info_view' &&  
                Route::current()->getName()!='checkout.order_confirm_view' &&  
                Route::current()->getName()!='cart' && 
                Route::current()->getName()!='checkout.shipping_info' &&
                Route::current()->getName()!='checkout.delivery_method_view' 
                 ) 
                <div class="mt-3">
                    <form class="form-inline" action="{{ route('checkout.apply_coupon_code') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group flex-grow-1">
                            <input type="text" class="coupon-input" name="code" placeholder="Have coupon code? Enter here" required>
                        </div>
                        <button type="submit" class="coupon-bt">{{__('Apply')}}</button>
                    </form>
                </div>
                @endif 
            @endif
        @endif
                   
  
</div>
