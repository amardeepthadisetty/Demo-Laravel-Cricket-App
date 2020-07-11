<?php $__env->startSection('content'); ?>

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    <?php if(Auth::user()->user_type == 'seller'): ?>
                        <?php echo $__env->make('desktop.frontend.inc.seller_side_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php elseif(Auth::user()->user_type == 'customer'): ?>
                        <?php echo $__env->make('desktop.frontend.inc.customer_side_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        <?php echo e(__('New Address ')); ?>

                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
                                            <li><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
                                            <li class="active"><a href="<?php echo e(route('profile')); ?>"><?php echo e(__('Manage Profile')); ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if(Session::has('error') ): ?>
                        <div>
                            <?php echo e(Session::get('error')); ?>

                        </div>
                        <?php endif; ?>

                        <form class="address_details" action="<?php echo e(route('address.add')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    <?php echo e(__('New Address')); ?>

                                </div>
                                <div class="form-box-content p-3">
                                     <div class="row">
                                        <div class="col-md-2">
                                            <label><?php echo e(__('Name')); ?></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" required class="form-control mb-3" placeholder="<?php echo e(__('Name')); ?>" name="name" value="<?php echo e(old('name')); ?>">
                                            
                                        </div>
                                    </div>

                                     <div class="row">
                                        <div class="col-md-2">
                                            <label><?php echo e(__('Email')); ?></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" required class="form-control mb-3" placeholder="<?php echo e(__('Email')); ?>" name="email" value="<?php echo e(old('email')); ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><?php echo e(__('Address')); ?></label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea class="form-control textarea-autogrow mb-3" placeholder="Your Address" rows="1" name="address"><?php echo e(old('address')); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><?php echo e(__('Address 1')); ?></label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea class="form-control textarea-autogrow mb-3" placeholder="Your Address" rows="1" name="address1"><?php echo e(old('address1')); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><?php echo e(__('Phone')); ?></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" required class="form-control mb-3" placeholder="Your Phone Number" name="phone" value="<?php echo e(old('phone')); ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><?php echo e(__('Country')); ?></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <select class="form-control mb-3 selectpicker country_name" data-placeholder="Select your country" name="country">
                                                    <?php $__currentLoopData = \App\Country::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($country->id); ?>" <?php if( old('country') == $country->id) echo "selected";?> ><?php echo e($country->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><?php echo e(__('State')); ?></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <select class="form-control mb-3 selectpicker state-fill" data-placeholder="Select your state" name="state">
                                                    <?php $__currentLoopData = \App\State::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($country->id); ?>" <?php if( old('state')  == $country->id) echo "selected";?> ><?php echo e($country->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><?php echo e(__('City')); ?></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="Your City" name="city" value="<?php echo e(old('city')); ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><?php echo e(__('Postal Code')); ?></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="Your Postal Code" name="zip_code" value="<?php echo e(old('zip_code')); ?>">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label><?php echo e(__('Default')); ?></label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control" name="default_one" required>
                                                <option value="">Choose one</option>
                                                <option value="1" <?php if( old('default_one') =="1"){ echo "selected"; } ?>  >Yes</option>
                                                <option value="0" <?php if( old('default_one') =="0"){ echo "selected"; } ?> >No</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1"><?php echo e(__('Add Address')); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


     <script>
    loadStates();
    $('.country_name').on('change', function(){
        //console.log(this.value);
        loadStates();
        
    });

    function loadStates(){
         $.ajax({
               type:"POST",
               url: '<?php echo e(route('ajax.getStates.from.countryid')); ?>',
               data: $('.address_details').serializeArray(),
               success: function(data){
                  //console.log(data);
                  $('.state-fill').html(data);
               }
           });
    }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/customer/add_address.blade.php ENDPATH**/ ?>