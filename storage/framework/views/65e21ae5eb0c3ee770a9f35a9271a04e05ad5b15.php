<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-lg-12">
            <a href="<?php echo e(route('teams.create')); ?>" class="btn btn-rounded btn-info pull-right"><?php echo e(__('Team List')); ?></a>
        </div>
    </div><br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo e(__('Teams Information')); ?></h3>
        </div>
        <div class="panel-body">

            <h2>
            List of players under <?php echo e($teams->name); ?> <img width="100px" height="100px" src="<?php echo e(asset($teams->logo_uri)); ?>">
                
            </h2>
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo e(__('Player Name')); ?></th>
                        <th><?php echo e(__('Jersey Number')); ?></th>
                        <th><?php echo e(__('Country')); ?></th>
                        <th><?php echo e(__('Image')); ?></th>
                        <th width="10%"><?php echo e(__('Options')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <td><?php echo e($player->first_name.' '. $player->last_name); ?></td>
                            <td><?php echo e($player->jersey_number); ?></td>
                            <td><?php echo e($player->country); ?></td>
                            <td><img width="100px" height="100px" src="<?php echo e(asset($player->image_uri)); ?>"></td>
                            
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        <?php echo e(__('Actions')); ?> <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="<?php echo e(route('players.edit', encrypt($player->id))); ?>"><?php echo e(__('Edit')); ?></a></li>
                                        <li>

                                            <form action="<?php echo e(route('players.destroy',$player->id)); ?>" method="POST">
                   
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cricket\resources\views/teams/team_list.blade.php ENDPATH**/ ?>