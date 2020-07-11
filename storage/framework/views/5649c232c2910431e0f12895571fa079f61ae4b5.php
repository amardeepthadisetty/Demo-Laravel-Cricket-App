<?php $__env->startSection('content'); ?>

<?php if($type != 'Seller'): ?>
    <div class="row">
        <div class="col-lg-12">
            <a href="<?php echo e(route('templatecategories.create')); ?>" class="btn btn-rounded btn-info pull-right"><?php echo e(__('Add New Template')); ?></a>
        </div>
    </div>
<?php endif; ?>

<br>

<?php if(Session::get('success')): ?>
    <?php echo e(Session::get('success')); ?>

<?php endif; ?>
<div class="col-lg-12">
    <div class="panel">
        <!--Panel heading-->
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo e(__($type.' Template Categories')); ?></h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reference ID</th>
                        <th width="20%"><?php echo e(__('Name')); ?></th>
                        <th width="20%"><?php echo e(__('Slug')); ?></th>
                        <th><?php echo e(__('Photo')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Published')); ?></th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($key+1); ?> </td>
                            <td><?php echo e($template->ref); ?></td>
                            <td>
                                <?php

                                $categoryName = '';
                            if($template->parent_id!="0" ){
                                $firstLevel = \App\TemplateCategories::where('ref',$template->parent_id)->first();
                                if ($firstLevel) {
                                     $categoryName = $firstLevel->name;

                                     //echo $categoryName."<br>";
                                     //die;


                                          $secondLevel = \App\TemplateCategories::where('ref',$firstLevel->parent_id)->where('active','1')->first();
                                          if ($secondLevel) {
                                              $categoryName .= ' > '.$secondLevel->name;

                                              $thirdLevel = \App\TemplateCategories::where('ref',$secondLevel->parent_id)->where('active','1')->first();
                                              if ($thirdLevel) {
                                                 $categoryName .= ' > '.$thirdLevel->name;
                                              }
                                          }//end of secondLevel if
                                }
                            }

                                $categoryName .= ' > '.$template->name;

                                ?>


                                 <?php if($template->parent_id!="0" ): ?>
                                 <a href="<?php echo e(route('product', $template->slug)); ?>" target="_blank"><?php echo e(__($categoryName)); ?></a>
                                <?php else: ?>
                                 <a href="<?php echo e(route('product', $template->slug)); ?>" target="_blank"><?php echo e(__($template->name)); ?></a>
                                <?php endif; ?>
                               
                            </td>
                            <td> <?php echo e($template->slug); ?></td>
                            <td>
                                <?php 
                                  
                                        $imageURL = '';
                                        if( !empty( $template->photos ) )
                                            $imageURL = $template->photos[0];
                                           

                                    ?>

                                <img loading="lazy"  class="img-md" src="<?php echo e(asset( getImageURL( $imageURL,'icon')  )); ?>" alt="Image">

                            </td>
                            
                            
                           
                            <td><label class="switch">
                                <input onchange="update_todays_deal(this)" value="<?php echo e($template->id); ?>" type="checkbox" <?php if($template->active == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                           
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        <?php echo e(__('Actions')); ?> <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <?php if($type == 'Seller'): ?>
                                            <li><a href="<?php echo e(route('templates.seller.edit', encrypt($template->id))); ?>"><?php echo e(__('Edit')); ?></a></li>
                                        <?php else: ?>
                                            <li><a href="<?php echo e(route('templatecategories.admin.edit', encrypt($template->id))); ?>"><?php echo e(__('Edit')); ?></a></li>
                                        <?php endif; ?>
                                        <li><a onclick="confirm_modal('<?php echo e(route('templates.destroy', $template->id)); ?>');"><?php echo e(__('Delete')); ?></a></li>
                                       
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script type="text/javascript">

        $(document).ready(function(){
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_todays_deal(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('<?php echo e(route('templatecategories.todays_deal')); ?>', {_token:'<?php echo e(csrf_token()); ?>', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Status updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_published(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('<?php echo e(route('templates.published')); ?>', {_token:'<?php echo e(csrf_token()); ?>', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Published templates updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_featured(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('<?php echo e(route('templates.featured')); ?>', {_token:'<?php echo e(csrf_token()); ?>', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Featured templates updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cricket\resources\views/templatecategories/index.blade.php ENDPATH**/ ?>