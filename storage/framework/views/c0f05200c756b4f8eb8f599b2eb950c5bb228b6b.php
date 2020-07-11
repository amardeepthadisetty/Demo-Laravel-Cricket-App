<?php $__env->startSection('content'); ?>


<div class="row">
	<form class="form form-horizontal mar-top" action="<?php echo e(route('shippingmethod.update', $sm->id)); ?>" method="POST" enctype="multipart/form-data" id="choice_form">
		<?php echo csrf_field(); ?>
		<input type="hidden" name="added_by" value="admin">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo e(__('Shipping Methods')); ?></h3>
			</div>
			<div class="panel-body">
				<div class="tab-base tab-stacked-left">
				    <!--Nav tabs-->
				    <ul class="nav nav-tabs">
				        <li class="active">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-1" aria-expanded="true"><?php echo e(__('General')); ?></a>
				        </li>
				      

				    </ul>

				    <!--Tabs Content-->
				    <div class="tab-content">
				        <div id="demo-stk-lft-tab-1" class="tab-pane fade active in">
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Shipping Name')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="shipping_name" placeholder="<?php echo e(__('Shipping Name')); ?>" value="<?php echo e($sm->name); ?>"  required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Status')); ?></label>
								<div class="col-lg-7">
									<select class="form-control" name="status" >
										<option value="1" <?php echo ($sm->status=="1") ? 'selected' :'';  ?> >Active</option>
										<option value="0" <?php echo ($sm->status=="0") ? 'selected' :'';  ?> >In Active</option>
									</select>
									
								</div>
							</div>


							
							

							
							

							
				        </div>
				        
				 
						

					

				      

						

						

				         
				    </div>
				</div>
			</div>
			<div class="panel-footer text-right">
				<button type="submit" name="button" class="btn btn-info"><?php echo e(__('Update')); ?></button>
			</div>
		</div>
	</form>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/shipping_methods/edit.blade.php ENDPATH**/ ?>