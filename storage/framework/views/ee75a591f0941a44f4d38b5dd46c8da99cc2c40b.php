<?php if( count($product_array)>0 ): ?>
    <div class="products-box-bar bg-white">
    <h1 class="title-heading ">Product Templates</h1>
        <div class="row sm-no-gutters gutters-5">
            <?php $__currentLoopData = $product_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $prod_image_name = $prd->ref.'_images';
                    $obj = json_decode( json_encode( $template->product_images, FALSE ) );
                    $imageURL = '';
                    if( !empty( $obj->$prod_image_name[0] ) )
                        $imageURL = $obj->$prod_image_name[0];                               

                ?>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-6">
                    <div class="product-box-2 bg-white alt-box my-2">
                        <div class="position-relative overflow-hidden">
                            <a href="<?php echo e(route('template.product',[ 'tmpslug' => $template->slug, 'prodslug' => $prd->slug ])); ?>" class="d-block product-image h-100" style="background-image:url('<?php echo e(asset( getImageURL( $imageURL ,'thumbnail') )); ?>');" tabindex="0">
                            </a>
                           
                        </div>
                        <div class="p-2">
                            <p class="product-title p-0 text-truncate">
                                <a href="<?php echo e(route('template.product',[ 'tmpslug' => $template->slug, 'prodslug' => $prd->slug ])); ?>" tabindex="0"><?php echo e(__($template->name.' '.$prd->name)); ?></a>
                            </p>
                            <div class="clearfix">
                                    <div class="price-box float-left">
                                      <span class="product-price strong-600"><i class="fa fa-inr" aria-hidden="true"></i><?php echo e(format_price( $template->display_price )); ?></span>
                                     </div>
                             </div>
                            
                        </div>
                    </div>
                    
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>



<?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/partials/filter_template_products.blade.php ENDPATH**/ ?>