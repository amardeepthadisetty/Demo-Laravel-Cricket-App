<?php  
$meta_title = '';
$meta_description = ''; 
?>

<?php $__env->startSection('meta_title'); ?><?php echo e($meta_title); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('meta_description'); ?><?php echo e($meta_description); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="<?php echo e($meta_title); ?>">
    <meta itemprop="description" content="<?php echo e($meta_description); ?>">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="<?php echo e($meta_title); ?>">
    <meta name="twitter:description" content="<?php echo e($meta_description); ?>">

    <!-- Open Graph data -->
    <meta property="og:title" content="<?php echo e($meta_title); ?>" />
    <meta property="og:description" content="<?php echo e($meta_description); ?>" />
<?php $__env->stopSection(); ?>

<link type="text/css" href="<?php echo e(asset('frontend/css/category.css')); ?>" rel="stylesheet" media="screen"> 
<?php $__env->startSection('content'); ?>

    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    
                </div>
            </div>
        </div>
    </div>

    <form id="filter_form">
    <?php echo csrf_field(); ?>
    <section class="gry-bg py-2">
        <div class="container">
            <div class="row">

              <!---------- sidebar Filters Start ---------->
              <div class="col-xl-3 d-none d-xl-block my-2">
                <input type="hidden" id="base_url" value="<?php echo e(config('app.url')); ?>">
                <input type="hidden" id="category_url" value="<?php echo e($cat_url); ?>">
                <input type="hidden" id="category_ref" name="category_ref" value="<?php echo e($category->ref); ?>">
                <input type="hidden" id="filter_output_array" name="filter_output_array" value="">
                <?php if( count( $categories )>0 ): ?>

                <div class="bg-white sidebar-box mb-3">
                    <div class="box-title text-center">
                        Categories
                    </div>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="box-content">
                        <ul class="sub-sub-category-list">
                          <li>
                            <a href="<?php echo e(route('categories', $cat->slug)); ?>" class="d-block " tabindex="0">
                              <?php echo e($cat->name); ?>

                            </a>
                          </li>
                        </ul>
                      </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </div>
                 <?php endif; ?>  



                <?php if( count( $filter_output_array )>0 ): ?>
                <div class="bg-white sidebar-box mb-3">
                    <div class="box-title text-center">
                        Filters
                    </div>
                        <?php $__currentLoopData = $filter_output_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $innerArray): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="box-content">
                                    <ul class="sub-sub-category-list">
                                        <li><?php echo e($innerArray[0]['filter_group_name']); ?></li>
                                        <ul class="sub-sub-category-list">
                            <?php $__currentLoopData = $innerArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>
                                           
                                            <input type="checkbox" class="checkbox_filters" name="filter_name[]" value="<?php echo e($value['filter_group_slug'].'_'.$value['filter_name_slug']); ?>"  
                                            <?php if( in_array( trim($value['filter_name_slug']), $filter_slugs ) ): ?> 
                                                checked
                                            <?php endif; ?>
                                             >
                                             <label><?php echo e($value['filter_name']); ?></label>
                                          </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>     

                                        </ul>
                                    </ul>
                                    
                                    
                            </div>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </div>
                   <?php endif; ?>



              </div>

<!---------- sidebar Filters End ---------->
                
                <div class="col-xl-9">
                    <?php if( count($categories)>0 ): ?>
                        <div class="products-box-bar bg-white">
                               
                                   <h1 class="title-heading">Categories</h1>
                            <div class="row sm-no-gutters gutters-5">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                  
                                        $imageURL = '';
                                        if( !empty( $cat->photos ) )
                                            $imageURL = $cat->photos[0];
                                           

                                    ?>
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-6">
                                        <div class="product-box-2 bg-white alt-box my-2">
                                            <div class="position-relative overflow-hidden">
                                                <a href="<?php echo e(route('categories', $cat->slug)); ?>" class="d-block product-image h-100" style="background-image:url('<?php echo e(asset( getImageURL($imageURL, 'thumbnail') )); ?>');" tabindex="0">
                                                </a>
                                                <div class="product-btns clearfix">
                                                    
                                                </div>
                                            </div>
                                            <div class="p-2">
                                                <p class="product-title p-0 text-truncate">
                                                    <a href="<?php echo e(route('categories', $cat->slug)); ?>" tabindex="0"><?php echo e(__($cat->name)); ?></a>
                                                  </p>
                                               <!--  <div class="clearfix">
                                                        <div class="price-box float-left">
                                                          <span class="product-price strong-600"><i class="fa fa-inr" aria-hidden="true"></i>600</span>
                                                         </div>
                                                 </div> -->
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>


                        


                        <div class="filter_results">

                            <!---------- Templates and  Products will be loaded here ---------->
                            
                        </div>
                        


                        <div class="products-pagination bg-white p-3">
                            <nav aria-label="Center aligned pagination">
                                <ul class="pagination justify-content-center">
                                    
                                </ul>
                            </nav>
                        </div>

                    <!-- </div> -->
                </div>
            </div>
        </div>
    </section>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript">
        function filter(){
            $('#search-form').submit();
        }
        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
    </script>
    <script>

        $('document').ready(function(){
            var filter_url = '';
            filter_url = getFilterCheckedValues(filter_url);
            pull_filters_ajax();
        });
        
        $('.checkbox_filters').on('change', function(){

            var filter_url = '';
            filter_url = getFilterCheckedValues(filter_url);                        
            window.history.pushState(null, null, $('#base_url').val()+ $('#category_url').val() +filter_url );
            pull_filters_ajax();
        });

        function getFilterCheckedValues( filter_url = ''){
            var filter_output_array = [];
            $.each($(".checkbox_filters:checked"), function(){
                var checkbox_value = $(this).val();
                var splitValues = checkbox_value.split("_");

                filter_output_array.push({'filter_group_name' : splitValues[0],'filter_name' : splitValues[1] });

                filter_url += splitValues[0]+'_'+splitValues[1]+'/';

            });
            if ( filter_url!='') {
                filter_url = '/filters/'+filter_url ;
            }
            $('#filter_output_array').val( JSON.stringify( filter_output_array ) );
            return filter_url;
        }


        function pull_filters_ajax(){

            $.ajax({
               type:"POST",
               url: '<?php echo e(route('filters.pull_filter_data')); ?>',
               data: $('#filter_form').serializeArray(),
               success: function(data){
                   //console.log(data);
                   if (data) {
                    //var d = JSON.parse(data);
                    //$('.filter_results').html(d.products_view);
                    $('.filter_results').html(data);
                   }
               }
           });


        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/categories_listing.blade.php ENDPATH**/ ?>