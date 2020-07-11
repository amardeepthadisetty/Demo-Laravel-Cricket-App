<?php $__env->startSection('content'); ?>

     <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo e(__('Status code info')); ?></h3>
            </div>

            <form class="form-horizontal" action="<?php echo e(route('status_code.update', $statusCode->id)); ?>" method="POST" enctype="multipart/form-data">
                 <input name="_method" type="hidden" value="PATCH">
                <?php echo csrf_field(); ?>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Status code')); ?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="status_code" value="<?php echo e($statusCode->status_code); ?>">
                           
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Display Name')); ?></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="display_name" value="<?php echo e($statusCode->display_name); ?>">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Description')); ?></label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="description"><?php echo e($statusCode->description); ?></textarea>
                           
                        </div>
                    </div>


                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Status')); ?></label>
                        <div class="col-lg-9">
                            <select class="form-control" name="status">
                                    <option value="">Select Status</option>
                                    <option value="1" <?php if($statusCode->status=="1"){ echo 'selected'; } ?> >Active</option>
                                    <option value="0" <?php if($statusCode->status=="0"){ echo 'selected'; } ?> >In Active</option>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/statuscode/edit.blade.php ENDPATH**/ ?>