<div class="panel-heading">
    <h3 class="panel-title"><?php echo e(__('Add Your Cart Base Coupon')); ?></h3>
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
<!-- <div class="form-group">
   <label class="col-lg-3 control-label"><?php echo e(__('Minimum Shopping')); ?></label>
   <div class="col-lg-9">
      <input type="number" min="0" step="0.01" placeholder="<?php echo e(__('Minimum Shopping')); ?>" name="min_buy" class="form-control" required>
   </div>
</div> -->
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
<!-- <div class="form-group">
   <label class="col-lg-3 control-label"><?php echo e(__('Maximum Discount Amount')); ?></label>
   <div class="col-lg-9">
      <input type="number" min="0" step="0.01" placeholder="<?php echo e(__('Maximum Discount Amount')); ?>" name="max_discount" class="form-control" required>
   </div>
</div> -->
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

    $(document).ready(function(){
        $('.demo-select2').select2();
    });

</script>
<?php /**PATH C:\xampp\htdocs\laramongo\resources\views/partials/shipping_base_coupon.blade.php ENDPATH**/ ?>