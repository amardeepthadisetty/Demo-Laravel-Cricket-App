<div class="card sticky-top">
    <div class="card-title">
        <div class="row align-items-center">
            <div class="col-12 border-bottom">
                <h3 class="heading-3 mb-0">
                    <span>{{__('Summary')}}</span>
                </h3> 
            </div>
            @php  
                $complete_order =  json_decode(  $order->complete_order, true ) ;
            @endphp
            <!-- <div class="col-6 text-right">
                <span class="badge badge-md badge-success">{{ count( $complete_order) }} {{__('Items')}}</span>
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
                @foreach ( $complete_order as $key => $cartItem)
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


                        //now attach if any uploaded images exists 
                        if ( json_decode( json_encode($template->more_settings) )->upload_settings->is_upload == "1" ) {
                            foreach($cartItem['uploaded_images'] as $img){
                                if($img!=''){
                                $user_uploaded_images .= '<img width="50px" height="50px" src="'.asset('uploads/user_uploaded_images/new/'.$img).'" >';
                                }
                            }
                            
                        }

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
                    
                @endforeach

                @foreach ($complete_order as $key => $cartItem)
                   @php 
                        $prod_name = \App\Product::find($cartItem['id'])->name;

                         //attach template name if template id is not zero
                        if( $cartItem['template_id'] != "0"  ){
                            $template = \App\Template::where('ref', $cartItem['template_id'] )->first();
                            $prod_name = $template->name. ' '. $product_name_with_choice;
                        }
                   @endphp
                    
                @endforeach

        

        <table class="table-cart table-cart-review">

            <tfoot>
                <tr class="cart-subtotal">
                    <th>{{__('Subtotal')}}</th>
                    <td class="text-right">
                        <span class="strong-600">{{ single_price($order->sub_total) }}</span>
                    </td>
                </tr>

                @if($order->promotion_discount!=0)
                    <tr class="cart-subtotal">
                        <th>{{__('Promotion')}}</th>
                        <td class="text-right">
                            <span class="strong-600">{{ single_price($order->promotion_discount) }}</span>
                        </td>
                    </tr>
                @endif

               <!--  <tr class="cart-shipping">
                    <th>{{__('Tax')}}</th>
                    <td class="text-right">
                        <span class="text-italic">{{ single_price($tax) }}</span>
                    </td>
                </tr> -->
                @if( $order->shipping_status=="3")
                     <tr class="cart-shipping">
                        <th>{{__('Shipping Cost')}}</th>
                        <td class="text-right">
                             @php 
                                $FREESHIPPING =  \App\ShippingSetting::where('s_key', 'free_shipping')->first()->s_value;
                            @endphp

                            @if($FREESHIPPING=="1")
                                FREE SHIPPING
                            @elseif($FREESHIPPING=="0")  
                            <span class="text-italic">{{ single_price($order->shipping_cost) }}  </span>
                            @endif
                            
                        </td>
                    </tr>
                @endif

                @php
                    $total = ( $order->sub_total + $order->shipping_cost ) - $order->promotion_discount;
                    
                @endphp

                <tr class="cart-total">
                    <th><span class="strong-600">{{__('Total')}}</span></th>
                    <td class="text-right">
                        <strong><span>{{ single_price($total) }}</span></strong>
                    </td>
                </tr>


                
                @if ( $order->coupon_discount!=0 )
                    <tr class="cart-shipping">
                        <th>
                            {{__('Coupon Discount')}}
                              ( {{ \App\Coupon::where('code',$order->coupon_code)->first()->name }} Applied ) 
                        </th>
                        
                        <td class="text-right">
                            <span class="text-italic">{{ single_price( $order->coupon_discount ) }}</span>
                        </td>
                    </tr>
                @endif

               @php
                   // $total = ( $order->sub_total + $order->shipping_cost ) - $order->promotion_discount;

                   // $grand_total = $total - $order->coupon_discount;
                    
                @endphp

                <tr class="cart-total">
                    <th><span class="strong-600">{{__('Grand Total')}}</span></th>
                    <td class="text-right">
                        <strong>
                            <span>{{ single_price( $order->grand_total ) }}</span>

                        </strong>
                        @if(  !empty( $matchStatus )  )
                            <span> ( {{ $matchStatus }} )</span>
                         @endif
                         <a  class="tax_breakup">TAX BREAKUP</a>
                         
                         
                    </td>
                </tr>

            </tfoot>
        </table>

        {{-- @if (Auth::check() && \App\BusinessSetting::where('type', 'coupon_system')->first()->value == 1)
            @if (Session::has('coupon_discount'))
                <div class="mt-3">
                    <form class="form-inline" action="{{ route('checkout.remove_coupon_code') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group flex-grow-1">
                            <div class="form-control bg-gray w-100">{{ \App\Coupon::find(Session::get('coupon_id'))->code }}</div>
                        </div>
                        <button type="submit" class="btn btn-base-1">{{__('Change Coupon')}}</button>
                    </form>
                </div>
            @else
                <div class="mt-3">
                    <form class="form-inline" action="{{ route('checkout.apply_coupon_code') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group flex-grow-1">
                            <input type="text" class="form-control w-100" name="code" placeholder="Have coupon code? Enter here" required>
                        </div>
                        <button type="submit" class="btn btn-base-1">{{__('Apply')}}</button>
                    </form>
                </div>
            @endif
        @endif --}}

</div>





<!-- Modal -->
<div id="tax_breakup_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Break up of Amount</h4>
      </div>
      <div class="modal-body">
            <div class="container">
                  <h2>Transaction breakup</h2>
                  @php 
                    $history = App\PaymentHistory::where('order_id', $order->id)->where('status','success')->get();
                  @endphp

                  @if( $history )
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Payment Type</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Transaction Date</th>
                          </tr>
                        </thead>
                        <tbody>
                             @foreach( $history as $h)
                                <tr>
                                    <td>
                                        @if($h->payment_type=="cash_free")
                                            CashFree
                                        @elseif($h->payment_type=="paytm")
                                            Paytm
                                        @endif
                                    </td>
                                    <td>{{ $h->status }}</td>
                                    <td>{{ $h->total_amount }}</td>
                                    <td>{{ date('d-m-Y h:i:s', strtotime( $h->created_at ) ) }}</td>
                                  </tr>

                             @endforeach
                          
                          
                        </tbody>
                      </table>
                   

                  @endif
                  
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


    <script>
        $('.tax_breakup').on('click', function(){
            //alert('clicked');
            $('#tax_breakup_modal').modal('show');
        });
    </script>



