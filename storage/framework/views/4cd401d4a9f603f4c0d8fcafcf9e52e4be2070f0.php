<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php 
            $imageURL = '';
            if( !empty( $prod->photos ) )
                $imageURL = $prod->photos[0];
               

        ?>
        <div class="col-xxl-3 col-xl-4 col-lg-3 col-md-4 col-6">
            <div class="product-box-2 bg-white alt-box my-2">
                <div class="position-relative overflow-hidden">
                    <a href="<?php echo e(route('product', $prod->slug)); ?>" class="d-block product-image h-100" style="background-image:url('<?php echo e(asset( getImageURL( $imageURL ,'thumbnail') )); ?>');" tabindex="0">
                    </a>
                    <div class="product-btns clearfix">
                        
                    </div>
                </div>
                <div class="p-3 border-top">
                    <h2 class="product-title p-0 text-truncate">
                        <a href="<?php echo e(route('product', $prod->slug)); ?>" tabindex="0"><?php echo e(__($prod->name)); ?></a>
                    </h2>
                    <div class="clearfix">
                            <div class="price-box float-left">
                              <span class="product-price strong-600"><i class="fa fa-inr" aria-hidden="true"></i>
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
            
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/partials/filter_templates.blade.php ENDPATH**/ ?>