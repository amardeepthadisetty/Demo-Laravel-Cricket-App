<?php $__env->startSection('content'); ?>


   <link type="text/css" href="<?php echo e(asset('frontend/css/cart.css')); ?>" rel="stylesheet" media="screen"> 
     
                
<section class="slice-xs">
        <div class="container container-sm">
            <div class="row ">
                <div class="col-md-12">
                <div class="di-table active ">
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
                   <!--  <a href="<?php echo e(route('checkout.shipping_info')); ?>"> -->
                         <h5><?php echo e(__('Shipping info')); ?></h5>
                    <!-- </a> -->
                   
                </div>

                 <div class="di-table  ">
                  <!--  <a href="<?php echo e(route('checkout.delivery_method_view')); ?>"> -->
                         <h5><?php echo e(__('Delivery Methods')); ?></h5>
                    <!-- </a> -->
                   
                </div>

              <div class="di-table ">
                    <!-- <a href="<?php echo e(route('checkout.delivery_info_view')); ?>"> -->
                        <h5><?php echo e(__('Delivery info')); ?></h5>
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



    <section class=" gry-bg" id="cart-summary">
        <div class="container">
            <?php if(Session::has('cart')): ?>
                <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-xl-8">
                    <!-- <form class="form-default bg-white p-4" data-toggle="validator" role="form"> -->
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
                                        //echo "<pre>";
                                        //print_r(Session::get('cart'));
                                        //echo "</pre>";
                                        
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
                                                    <a href="#" onclick="removeFromCartView(event, <?php echo e($key); ?>)">
                                                       Remove
                                                    </a>
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
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-number" type="button" data-type="minus" data-field="quantity[<?php echo e($key); ?>]">
                                                                <i class="la la-minus"></i>
                                                            </button>
                                                        </span>
                                                        <input type="text" name="quantity[<?php echo e($key); ?>]" class="form-control input-number" placeholder="1" value="<?php echo e($cartItem['quantity']); ?>" min="1" max="10" onchange="updateQuantity(<?php echo e($key); ?>, this)">
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-number" type="button" data-type="plus" data-field="quantity[<?php echo e($key); ?>]">
                                                                <i class="la la-plus"></i>
                                                            </button>
                                                        </span>
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
                           

                        <div class="row align-items-center pt-4">
                            <div class="col-6">
                                <a href="<?php echo e(route('home')); ?>" class="link link--style-3">
                                    <i class="la la-mail-reply"></i>
                                    <?php echo e(__('Return to shop')); ?>

                                </a>
                            </div>
                            <div class="col-6 text-right">
                                <?php if(Auth::check()): ?>
                                    <a href="<?php echo e(route('checkout.shipping_info')); ?>" class="btn btn-base-1"><?php echo e(__('Continue to Shipping')); ?></a>
                                <?php else: ?>
                                    <button class="btn btn-base-1" onclick="showCheckoutModal()"><?php echo e(__('Continue to Shipping')); ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- </form> -->
                </div>

                <div class="col-xl-4 ml-lg-auto cart-bg pb-3">
                    <?php echo $__env->make('desktop.frontend.partials.cart_summary', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <?php else: ?>
                <div class="dc-header">
                    <h4 class="heading heading-6 strong-700"><?php echo e(__('Your Cart is empty')); ?></h4>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="GuestCheckout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel"><?php echo e(__('Login')); ?></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="card">
                                <div class="card-body px-4">
                                    <form class="form-default" role="form" action="<?php echo e(route('cart.login.submit')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="input-group input-group--style-1">
                                                        <input type="email" name="email" class="form-control" placeholder="<?php echo e(__('Email')); ?>">
                                                        <span class="input-group-addon">
                                                            <i class="text-md ion-person"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="input-group input-group--style-1">
                                                        <input type="password" name="password" class="form-control" placeholder="<?php echo e(__('Password')); ?>">
                                                        <span class="input-group-addon">
                                                            <i class="text-md ion-locked"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <a href="#" class="link link-xs link--style-3"><?php echo e(__('Forgot password?')); ?></a>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="submit" class="btn btn-styled btn-base-1 px-4"><?php echo e(__('Sign in')); ?></button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body px-4">
                                    <?php if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1): ?>
                                        <a href="<?php echo e(route('social.login', ['provider' => 'google'])); ?>" class="btn btn-styled btn-block btn-google btn-icon--2 btn-icon-left px-4 my-4">
                                            <i class="icon fa fa-google"></i> <?php echo e(__('Login with Google')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <?php if(\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1): ?>
                                        <a href="<?php echo e(route('social.login', ['provider' => 'facebook'])); ?>" class="btn btn-styled btn-block btn-facebook btn-icon--2 btn-icon-left px-4 my-4">
                                            <i class="icon fa fa-facebook"></i> <?php echo e(__('Login with Facebook')); ?>

                                        </a>
                                    <?php endif; ?>
                                    <?php if(\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1): ?>
                                    <a href="<?php echo e(route('social.login', ['provider' => 'twitter'])); ?>" class="btn btn-styled btn-block btn-twitter btn-icon--2 btn-icon-left px-4 my-4">
                                        <i class="icon fa fa-twitter"></i> <?php echo e(__('Login with Twitter')); ?>

                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="or or--1 mt-2">
                        <span><?php echo e(__('or')); ?></span>
                    </div>
                    <div class="text-center">
                        <a href="<?php echo e(route('checkout.guest_checkout')); ?>" class="btn btn-styled btn-base-1"><?php echo e(__('Guest Checkout')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
    function removeFromCartView(e, key){
        e.preventDefault();
        removeFromCart(key);
    }

    function updateQuantity(key, element){
        $.post('<?php echo e(route('cart.updateQuantity')); ?>', { _token:'<?php echo e(csrf_token()); ?>', key:key, quantity: element.value}, function(data){
            updateNavCart();
            $('#cart-summary').html(data);
        });
    }

    function showCheckoutModal(){
        $('#GuestCheckout').modal();
    }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/view_cart.blade.php ENDPATH**/ ?>