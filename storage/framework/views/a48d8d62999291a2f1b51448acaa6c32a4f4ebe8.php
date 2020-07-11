<?php $__env->startSection('content'); ?>
<link type="text/css" href="<?php echo e(asset('frontend/css/cart.css')); ?>" rel="stylesheet" media="screen"> 
    <div id="page-content">


                  
<section class="slice-xs">
        <div class="container container-sm">
            <div class="row ">
                <div class="col-md-12">
                

                <div class="di-table  ">
                    <a href="<?php echo e(route('fill_later.shipping_info')); ?>">
                         <h5><?php echo e(__('Shipping info')); ?></h5>
                    </a>
                   
                </div>

                <div class="di-table active  ">
                    <a href="<?php echo e(route('fill_later.delivery_method_view')); ?>"> 
                         <h5><?php echo e(__('Delivery Methods')); ?></h5>
                     </a> 
                   
                </div>

              <div class="di-table ">
                    <!-- <a href="<?php echo e(route('fill_later.delivery_info_view')); ?>"> -->
                        <h5><?php echo e(__('Payment Selection')); ?></h5>
                    <!-- </a> -->
                     
                </div>

                <div class="di-table">
                    <!-- <a href="<?php echo e(route('checkout.order_confirm_view')); ?>"> -->
                        <h5><?php echo e(__('Confirmation')); ?></h5>
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
                        <form class="form-default" id="form_submit" data-toggle="validator" action="<?php echo e(route('fill_later.store_delivery_method_info')); ?>" role="form" method="POST">
                            <?php echo csrf_field(); ?>
                            



                           
                            <div class="card mb-3" >
                                <!-- <div class="card-header bg-white py-3">
                                    <h5 class="heading-6 mb-0"><?php echo e(\App\GeneralSetting::first()->site_name); ?> Products</h5>
                                </div> -->
                                <div class="form-default bg-white pr-4">
                               
                            <?php if(Session::get('delivery_type')!="local_pickup"): ?>        
                               <div class="row">
                                    <?php if(Session::has('shipping_info')): ?>

                                         <div class=" col-md-12">
                                                <div class="add-tab">
                                     
                                                <h5 class="heading-5">
                                                Shipping Info
                                                </h5>

                                                    <p>
                                                    <?php  
                                                        $shipping_info = Session::get('shipping_info');
                                                       
                                                    ?>

                                                    <?php if($shipping_info['email']): ?>  
                                                      <strong><?php echo e($shipping_info['name']); ?></strong> <br>
                                                    <?php endif; ?>
                                                   
                                                 

                                                    <?php if($shipping_info['address']): ?>  
                                                     <?php echo e($shipping_info['address']); ?><br>
                                                    <?php endif; ?>


                                                    <?php if($shipping_info['address1']): ?>  
                                                     <?php echo e($shipping_info['address1']); ?>  <br>
                                                    <?php endif; ?>

                                                   

                                                     <?php if($shipping_info['city']): ?>  
                                                        <?php echo e($shipping_info['city']); ?><br>
                                                    <?php endif; ?>

                                                  

                                                  

                                                    <?php if($shipping_info['state']): ?>  
                                                   <?php echo e($shipping_info['state']); ?>  <br>
                                                    <?php endif; ?>

                                               

                                                    <?php if($shipping_info['postal_code']): ?>  
                                                     <?php echo e($shipping_info['postal_code']); ?> <br>
                                                    <?php endif; ?>

                                                  

                                                    </p>

                                                    <p>  <?php if($shipping_info['phone']): ?>  
                                                        Phone : <span > <?php echo e($shipping_info['phone']); ?>  </span> 
                                                    <?php endif; ?></p>
                                                    
                                                    
                                                </div>
                                         </div>


                                        <?php if( $shippingMethods ): ?>
                                        <div class="col-md-12 add-tab">
                                            <h5 class="heading-5">
                                                Select a Delivery Method
                                            </h5>
                                            <?php $__currentLoopData = $shippingMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php 
                                                    $res='';
                                                    $FREESHIPPING =  \App\ShippingSetting::where('s_key', 'free_shipping')->first()->s_value;
                                                     $res = showPriceForDeliveryMethods_filllater( $sm->id );

                                                     $show=false;
                                                     if($sm->id!=1){
                                                        if( $res['shipping_cost'] >0  ){
                                                            $show = true;
                                                        }
                                                     }else{
                                                        $show = true;
                                                    }

                                                     
                                                    
                                                ?>

                                                <?php if($show): ?>
                                                <div class="pay-div">
                                                    <label class="payment_option mb-1 active" >
                                                        <input type="radio" id="" name="shipping_method"  value="<?php echo e($sm->id); ?>" class="shipping_method" >
                                                        
                                                        <span class="dp-in">
                                                            <?php echo e($sm->name); ?>

                                                        </span>

                                                        
                                                        <div>
                                                            <?php if($FREESHIPPING=="1"): ?>
                                                                FREE SHIPPING
                                                            <?php elseif($FREESHIPPING=="0"): ?>  
                                                            <?php echo e(single_price($res['shipping_cost'])); ?>  
                                                            <?php endif; ?>
                                                        </div>
                                                    </label>
                                                </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php endif; ?>




                                   
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                               
                            <?php if(Session::get('delivery_type')=="local_pickup"): ?>    
                                    <div class="row">
                                        <div class="col-md-12 py-3 payment-op">
                                            
                                            <?php if($isLocalPickUpAvailable=="1"): ?>
                                                <div>
                                                    <h5 class="heading-5">
                                                        <?php echo e(__('Select a Location for Local Pickup')); ?>

                                                    </h5>



                                                  
                                                    <?php if($locations): ?>
                                                        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <div class="pay-div">
                                                            <label class="payment_option mb-1 active" >
                                                                <input type="radio" id="" name="location_addr" class="location_addr"  value="<?php echo e($loc->id); ?>" >
                                                                
                                                                <span class="dp-in">
                                                                    <?php echo e($loc->location); ?>

                                                                </span>
                                                            </label>
                                                        </div>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <?php endif; ?>
                                                   

                                               </div>    
                                                    
                                            <?php endif; ?> 
                                            

                                          
                            <?php endif; ?>    
                                      <div class="row align-items-center pt-4">
                                                <div class="col-6">
                                                    <a href="<?php echo e(route('home')); ?>" class="link link--style-3">
                                                        <i class="ion-android-arrow-back"></i>
                                                        <?php echo e(__('Return to shop')); ?>

                                                    </a>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button type="submit" class="btn btn-base-1 "><?php echo e(__('Continue')); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                            
                            <?php if(!empty($seller_products)): ?>
                                <?php $__currentLoopData = $seller_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $seller_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card mb-3">
                                        <div class="card-header bg-white py-3">
                                            <h5 class="heading-6 mb-0"><?php echo e(\App\Shop::where('user_id', $key)->first()->name); ?> Products</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row no-gutters">
                                                <div class="col-md-6">
                                                    <table class="table-cart">
                                                        <tbody>
                                                            <?php $__currentLoopData = $seller_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr class="cart-item">
                                                                <td class="product-image" width="25%">
                                                                    <a href="<?php echo e(route('product', \App\Product::find($id)->slug)); ?>" target="_blank">
                                                                        <img loading="lazy"  src="<?php echo e(asset(\App\Product::find($id)->thumbnail_img)); ?>">
                                                                    </a>
                                                                </td>
                                                                <td class="product-name strong-600">
                                                                    <a href="<?php echo e(route('product', \App\Product::find($id)->slug)); ?>" target="_blank" class="d-block c-base-2">
                                                                        <?php echo e(\App\Product::find($id)->name); ?>

                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="d-flex align-items-center p-3 border rounded gry-bg c-pointer">
                                                                <input type="radio" name="shipping_type_<?php echo e($key); ?>" value="home_delivery" checked class="d-none" onchange="show_pickup_point(this)" data-target=".pickup_point_id_<?php echo e($key); ?>">
                                                                <span class="radio-box"></span>
                                                                <span class="d-block ml-2 strong-600">
                                                                    <?php echo e(__('Home Delivery')); ?>

                                                                </span>
                                                            </label>
                                                        </div>
                                                        <?php if(\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1): ?>
                                                            <?php if(is_array(json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id))): ?>
                                                                <div class="col-6">
                                                                    <label class="d-flex align-items-center p-3 border rounded gry-bg c-pointer">
                                                                        <input type="radio" name="shipping_type_<?php echo e($key); ?>" value="pickup_point" class="d-none" onchange="show_pickup_point(this)" data-target=".pickup_point_id_<?php echo e($key); ?>">
                                                                        <span class="radio-box"></span>
                                                                        <span class="d-block ml-2 strong-600">
                                                                            <?php echo e(__('Local Pickup')); ?>

                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>

                                                    <?php if(\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1): ?>
                                                        <?php if(is_array(json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id))): ?>
                                                            <?php $__currentLoopData = json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pick_up_point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(\App\PickupPoint::find($pick_up_point) != null): ?>
                                                                    <div class="mt-3 pickup_point_id_<?php echo e($key); ?> d-none">
                                                                        <select class="pickup-select form-control-lg w-100" name="pickup_point_id_<?php echo e($key); ?>" data-placeholder="Select a pickup point">
                                                                            <option>Select your nearest pickup point</option>
                                                                            <option value="<?php echo e(\App\PickupPoint::find($pick_up_point)->id); ?>" data-address="<?php echo e(\App\PickupPoint::find($pick_up_point)->address); ?>" data-phone="<?php echo e(\App\PickupPoint::find($pick_up_point)->phone); ?>">
                                                                                <?php echo e(\App\PickupPoint::find($pick_up_point)->name); ?>

                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            
                        </form>
                    </div>
                    <div class="col-lg-4 ml-lg-auto cart-bg">
                        
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
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
                $.post('<?php echo e(route('cart.updateQuantity')); ?>', { _token:'<?php echo e(csrf_token()); ?>', key:key, quantity: element.value, ajax_request_from_delivery_info: 'true' }, function(data){
                    updateNavCart();
                    $('#cart-summary').html(data);
                });
            }

            function showCheckoutModal(){
                $('#GuestCheckout').modal();
            }

           
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/fill_later/delivery_method.blade.php ENDPATH**/ ?>