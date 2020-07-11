
<?php $__currentLoopData = $allIDS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eachID): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 			<?php 
 			 $shipChargeItems = \App\ShippingCharge::where('id', $eachID)->get();
 			?> 
          
           <?php if($shipChargeItems): ?> 
              <?php $__currentLoopData = $shipChargeItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sCharge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                 <input type="hidden" name="id[]" value=<?php echo e($sCharge->id); ?>>

                  <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Shipping Methods')); ?></label>
                        <div class="col-lg-9">
                            <select name="shipping_method_id[]" id="shipping_method_id" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                                <?php $__currentLoopData = $sMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sm->id); ?>" <?php if($sCharge->shipping_method_id==$sm->id){ echo 'selected';} ?>   ><?php echo e($sm->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Price')); ?></label>
                        <div class="col-lg-9">
                            <input type="text" name="price[]" class="form-control" value="<?php echo e($sCharge->price); ?>">
                        </div>
                    </div>

                      <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Status')); ?></label>
                        <div class="col-lg-9">
                            <select name="status[]" id="status" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                               
                                    <option value="1" <?php if($sCharge->status=="1"){ echo 'selected';} ?>  >Active</option>
                                    <option value="0" <?php if($sCharge->status=="0"){ echo 'selected';} ?>  >Inactive</option>
                                
                            </select>
                        </div>
                    </div>
                    <hr>



              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
           <?php endif; ?>
        
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/shipping_charge/getShipCharges.blade.php ENDPATH**/ ?>