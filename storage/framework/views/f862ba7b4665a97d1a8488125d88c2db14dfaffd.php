<?php $__env->startSection('content'); ?>

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    <?php echo $__env->make('desktop.frontend.inc.customer_side_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-lg-9">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-12">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    <?php echo e(__('Address Book')); ?> <a class="btn btn-sm btn-primary" href="<?php echo e(route('address.new')); ?>">+ Add new Address</a>
                                </h2>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
                                        <li class="active"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- dashboard content -->
                    <div class="">
                        
                        <div class="row">

                            <?php if($addresses): ?>
                            <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-5">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 clearfix ">
                                        <?php echo e(__('Saved Address Info')); ?> 

                                        <?php if($addr->default_address=="1"): ?>
                                        - Default one
                                        <?php endif; ?>
                                        <div class="float-right">
                                            <a href="<?php echo e(route('address.info' , ['id' => $addr->id ] )); ?>" class="btn btn-link btn-sm"><?php echo e(__('Edit')); ?></a>
                                            <form>
                                            <?php echo csrf_field(); ?>  
                                            <a href="<?php echo e(route('address.delete' , ['id' => $addr->id ] )); ?>" class="btn btn-danger btn-sm"><?php echo e(__('Delete')); ?></a>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="form-box-content p-3">
                                        <table>
                                            <tr>
                                                <td><?php echo e(__('Name')); ?>:</td>
                                                <td class="p-2"><?php echo e($addr->name); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo e(__('Email')); ?>:</td>
                                                <td class="p-2"><?php echo e($addr->email); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo e(__('Address')); ?>:</td>
                                                <td class="p-2"><?php echo e($addr->address); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo e(__('Address1')); ?>:</td>
                                                <td class="p-2"><?php echo e($addr->address1); ?></td>
                                            </tr>

                                            <tr>
                                                <td><?php echo e(__('Phone')); ?>:</td>
                                                <td class="p-2"><?php echo e($addr->phone); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo e(__('Country')); ?>:</td>
                                                <td class="p-2">
                                                    <?php if($addr->country != null): ?>
                                                        <?php echo e(\App\Country::where('id', $addr->country )->first()->name); ?>

                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                             <tr>
                                                <td><?php echo e(__('State')); ?>:</td>
                                                <td class="p-2">
                                                    <?php if($addr->state != null): ?>
                                                        <?php echo e(\App\State::where('id', $addr->state  )->first()->name); ?>

                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td><?php echo e(__('City')); ?>:</td>
                                                <td class="p-2"><?php echo e($addr->city); ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo e(__('Postal Code')); ?>:</td>
                                                <td class="p-2"><?php echo e($addr->zip_code); ?></td>
                                            </tr>
                                           
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/customer/address.blade.php ENDPATH**/ ?>