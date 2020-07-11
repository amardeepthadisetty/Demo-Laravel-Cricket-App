<?php $__env->startSection('content'); ?>


<link type="text/css" href="<?php echo e(asset('frontend/css/cart.css')); ?>" rel="stylesheet" media="screen"> 


    <div id="page-content">
       


                
<section class="slice-xs">
        <div class="container container-sm">
            <div class="row ">
                <div class="col-md-12">
                <div class="di-table ">
                    <a href="<?php echo e(route('cart')); ?>">
                         <h5><?php echo e(__('My Cart')); ?></h5>
                    </a>
                   
                </div>

                <?php if(!Auth::check()): ?>
                 <div class="di-table active">
                     <a href="<?php echo e(route('checkout.guest_checkout')); ?>">
                          <h5><?php echo e(__('Guest Checkout')); ?></h5>
                    </a>
                   
                 </div>
                <?php endif; ?>

                <div class="di-table ">
                    <a href="<?php echo e(route('checkout.shipping_info')); ?>">
                         <h5><?php echo e(__('Shipping info')); ?></h5>
                    </a>
                   
                </div>

              <div class="di-table ">
                    <a href="<?php echo e(route('checkout.delivery_info_view')); ?>">
                        <h5><?php echo e(__('Delivery info')); ?></h5>
                    </a>
                     
                </div>

                <div class="di-table">
                    <a href="<?php echo e(route('checkout.order_confirm_view')); ?>">
                        <h5><?php echo e(__('Confirmation')); ?></h5>
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
                        <form class="form-default" id="user_details" data-toggle="validator" action="<?php echo e(route('checkout.store_guestcheckout_infostore')); ?>" role="form" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="card"> 
                                <?php if(Auth::check()): ?>
                                    <?php
                                        $user = Auth::user();
                                        //echo $user->name."<br>";
                                        $addresses = \App\Address::where('user_id', Auth::user()->id)->get();
                                        $default_addr = \App\Address::where('user_id', Auth::user()->id)->where('default_address',1)->first();
                                    ?>

                                        
                                    
                                    
                                <?php else: ?>
                                    <div class="pr-4 pl-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo e(__('Name')); ?></label>
                                                    <input type="text" class="form-control" name="guest_name"  required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo e(__('Email')); ?></label>
                                                    <input type="text" class="form-control" name="guest_email" required>
                                                </div>
                                            </div>
                                        </div>

                                       

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label"><?php echo e(__('Phone')); ?></label>
                                                    <input type="number" min="0" class="form-control" name="guest_phone" required>
                                                </div>
                                            </div>
                                        </div>


                                        <input type="hidden" name="checkout_type" value="guest">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="row align-items-center mb-4 pr-4">
                                <div class="col-md-6">
                                    <a href="<?php echo e(route('home')); ?>" class="link link--style-3">
                                        <i class="ion-android-arrow-back"></i>
                                        <?php echo e(__('Return to shop')); ?>

                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-base-1"><?php echo e(__('Continue to Shipping Info')); ?></a>
                                </div>
                            </div>
                            
                        </form>
                    </div>

                    <div class="col-lg-4 ml-lg-auto cart-bg">
                        <?php echo $__env->make('desktop.frontend.partials.cart_summary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
    
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/guest_checkout.blade.php ENDPATH**/ ?>