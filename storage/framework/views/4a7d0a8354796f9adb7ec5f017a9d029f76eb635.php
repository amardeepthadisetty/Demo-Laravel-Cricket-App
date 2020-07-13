<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-lg-12">
            
        </div>
    </div><br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo e(__('Points')); ?></h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo e(__('Teams')); ?></th>
                        <th><?php echo e(__('Matches')); ?></th>
                        <th><?php echo e(__('Won')); ?></th>
                        <th><?php echo e(__('Lost')); ?></th>
                        <th><?php echo e(__('Tie')); ?></th>
                        <!-- <th width="10%"><?php echo e(__('Options')); ?></th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <td>
                                <a href="<?php echo e(route('teams.team_info.teamid', $team->id)); ?>">
                                    <?php echo e($team->name); ?>

                                </a>
                                
                            </td>
                            <td>
                               <?php  
                               $orThose = ['team_a' => $team->id , 'team_b' => $team->id ];
                                   $matches =  \App\Fixtures::orWhere($orThose)->count();
                                   echo $matches;
                               ?>
                            </td>
                            <td>
                            <?php  
                               $whereCond = ['status' => 3 , 'winner' => $team->id ];
                                   $won_matches =  \App\Fixtures::where($whereCond)->count();
                                   echo $won_matches;
                            ?>
                            </td>
                            <td> 
                            <?php  
                             $orThose = ['team_a' => $team->id , 'team_b' => $team->id ];

                                   $lost_matches =  \App\Fixtures::orWhere($orThose)->where('winner','!=', $team->id )->count();
                                   echo $lost_matches;
                            ?>
                            </td>
                            <td> 
                            <?php  
                              $orThose = ['team_a' => $team->id , 'team_b' => $team->id ];

                                   $draw_matches =  \App\Fixtures::orWhere($orThose)->where('status','=', 2 )->count();
                                   echo $draw_matches;
                            ?>

                            </td>
                            
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cricket\resources\views/points/index.blade.php ENDPATH**/ ?>