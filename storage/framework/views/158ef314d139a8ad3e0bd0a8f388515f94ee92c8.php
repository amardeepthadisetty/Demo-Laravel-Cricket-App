<?php $__env->startSection('content'); ?>

     <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo e(__('Team edit')); ?></h3>
            </div>

            <form class="form-horizontal" action="<?php echo e(route('fixtures.update', $fixtures_data->id)); ?>" method="POST" enctype="multipart/form-data">
                 <input name="_method" type="hidden" value="PATCH">
                <?php echo csrf_field(); ?>
                <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name"><?php echo e(__('Match Date')); ?></label>
                            <div class="col-lg-5">
                                <input class="form-control" required type="date" value="<?php echo e($fixtures_data->match_date); ?>" name="match_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name"><?php echo e(__('Team A')); ?></label>
                            <div class="col-lg-5">
                                <select class="form-control" required name="team_a">
                                    <option>Select Team</option>
                                    <?php $__currentLoopData = $all_teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($at->id); ?>"
                                            <?php  
                                                if($at->id===$fixtures_data->team_a){
                                                    echo 'selected';
                                                }
                                            ?>

                                            ><?php echo e($at->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name"><?php echo e(__('Team B')); ?></label>
                            <div class="col-lg-5">
                                <select class="form-control" required name="team_b">
                                    <option>Select Team</option>
                                    <?php $__currentLoopData = $all_teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($at->id); ?>"
                                            <?php  
                                                if($at->id===$fixtures_data->team_b){
                                                    echo 'selected';
                                                }
                                            ?>

                                            ><?php echo e($at->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name"><?php echo e(__('Venue')); ?></label>
                            <div class="col-lg-5">
                                <input class="form-control" required type="text" name="venue" value="<?php echo e($fixtures_data->venue); ?>">

                            </div>
                        </div>


                         <div class="form-group">
                            <label class="col-lg-3 control-label" for="name"><?php echo e(__('Team B')); ?></label>
                            <?php  
                                $statuses = array(
                                    '1' => 'pending',
                                    '2' => 'draw',
                                    '3' => 'complete'
                                );
                            ?>
                            <div class="col-lg-5">
                                <select class="form-control" required name="status">
                                    <option>Status</option>
                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($s); ?>"
                                            <?php  
                                                if($s===$fixtures_data->status){
                                                    echo 'selected';
                                                }
                                            ?>

                                            ><?php echo e($v); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name"><?php echo e(__('Winner')); ?></label>
                            <div class="col-lg-5">
                                <select class="form-control" name="winner">
                                    <option>Select Team</option>
                                    <?php $__currentLoopData = $all_teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $at): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($at->id); ?>"
                                            <?php  
                                                if($at->id===$fixtures_data->winner){
                                                    echo 'selected';
                                                }
                                            ?>

                                            ><?php echo e($at->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                </select>
                            </div>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cricket\resources\views/fixtures/edit.blade.php ENDPATH**/ ?>