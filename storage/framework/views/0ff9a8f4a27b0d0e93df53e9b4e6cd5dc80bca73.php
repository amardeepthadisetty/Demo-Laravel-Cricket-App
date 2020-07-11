<?php if( count($templates)>0 ): ?>
    <div class="products-box-bar bg-white">
      <h2 class="title-heading">Templates</h2>
        <div class="row sm-no-gutters gutters-5">
            <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tmplte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
              
                    $imageURL = '';
                    if( !empty( $tmplte->photos ) )
                        $imageURL = $tmplte->photos[0];
                       

                ?>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-6">
                    <div class="product-box-2 bg-white alt-box my-2">
                        <div class="position-relative overflow-hidden">
                            <a href="<?php echo e(route('templates', $tmplte->slug)); ?>" class="d-block product-image h-100" style="background-image:url('<?php echo e(asset( getImageURL($imageURL, 'thumbnail')   )); ?>');" tabindex="0">
                            </a>
                            <div class="product-btns clearfix">
                                
                            </div>
                        </div>
                        <div class="p-2">
                            <p class="product-title p-0 text-truncate">
                                <a href="<?php echo e(route('templates', $tmplte->slug)); ?>" tabindex="0"><?php echo e(__($tmplte->name)); ?></a>
                             </p>
                             <div class="clearfix">
                                    <div class="price-box float-left">
                                      <span class="product-price strong-600"><i class="fa fa-inr" aria-hidden="true"></i><?php echo e(format_price( $tmplte->display_price )); ?></span>
                                     </div>
                             </div>
                            
                        </div>
                    </div>
                    
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>


<?php if( count($products)>0 ): ?>
        <div class="products-box-bar p-3 bg-white">
                   <h3>Products</h3>
            <div class="row sm-no-gutters gutters-5 products_filters_show">
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/partials/filter_products.blade.php ENDPATH**/ ?>