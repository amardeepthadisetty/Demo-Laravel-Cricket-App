<?php $__env->startSection('content'); ?>

    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo e(__('Players')); ?></h3>
            </div>

            <form class="form-horizontal" action="<?php echo e(route('players.store')); ?>" method="POST" enctype="multipart/form-data">
            	<?php echo csrf_field(); ?>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('First name')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="first_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Last Name')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="last_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Jersey Number')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="jersey_number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Image of player')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="file" name="image_uri">

                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Country')); ?></label>
                        <div class="col-lg-5">
                            <select required class="form-control" name="country">
                                <option> Select country</option>
                                <option value="IND">INDIA</option>
                                <option value="PAK">PAKISTAN</option>
                                <option value="ENG">ENGLAND</option>
                                <option value="AUS">AUSTRALIA</option>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cricket\resources\views/players/create.blade.php ENDPATH**/ ?>