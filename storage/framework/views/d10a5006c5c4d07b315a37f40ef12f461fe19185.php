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
                <input type="hidden" id="template_url" value="<?php echo e($temp_url); ?>">
                <input type="hidden" id="template_ref" name="template_ref" value="<?php echo e($template->ref); ?>">
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



            
                <div class="col-xl-9 products_filters_show">
                   <!---------- Template Products will be loaded here ---------->
                        
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
            window.history.pushState(null, null, $('#base_url').val()+ $('#template_url').val() +filter_url );
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
               url: '<?php echo e(route('filters.pull_filter_data_in_templates')); ?>',
               data: $('#filter_form').serializeArray(),
               success: function(data){
                   //console.log(data);
                   if (data) {
                    //var d = JSON.parse(data);
                    //$('.products_filters_show').html(d.products_view);
                    $('.products_filters_show').html(data);
                   }
               }
           });


        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/template_product_listing.blade.php ENDPATH**/ ?>