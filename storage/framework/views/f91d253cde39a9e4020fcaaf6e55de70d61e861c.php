<?php $__env->startSection('content'); ?>

<link type="text/css" href="<?php echo e(asset('frontend/css/my-account.css')); ?>" rel="stylesheet">

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
                                <h2 class=" heading-6 text-capitalize mb-0">
                                    <?php echo e(__('Dashboard')); ?>

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
                            <div class="col-md-4">
                                <div class="dashboard-widget text-center green-widget  c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-shopping-cart"></i>
                                        <?php if(Session::has('cart')): ?>
                                            <span class="d-block title"><?php echo e(count(Session::get('cart'))); ?> Product(s)</span>
                                        <?php else: ?>
                                            <span class="d-block title">0 Product</span>
                                        <?php endif; ?>
                                        <span class="d-block sub-title">in your cart</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-widget text-center red-widget  c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-heart"></i>
                                        <span class="d-block title"><?php echo e(count( (array) Auth::user()->wishlists)); ?> Product(s)</span>
                                        <span class="d-block sub-title">in your wishlist</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="dashboard-widget text-center yellow-widget  c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <i class="fa fa-building"></i>
                                        <?php
                                            $orders = \App\Order::where('user_id', Auth::user()->id)->get();
                                            $total = 0;
                                            foreach ($orders as $key => $order) {
                                                $total += count($order->orderDetails);
                                            }
                                        ?>
                                        <span class="d-block title"><?php echo e($total); ?> Product(s)</span>
                                        <span class="d-block sub-title">you ordered</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            

                            <?php if($addr): ?>
                          
                            <div class="col-md-5">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 clearfix ">
                                        <?php echo e(__('Default Address')); ?> 

                                        
                                        <div class="float-right">
                                            <a href="<?php echo e(route('address.info' , ['id' => $addr->id ] )); ?>" class=" btn-link btn-sm"><?php echo e(__('Edit')); ?></a>
                                            
                                            <?php echo csrf_field(); ?>  
                                            <a href="<?php echo e(route('address.delete' , ['id' => $addr->id ] )); ?>" class=" btn-text btn-sm"><?php echo e(__('Delete')); ?></a>
                                          
                                        </div>
                                    </div>
                                    <div class="form-box-content p-3">

                                    <?php /*
                                        <table>
                                            <tr>
                                                <td>{{__('Name')}}:</td>
                                                <td class="p-2">{{ $addr->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Email')}}:</td>
                                                <td class="p-2">{{ $addr->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Address')}}:</td>
                                                <td class="p-2">{{ $addr->address }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Address1')}}:</td>
                                                <td class="p-2">{{ $addr->address1 }}</td>
                                            </tr>

                                            <tr>
                                                <td>{{__('Phone')}}:</td>
                                                <td class="p-2">{{ $addr->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Country')}}:</td>
                                                <td class="p-2">
                                                    @if ($addr->country != null)
                                                        {{ \App\Country::where('id', $addr->country )->first()->name }}
                                                    @endif
                                                </td>
                                            </tr>

                                             <tr>
                                                <td>{{__('State')}}:</td>
                                                <td class="p-2">
                                                    @if ($addr->state != null)
                                                        {{ \App\State::where('id', $addr->state  )->first()->name }}
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>{{__('City')}}:</td>
                                                <td class="p-2">{{ $addr->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Postal Code')}}:</td>
                                                <td class="p-2">{{ $addr->zip_code }}</td>
                                            </tr>
                                           
                                        </table>

                                        */ ?>

                                             <?php echo e($addr->name); ?><br/>
                                           
                                           
                                             
                                              <?php echo e($addr->email); ?><br/>
                                           
                                           
                                                    <?php echo e($addr->address); ?><br/>
                                       
                                          
                                                    <?php echo e($addr->address1); ?><br/>
                                          
                                            
                                                    
                                                <?php echo e($addr->phone); ?><br/>
                                          
                                          
                                                    <?php if($addr->country != null): ?>
                                                        <?php echo e(\App\Country::where('id', $addr->country )->first()->name); ?>

                                                    <?php endif; ?>  <br/>
                                               
                                         
                                           
                                               
                                                    <?php if($addr->state != null): ?>
                                                        <?php echo e(\App\State::where('id', $addr->state  )->first()->name); ?>

                                                    <?php endif; ?>  <br/>
                                            

                                            
                                              <?php echo e($addr->city); ?> <br/>
                                            <?php echo e($addr->zip_code); ?>

                                      


                                    </div>
                                </div>
                            </div>
                          
                            <?php endif; ?>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/customer/dashboard.blade.php ENDPATH**/ ?>