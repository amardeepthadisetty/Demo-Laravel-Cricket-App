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
               

   

        <table class="table-cart table-cart-review">

            <tfoot>
               


           

                
       

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
                            $delivery_method_id = Session::get('shipping_method_id');
                            $res = showPriceForDeliveryMethods_filllater( $delivery_method_id );
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

                    
                @endphp

                <tr class="cart-total">
                    <th><span class="strong-600">{{__('Grand Total')}}</span></th>
                    <td class="text-right">
                        <strong><span>{{ single_price($total) }}</span></strong>
                    </td>
                </tr>
            </tfoot>
        </table>
        
                
        <!-- @if ( \App\BusinessSetting::where('type', 'coupon_system')->first()->value == 1)
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
        @endif -->
                   
  
</div>
