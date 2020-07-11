<?php $__env->startSection('content'); ?>

     <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo e(__('Payment type info')); ?></h3>
            </div>

            <form class="form-horizontal" action="<?php echo e(route('payment_type.update', $paymentType->id)); ?>" method="POST" enctype="multipart/form-data">
                 <input name="_method" type="hidden" value="PATCH">
                <?php echo csrf_field(); ?>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Type')); ?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="type" value="<?php echo e($paymentType->type); ?>">
                           
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Code')); ?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="code" value="<?php echo e($paymentType->code); ?>">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Description')); ?></label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="description"><?php echo e($paymentType->description); ?></textarea>
                           
                        </div>
                    </div>


                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Status')); ?></label>
                        <div class="col-lg-9">
                            <select class="form-control" name="status">
                                    <option value="">Select Status</option>
                                    <option value="1" <?php if($paymentType->status=="1"){ echo 'selected'; } ?> >Active</option>
                                    <option value="0" <?php if($paymentType->status=="0"){ echo 'selected'; } ?> >In Active</option>
                            </select>
                           
                        </div>
                    </div>

                   
                <div class="panel-footer text-right">
                    <button class="btn btn-purple" type="submit"><?php echo e(__('Save')); ?></button>
                </div>
            </form>

        </div>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script type="text/javascript">

   


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/payment_type/edit.blade.php ENDPATH**/ ?>