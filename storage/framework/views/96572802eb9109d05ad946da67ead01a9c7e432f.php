<?php $__env->startSection('content'); ?>

    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo e(__('Add Shipping Charge')); ?></h3>
            </div>

            <form class="form-horizontal" action="<?php echo e(route('shipping_charge.update', $sc->id)); ?>" method="POST" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PATCH">
                <?php echo csrf_field(); ?>
                <div class="panel-body">


                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Shipping Station')); ?></label>
                        <div class="col-lg-9">
                            <select name="shipping_station_id" id="shipping_station_id" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($st->id); ?>" <?php if($sc->ship_station_id==$st->id){ echo 'selected';} ?> ><?php echo e($st->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('States')); ?></label>
                        <div class="col-lg-9">
                            <select name="state_id" id="state_id" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($st->id); ?>" <?php if($sc->state_id==$st->id){ echo 'selected';} ?> ><?php echo e($st->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Min in Kgs ')); ?></label>
                        <div class="col-lg-9">
                            <input type="text" name="min" class="form-control" value="<?php echo e($sc->min); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Max in Kgs ')); ?></label>
                        <div class="col-lg-9">
                            <input type="text" name="max" class="form-control" value="<?php echo e($sc->max); ?>">
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Shipping Methods')); ?></label>
                        <div class="col-lg-9">
                            <select name="shipping_method_id" id="shipping_method_id" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                                <?php $__currentLoopData = $sMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sm->id); ?>" <?php if($sc->shipping_method_id==$sm->id){ echo 'selected';} ?>   ><?php echo e($sm->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Price')); ?></label>
                        <div class="col-lg-9">
                            <input type="text" name="price" class="form-control" value="<?php echo e($sc->price); ?>">
                        </div>
                    </div>


                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Status')); ?></label>
                        <div class="col-lg-9">
                            <select name="status" id="status" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                               
                                    <option value="1" <?php if($sc->status=="1"){ echo 'selected';} ?>  >Active</option>
                                    <option value="0" <?php if($sc->status=="0"){ echo 'selected';} ?>  >Inactive</option>
                                
                            </select>
                        </div>
                    </div>


                    

                <div class="panel-footer text-right">
                    <button class="btn btn-purple" type="submit"><?php echo e(__('Update')); ?></button>
                </div>
            </form>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/shipping_charge/edit.blade.php ENDPATH**/ ?>