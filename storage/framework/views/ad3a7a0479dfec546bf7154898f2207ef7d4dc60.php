<?php $__env->startSection('content'); ?>


<link type="text/css" href="<?php echo e(asset('frontend/css/cart.css')); ?>" rel="stylesheet" media="screen"> 


    <div id="page-content">
       


                   
<section class="slice-xs">
        <div class="container container-sm">
            <div class="row ">
                <div class="col-md-12">
               

                <div class="di-table active ">
                    <a href="<?php echo e(route('fill_later.shipping_info')); ?>">
                         <h5><?php echo e(__('Shipping info')); ?></h5>
                    </a>
                   
                </div>


                <div class="di-table  ">
                   <!-- <a href="<?php echo e(route('checkout.delivery_method_view')); ?>"> -->
                         <h5><?php echo e(__('Delivery Methods')); ?></h5>
                    <!-- </a> -->
                   
                </div>

              <div class="di-table ">
                   <!--  <a href="<?php echo e(route('checkout.delivery_info_view')); ?>"> -->
                        <h5><?php echo e(__('Payment Selection')); ?></h5>
                    <!-- </a> -->
                     
                </div>

                <div class="di-table">
                    <!-- <a href="<?php echo e(route('checkout.order_confirm_view')); ?>"> -->
                        <h5><?php echo e(__('Confirmation')); ?></h5>
                   <!--  </a> -->
                
                </div>
            </div>
            </div>
        </div>
    </section> 


        <section class="gry-bg address-form">
            <div class="container">
                <div class="row cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-lg-8">
                        <form class="form-default" id="user_details" data-toggle="validator" action="<?php echo e(route('fill_later.store_shipping_infostore')); ?>" role="form" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="card"> 
                                <?php if(Auth::check()): ?>
                                    <?php
                                        $user = Auth::user();
                                        //echo $user->name."<br>";
                                        $addresses = \App\Address::where('user_id', Auth::user()->id)->get();
                                        $default_addr = \App\Address::where('user_id', Auth::user()->id)->where('default_address',1)->first();
                                    ?>

                                        
                                    
                                    <div class="pr-4 pl-2">

                                         <?php if( $addresses ): ?>
                                          <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <!-- <label class="control-label"><?php echo e(__('Select An Address')); ?></label>
                                                    <select class="form-control prefilled_addresses" name="prefilled_addresses"  >
                                                    <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($addr->id); ?>" <?php if($addr->default_address=="1"){ echo 'selected'; } 
                                                            ?>><?php echo e($addr->name); ?>, 
                                                            <?php echo e($addr->email); ?>, <?php echo e($addr->address); ?>, <?php echo e($addr->phone); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  -->

                                                    <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $addr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                         <div class="add-div address_box <?php if( $addr->default_address=='1'): ?> active  <?php endif; ?>" id="addr_<?php echo e($addr->id); ?>">
                                                           <b> <?php echo e($addr->name); ?> </b><br>
                                                           <input type="hidden" id="addr_name_<?php echo e($addr->id); ?>" value="<?php echo e($addr->name); ?>">
                                                           <input type="hidden" id="addr_email_<?php echo e($addr->id); ?>" value="<?php echo e($addr->email); ?>">
                                                           <input type="hidden" id="addr_address_<?php echo e($addr->id); ?>" value="<?php echo e($addr->address); ?>">
                                                           <input type="hidden" id="addr_address1_<?php echo e($addr->id); ?>" value="<?php echo e($addr->address1); ?>">
                                                           <input type="hidden" id="addr_phone_<?php echo e($addr->id); ?>" value="<?php echo e($addr->phone); ?>">
                                                           <input type="hidden" id="addr_country_<?php echo e($addr->id); ?>" value="<?php echo e(\App\Country::where('id', $addr->country)->first()->name); ?>">
                                                           <input type="hidden" id="addr_state_<?php echo e($addr->id); ?>" value="<?php echo e(\App\State::where('id', $addr->state)->first()->name); ?>">
                                                           <input type="hidden" id="addr_city_<?php echo e($addr->id); ?>" value="<?php echo e($addr->city); ?>">
                                                           <input type="hidden" id="addr_zip_code_<?php echo e($addr->id); ?>" value="<?php echo e($addr->zip_code); ?>">
                                                            <?php echo e($addr->address); ?><br>
                                                            <?php echo e($addr->address1); ?><br>
                                                            <?php echo e($addr->city); ?><br>
                                                            <?php echo e(\App\State::where('id', $addr->state)->first()->name); ?><br>
                                                            <?php echo e(\App\Country::where('id', $addr->country)->first()->name); ?>

                                                        </div>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                   

                                                   <!--  <div class="add-div">
                                                       <b> Chinthala Kondalu </b><br>
                                                        29-1104/ kothapet, kalavakatta<br>
                                                        karampudi road<br>
                                                        Hyderabad 500049<br>
                                                        Telangana<br>
                                                        India
                                                    </div> -->
                                                
                                                </div>
                                            </div>
                                        </div>
                                        
                                         <?php endif; ?>
                                        

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo e(__('Name')); ?></label>
                                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e($default_addr->name); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo e(__('Email')); ?></label>
                                                    <input type="email" id="email" class="form-control" name="email" value="<?php echo e($default_addr->email); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group address-feld" >
                                                    <label class="control-label"><?php echo e(__('Address')); ?></label>
                                                    <input type="text" id="address" class="form-control" name="address" value="<?php echo e($default_addr->address); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group address-feld">
                                                    <label class="control-label"><?php echo e(__('Address 1')); ?></label>  
                                                    <input type="text" id="address1" class="form-control" name="address1" value="<?php echo e($default_addr->address1); ?>" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label"><?php echo e(__('Phone')); ?></label>
                                                    <input type="number" id="phone" min="0" class="form-control" value="<?php echo e($default_addr->phone); ?>" name="phone" required>
                                                </div>
                                            </div>
                                        </div>

                                        <?php 
                                            
                                            $cntry = \App\Country::where('id', $default_addr->country)->first();
                                            $statee = \App\State::where('id', $default_addr->state)->first();
                                        ?>
                                         

                                        <div class="row">
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo e(__('Select your country')); ?></label>
                                                    <select class="form-control custome-control country_name" id="country" data-live-search="true" name="country">
                                                        <?php $__currentLoopData = \App\Country::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($country->name); ?>"  <?php if($cntry->name==$country->name){ echo 'selected'; } ?> ><?php echo e($country->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo e(__('Select your state')); ?></label>
                                                    <select class="form-control custome-control state-fill" data-live-search="true" id="state" name="state">
                                                         <?php $__currentLoopData = \App\State::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($country->name); ?>" <?php if($statee->name==$country->name){ echo 'selected'; } ?> ><?php echo e($country->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label"><?php echo e(__('City')); ?></label>
                                                    <input type="text" class="form-control" id="city" value="<?php echo e($default_addr->city); ?>" name="city" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label"><?php echo e(__('Postal code')); ?></label>
                                                    <input type="number" min="0" id="zip_code" class="form-control" value="<?php echo e($default_addr->zip_code); ?>" name="postal_code" required>
                                                </div>
                                            </div>
                                           
                                        </div>

                                          <div class="row">
                                            <div class="col-md-6">
                                                
                                            </div>
                                             <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                   
                                                    
                                                     <label class="control-label"><?php echo e(__('Local Pickup')); ?>

                                                     <input type="radio" class="form-control " name="delivery_type" value="local_pickup" >

                                                     </label>
                                                </div>
                                            </div>
                                        </div> 


                                        <input type="hidden" name="checkout_type" value="logged">
                                    </div>
                                <?php else: ?>
                                    <div class="pr-4 pl-3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo e(__('Name')); ?></label>
                                                    <input type="text" class="form-control" name="name"  required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo e(__('Email')); ?></label>
                                                    <input type="text" class="form-control" name="email" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group address-feld">
                                                    <label class="control-label"><?php echo e(__('Address')); ?></label>
                                                    <input type="text" class="form-control" name="address"  required>
                                                </div>
                                            </div>
                                        </div>


                                         <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group address-feld">
                                                    <label class="control-label"><?php echo e(__('Address 1')); ?></label>
                                                    <input type="text" class="form-control" name="address1"   required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label"><?php echo e(__('Phone')); ?></label>
                                                    <input type="number" min="0" class="form-control" name="phone" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo e(__('Select your country')); ?></label>
                                                    <select class="form-control custome-control country_name" data-live-search="true" name="country">
                                                        <?php $__currentLoopData = \App\Country::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($country->name); ?>"><?php echo e($country->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo e(__('Select your state')); ?></label>
                                                    <select class="form-control custome-control state-fill" data-live-search="true" name="state">
                                                        <!-- <?php $__currentLoopData = \App\State::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($country->name); ?>"><?php echo e($country->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->
                                                    </select>
                                                </div>
                                            </div>


                                           
                                        </div>

                                        <div class="row">

                                             <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label"><?php echo e(__('City')); ?></label>
                                                    <input type="text" class="form-control"  name="city" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                    <label class="control-label"><?php echo e(__('Postal code')); ?></label>
                                                    <input type="number" min="0" class="form-control"  name="postal_code" required>
                                                </div>
                                            </div>
                                           
                                        </div>

                                         <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                   
                                                    <input type="radio" class="form-control fill_later_checkbox" name="delivery_type" value="fill_later" >
                                                     <label class="control-label"><?php echo e(__('Fill Later')); ?></label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group has-feedback">
                                                   
                                                    
                                                     <label class="control-label"><?php echo e(__('Local Pickup')); ?>

                                                     <input type="radio" class="form-control " name="delivery_type" value="local_pickup" >

                                                     </label>
                                                </div>
                                            </div>
                                        </div> 

                                        

                                        <input type="hidden" name="checkout_type" value="guest">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="row align-items-center mb-4 pr-4">
                                <div class="col-md-6">
                                    <a href="<?php echo e(route('home')); ?>" class="link link--style-3">
                                        <i class="ion-android-arrow-back"></i>
                                        <?php echo e(__('Return to shop')); ?>

                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-base-1"><?php echo e(__('Continue to Delivery Info')); ?></a>
                                </div>
                            </div>
                            
                        </form>
                    </div>

                    <div class="col-lg-4 ml-lg-auto cart-bg">
                       
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
    loadStates();
    $('.country_name').on('change', function(){
        //console.log(this.value);
        loadStates();
        
    });


    $('.fill_later_checkbox').on('change', function(){
           var a =  $(this).val();
           
           if ($(this).prop('checked')==true){ 
                //alert('checked');
                $("#user_details input").removeAttr("required");
            }else{
                $("#user_details input").attr("required", true);
                $('.fill_later_checkbox').removeAttr("required");
            }
    });

<?php if( Auth::check() ): ?>
    $('.prefilled_addresses').on('change', function(){
        //console.log(this.value);
        loadPrefilledAddress();
        
    });

    $('.address_box').on('click', function(){
        $('.address_box').removeClass('active');
        $(this).addClass('active');
        var boxID = this.id.split("_");
        var addressBoxID = boxID['1'];
        
        var name_div = 'addr_name_'+addressBoxID;
        var email_div = 'addr_email_'+addressBoxID;
        var address_div = 'addr_address_'+addressBoxID;
        var address1_div = 'addr_address1_'+addressBoxID;
        var phone_div = 'addr_phone_'+addressBoxID;
        var country_div = 'addr_country_'+addressBoxID;
        var state_div = 'addr_state_'+addressBoxID;
        var city_div = 'addr_city_'+addressBoxID;
        var zip_code_div = 'addr_zip_code_'+addressBoxID;
        //alert( $('#'+email_div).val() );

        //now fill in the selected box values in the address input box fields, which are visible to user
        $('#name').val( $('#'+name_div).val() );
        $('#email').val( $('#'+email_div).val() );
        $('#address').val( $('#'+address_div).val() );
        $('#address1').val( $('#'+address1_div).val() );
        $('#phone').val( $('#'+phone_div).val() );
        $('#country').val( $('#'+country_div).val() );
        $('#state').val( $('#'+state_div).val() );
        $('#city').val( $('#'+city_div).val() );
        $('#zip_code').val( $('#'+zip_code_div).val() );
    });

     function loadPrefilledAddress(){
         $.ajax({
               type:"POST",
               url: '<?php echo e(route('ajax.getAddressInfo')); ?>',
               data: $('#user_details').serializeArray(),
               success: function(data){
                  console.log(data);
                  var d = JSON.parse(data);
                  if (d!=null) {
                      $("input[name='name']").val(d.name);
                      $("input[name='email']").val(d.email);
                      $("input[name='address']").val(d.address);
                      $("input[name='address1']").val(d.address1);
                      $("input[name='phone']").val(d.phone);
                      $('.country_name').val(d.country);
                      $('.state-fill').val(d.state);
                      $("input[name='city']").val(d.city);
                      $("input[name='postal_code']").val(d.zip_code);
                  }
                  //$('.state-fill').html(data);
               }
           });
    }
<?php endif; ?>
    

    function loadStates(){
         $.ajax({
               type:"POST",
               url: '<?php echo e(route('ajax.getStates')); ?>',
               data: $('#user_details').serializeArray(),
               success: function(data){
                  //console.log(data);
                  $('.state-fill').html(data);
               }
           });
    }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/desktop/frontend/fill_later/shipping_info.blade.php ENDPATH**/ ?>