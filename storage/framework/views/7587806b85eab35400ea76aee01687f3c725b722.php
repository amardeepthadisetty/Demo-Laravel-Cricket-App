<?php if($request->option_type !=''): ?>
	<table class="table table-bordered">
		<thead>
			<tr>
				<td class="text-center">
					<label for="" class="control-label"><?php echo e(__('Option Name')); ?></label>
				</td>
				<td class="text-center">
					<label for="" class="control-label"><?php echo e(__('Default Value')); ?></label>
				</td>
				<td class="text-center">
					<label for="" class="control-label"><?php echo e(__('Price')); ?></label>
				</td>
				<td class="text-center">
					<label for="" class="control-label"><?php echo e(__('Sort Order')); ?></label>
				</td>
			</tr>
		</thead>
		<tbody>
			<!-- This is for radio and checkbox -->
			<?php if($request->option_type=="radio" || $request->option_type=="checkbox"): ?>
			<?php $__currentLoopData = $option_values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td>
				<label for="" class="control-label"><?php echo e(concat_string($option,$o)); ?></label>
			</td>
			<td>
					<input type="text" name="default_<?php echo e(concat_string($option,$o)); ?>" value="<?php 
				$str = concat_string($option,$o);
				//echo $str;
				//print_r($product->additional_options_variations);
				if(isset($product->additional_options_variations->$str->default)){
	                        echo $product->additional_options_variations->$str->default;
	                    }
	                    else{
	                        echo '0';
	                    }

				?>" class="form-control" >
				</td>
			<td>
				<input type="number" name="price_<?php echo e(concat_string($option,$o)); ?>" value="<?php 
				$str = concat_string($option,$o);
				//echo $str;
				//print_r($product->additional_options_variations);
				if(isset($product->additional_options_variations->$str->price)){
	                        echo $product->additional_options_variations->$str->price;
	                    }
	                    else{
	                        echo '0';
	                    }

				?>"  min="0" step="0.01" class="form-control" required="">
			</td>
			<td>
				<input type="number" name="sort_<?php echo e(concat_string($option,$o)); ?>" value="<?php 
				$str = concat_string($option,$o);
				//echo $str;
				//print_r($product->additional_options_variations);
				if(isset($product->additional_options_variations->$str->sort)){
	                        echo $product->additional_options_variations->$str->sort;
	                    }
	                    else{
	                        echo '0';
	                    }

				?>" min="0" step="1" class="form-control" required="">
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
		<!-- End of radio and checkbox -->

		<!-- This is for text and text area -->
		<?php if($request->option_type=="text" || $request->option_type=="textarea"): ?>
		 	<tr>
				<td>
					<label for="" class="control-label"><?php echo e(concat_string($option,$request->option_type)); ?></label>
				</td>
				<td>
					<input type="text" name="default_<?php echo e(concat_string($option,$request->option_type)); ?>" value="<?php 
				$str = concat_string($option,$request->option_type);
				//echo $str;
				//print_r($product->additional_options_variations);
				if(isset($product->additional_options_variations->$str->default)){
	                        echo $product->additional_options_variations->$str->default;
	                    }
	                    else{
	                        echo '0';
	                    }

				?>" class="form-control" required="">
				</td>
				<td>
					<input type="number" name="price_<?php echo e(concat_string($option,$request->option_type)); ?>" value="<?php 
				$str = concat_string($option,$request->option_type);
				//echo $str;
				//print_r($product->additional_options_variations);
				if(isset($product->additional_options_variations->$str->price)){
	                        echo $product->additional_options_variations->$str->price;
	                    }
	                    else{
	                        echo '0';
	                    }

				?>" class="form-control" required="">
				</td>
				<td>
					<input type="number" name="sort_<?php echo e(concat_string($option,$request->option_type)); ?>" value="<?php 
				$str = concat_string($option,$request->option_type);
				//echo $str;
				//print_r($product->additional_options_variations);
				if(isset($product->additional_options_variations->$str->sort)){
	                        echo $product->additional_options_variations->$str->sort;
	                    }
	                    else{
	                        echo '0';
	                    }

				?>" min="0" step="1" class="form-control" required="">
				</td>
			</tr>
		<?php endif; ?>
		<!-- End of text and text area -->

	</tbody>
</table>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\laramongo\resources\views/partials/more_options_edit.blade.php ENDPATH**/ ?>