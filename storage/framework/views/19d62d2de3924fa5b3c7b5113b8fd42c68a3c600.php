<?php $__env->startSection('content'); ?>

<div class="row">
	<form class="form form-horizontal mar-top" action="<?php echo e(route('products.store')); ?>" method="POST" enctype="multipart/form-data" id="choice_form">
		<?php echo csrf_field(); ?>
		<input type="hidden" name="added_by" value="admin">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo e(__('Product Information')); ?></h3>
			</div>
			<div class="panel-body">
				<div class="tab-base tab-stacked-left">
				    <!--Nav tabs-->
				    <ul class="nav nav-tabs">
				        <li class="active">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-1" aria-expanded="true"><?php echo e(__('General')); ?></a>
				        </li>
				        <li class="">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-2" aria-expanded="false"><?php echo e(__('Images')); ?></a>
				        </li>
						<li class="">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-3" aria-expanded="false"><?php echo e(__('Videos')); ?></a>
				        </li>
				        <li class="">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-4" aria-expanded="false"><?php echo e(__('Meta Tags')); ?></a>
				        </li>
						<li class="">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-5" aria-expanded="false"><?php echo e(__('Customer Choice')); ?></a>
				        </li>
						<li class="">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-6" aria-expanded="false"><?php echo e(__('Price')); ?></a>
				        </li>
				        <li class="">
				            <a data-toggle="tab" href="#demo-options" aria-expanded="false"><?php echo e(__('Options')); ?></a>
				        </li>
						<li class="">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-7" aria-expanded="false"><?php echo e(__('Description')); ?></a>
				        </li>

						
						<li class="">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-9" aria-expanded="false"><?php echo e(__('Shipping Info')); ?></a>
				        </li>
						<li class="">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-10" aria-expanded="false"><?php echo e(__('PDF Specification')); ?></a>
				        </li>
				        <li class="">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-11" aria-expanded="false"><?php echo e(__('More Options')); ?></a>
				        </li>
				    </ul>

				    <!--Tabs Content-->
				    <div class="tab-content">
				        <div id="demo-stk-lft-tab-1" class="tab-pane fade active in">
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Product Name')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="name" placeholder="<?php echo e(__('Product Name')); ?>" onchange="update_sku();" required>
								</div>
							</div>

							<div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Product Type')); ?></label>
	                            <div class="col-lg-7">
	                                <input type="text" class="form-control" name="product_type" placeholder="<?php echo e(__('Product Type')); ?>" value=""   required>
	                            </div>
	                        </div>
							

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Model')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="model" placeholder="<?php echo e(__('Model')); ?>" required>
								</div>
							</div>

							 <div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Categories')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" id="category_id_name" name="parent_id_name" placeholder="Type to get suggestions" data-role="" value="">
									<div id="category_ids">

										
									</div>
									
								</div>
							</div>

							
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Unit')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="unit" placeholder="Unit (e.g. KG, Pc etc)" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Tags')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="tags[]" placeholder="Type to add a tag" data-role="tagsinput">
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Is Template')); ?></label>
								<div class="col-lg-7">
								
									<label class="switch" style="margin-top:5px;">
										<input value="1" type="checkbox" name="is_template"  >
										<span class="slider round"></span>
									</label>
								</div>
								
							</div>
				        </div>
				        <div id="demo-stk-lft-tab-2" class="tab-pane fade">
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Main Images')); ?> </label>
								<div class="col-lg-7">
									<div id="photos">

									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Thumbnail Image')); ?> <small>(290x300)</small></label>
								<div class="col-lg-7">
									<div id="thumbnail_img">

									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Featured')); ?> <small>(290x300)</small></label>
								<div class="col-lg-7">
									<div id="featured_img">

									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Flash Deal')); ?> <small>(290x300)</small></label>
								<div class="col-lg-7">
									<div id="flash_deal_img">

									</div>
								</div>
							</div>
				        </div>
				        <div id="demo-stk-lft-tab-3" class="tab-pane fade">
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Video Provider')); ?></label>
								<div class="col-lg-7">
									<select class="form-control demo-select2-placeholder" name="video_provider" id="video_provider">
										<option value="youtube"><?php echo e(__('Youtube')); ?></option>
										<option value="dailymotion"><?php echo e(__('Dailymotion')); ?></option>
										<option value="vimeo"><?php echo e(__('Vimeo')); ?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Video Link')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="video_link" placeholder="<?php echo e(__('Video Link')); ?>">
								</div>
							</div>
				        </div>
						<div id="demo-stk-lft-tab-4" class="tab-pane fade">
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Meta Title')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="meta_title" placeholder="<?php echo e(__('Meta Title')); ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Description')); ?></label>
								<div class="col-lg-7">
									<textarea name="meta_description" rows="8" class="form-control"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Meta Image')); ?></label>
								<div class="col-lg-7">
									<div id="meta_photo">

									</div>
								</div>
							</div>
				        </div>

						<div id="demo-stk-lft-tab-5" class="tab-pane fade">
							<div class="form-group">
								<div class="col-lg-2">
									<input type="text" class="form-control" value="<?php echo e(__('Colors')); ?>" disabled>
								</div>
								<div class="col-lg-7">
									<select class="form-control color-var-select" name="colors[]" id="colors" multiple disabled>
										
									</select>
								</div>
								<div class="col-lg-2">
									<label class="switch" style="margin-top:5px;">
										<input value="1" type="checkbox" name="colors_active">
										<span class="slider round"></span>
									</label>
								</div>
							</div>

							<div class="customer_choice_options" id="customer_choice_options">

							</div>
							<div class="form-group">
								<div class="col-lg-2">
									<button type="button" class="btn btn-info" onclick="add_more_customer_choice_option()"><?php echo e(__('Add more customer choice option')); ?></button>
								</div>
							</div>
				        </div>

						<div id="demo-stk-lft-tab-6" class="tab-pane fade">
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Unit price')); ?></label>
								<div class="col-lg-7">
									<input type="number" min="0" value="0" step="0.01" placeholder="<?php echo e(__('Unit price')); ?>" name="unit_price" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Purchase price')); ?></label>
								<div class="col-lg-7">
									<input type="number" min="0" value="0" step="0.01" placeholder="<?php echo e(__('Purchase price')); ?>" name="purchase_price" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Tax')); ?></label>
								<div class="col-lg-7">
									<input type="number" min="0" value="0" step="0.01" placeholder="<?php echo e(__('Tax')); ?>" name="tax" class="form-control" required>
								</div>
								<div class="col-lg-1">
									<select class="demo-select2" name="tax_type">
										<option value="amount">$</option>
										<option value="percent">%</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Discount')); ?></label>
								<div class="col-lg-7">
									<input type="number" min="0" value="0" step="0.01" placeholder="<?php echo e(__('Discount')); ?>" name="discount" class="form-control" required>
								</div>
								<div class="col-lg-1">
									<select class="demo-select2" name="discount_type">
										<option value="amount">$</option>
										<option value="percent">%</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="quantity">
								<label class="col-lg-2 control-label"><?php echo e(__('Quantity')); ?></label>
								<div class="col-lg-7">
									<input type="number" min="0" value="0" step="1" placeholder="<?php echo e(__('Quantity')); ?>" name="current_stock" class="form-control" required>
								</div>
							</div>
							<br>

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Is Variant')); ?></label>
								<div class="col-lg-7">
								
									<label class="switch" style="margin-top:5px;">
										<input value="1" type="checkbox" name="is_variant"  >
										
										<span class="slider round"></span>
									</label>
								</div>
								
							</div>


							<div class="sku_combination" id="sku_combination">

							</div>
				        </div>

				        <div id="demo-options" class="tab-pane fade">
				        	<div id="more_options"> 
				        	 
				        	 </div>
				        	<div class="form-group">
								<div class="col-lg-2">
									<button type="button" class="btn btn-info" onclick="add_more_options()"><?php echo e(__('Add more Options')); ?></button>
								</div>
							</div>


				        </div>

						<div id="demo-stk-lft-tab-7" class="tab-pane fade">

							<div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Small Description')); ?></label>
	                            <div class="col-lg-9">
	                                <textarea class="editor" name="small_description"></textarea>
	                            </div>
	                        </div>

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Description')); ?></label>
								<div class="col-lg-9">
									<textarea class="editor" name="description"></textarea>
								</div>
							</div>
				        </div>

						

						<div id="demo-stk-lft-tab-9" class="tab-pane fade">
							<div class="row bord-btm">
								<div class="col-md-2">
									<div class="panel-heading">
										<h3 class="panel-title"><?php echo e(__('Free Shipping')); ?></h3>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label class="col-lg-2 control-label"><?php echo e(__('Status')); ?></label>
										<div class="col-lg-7">
											<label class="switch" style="margin-top:5px;">
												<input type="radio" name="shipping_type" value="free" checked>
												<span class="slider round"></span>
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-2">
									<div class="panel-heading">
										<h3 class="panel-title"><?php echo e(__('Flat Rate')); ?></h3>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label class="col-lg-2 control-label"><?php echo e(__('Status')); ?></label>
										<div class="col-lg-7">
											<label class="switch" style="margin-top:5px;">
												<input type="radio" name="shipping_type" value="flat_rate" checked>
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label"><?php echo e(__('Shipping cost')); ?></label>
										<div class="col-lg-7">
											<input type="number" min="0" value="0" step="0.01" placeholder="<?php echo e(__('Shipping cost')); ?>" name="flat_shipping_cost" class="form-control" required>
										</div>
									</div>
								</div>
							</div>

				        </div>
						<div id="demo-stk-lft-tab-10" class="tab-pane fade">
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('PDF Specification')); ?></label>
								<div class="col-lg-7">
									<input type="file" class="form-control" placeholder="<?php echo e(__('PDF')); ?>" name="pdf" accept="application/pdf">
								</div>
							</div>
				        </div>

				         <div id="demo-stk-lft-tab-11" class="tab-pane fade">

				        	<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Upload Image')); ?></label>
								<div class="col-lg-2">
								
									<label class="switch" style="margin-top:5px;">
										<input value="1" type="checkbox" name="upload_active" <?php  echo "checked";?> >
										<span class="slider round"></span>
									</label>
								</div>
								
							</div>

							<div class="form-group upload_limit_div">
										<label class="col-lg-2 control-label"><?php echo e(__('Limit Number Of Images')); ?></label>
										<div class="col-lg-7">
											<input type="number" min="0" step="0.01" placeholder="<?php echo e(__('Upload Limit')); ?>" name="upload_limit" class="form-control" value="" >
										</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Instructions')); ?></label>
								<div class="col-lg-2">
								
									<label class="switch" style="margin-top:5px;">
										<input value="1" type="checkbox" name="instructions_active" <?php  echo "checked";?> >
										<span class="slider round"></span>
									</label>
								</div>
								
							</div>





							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Promotion')); ?></label>
								<div class="col-lg-2">
								
									<label class="switch" style="margin-top:5px;">
										<input value="1" type="checkbox" name="promotion_active" <?php  echo "checked";?> >
										<span class="slider round"></span>
									</label>
								</div>
								
							</div>

							<div class="promotion_div">
								<div class="form-group ">
											<label class="col-lg-2 control-label"><?php echo e(__('Text to appear for promotion')); ?></label>
											<div class="col-lg-7">
												<input type="text" placeholder="<?php echo e(__('Text')); ?>" name="promotion_text" class="form-control" value="" >
											</div>
								</div>

								<div class="form-group upload_limit_div">
											<label class="col-lg-2 control-label"><?php echo e(__('Discount')); ?></label>
											<div class="col-lg-7">
												<input type="number" placeholder="<?php echo e(__('Text')); ?>" name="promotion_discount" class="form-control" value="0" >
											</div>
								</div>
								
							</div>
							
							
				        </div>
				    </div>
				</div>
			</div>
			<div class="panel-footer text-right">
				<button type="submit" name="button" class="btn btn-info"><?php echo e(__('Save')); ?></button>
			</div>
		</div>
	</form>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
	var i = 0;
	var j = 0;
	function add_more_customer_choice_option(){
		$('#customer_choice_options').append('<div class="form-group"><div class="col-lg-2"><input type="hidden" name="choice_no[]" value="'+i+'"><input type="text" class="form-control" name="choice[]" value="" placeholder="Choice Title"></div><div class="col-lg-7"><input type="text" class="form-control" name="choice_options_'+i+'[]" placeholder="Enter choice values" data-role="tagsinput" onchange="update_sku()"></div><div class="col-lg-2"><button onclick="delete_row(this)" class="btn btn-danger btn-icon"><i class="demo-psi-recycling icon-lg"></i></button></div></div>');
		i++;
		$("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
	}

	function add_more_options(){
		j++;
		$('#more_options').append('<div class="form-group options_div_'+j+'"><div class="col-lg-2"><input type="hidden" name="options_no[]" value="'+j+'"><input type="text" class="form-control" name="option[]" value="" placeholder="Option Title"></div><div class="col-lg-2"><select class="form-control" name="option_type_'+j+'" id="option_type_'+j+'" onchange="update_option_sku('+j+')"> <option value="">Select input type</option> <option value="radio">Radio</option> <option value="checkbox">Checkbox</option> <option value="text">Text</option> <option value="textarea">Text Area</option> </select> </div><div class="col-lg-5" id="option_values_'+j+'"><input type="text" class="form-control" name="option_values_'+j+'[]" placeholder="Enter option values" data-role="tagsinput" onchange="update_option_sku('+j+')"></div><div class="col-lg-2"><button onclick="delete_row(this)" class="btn btn-danger btn-icon"><i class="demo-psi-recycling icon-lg"></i></button></div><div id="option_def_'+j+'"></div></div>'); $("input[data-role=tagsinput]").tagsinput();
	}

	$('input[name="colors_active"]').on('change', function() {
	    if(!$('input[name="colors_active"]').is(':checked')){
			$('#colors').prop('disabled', true);
		}
		else{
			$('#colors').prop('disabled', false);
		}
		update_sku();
	});


	$('input[name="upload_active"]').on('change', function() {
	    if($('input[name="upload_active"]').is(':checked')){
			//$('.upload_limit_div').show();
			$('input[name="upload_active"]').val(1);
		}
		else{
			//$('#colors').prop('disabled', false);
			//$('.upload_limit_div').hide();
			$('input[name="upload_active"]').val(0);
		}
		
	});

	$('input[name="is_template"]').on('change', function() {
	    if($('input[name="is_template"]').is(':checked')){
			//$('.upload_limit_div').show();
			$('input[name="is_template"]').val(1);
		}
		else{
			//$('#colors').prop('disabled', false);
			//$('.upload_limit_div').hide();
			$('input[name="is_template"]').val(0);
		}
		
	});


	$('input[name="is_variant"]').on('change', function() {
	    if($('input[name="is_variant"]').is(':checked')){
			//$('.upload_limit_div').show();
			$('input[name="is_variant"]').val(1);
		}
		else{
			//$('#colors').prop('disabled', false);
			//$('.upload_limit_div').hide();
			$('input[name="is_variant"]').val(0);
		}
		
	});

	$('input[name="instructions_active"]').on('change', function() {
	    if($('input[name="instructions_active"]').is(':checked')){
			
			$('input[name="instructions_active"]').val(1);
		}
		else{
			//$('#colors').prop('disabled', false);
			
			$('input[name="instructions_active"]').val(0);
		}
		
	});

	

	$('input[name="promotion_active"]').on('change', function() {
	    if($('input[name="promotion_active"]').is(':checked')){
			//$('.promotion_div').show();
			$('input[name="promotion_active"]').val(1);
		}
		else{
			//$('#colors').prop('disabled', false);
			//$('.promotion_div').hide();
			$('input[name="promotion_active"]').val(0);
		}
		
	});

	$('#colors').on('change', function() {
	    update_sku();
	});

	$('input[name="unit_price"]').on('keyup', function() {
	    update_sku();
	});

	$('input[name="name"]').on('keyup', function() {
	    update_sku();
	});

	function delete_row(em){
		$(em).closest('.form-group').remove();
		update_sku();
	}

	function update_option_sku(ref_row){
		//console.log("ref row is: "+ref_row);
		//alert(ref_row);
		//debugger;
		var idNametohide_tag_input = '#option_values_'+ref_row;
		var selectBoxName = '#option_type_'+ref_row;
		var option_type = $(selectBoxName).val();
		if (option_type=="radio" || option_type=='checkbox') {
			$(idNametohide_tag_input).show();
		}else{
			$(idNametohide_tag_input).hide();
		}
		$.ajax({
		   type:"POST",
		   url:'<?php echo e(route('products.more_options')); ?>',
		   data:{
		   //	'data':$('#choice_form .options_div_'+ref_row).serialize(),
		   	'data':$('#choice_form').serialize(),
		   	'_token': '<?php echo e(csrf_token()); ?>',
		   	'ref_row' : ref_row,
		   	'option_type' : option_type
		   },
		   success: function(data){
		   	//alert(option_type);
		   /*	if(option_type=="textarea" || option_type=="text"){
		   		console.log("option type txt,txtarea data is: ",data);
		   	}*/
		   	if (data!='') {
		   		$('#option_def_'+ref_row).html(data);
		   	}
		   	
			   /*$('#sku_combination').html(data);
			   if (!data) {
				   $('#quantity').show();
			   }
			   else {
			   		$('#quantity').hide();
			   }*/
		   }
	   });
	}

	function update_sku(){
		$.ajax({
		   type:"POST",
		   url:'<?php echo e(route('products.sku_combination')); ?>',
		   data:$('#choice_form').serialize(),
		   success: function(data){
			   $('#sku_combination').html(data);
			   if (!data) {
				   $('#quantity').show();
			   }
			   else {
			   		$('#quantity').hide();
			   }
		   }
	   });
	}

	function get_subcategories_by_category(){
		var category_id = $('#category_id').val();
		$.post('<?php echo e(route('subcategories.get_subcategories_by_category')); ?>',{_token:'<?php echo e(csrf_token()); ?>', category_id:category_id}, function(data){
		    $('#subcategory_id').html(null);
		    for (var i = 0; i < data.length; i++) {
		        $('#subcategory_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		        $('.demo-select2').select2();
		    }
		    get_subsubcategories_by_subcategory();
		});
	}

	function get_subsubcategories_by_subcategory(){
		var subcategory_id = $('#subcategory_id').val();
		$.post('<?php echo e(route('subsubcategories.get_subsubcategories_by_subcategory')); ?>',{_token:'<?php echo e(csrf_token()); ?>', subcategory_id:subcategory_id}, function(data){
		    $('#subsubcategory_id').html(null);
		    for (var i = 0; i < data.length; i++) {
		        $('#subsubcategory_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		        $('.demo-select2').select2();
		    }
		    get_brands_by_subsubcategory();
		});
	}

	function get_brands_by_subsubcategory(){
		var subsubcategory_id = $('#subsubcategory_id').val();
		$.post('<?php echo e(route('subsubcategories.get_brands_by_subsubcategory')); ?>',{_token:'<?php echo e(csrf_token()); ?>', subsubcategory_id:subsubcategory_id}, function(data){
		    $('#brand_id').html(null);
		    //console.log(data);
		    for (var i = 0; i < data.length; i++) {
		    	//console.log("data is: ",data[i]);
		    	//console.log("name  is: "+data[i][0].name);
		    	//console.log("data is: "+data[i]['name']);
		        $('#brand_id').append($('<option>', {
		            value: data[i][0].id,
		            text: data[i][0].name
		        }));
		        $('.demo-select2').select2();
		    }
		});
	}

	$(document).ready(function(){
		$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
	    get_subcategories_by_category();
		$("#photos").spartanMultiImagePicker({
			fieldName:        'photos[]',
			maxCount:         10,
			rowHeight:        '200px',
			groupClassName:   'col-md-4 col-sm-4 col-xs-6',
			maxFileSize:      '',
			dropFileLabel : "Drop Here",
			onExtensionErr : function(index, file){
				console.log(index, file,  'extension err');
				alert('Please only input png or jpg type file')
			},
			onSizeErr : function(index, file){
				console.log(index, file,  'file size too big');
				alert('File size too big');
			}
		});
		$("#thumbnail_img").spartanMultiImagePicker({
			fieldName:        'thumbnail_img',
			maxCount:         1,
			rowHeight:        '200px',
			groupClassName:   'col-md-4 col-sm-4 col-xs-6',
			maxFileSize:      '',
			dropFileLabel : "Drop Here",
			onExtensionErr : function(index, file){
				console.log(index, file,  'extension err');
				alert('Please only input png or jpg type file')
			},
			onSizeErr : function(index, file){
				console.log(index, file,  'file size too big');
				alert('File size too big');
			}
		});
		$("#featured_img").spartanMultiImagePicker({
			fieldName:        'featured_img',
			maxCount:         1,
			rowHeight:        '200px',
			groupClassName:   'col-md-4 col-sm-4 col-xs-6',
			maxFileSize:      '',
			dropFileLabel : "Drop Here",
			onExtensionErr : function(index, file){
				console.log(index, file,  'extension err');
				alert('Please only input png or jpg type file')
			},
			onSizeErr : function(index, file){
				console.log(index, file,  'file size too big');
				alert('File size too big');
			}
		});
		$("#flash_deal_img").spartanMultiImagePicker({
			fieldName:        'flash_deal_img',
			maxCount:         1,
			rowHeight:        '200px',
			groupClassName:   'col-md-4 col-sm-4 col-xs-6',
			maxFileSize:      '',
			dropFileLabel : "Drop Here",
			onExtensionErr : function(index, file){
				console.log(index, file,  'extension err');
				alert('Please only input png or jpg type file')
			},
			onSizeErr : function(index, file){
				console.log(index, file,  'file size too big');
				alert('File size too big');
			}
		});
		$("#meta_photo").spartanMultiImagePicker({
			fieldName:        'meta_img',
			maxCount:         1,
			rowHeight:        '200px',
			groupClassName:   'col-md-4 col-sm-4 col-xs-6',
			maxFileSize:      '',
			dropFileLabel : "Drop Here",
			onExtensionErr : function(index, file){
				console.log(index, file,  'extension err');
				alert('Please only input png or jpg type file')
			},
			onSizeErr : function(index, file){
				console.log(index, file,  'file size too big');
				alert('File size too big');
			}
		});
	});

	$('#category_id').on('change', function() {
	    get_subcategories_by_category();
	});

	$('#subcategory_id').on('change', function() {
	    get_subsubcategories_by_subcategory();
	});

	$('#subsubcategory_id').on('change', function() {
	    get_brands_by_subsubcategory();
	});

	/*function buildslug(name){
		//var name = 
		//console.log("name is: ", name);
		if (name!='') {
			var n = name.split(' ').join('_').toLowerCase();
			//console.log("n is: ", n);
			$('#slug').val(n);
		}
		

	}*/







	$( "#category_id_name" ).autocomplete({
      source: function(d,e){
      	

        $.ajax({
               type:"POST",
               url: '<?php echo e(route('ajax.templatecategories')); ?>',
               data: $('#choice_form').serializeArray(),
               success: function(data){
                   
                   	var data = JSON.parse(data);
                   	//console.log(data);
                     var c = [];
		              $.each(data, function (i, a, k) {
		                c.push({'value':a.id, 'label':a.name }) // Displays Title and Date
		                //console.log(a);
		              });
		              e(c)
               }
           });



      },
      select: function (a, b) {
      //console.log(b);
        // Appends an array with 2 keys: Value and Label. 
        // Both display the title and date as shown above.
       // console.log(a);
        //console.log(b);
        a.preventDefault();
        $('#category_id_name').val(b.item.label);
        $('#parent_id').val(b.item.value);

        pushCatNamenLabels( b.item.value , b.item.label);
        //console.log(a);
        //console.log(b);
        $('#category_id_name').val('');
      },
	    focus: function(a, b) {
	        a.preventDefault();
	        $('#category_id_name').val(b.item.label);
	        $('#parent_id').val(b.item.value);
	    }
	  }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $( "<li></li>" )
                    .data( "ui-autocomplete-item", item )
                    .append( "<a>"+ item.label + "</a>" ) 
                       // Here I want to append a.id as class of this
                       // but the only values are value and label.
                    .appendTo( ul );
            };


     let catIDSArray = [];
     function pushCatNamenLabels(cat_ref, category_name_with_heirarchy){


		const index = catIDSArray.findIndex((e) => e.id === cat_ref);

	    if (index === -1) {
	        catIDSArray.push({ 
			'id' : cat_ref,
			'name': category_name_with_heirarchy

			});
	    } 

		//console.log("catIDSArray is:", catIDSArray);

		showCatIDSArray();

	}


	function showCatIDSArray( ){

		let divHTML = '';

		for (var i = catIDSArray.length - 1; i >= 0; i--) {
			//catIDSArray[i].id;
			//catIDSArray[i].name;

			divHTML += '<div>';
			divHTML += '<button  id="'+catIDSArray[i].id+'" type="button" class="removeCatItem btn btn-purple btn-xs">X</button>';
			divHTML += '<label>'+  catIDSArray[i].name  +'</label>';
			divHTML += '<input type="hidden" name="category_ids[]" value="'+catIDSArray[i].id+'"  >';
			divHTML += '</div>';
		}

		$('#category_ids').html( divHTML );

	}


	$('body').on('click','.removeCatItem', function(){
		var idToRemove = this.id;

		//alert(this.id);
		for (var i = catIDSArray.length - 1; i >= 0; i--) {
			
			if( catIDSArray[i].id === this.id){
				catIDSArray.splice(i,1);
			}
		}

		showCatIDSArray( );

	});


	


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/products/create.blade.php ENDPATH**/ ?>