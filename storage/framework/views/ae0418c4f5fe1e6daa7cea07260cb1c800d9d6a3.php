<?php $__env->startSection('content'); ?>

     <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo e(__('Team edit')); ?></h3>
            </div>

            <form class="form-horizontal" action="<?php echo e(route('teams.update', $team_data->id)); ?>" method="POST" enctype="multipart/form-data">
                 <input name="_method" type="hidden" value="PATCH">
                <?php echo csrf_field(); ?>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Team Name')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="team_name" value="<?php echo e($team_data->name); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Logo')); ?></label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="file" name="logo_uri">
                            <img src="<?php echo e(asset( $team_data->logo_uri)); ?>" width="300px" height="200px">

                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name"><?php echo e(__('Players')); ?></label>
                        <div class="col-lg-5">
                            <select name="players[]" class="form-control players" multiple="">
                                <option>Select players</option>
                                <?php $__currentLoopData = $all_players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($p->id); ?>"
                                        <?php 
                                        foreach ($mappedPlayers as $mP){
                                            if($mP->player_id===$p->id){
                                                echo 'selected';
                                            }
                                        }

                                        ?>

                                        > <?php echo e($p->first_name.'->'.$p->jersey_number); ?> </option>
                                        
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

   $('.players').select2();


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cricket\resources\views/Teams/edit.blade.php ENDPATH**/ ?>