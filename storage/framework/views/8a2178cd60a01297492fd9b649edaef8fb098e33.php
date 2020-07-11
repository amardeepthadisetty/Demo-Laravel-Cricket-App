<div class="card sticky-top">
    <div class="card-title">
        <div class="row align-items-center">
            <div class="col-12 border-bottom">
                <h3 class="heading-3 mb-0">
                    <span><?php echo e(__('Summary')); ?></span>
                </h3> 
            </div>
            <?php  
                $complete_order =  json_decode(  $order->complete_order, true ) ;
            ?>
            <!-- <div class="col-6 text-right">
                <span class="badge badge-md badge-success"><?php echo e(count( $complete_order)); ?> <?php echo e(__('Items')); ?></span>
            </div> -->
        </div>
    </div>

   
    <?php
                    $subtotal = 0;
                    $template = '';
                    $tax = 0;
                    $shipping = 0;
                    $promotion = 0;
                    
                ?>
                <?php $__currentLoopData = $complete_order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
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
                    ?>
                    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php $__currentLoopData = $complete_order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <?php 
                        $prod_name = \App\Product::find($cartItem['id'])->name;

                         //attach template name if template id is not zero
                        if( $cartItem['template_id'] != "0"  ){
                            $template = \App\Template::where('ref', $cartItem['template_id'] )->first();
                            $prod_name = $template->name. ' '. $product_name_with_choice;
                        }
                   ?>
                    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        

        <table class="table-cart table-cart-review">

            <tfoot>
                <tr class="cart-subtotal">
                    <th><?php echo e(__('Subtotal')); ?></th>
                    <td class="text-right">
                        <span class="strong-600"><?php echo e(single_price($order->sub_total)); ?></span>
                    </td>
                </tr>

                <?php if($order->promotion_discount!=0): ?>
                    <tr class="cart-subtotal">
                        <th><?php echo e(__('Promotion')); ?></th>
                        <td class="text-right">
                            <span class="strong-600"><?php echo e(single_price($order->promotion_discount)); ?></span>
                        </td>
                    </tr>
                <?php endif; ?>

               <!--  <tr class="cart-shipping">
                    <th><?php echo e(__('Tax')); ?></th>
                    <td class="text-right">
                        <span class="text-italic"><?php echo e(single_price($tax)); ?></span>
                    </td>
                </tr> -->
                <?php if( $order->shipping_status=="3"): ?>
                     <tr class="cart-shipping">
                        <th><?php echo e(__('Shipping Cost')); ?></th>
                        <td class="text-right">
                             <?php 
                                $FREESHIPPING =  \App\ShippingSetting::where('s_key', 'free_shipping')->first()->s_value;
                            ?>

                            <?php if($FREESHIPPING=="1"): ?>
                                FREE SHIPPING
                            <?php elseif($FREESHIPPING=="0"): ?>  
                            <span class="text-italic"><?php echo e(single_price($order->shipping_cost)); ?>  </span>
                            <?php endif; ?>
                            
                        </td>
                    </tr>
                <?php endif; ?>

                <?php
                    $total = ( $order->sub_total + $order->shipping_cost ) - $order->promotion_discount;
                    
                ?>

                <tr class="cart-total">
                    <th><span class="strong-600"><?php echo e(__('Total')); ?></span></th>
                    <td class="text-right">
                        <strong><span><?php echo e(single_price($total)); ?></span></strong>
                    </td>
                </tr>


                
                <?php if( $order->coupon_discount!=0 ): ?>
                    <tr class="cart-shipping">
                        <th>
                            <?php echo e(__('Coupon Discount')); ?>

                              ( <?php echo e(\App\Coupon::where('code',$order->coupon_code)->first()->name); ?> Applied ) 
                        </th>
                        
                        <td class="text-right">
                            <span class="text-italic"><?php echo e(single_price( $order->coupon_discount )); ?></span>
                        </td>
                    </tr>
                <?php endif; ?>

               <?php
                   // $total = ( $order->sub_total + $order->shipping_cost ) - $order->promotion_discount;

                   // $grand_total = $total - $order->coupon_discount;
                    
                ?>

                <tr class="cart-total">
                    <th><span class="strong-600"><?php echo e(__('Grand Total')); ?></span></th>
                    <td class="text-right">
                        <strong>
                            <span><?php echo e(single_price( $order->grand_total )); ?></span>

                        </strong>
                        <?php if(  !empty( $matchStatus )  ): ?>
                            <span> ( <?php echo e($matchStatus); ?> )</span>
                         <?php endif; ?>
                         <a  class="tax_breakup">TAX BREAKUP</a>
                         
                         
                    </td>
                </tr>

            </tfoot>
        </table>

        

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
                  <?php 
                    $history = App\PaymentHistory::where('order_id', $order->id)->where('status','success')->get();
                  ?>

                  <?php if( $history ): ?>
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
                             <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php if($h->payment_type=="cash_free"): ?>
                                            CashFree
                                        <?php elseif($h->payment_type=="paytm"): ?>
                                            Paytm
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($h->status); ?></td>
                                    <td><?php echo e($h->total_amount); ?></td>
                                    <td><?php echo e(date('d-m-Y h:i:s', strtotime( $h->created_at ) )); ?></td>
                                  </tr>

                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          
                          
                        </tbody>
                      </table>
                   

                  <?php endif; ?>
                  
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



<?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/partials/cart_summary_status.blade.php ENDPATH**/ ?>