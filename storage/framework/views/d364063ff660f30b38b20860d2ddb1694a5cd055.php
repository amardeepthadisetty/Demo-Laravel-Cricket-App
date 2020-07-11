<div class="panel-heading">
    <h3 class="panel-title"><?php echo e(__('Add Your Product Base Coupon')); ?></h3>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label" for="coupon_name"><?php echo e(__('Name of the Coupon')); ?></label>
    <div class="col-lg-9">
        <input type="text" placeholder="<?php echo e(__('Coupon Name')); ?>" id="coupon_name" name="coupon_name" class="form-control" required>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-3 control-label" for="coupon_code"><?php echo e(__('Coupon code')); ?></label>
    <div class="col-lg-9">
        <input type="text" placeholder="<?php echo e(__('Coupon code')); ?>" id="coupon_code" name="coupon_code" class="form-control" required>
    </div>
</div>
<div class="product-choose-list">
    <div class="product-choose">
        <div class="form-group">
           <label class="col-lg-3 control-label"><?php echo e(__('Category')); ?></label>
           <div class="col-lg-9">
              <select class="form-control category_id demo-select2" name="category_ids[]" required>
                 <?php $__currentLoopData = \App\TemplateCategories::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <option value="<?php echo e($category->ref); ?>"><?php echo e($category->name); ?></option>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
           </div>
        </div>
        
       
        <!-- <div class="form-group">
            <label class="col-lg-3 control-label" for="name"><?php echo e(__('Product')); ?></label>
            <div class="col-lg-9">
                <select name="product_ids[]" class="form-control product_id demo-select2" required>

                </select>
            </div>
        </div> -->
        <hr>
    </div>
</div>
<div class="more hide">
    <div class="product-choose">
        <div class="form-group">
           <label class="col-lg-3 control-label"><?php echo e(__('Category')); ?></label>
           <div class="col-lg-9">
              <select class="form-control category_id" name="category_ids[]" >
                 <?php $__currentLoopData = \App\TemplateCategories::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <option value="<?php echo e($category->ref); ?>"><?php echo e($category->name); ?></option>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
           </div>
        </div>
        
        
      <!--   <div class="form-group">
            <label class="col-lg-3 control-label" for="name"><?php echo e(__('Product')); ?></label>
            <div class="col-lg-9">
                <select name="product_ids[]" class="form-control product_id">

                </select>
            </div>
        </div> -->
        <hr>
    </div>
</div>
<div class="text-right">
    <button class="btn btn-primary" type="button" name="button" onclick="appendNewProductChoose()"><?php echo e(__('Add More')); ?></button>
</div>
<br>
<div class="form-group">
    <label class="col-lg-3 control-label" for="start_date"><?php echo e(__('Date')); ?></label>
    <div class="col-lg-9">
        <div id="demo-dp-range">
            <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="form-control" name="start_date">
                <span class="input-group-addon"><?php echo e(__('to')); ?></span>
                <input type="text" class="form-control" name="end_date">
            </div>
        </div>
    </div>
</div>
<div class="form-group">
   <label class="col-lg-3 control-label"><?php echo e(__('Discount')); ?></label>
   <div class="col-lg-8">
      <input type="number" min="0" step="0.01" placeholder="<?php echo e(__('Discount')); ?>" name="discount" class="form-control" required>
   </div>
   <div class="col-lg-1">
      <select class="demo-select2" name="discount_type">
         <option value="amount">$</option>
         <option value="percent">%</option>
      </select>
   </div>
</div>

<div id="extra_options" >

                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name"><?php echo e(__('Repeat Type')); ?></label>
                            <div class="col-lg-9">
                                <select name="repeat_type" id="repeat_type" class="form-control demo-select2" required>
                                    <option value="">Select One</option>
                                    <option value="unlimited"><?php echo e(__('Unlimited')); ?></option>
                                    <option value="normal_limit"><?php echo e(__('Normal Limit')); ?></option>
                                    <option value="user_limit"><?php echo e(__('User Limit')); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name"><?php echo e(__('Limit')); ?></label>
                            <div class="col-lg-9">
                                <input type="number" class="form-control" name="limit_number" value="0">
                                
                            </div>
                        </div>

                    </div>


<script type="text/javascript">

    function appendNewProductChoose(){
        $('.product-choose-list').append($('.more').html());
        $('.product-choose-list').find('.product-choose').last().find('.category_id').select2();
    }

  


  

    $(document).ready(function(){
        $('.demo-select2').select2();
        //get_subcategories_by_category($('.category_id'));
    });

    $('.category_id').on('change', function() {
        //get_subcategories_by_category(this);
    });

    $('.subcategory_id').on('change', function() {
	   // get_subsubcategories_by_subcategory(this);
	});

    $('.subsubcategory_id').on('change', function() {
 	    //get_products_by_subsubcategory(this);
 	});


</script>
<?php /**PATH C:\xampp\htdocs\laramongo\resources\views/partials/category_base_coupon.blade.php ENDPATH**/ ?>