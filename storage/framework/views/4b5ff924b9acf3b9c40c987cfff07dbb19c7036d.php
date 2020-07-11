<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-lg-12">
            <a href="<?php echo e(route('status_code.create')); ?>" class="btn btn-rounded btn-info pull-right"><?php echo e(__('Add New Status Code')); ?></a>
        </div>
    </div><br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo e(__('Status code Information')); ?></h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo e(__('Status code')); ?></th>
                        <th><?php echo e(__('Display Name')); ?></th>
                        <th><?php echo e(__('Description')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th width="10%"><?php echo e(__('Options')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $status_codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status_code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?></td>
                            <td><?php echo e($status_code->status_code); ?></td>
                            <td><?php echo e($status_code->display_name); ?></td>
                            <td><?php echo e($status_code->description); ?></td>
                            <td>
                                
                                <?php if($status_code->status=="1"): ?>
                                    Active
                                <?php elseif($status_code->status=="0"): ?>
                                    In active
                                <?php endif; ?>

                            </td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        <?php echo e(__('Actions')); ?> <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="<?php echo e(route('status_code.edit', encrypt($status_code->id))); ?>"><?php echo e(__('Edit')); ?></a></li>
                                        <li><a onclick="confirm_modal('<?php echo e(route('status_code.destroy', $status_code->id)); ?>');"><?php echo e(__('Delete')); ?></a></li>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/statuscode/index.blade.php ENDPATH**/ ?>