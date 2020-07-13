<?php $__env->startSection('content'); ?>

     <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo e(__('Player edit')); ?></h3>
            </div>

            <form class="form-horizontal" action="<?php echo e(route('players.update', $player_data->id)); ?>" method="POST" enctype="multipart/form-data">
                 <input name="_method" type="hidden" value="PATCH">
                <?php echo csrf_field(); ?>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('First name')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="first_name" value="<?php echo e($player_data->first_name); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Last Name')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="last_name" value="<?php echo e($player_data->last_name); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Jersey Number')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control" readonly="true" type="text" name="jersey_number" value="<?php echo e($player_data->jersey_number); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Image of player')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control" type="file" name="image_uri">
                            <img src="<?php echo e(asset($player_data->image_uri)); ?>" width="300px" height="300px">
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Country')); ?></label>
                        <?php 
                        $country = array(
                        'IND' => 'INDIA',
                        'PAK' => 'PAKISTAN',
                        'ENG' => 'ENGLAND',
                        'AUS' => 'AUSTRALIA',
                        );
                        ?>
                        <div class="col-lg-5">
                            <select required class="form-control" name="country">
                                <option> Select country</option>
                                <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c); ?>" <?php if($player_data->country===$c): ?> selected  <?php endif; ?>> <?php echo e($value); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <!-- <option value="IND">INDIA</option>
                                <option value="PAK">PAKISTAN</option>
                                <option value="ENG">ENGLAND</option>
                                <option value="AUS">AUSTRALIA</option> -->
                            </select>
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Matches')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="text" name="matches" value="<?php echo e($player_data->matches); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Runs')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="text" name="runs" value="<?php echo e($player_data->runs); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Highest Score')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="text" name="highest_score" value="<?php echo e($player_data->highest_score); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('50s')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="text" name="fifties" value="<?php echo e($player_data->fifties); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Hundreds')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="text" name="hundreds" value="<?php echo e($player_data->hundreds); ?>">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cricket\resources\views/players/edit.blade.php ENDPATH**/ ?>