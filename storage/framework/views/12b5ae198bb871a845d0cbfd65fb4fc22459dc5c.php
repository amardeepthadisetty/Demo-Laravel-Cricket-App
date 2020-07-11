<?php $__env->startSection('meta_title'); ?><?php echo e($product->meta_title); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('meta_description'); ?><?php echo e($product->meta_description); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('meta_keywords'); ?><?php echo e($product->tags); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>  
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="<?php echo e($product->meta_title); ?>">
    <meta itemprop="description" content="<?php echo e($product->meta_description); ?>">
    <meta itemprop="image" content="<?php echo e(asset($product->meta_img)); ?>">

   
<?php $__env->stopSection(); ?>

<link type="text/css" href="<?php echo e(asset('frontend/css/xzoom.css')); ?>" rel="stylesheet">
<link type="text/css" href="<?php echo e(asset('frontend/css/product.css')); ?>" rel="stylesheet"> 
<link type="text/css" href="<?php echo e(asset('frontend/css/slick.css')); ?>" rel="stylesheet">

<?php $__env->startSection('content'); ?>




    <!-- SHOP GRID WRAPPER -->
    <section class="product-details-area">
        <div class="container">

            <div class="bg-white">

                <!-- Product gallery and Description -->
                <div class="row no-gutters cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-lg-6">
                        <div class="product-gal sticky-top d-flex flex-row-reverse">
                            <?php if(is_array(($product->photos)) && count(($product->photos)) > 0): ?>
                                <div class="product-gal-img">
                                    <?php 
                                        $imageURL = '';
                                        if( !empty( ($product->photos)[0] ) )
                                            $imageURL = ($product->photos)[0];                               

                                    ?>
                                    <img loading="lazy"  class="xzoom img-fluid" src="<?php echo e(asset( getImageURL($imageURL, 'thumbnail') )); ?>" xoriginal="<?php echo e(asset( getImageURL($imageURL, 'thumbnail') )); ?>" />
                                </div>
                                <div class="product-gal-thumb">
                                    <div class="xzoom-thumbs">
                                        <?php $__currentLoopData = ($product->photos); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php 
                                                $imageURL = '';
                                                if( !empty( $photo ) )
                                                    $imageURL = $photo;                               

                                            ?>
                                            <a href="<?php echo e(asset($photo)); ?>">
                                                <img loading="lazy"  class="xzoom-gallery" width="80" src="<?php echo e(asset(  $imageURL )); ?>"  <?php if($key == 0): ?> xpreview="<?php echo e(asset( $imageURL )); ?>" <?php endif; ?>>
                                            </a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <!-- Product description -->
                        <div class="product-description-wrapper">
                            <!-- Product title -->
                            <h1 class="product-title">
                                <?php echo e(__($product->name)); ?>

                            </h1>
                            

                                
                            <div class="row">
                                <div class="col-12">
                                    <div class="sold-by py-2">
                                        <small>Product Code : <?php echo e($product->model); ?> </small>
                                    </div>
                                </div>
                               
                            </div>

                            <?php
                            $qty = 0;
                            if($product->is_variant=="1"){
                                if(is_array(($product->variations)) && !empty(($product->variations))){
                                    foreach (($product->variations) as $key => $variation) {
                                        $qty += $variation['qty'];
                                    }
                                }
                            }else{
                                $qty = $product->current_stock;
                            }
                        ?>
                        

                             

                            <div style="color:red;float:right;display:none;" class="loading-text">
                                ...Loading....!!!
                            </div>


                            <?php /*
                            @if(home_price($product->id) != home_discounted_price($product->id))
                                

                            
                                <div class="row no-gutters mt-4">
                                    <div class="col-2">
                                        <div class="product-description-label">{{__('Price')}}:</div>
                                    </div>
                                    <div class="col-10">
                                        <div class="product-price-old">
                                            <del>
                                                {{ home_price($product->id) }}
                                                <span>/{{ $product->unit }}</span>
                                            </del>
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="row no-gutters mt-3">
                                    <div class="col-2">
                                        <div class="product-description-label mt-1">{{__('Price')}}:</div>
                                    </div>
                                    <div class="col-10">
                                        <div class="product-price">
                                            <strong>
                                                {{ home_discounted_price($product->id) }}
                                            </strong>
                                            <span class="piece">/{{ $product->unit }}</span> -
                                        </div>
                                    </div>
                                </div>
                            @else
                            
                                <div class="row no-gutters mt-3">
                                    <div class="col-2">
                                        <div class="product-description-label">{{__('Price')}}:</div>
                                    </div>
                                    <div class="col-10">
                                        <div class="product-price">
                                            <strong>
                                                {{ home_discounted_price($product->id) }}
                                            </strong>
                                            <span class="piece">/{{ $product->unit }}</span>
                                        </div>
                                    </div>
                                </div>
                              
                            @endif

                            */ ?>


                            <form id="option-choice-form">


                                <div class="row no-gutters py-3 d-none" id="chosen_price_div">
                                    <div class="col-1">
                                        <div class="product-description-label"><?php echo e(__('Price')); ?></div>
                                    </div>
                                    <div class="col-10">
                                        <div class="product-price">
                                            <strong id="chosen_price">

                                            </strong>
                                        </div>
                                    </div>
                                </div>



                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo e($product->id); ?>">
                                <input type="hidden" name="template_id" value="0">
                                <?php if( !empty( $product->choice_options ) ): ?>
                                <?php $__currentLoopData = json_decode(json_encode($product->choice_options)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $choice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="row pd-section">
                                        <div class="col-12">
                                            <div class="product-description-label "><?php echo e($choice->title); ?></div>
                                        </div>
                                        <div class="col-12 mt-1">
                                            <ul class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 ">
                                                <?php $__currentLoopData = $choice->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <input type="radio" id="<?php echo e($choice->name); ?>-<?php echo e($option); ?>" name="<?php echo e($choice->name); ?>" value="<?php echo e($option); ?>" <?php if($key == 0): ?> checked <?php endif; ?>>
                                                        <label for="<?php echo e($choice->name); ?>-<?php echo e($option); ?>"><?php echo e($option); ?></label>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                                <?php if(count(json_decode(json_encode($product->colors))) > 0): ?>
                                    <div class="row pd-section">
                                        <div class="col-12">
                                            <div class="product-description-label"><?php echo e(__('Color')); ?></div>
                                        </div>
                                        <div class="col-12 mt-1">
                                            <ul class="list-inline checkbox-color">
                                                <?php $__currentLoopData = json_decode(json_encode($product->colors)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <input type="radio" id="<?php echo e($product->id); ?>-color-<?php echo e($key); ?>" name="color" value="<?php echo e($color); ?>" <?php if($key == 0): ?> checked <?php endif; ?>>
                                                        <label style="background: <?php echo e($color); ?>;" for="<?php echo e($product->id); ?>-color-<?php echo e($key); ?>" data-toggle="tooltip"></label>
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    </div>

                                    <hr>
                                <?php endif; ?>


                                <?php $__currentLoopData = json_decode(json_encode($product->additional_options)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            
                                   
                                    <?php switch(trim($opt->option_type)):
                                        case ('text'): ?>
                                                <div class="row pd-section">
                                                    <div class="col-12">
                                                        <div class="product-description-label"><?php echo e($opt->title); ?></div>
                                                    </div>
                                                    <div class="col-12 mt-1">
                                                        <ul class="list-inline">
                                                            
                                                                <li>
                                                                    <?php
                                                                        $title = strtolower(str_replace(" ","_",$opt->title));
                                                                        $session_title_value = '';
                                                                        $name = $opt->name;
                                                                        if($sesArray){
                                                                            if( isset( $sesArray["additional_options"][$name] ) ){
                                                                                if(  $sesArray["additional_options"][$name]!=''  ){
                                                                                     $session_title_value = $sesArray["additional_options"][$name];
                                                                                }
                                                                            }
                                                                        }
                                                                     ?>

                                                                    <input type="text" id="<?php echo e($opt->name); ?>-<?php echo e($title); ?>" class="form-control" name="<?php echo e($opt->name); ?>" value="<?php echo e($session_title_value); ?>" placeholder="<?php echo e($opt->title); ?>">
                                                                    
                                                                </li>
                                                           
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php break; ?>;
                                        @endcase
                                        <?php case ('textarea'): ?>
                                                <div class="row pd-section">
                                                    <div class="col-12">
                                                        <div class="product-description-label"><?php echo e($opt->title); ?></div>
                                                    </div>
                                                    <div class="col-12 mt-1">
                                                        <ul class="list-inline">
                                                            
                                                                <li>
                                                                    <?php
                                                                        $title = strtolower(str_replace(" ","_",$opt->title));
                                                                        $session_title_value = '';
                                                                        $name = $opt->name;
                                                                        if($sesArray){
                                                                            if( isset( $sesArray["additional_options"][$name] ) ){
                                                                                if(  $sesArray["additional_options"][$name]!=''  ){
                                                                                     $session_title_value = $sesArray["additional_options"][$name];
                                                                                }
                                                                            }
                                                                        }
                                                                   
                                                                     ?>
                                                                     
                                                                    <textarea id="<?php echo e($opt->name); ?>-<?php echo e($title); ?>" class="form-control" name="<?php echo e($opt->name); ?>" placeholder="<?php echo e($opt->title); ?>">
                                                                        <?php echo e($session_title_value); ?>

                                                                    </textarea>
                                                                </li>
                                                           
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php break; ?>;
                                        @endcase
                                        <?php case ('radio'): ?>
                                        <div class="row pd-section">
                                            <div class="col-12">
                                                        <div class="product-description-label"><?php echo e($opt->title); ?></div>
                                                    </div>
                                                    <div class="col-12 mt-1">
                                                        <ul class="list-inline">
                                                            <?php $__currentLoopData = $opt->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li >
                                                                <?php

                                                                
                                                                $name = concat_string( $opt->title , $c);
                                                                if( !empty( json_decode( json_encode( $product->additional_options_variations) )->$name ) ){

                                                                    $obj = json_decode( json_encode( $product->additional_options_variations) )->$name;

                                                                }
                                                                
                                                                //print_r($obj);
                                                                $price = single_price( $obj->price );
                                                                ?>
                                                                    <input type="radio" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" value="yes"
                                                                    <?php 
                                                                    if($sesArray){
                                                                        if( isset( $sesArray["additional_options"][$name] ) ){
                                                                            if(  $sesArray["additional_options"][$name]=="yes"  ){
                                                                                echo "checked";
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                    >
                                                                    <label title="<?php echo e($price); ?>"  for="<?php echo e($name); ?>" data-toggle="tooltip"> <?php echo e($c); ?> </label>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>

                                                       
                                                    </div>
                                                </div>
                                                <?php break; ?>;
                                        @endcase
                                        <?php case ('checkbox'): ?>
                                        <div class="row pd-section">
                                            <div class="col-12">
                                                        <div class="product-description-label"><?php echo e($opt->title); ?></div>
                                                    </div>
                                                    <div class="col-12 mt-1">
                                                        <ul class="list-inline">
                                                            <?php $__currentLoopData = $opt->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li >
                                                                <?php
                                                                $name = concat_string( $opt->title , $c);
                                                                $obj = json_decode( json_encode( $product->additional_options_variations) )->$name;
                                                                //print_r($obj);
                                                                $price = single_price( $obj->price );
                                                                ?>
                                                                    <input type="checkbox" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>" value="yes"
                                                                    <?php 
                                                                    if($sesArray){
                                                                        if( isset( $sesArray["additional_options"][$name] ) ){
                                                                            if(  $sesArray["additional_options"][$name]=="yes"  ){
                                                                                echo "checked";
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                    
                                                                    >
                                                                    <label title="<?php echo e($price); ?>"  for="<?php echo e($name); ?>" data-toggle="tooltip"> <?php echo e($c); ?> </label>
                                                                </li>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>

                                                       
                                                    </div>
                                                </div>
                                                <?php break; ?>;
                                        @endcase

                                        @default_case
                                        @endcase
                                    <?php endswitch; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <!--  Upload Module Start  -->
                                    <?php echo $__env->make('desktop/frontend/partials/upload_part', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
                                <!--  Upload Module End  -->

                                <!-- More Settings Instructions -->
                                <?php if( json_decode( json_encode($product->more_settings) )->instructions =="1"  ): ?>
                                <div class="row pd-section">
                                    <div class="col-12">
                                            <div class="product-description-label"> Instructions </div>
                                        </div>
                                        <div class="col-12 mt-1">
                                            <ul class="list-inline">
                                                <?php
                                                $instructions_value = '';
                                                if($sesArray){
                                                    if( isset( $sesArray['instructions'] ) ) {
                                                        if(  $sesArray['instructions'] !=''  ) {
                                                             $instructions_value = $sesArray['instructions'];
                                                        }
                                                    }
                                                }
                                                ?>
                                            
                                               
                                                    <textarea class="form-control" name="instructions" placeholder="Instructions"><?php echo e($instructions_value); ?></textarea>
                                                    <span id="instructions_error" class="error"></span>
                                               
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <!-- More Settings Instructions -->

                                <!-- More Settings Promotion -->
                                <?php if( json_decode( json_encode($product->more_settings) )->promotion_settings->is_promotion =="1"  ): ?>
                                <div class="row pd-section">
                                    <div class="col-12">
                                            <div class="product-description-label"> Promotion </div>
                                        </div>
                                        <div class="col-12 mt-1">
                                            <ul class="list-inline">
                                               
                                                    <label>
                                                        <input type="checkbox" name="promotion" value="yes"
                                                        <?php
                                                        if($sesArray){
                                                            if( isset($sesArray['promotion']) ){
                                                                if( $sesArray['promotion']=="true" ){
                                                                    echo "checked";
                                                                }
                                                            }
                                                        }
                                                        ?>


                                                        >
                                                        <?php echo e(json_decode( json_encode($product->more_settings) )->promotion_settings->promotion_text); ?>

                                                    </label>
                                                     <span id="promotion_error" class="error"></span>
                                               
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <!-- More Settings Promotion -->

                                 <!-- Quantity + Add to cart -->
                                 <div class="row pd-section">
                                    <div class="col-2">
                                        <div class="product-description-label qty"><?php echo e(__('Quantity')); ?></div>
                                    </div>
                                    <div class="col-10">
                                        <div class="product-quantity d-flex align-items-center">
                                            <div class="input-group input-group--style-2 pr-3" style="width: 160px;">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-number" type="button" data-type="minus" data-field="quantity" disabled="disabled">
                                                        <i class="la la-minus"></i>
                                                    </button> 
                                                </span>
                                                <input type="text" name="quantity" class="form-control input-number text-center" placeholder="1" value="1" min="1" max="10">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-number" type="button" data-type="plus" data-field="quantity">
                                                        <i class="la la-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                            <!-- <div class="avialable-amount">(<span id="available-quantity"><?php echo e($qty); ?></span> <?php echo e(__('available')); ?>)</div> -->
                                        </div>
                                    </div>
                                </div>

                                
                                <?php /*
                                <div class="row no-gutters pb-3 d-none" id="chosen_price_div">
                                    <div class="col-2">
                                        <div class="product-description-label">{{__('Total Price')}}:</div>
                                    </div>
                                    <div class="col-10">
                                        <div class="product-price">
                                            <strong id="chosen_price">

                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                */ ?>

                            </form>

                            <div class="d-table width-100">
                                <div class="d-table-cell">
                                    <!-- Buy Now button -->
                                    <?php if($qty > 0): ?>
                                        <button type="button" class="btn-styled btn-base-1 buy-now" onclick="buyNow()">
                                            <!-- <i class="la la-shopping-cart"></i>  -->
                                            <?php echo e(__('Buy Now')); ?>

                                        </button>
                                        <button type="button" class="btn-styled btn-alt-base-1 ml-3 c-white add-to-cart" onclick="addToCart()">
                                            <!-- <i class="la la-shopping-cart"></i> -->
                                            <span class="d-none d-md-inline-block"> 
                                                <?php echo e(__('Add to cart')); ?></span>
                                        </button>

                                   
                                    <?php else: ?>
                                        <!-- <button type="button" class="btn btn-styled btn-base-1 btn-icon-left strong-700 hov-bounce hov-shaddow">
                                            <i class="la la-cart-arrow-down"></i> <?php echo e(__('Out of Stock')); ?>

                                        </button> -->
                                    <?php endif; ?>
                                   
                                </div>
                            </div>


                            <?php /*

                            <div class="d-table width-100 mt-2">
                                <div class="d-table-cell">
                                    <!-- Add to wishlist button -->
                                    <button type="button" class="btn pl-0 btn-link strong-700" onclick="addToWishList({{ $product->id }})">
                                        {{__('Add to wishlist')}}
                                    </button>
                                    <!-- Add to compare button -->
                                    <button type="button" class="btn btn-link btn-icon-left strong-700" onclick="addToCompare({{ $product->id }})">
                                        {{__('Add to compare')}}
                                    </button>
                                </div>
                            </div>

                           
                           
                            <div class="row no-gutters mt-3">
                                <div class="col-2">
                                    <div class="product-description-label alpha-6">{{__('Return Policy')}}:</div>
                                </div>
                                <div class="col-10">
                                    {{__('Returns accepted if product not as described, buyer pays return shipping fee; or keep the product & agree refund with seller.')}} <a href="{{ route('returnpolicy') }}" class="ml-2">View details</a>
                                </div>
                            </div>
                            @if ($product->added_by == 'seller')
                                <div class="row no-gutters mt-3">
                                    <div class="col-2">
                                        <div class="product-description-label alpha-6">{{__('Seller Guarantees')}}:</div>
                                    </div>
                                    <div class="col-10">
                                        @if ($product->user->seller->verification_status == 1)
                                            {{__('Verified seller')}}
                                        @else
                                            {{__('Non verified seller')}}
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="row no-gutters mt-3">
                                <div class="col-2">
                                    <div class="product-description-label alpha-6">{{__('Payment')}}:</div>
                                </div>
                                <div class="col-10">
                                    <ul class="inline-links">
                                        <li>
                                            <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/visa.png') }}" width="30" class="">
                                        </li>
                                        <li>
                                            <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/mastercard.png') }}" width="30" class="">
                                        </li>
                                        <li>
                                            <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/maestro.png') }}" width="30" class="">
                                        </li>
                                        <li>
                                            <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/paypal.png') }}" width="30" class="">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            {{-- <div class="row no-gutters mt-3">
                                <div class="col-2">
                                    <img loading="lazy"  src="{{ asset('frontend/images/icons/buyer-protection.png') }}" width="40" class="">
                                </div>
                                <div class="col-10">
                                    <div class="heading-6 strong-700 text-info d-inline-block">Buyer protection</div><a href="" class="ml-2">View details</a>
                                    <ul class="list-symbol--1 pl-4 mb-0 mt-2">
                                        <li><strong>Full Refund</strong> if you don't receive your order</li>
                                        <li><strong>Full or Partial Refund</strong>, if the item is not as described</li>
                                    </ul>
                                </div>
                            </div> --}}
                            <hr class="mt-4">
                            <div class="row no-gutters mt-4">
                                <div class="col-2">
                                    <div class="product-description-label mt-2">{{__('Share')}}:</div>
                                </div>
                                <div class="col-10">
                                    <div id="share"></div>
                                </div>
                            </div>

                                */ ?>

                                <div class="row">
                                    <div class="col-md-12 small-des mt-4">
                                        <?php echo $product->small_description; ?>
                                    </div>
                                </div>
                                

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



                 <!--divider section Start  -->

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>
                <!--  divider section End -->



    <section class="gry-bg">
        <div class="container">
            <div class="row">

                <?php /*
                
                <div class="col-xl-3 d-none d-xl-block">
                    
                    <div class="seller-category-box bg-white sidebar-box mb-3">
                        <div class="box-title">
                            {{__("This Seller's Categories")}}
                        </div>
                        <div class="box-content"> 
                                @foreach (\App\Product::where('user_id', $product->user_id)->select('category_id')->distinct()->get() as $key => $category)
                                    
                                    <div class="single-category">
                                        <button class="btn w-100 category-name collapsed" type="button" data-toggle="collapse" data-target="#category-{{ $key }}" aria-expanded="false">
                                        {{ App\Category::where('id',$category->getOriginal()[0])->first()->title }}
                                        </button>

                                        <div id="category-{{ $key }}" class="collapse">
                                            @foreach (\App\Product::where('user_id', $product->user_id)->where('category_id', $category->category_id)->select('subcategory_id')->distinct()->get() as $subcategory)
                                                <div class="single-sub-category">
                                                    <button class="btn w-100 sub-category-name" type="button" data-toggle="collapse" data-target="#subCategory-{{ $subcategory->subcategory_id }}" aria-expanded="false">
                                                    {{ App\SubCategory::findOrFail($subcategory->subcategory_id)->name }}
                                                    </button>
                                                    <div id="subCategory-{{ $subcategory->subcategory_id }}" class="collapse show">
                                                        <ul class="sub-sub-category-list">
                                                            @foreach (\App\Product::where('user_id', $product->user_id)->where('category_id',            $category->category_id)->where('subcategory_id', $subcategory->subcategory_id)->select('subsubcategory_id')->distinct()->get() as $subsubcategory)
                                                                <li><a href="{{ route('products.subsubcategory', App\SubSubCategory::findOrFail($subsubcategory->subsubcategory_id)->slug) }}">{{ App\SubSubCategory::findOrFail($subsubcategory->subsubcategory_id)->name }}</a></li>
                                                            @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="seller-top-products-box bg-white sidebar-box mb-3">
                        <div class="box-title">
                            {{__('Top Selling Products From This Seller')}}
                        </div>
                        <div class="box-content">
                         
                            @foreach (filter_products(\App\Product::where('user_id', $product->user_id)->orderBy('num_of_sale', 'desc'))->limit(4)->get() as $key => $top_product)
                            <?php 
                                $imageURL = '';
                                if( !empty( $top_product->photos ) )
                                    $imageURL = $top_product->photos[0];                               

                            ?>
                            <div class="mb-3 product-box-3">
                                <div class="clearfix">
                                    <div class="product-image float-left">
                                        <a href="{{ route('product', $top_product->slug) }}" style="background-image:url('{{ asset( getImageURL( $imageURL ,'thumbnail') ) }}');"></a>
                                    </div>
                                    <div class="product-details float-left">
                                        <h4 class="title text-truncate">
                                            <a href="{{ route('product', $top_product->slug) }}" class="d-block">{{ $top_product->name }}</a>
                                        </h4>
                                        <div class="star-rating star-rating-sm mt-1">
                                            {{ renderStarRating($top_product->rating) }}
                                        </div>
                                        <div class="price-box">
                                            <!-- @if(home_base_price($top_product->id) != home_discounted_base_price($top_product->id))
                                                <del class="old-product-price strong-400">{{ home_base_price($top_product->id) }}</del>
                                            @endif -->
                                            <span class="product-price strong-600">{{ home_discounted_base_price($top_product->id) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                */ ?>


                <div class="col-xl-12">
                    <div class="product-desc-tab bg-white">



                      
                         
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php echo $product->description; ?>
                                    </div>
                                </div>






                                <?php /*
                        <div class="tabs tabs--style-2">
                            <ul class="nav nav-tabs justify-content-center sticky-top bg-white">
                                <li class="nav-item">
                                    <a href="#tab_default_1" data-toggle="tab" class="nav-link text-uppercase strong-600 active show">{{__('Description')}}</a>
                                </li>
                                @if($product->video_link != null)
                                    <li class="nav-item">
                                        <a href="#tab_default_2" data-toggle="tab" class="nav-link text-uppercase strong-600">{{__('Video')}}</a>
                                    </li>
                                @endif
                                @if($product->pdf != null)
                                    <li class="nav-item">
                                        <a href="#tab_default_3" data-toggle="tab" class="nav-link text-uppercase strong-600">{{__('Downloads')}}</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a href="#tab_default_4" data-toggle="tab" class="nav-link text-uppercase strong-600">{{__('Reviews')}}</a>
                                </li>
                            </ul>

                            <div class="tab-content pt-0">
                                <div class="tab-pane active show" id="tab_default_1">
                                    <div class="py-2 px-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $product->description; ?>
                                            </div>
                                        </div>
                                        <span class="space-md-md"></span>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_default_2">
                                    <div class="fluid-paragraph py-2">
                                        <!-- 16:9 aspect ratio -->
                                        <div class="embed-responsive embed-responsive-16by9 mb-5">
                                            @if ($product->video_provider == 'youtube' && $product->video_link != null)
                                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ explode('=', $product->video_link)[1] }}"></iframe>
                                            @elseif ($product->video_provider == 'dailymotion' && $product->video_link != null)
                                                <iframe class="embed-responsive-item" src="https://www.dailymotion.com/embed/video/{{ explode('video/', $product->video_link)[1] }}"></iframe>
                                            @elseif ($product->video_provider == 'vimeo' && $product->video_link != null)
                                                <iframe src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $product->video_link)[1] }}" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_default_3">
                                    <div class="py-2 px-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ asset($product->pdf) }}">{{ __('Download') }}</a>
                                            </div>
                                        </div>
                                        <span class="space-md-md"></span>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_default_4">
                                    <!-- this section is deleted. If needed, refer original script -->
                                </div>


                                */ ?>

                            </div>
                        </div>
                    </div>



                    <!--  Related products Start  -->

                   

                                  <!--  Related products Start  -->

                </div>
            </div>
        </div>
    </section>



 <!--  Related products New Start  -->
 
 <section class="mb-4">
    <?php if( count( $related_products )>0 ): ?>
    <div class="container">
       
            <div class="section-title-1 clearfix">
                <h4>
                    <span class="mr-4">Related Products</span>
                </h4>
            </div>
            <div class="caorusel-box">
                <div class="slick-carousel" data-slick-items="5" data-slick-xl-items="4" data-slick-lg-items="3"  data-slick-md-items="2" data-slick-sm-items="2" data-slick-xs-items="1">
                    <?php $__currentLoopData = $related_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                    <?php 
                        $imageURL = '';
                        if( !empty( $prod->photos ) )
                            $imageURL = $prod->photos[0];
                           

                    ?>  

                    <div class="product-card-2 card card-product m-2 shop-cards shop-tech">
                        <div class="card-body p-0">

                            <div class="card-image">
                                <a href="<?php echo e(route('product', $prod->slug)); ?>" class="d-block" style="background-image:url('<?php echo e(asset( getImageURL( $imageURL ,'thumbnail') )); ?>');">
                                </a>
                            </div>

                            <div class="p-3">
                               
                             
                                <h2 class="product-title p-0 text-truncate-2">
                                    <a href="http://192.168.1.6/dp24/product/Demo-product-41zHs"><?php echo e(__($prod->name)); ?></a>
                                </h2>
                                <div class="price-box">
                              
                                    <span class="product-price strong-600">

                                        <?php 
                                        if( $prod->is_variant=="0" ){
                                          echo format_price( $prod->unit_price);
                                        }else{
                                          echo home_price( $prod->_id );
                                        }
                                        ?>

                                    </span>
                                   </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
       
    </div>

    <?php endif; ?>

</section>

<!--  Related products New End  -->










<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        $(document).ready(function() {
    		$('#share').share({
    			networks: ['facebook','twitter','linkedin','tumblr','in1','stumbleupon','digg'],
    			theme: 'square'
    		});
            getVariantPrice();
    	});

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/product_details.blade.php ENDPATH**/ ?>