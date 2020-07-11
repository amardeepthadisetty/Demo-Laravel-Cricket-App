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
                 <div class="di-table">
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

                 <div class="di-table  ">
                   <a href="<?php echo e(route('checkout.delivery_method_view')); ?>">
                         <h5><?php echo e(__('Delivery Methods')); ?></h5>
                    </a>
                   
                </div>

              <div class="di-table active">
                    <a href="<?php echo e(route('checkout.delivery_info_view')); ?>">
                        <h5><?php echo e(__('Delivery info')); ?></h5>
                    </a>
                     
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
                        <?php if(Session::has('message')): ?>
                            <div class="alert alert-warning">
                              <strong>Warning!</strong> <?php echo e(Session::get('message')); ?>

                            </div>
                        <?php endif; ?>

                        <form class="form-default" id="form_submit" data-toggle="validator" action="<?php echo e(route('checkout.store_delivery_info')); ?>" role="form" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php
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
                            ?>

                            <?php if(!empty($admin_products)): ?>
                            <div class="card mb-3" >
                                <!-- <div class="card-header bg-white py-3">
                                    <h5 class="heading-6 mb-0"><?php echo e(\App\GeneralSetting::first()->site_name); ?> Products</h5>
                                </div> -->
                                <div class="form-default bg-white pr-4">
                               
                                        <table class="table-cart border-bottom">
                                            <thead>
                                                <tr>
                                                    <th class="product-image"></th>
                                                    <th class="product-name"><?php echo e(__('Product')); ?></th>
                                                    <!-- <th class="product-price d-none d-lg-table-cell"><?php echo e(__('Price')); ?></th> -->
                                                    <th class="product-quanity d-none d-md-table-cell"><?php echo e(__('Quantity')); ?></th>
                                                    <th class="product-total"><?php echo e(__('Total')); ?></th>
                                                    <!-- <th class="product-remove"></th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total = 0;
                                                $template = '';
                                                ?>
                                                <?php $__currentLoopData = Session::get('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
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
                                                    ?>
                                                    <tr class="cart-item">
                                                        <td class="product-image">
                                                            <a href="#" class="mr-3">
                                                                <?php 
                                                                    $imageURL = '';
                                                                    if( !empty( ($product->photos)[0] ) )
                                                                        $imageURL = ($product->photos)[0];                               

                                                                ?>
                                                                <img loading="lazy"  src="<?php echo e(asset( getImageURL($imageURL, 'icon') )); ?>">
                                                            </a>
                                                            <div class="remove-link"> 
                                                            <!-- <a href="#" onclick="removeFromCartView(event, <?php echo e($key); ?>)" class="">
                                                               Remove
                                                            </a> -->
                                                            </div>
                                                        </td>

                                                        <td class="product-name">
                                                            <span class="pr-4 d-block"><?php echo e($product_name_with_choice); ?></span>
                                                            <?php if( $user_uploaded_images!=''): ?>
                                                            <div> Your Image is: 
                                                                <?php echo $user_uploaded_images; ?>

                                                            </div>
                                                            <?php endif; ?>

                                                            <?php
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

                                                            ?>



                                                        </td>

                                                        <!-- <td class="product-price d-none d-lg-table-cell">
                                                            <span class="pr-3 d-block"><?php echo e(single_price($cartItem['price'])); ?></span>
                                                        </td> -->

                                                        <td class="product-quantity d-none d-md-table-cell">
                                                            <div class="input-group input-group--style-2 pr-4" style="width: 130px;">
                                                                <?php echo e($cartItem['quantity']); ?>

                                                            </div>
                                                        </td>
                                                        <td class="product-total">
                                                            <span><?php echo e(single_price($cartItem['price']*$cartItem['quantity'])); ?></span>
                                                        </td>
                                                        <!-- <td class="product-remove">
                                                            <a href="#" onclick="removeFromCartView(event, <?php echo e($key); ?>)" class="text-right pl-4">
                                                                <i class="la la-trash"></i>
                                                            </a>
                                                        </td> -->
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                               
                            <?php 
                            $delivery_type = Session::get('fill_later');
                            ?>

                            <?php if($delivery_type=="local_pickup" || $delivery_type==''): ?>

                                    <?php if(Session::has('shipping_info')): ?>
                               
                                    <div class="row">
                                   
                                    


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
                                               


                                                <?php 
                                                $shipping_method  = Session::get('shipping_method');
                                                if($shipping_method!=''){
                                                    $shippingMethodName = \App\ShippingMethod::where('id', $shipping_method)->first()->name;
                                                }
                                                ?>
                                                <p>  <?php if($shipping_method!=''): ?>  
                                                        Shipping Method : <span > <?php echo e($shippingMethodName); ?>   </span> 
                                                     <?php endif; ?>
                                                 </p>

                                                 <p>  <?php if($shipping_info['fill_later']=="fill_later"): ?>  
                                                         <span > Fill Later   </span> 
                                                         
                                                    <?php endif; ?>
                                                 </p>

                                                 

                                                <?php 
                                                $location_addr  = Session::get('location_addr');
                                                if($location_addr!=''){
                                                    $locationName = \App\LocalPickup::where('id', $location_addr)->first()->location;
                                                }
                                                ?>
                                                <p>  <?php if($location_addr!=''): ?>  
                                                        Local Pickup : <span > <?php echo e($locationName); ?>   </span> 
                                                     <?php endif; ?></p>     
                                            </div>
                                    </div>









                                    </div>
                                    <?php endif; ?>


                            <?php elseif( $delivery_type=="fill_later" ): ?>
                               <div class="row add-tab">
                                    <h5 class="heading-5">Delivery type : Fill Later</h5>
                                  
                                        <p>
                                        Note: By selecting fill later option, you can pay the shipping charges later.
                                    </p>
                                        
                                    
                                </div>

                            <?php endif; ?>


                            

                               
                                    <div class="row">
                                        <div class="col-md-12 py-3 payment-op">
                                         
                                                    <h5 class="heading-5">
                                                        <?php echo e(__('Select a payment option')); ?>

                                                    </h5>



                                                    <?php if(\App\BusinessSetting::where('type', 'cash_payment')->first()->value == 1): ?>
                                                    <div class="pay-div">
                                                        <label class="payment_option mb-1 active" >
                                                            <input type="radio" id="" name="payment_option" checked value="cash_free" >
                                                            <img loading="lazy"  src="<?php echo e(asset('frontend/images/icons/cards/card.png')); ?>" class="img-fluid"> 
                                                            
                                                            <span class="dp-in">
                                                                Card/Net Banking/Wallet/UPI - CashFree
                                                            </span>
                                                        </label>
                                                    </div>
                                                <?php endif; ?>



                                                
                                                    <div class="pay-div">
                                                        <label class="payment_option mb-1" >
                                                            <input type="radio" id="" name="payment_option" value="paytm" >
                                                            <img loading="lazy"  src="<?php echo e(asset('frontend/images/icons/cards/paytm.png')); ?>" class="img-fluid"> 
                                                            
                                                            <span class="dp-in">
                                                                PayTM
                                                            </span>
                                                        </label>
                                                    </div>
                                             



                                                <?php 
                                        $gst_number = '';
                                        $c_name = '';
                                        $other_details = '';

                                        if( Auth::check() ){
                                           $gst_number = Auth::user()->gst_number;
                                           $c_name = Auth::user()->company_name;
                                           $other_details = Auth::user()->other;
                                         }else{
                                            
                                            if( Session::get('gst') ){
                                                    $guest_details = Session::get('gst');

                                                   $gst_number = $guest_details['gst_number'];
                                                   $c_name = $guest_details['c_name'];
                                                   $other_details = $guest_details['other'];
                                            }
                                        }
                                        ?>

                                        <button type='button' class="btn btn-primary" id='hideshow' value='hide/show'>Hide/Show GST details</button>

                                        <div id="GST_div" style="display:none;">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo e(__('GST Number')); ?> </label>
                                                            <input type="text" class="form-control" id="gst_num" name="gst_num" value="<?php echo e($gst_number); ?>" >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo e(__('Company Name')); ?> </label>
                                                            <input type="text" class="form-control" id="c_name" name="c_name" value="<?php echo e($c_name); ?>" >
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label"><?php echo e(__('Other details')); ?> </label>
                                                            <input type="text" class="form-control" id="other" name="other" value="<?php echo e($other_details); ?>" >
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>

                                                
                                         <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <?php 
                                                    $tnc_checked="";
                                                    if( Session::get('t_n_c') ){
                                                        if( Session::get('t_n_c')=='true' ){
                                                           $tnc_checked = 'checked';
                                                        }
                                                       
                                                    }

                                                    ?>


                                                    <div class="pay-div">
                                                        <label class="terms_n_conditions mb-1" >
                                                            <input type="checkbox" id="" name="t_n_c" required <?php echo e($tnc_checked); ?>  >
                                                            
                                                            <span class="dp-in">
                                                               I accept Terms &  conditions
                                                            </span>
                                                        </label>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        
                                            

                                            <div class="row align-items-center pt-4">
                                                <div class="col-6">
                                                    <a href="<?php echo e(route('home')); ?>" class="link link--style-3">
                                                        <i class="ion-android-arrow-back"></i>
                                                        <?php echo e(__('Return to shop')); ?>

                                                    </a>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button type="button" class="btn btn-base-1 continue"><?php echo e(__('Continue')); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
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
                        <?php echo $__env->make('desktop.frontend.partials.cart_summary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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


        $('#hideshow').on('click', function(event) {        
         $('#GST_div').toggle('show');
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

            $('.continue').on('click', function(e){
                e.preventDefault();
                //alert("hello"+!$('.t_n_c').is(':checked'));
                var gst_num = $('#gst_num').val();
                var c_name = $('#c_name').val();
                if ( gst_num=='' && c_name=='') {
                    $('#form_submit').submit();
                }else if(gst_num.length < 3 || c_name.length < 3){
                    alert("GST Number and Company name should be more than 3 characters");
                }/*else if(!$('.t_n_c').is(':checked')){
                    alert("You have to accept Terms and conditions, in order to proceed ");
                }*/else{
                    $('#form_submit').submit();
                }
                
            });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/delivery_info.blade.php ENDPATH**/ ?>