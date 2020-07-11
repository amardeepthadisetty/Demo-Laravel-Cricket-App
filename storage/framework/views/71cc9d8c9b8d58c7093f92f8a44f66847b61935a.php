<?php if(isset($subsubcategory_id)): ?>
    <?php
        $meta_title = \App\SubSubCategory::find($subsubcategory_id)->meta_title;
        $meta_description = \App\SubSubCategory::find($subsubcategory_id)->meta_description;
    ?>
<?php elseif(isset($subcategory_id)): ?>
    <?php
        $meta_title = \App\SubCategory::find($subcategory_id)->meta_title;
        $meta_description = \App\SubCategory::find($subcategory_id)->meta_description;
    ?>
<?php elseif(isset($category_id)): ?>
    <?php
        
        $meta_title = \App\Category::where('id',$category_id)->first()->meta_title;
        $meta_description = \App\Category::where('id',$category_id)->first()->meta_description;
    ?>
<?php elseif(isset($brand_id)): ?>
    <?php
        $meta_title = \App\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Brand::find($brand_id)->meta_description;
    ?>
<?php else: ?>
    <?php
        $meta_title = env('APP_NAME');
        $meta_description = \App\SeoSetting::first()->description;
    ?>
<?php endif; ?>

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

<?php $__env->startSection('content'); ?>

    <!-- <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
                        <li><a href="<?php echo e(route('products')); ?>"><?php echo e(__('All Categories')); ?></a></li>
                        <?php if(isset($category_id)): ?>
                            <li class="active"><a href="<?php echo e(route('products.category', \App\Category::find($category_id)->slug)); ?>"><?php echo e(\App\Category::find($category_id)->name); ?></a></li>
                        <?php endif; ?>
                        <?php if(isset($subcategory_id)): ?>
                            <li ><a href="<?php echo e(route('products.category', \App\SubCategory::find($subcategory_id)->category->slug)); ?>"><?php echo e(\App\SubCategory::find($subcategory_id)->category->name); ?></a></li>
                            <li class="active"><a href="<?php echo e(route('products.subcategory', \App\SubCategory::find($subcategory_id)->slug)); ?>"><?php echo e(\App\SubCategory::find($subcategory_id)->name); ?></a></li>
                        <?php endif; ?>
                        <?php if(isset($subsubcategory_id)): ?>
                            <li ><a href="<?php echo e(route('products.category', \App\SubSubCategory::find($subsubcategory_id)->subcategory->category->slug)); ?>"><?php echo e(\App\SubSubCategory::find($subsubcategory_id)->subcategory->category->name); ?></a></li>
                            <li ><a href="<?php echo e(route('products.subcategory', \App\SubsubCategory::find($subsubcategory_id)->subcategory->slug)); ?>"><?php echo e(\App\SubsubCategory::find($subsubcategory_id)->subcategory->name); ?></a></li>
                            <li class="active"><a href="<?php echo e(route('products.subsubcategory', \App\SubSubCategory::find($subsubcategory_id)->slug)); ?>"><?php echo e(\App\SubSubCategory::find($subsubcategory_id)->name); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div> -->

  <form id="filter_form">
  <?php echo csrf_field(); ?>
    <section class="gry-bg py-4">
        <div class="container">
            <div class="row">
                <!---------- sidebar Filters Start ---------->
                      <div class="col-xl-3 d-none d-xl-block my-2">
                        <input type="hidden" id="base_url" value="<?php echo e(config('app.url')); ?>">
                        <input type="hidden" id="search_url" value="<?php echo e($search_url); ?>">
                        <input type="hidden" id="search_param" name="search_param" value="<?php echo e(request()->segment(2)); ?>">
                        
                        <input type="hidden" id="filter_output_array" name="filter_output_array" value="">

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
                    <!-- <div class="bg-white"> -->
                        <div class="brands-bar row no-gutters pb-3 bg-white p-3">
                            <div class="col-11">
                                <div class="brands-collapse-box" id="brands-collapse-box">
                                    
                                </div>
                            </div>
                           
                        </div>
                       <!--  <form class="" id="search-form" action="<?php echo e(route('search_post')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            
                        </form> -->
                        <!-- <hr class=""> -->

                         <div class="filter_results">

                            <!---------- Templates and  Products will be loaded here ---------->
                            
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
            window.history.pushState(null, null, $('#base_url').val()+ $('#search_url').val() +filter_url );
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
               url: '<?php echo e(route('filters.pull_search_filter_data')); ?>',
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

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/product_listing.blade.php ENDPATH**/ ?>