<?php $__env->startSection('content'); ?>

<style type="text/css">
	.ui-menu {
		position: relative;
		z-index: 9999;
	}
</style>
<div class="row">
	<form class="form form-horizontal mar-top" action="<?php echo e(route('templates.update', $template->id)); ?>" method="POST" enctype="multipart/form-data" id="choice_form">
		<input name="_method" type="hidden" value="POST">
		<input type="hidden" name="id" value="<?php echo e($template->id); ?>">
		<?php echo csrf_field(); ?>
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo e(__('Template Information')); ?></h3>
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
				            <a data-toggle="tab" href="#demo-stk-lft-tab-4" aria-expanded="false"><?php echo e(__('Meta Tags')); ?></a>
				        </li>
				        <li class="">
				            <a data-toggle="tab" href="#demo-options" aria-expanded="false"><?php echo e(__('Options')); ?></a>
				        </li>
						<li class="">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-7" aria-expanded="false"><?php echo e(__('Description')); ?></a>
				        </li>
						
				        <li class="">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-11" aria-expanded="false"><?php echo e(__('More Options')); ?></a>
				        </li>
				    </ul>

				    <!--Tabs Content-->
				    <div class="tab-content">
				        <div id="demo-stk-lft-tab-1" class="tab-pane fade active in">
							<div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Template Name')); ?></label>
	                            <div class="col-lg-7">
	                                <input type="text" class="form-control" name="name" placeholder="<?php echo e(__('Template Name')); ?>" value="<?php echo e($template->name); ?>"   required>
	                            </div>
	                        </div>



	                        <div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Template Type')); ?></label>
	                            <div class="col-lg-7">
	                                <select class="form-control" name="template_type" required>
	                                	<option value="">Select Type</option>
	                                	<option value="template" <?php if($template->template_type=="template"){ echo 'selected'; }  ?> >Template</option>
	                                	<option value="layout" <?php if($template->template_type=="layout"){ echo 'selected'; }  ?> >Layout</option>
	                                </select>
	                            </div>
	                        </div>

	                        

	                        <div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Slug')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" id="slug" name="slug" value="<?php echo e($template->slug); ?>" placeholder="<?php echo e(__('SLUG')); ?>" required>
									<span id="slug_error"></span>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Model')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" value="<?php echo e($template->model); ?>" name="model" placeholder="<?php echo e(__('Model')); ?>" required>
								</div>
							</div>


							  



	                        <div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Categories')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" id="category_id_name" name="parent_id_name" placeholder="Type to get suggestions" data-role="" value="">
									<div id="category_ids">

										<?php  
											$catIDS = [];
										?>

										<?php if( $template->categories ): ?> 
											<?php $__currentLoopData = $template->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php  
													$c = \App\TemplateCategories::where('ref', $cat)->first();

													


													 $categoryName = '';
						                            if($c->parent_id!="0" ){
						                                $firstLevel = \App\TemplateCategories::where('ref',$c->parent_id)->first();
						                                if ($firstLevel) {
						                                     $categoryName = $firstLevel->name;

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

						                                $categoryName .= ' > '.$c->name;
						                                $categoryName = ltrim($categoryName,"> ");

						                                $tmp = array(
														"id" =>  $c->ref,
													    "name" => $categoryName
													);
													array_push($catIDS,$tmp);
												?>
												<div >
													<button id="<?php echo e($cat); ?>" type="button" class="removeCatItem btn btn-purple btn-xs">X</button>
													<label><?php echo e($categoryName); ?></label>
													<input type="hidden" name="category_ids[]" value="<?php echo e($cat); ?>">
												</div>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

										<?php endif; ?>

									</div>
									 <input type="hidden" id="catIDS" name="catIDS" value='<?php echo json_encode($catIDS);  ?>'> 
								</div>
							</div>



							   <div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Template Products')); ?></label>
	                            <div class="col-lg-7">
	                                <select class="form-control template_products " name="products_add[]" multiple="multiple"  required>
	                                	<option value="">Select Products</option>
	                                	<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                	<option value="<?php echo e($prod->ref); ?>"  
		                                		<?php 
		                                		if($template->products){
		                                			foreach( $template->products as $p){
		                                				if($prod->ref == $p){
		                                					echo 'selected';
		                                				}
		                                			}
		                                		}
		                                		?>
		                                		><?php echo e($prod->name); ?></option>
	                                	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                </select>
	                            </div>
	                        </div>
	                      
	                    
	                        <div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Base Price')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" value="<?php echo e($template->base_price); ?>" name="base_price" placeholder="<?php echo e(__('Base Price')); ?>" required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Display Price')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" value="<?php echo e($template->display_price); ?>" name="display_price" placeholder="<?php echo e(__('Display Price')); ?>" required>
								</div>
							</div>

	                        <div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Tags')); ?></label>
	                            <div class="col-lg-7">
	                                <input type="text" class="form-control" name="tags[]" id="tags" value="<?php echo e($template->tags); ?>" placeholder="Type to add a tag" data-role="tagsinput">
	                            </div>
	                        </div>

	                        
				        </div>
				        <div id="demo-stk-lft-tab-2" class="tab-pane fade">
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Main Images')); ?></label>
								<div class="col-lg-7">
									<div id="photos">
										<?php if(is_array($template->photos)): ?>
											<?php $__currentLoopData = $template->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<div class="col-md-4 col-sm-4 col-xs-6">
													<div class="img-upload-preview">
														<img loading="lazy"  src="<?php echo e(asset( getImageURL($photo, 'thumbnail') )); ?>" alt="" class="img-responsive">
														<input type="hidden" name="previous_photos[]" value="<?php echo e($photo); ?>">
														<button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
													</div>
												</div>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</div>
								</div>
							</div>

							<div id="product_images">
								<?php if($template->products): ?>
									<?php $__currentLoopData = $template->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pids): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										<div class="form-group" id="id_div_<?php echo e($pids); ?>">
											<label class="col-lg-2 control-label"><?php echo e(\App\Product::where('ref',$pids)->first()->name); ?></label>
											<div class="col-lg-7" id="prod_id_<?php echo e($pids); ?>">
												<?php 
													$pid_name = $pids.'_images';
													
													$obj = json_decode (json_encode ($template->product_images), FALSE);
													
												?>
												<?php if(  !empty( $obj->$pid_name )  ): ?>
													<?php $__currentLoopData = $obj->$pid_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<div class="col-md-4 col-sm-4 col-xs-6">
															<div class="img-upload-preview">
																<img loading="lazy"  src="<?php echo e(asset( getImageURL($photo, 'thumbnail') )); ?>" alt="" class="img-responsive">
																<input type="hidden" name="previous_product_photos_<?php echo e($pids); ?>[]" value="<?php echo e($photo); ?>">
																<button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
															</div>
														</div>

													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												<?php endif; ?>
												

											</div>
											
										</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>


										
							</div>

							
							
							
				        </div>
				        
						<div id="demo-stk-lft-tab-4" class="tab-pane fade">
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Meta Title')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="meta_title" value="<?php echo e($template->meta_title); ?>" placeholder="<?php echo e(__('Meta Title')); ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Description')); ?></label>
								<div class="col-lg-7">
									<textarea name="meta_description" rows="8" class="form-control"><?php echo e($template->meta_description); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Meta Image')); ?></label>
								<div class="col-lg-7">
									<div id="meta_photo">
										<?php if($template->meta_img != null): ?>
											<div class="col-md-4 col-sm-4 col-xs-6">
												<div class="img-upload-preview">
													<img loading="lazy"  src="<?php echo e(asset($template->meta_img)); ?>" alt="" class="img-responsive">
													<input type="hidden" name="previous_meta_img" value="<?php echo e($template->meta_img); ?>">
													<button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
				        </div>
						
						
				        
				        <div id="demo-options" class="tab-pane fade">
				        	<div id="more_options"> 
				        	 <?php if(isset($template->additional_options)): ?>

				        		<?php $__currentLoopData = $template->additional_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				        		<input type="hidden" name="indexes[]" value="<?php echo e(explode('_', $a->name)[1]); ?>" class="indexes">
				        		<div class="form-group options_div_<?php echo e(explode('_', $a->name)[1]); ?>">
				        			<div class="col-lg-2">
				        				<input type="hidden" name="options_no[]" value="<?php echo e(explode('_', $a->name)[1]); ?>">
				        				<input type="text" class="form-control" name="option[]" value="<?php echo e($a->title); ?>" placeholder="Option Title">
				        			</div>
				        			<div class="col-lg-2">
				        				<select class="form-control" name="option_type_<?php echo e(explode('_', $a->name)[1]); ?>" id="option_type_<?php echo e(explode('_', $a->name)[1]); ?>" onchange="update_option_sku(<?php echo e(explode('_', $a->name)[1]); ?>)">
				        					<option value="">Select input type</option>
				        					<option value="radio" <?php echo e(($a->option_type=="radio") ? 'selected' : ''); ?> >Radio</option>
				        					<option value="checkbox" <?php echo e(($a->option_type=="checkbox") ? 'selected' : ''); ?> >Checkbox</option>
				        					<option value="text" <?php echo e(($a->option_type=="text") ? 'selected' : ''); ?> >Text</option>
				        					<option value="textarea" <?php echo e(($a->option_type=="textarea") ? 'selected' : ''); ?> >Text Area</option>
				        				</select>
				        			</div>
				        		<div class="col-lg-5" id="option_values_<?php echo e(explode('_', $a->name)[1]); ?>">
				        			
				        			<input type="text" class="form-control" name="option_values_<?php echo e(explode('_', $a->name)[1]); ?>[]" placeholder="Enter option values" data-role="tagsinput" onchange="update_option_sku(<?php echo e(explode('_', $a->name)[1]); ?>)" value="<?php echo e(implode(',', $a->options)); ?>">
				        		</div>
				        		<div class="col-lg-2">
				        			<button onclick="delete_row(this)" class="btn btn-danger btn-icon">
				        				<i class="demo-psi-recycling icon-lg"></i>
				        			</button>
				        		</div>
				        		<div id="option_def_<?php echo e(explode('_', $a->name)[1]); ?>"></div></div>
				        		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				        		<?php endif; ?>
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
	                                <textarea class="editor" name="small_description"><?php echo e($template->small_description); ?></textarea>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Description')); ?></label>
	                            <div class="col-lg-9">
	                                <textarea class="editor" name="description"><?php echo e($template->description); ?></textarea>
	                            </div>
	                        </div>
				        </div>
						
						
						
				        <div id="demo-stk-lft-tab-11" class="tab-pane fade">

				        	<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Upload Image')); ?></label>
								<div class="col-lg-2">
								
									<label class="switch" style="margin-top:5px;">
										<input value="1" type="checkbox" name="upload_active" <?php if($template->more_settings->upload_settings->is_upload =="1" ) echo "checked";?> >
										<span class="slider round"></span>
									</label>
								</div>
								
							</div>

							<div class="form-group upload_limit_div">
										<label class="col-lg-2 control-label"><?php echo e(__('Limit Number Of Images')); ?></label>
										<div class="col-lg-7">
											<input type="number" min="0" step="0.01" placeholder="<?php echo e(__('Upload Limit')); ?>" name="upload_limit" class="form-control" value="<?php echo e($template->more_settings->upload_settings->upload_limit); ?>" >
										</div>
							</div>

							





						

							
							
							
				        </div>
				    </div>
				</div>
			</div>
			<div class="panel-footer text-right">
				<button type="submit" name="button" class="btn btn-purple"><?php echo e(__('Save')); ?></button>
			</div>
		</div>
	</form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>



<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
	$('.template_products, .template_categories').select2();

	$('.template_products').on("select2:select", function(e) { 
	    //console.log(e);
	   // console.log(e.params.data.id);
	   // console.log(e.params.data.text);
	    var htmlContent = '<div class="form-group" id="id_div_'+e.params.data.id+'">';
	    htmlContent += '<label class="col-lg-2 control-label">'+e.params.data.text+' Images </label>';
	    htmlContent += '<div class="col-lg-7" id="prod_id_'+e.params.data.id+'">';
	    htmlContent += '</div>';
	    htmlContent += '</div>';



							


	    $("#product_images").append( htmlContent );

	    var idName = 'prod_id_'+e.params.data.id;
	    $("#"+idName).spartanMultiImagePicker({
			fieldName:        idName+'[]',
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


	});


	$('.template_products').on("select2:unselect", function(e) { 
		//console.log(e);
	    //console.log(e.params.data.id);
	    //console.log(e.params.data.text);

	    $('#id_div_'+e.params.data.id).remove();

	});


	$('document').ready(function(){


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









		//alert("hello");
		//this is for Advanced options initial load only
		var inputs = $(".indexes");
		if (inputs.length>0) {
			for(var i = 0; i < inputs.length; i++){
			    var index = $(inputs[i]).val();
			    var selectBoxName = '#option_type_'+index;
				var option_type = $(selectBoxName).val();
				
				if (option_type=="text" || option_type=="textarea") {
					update_option_sku(index);
				}
				

			}

		}
		

	});

	var i = $('input[name="choice_no[]"').last().val();
	var j = $('input[name="options_no[]"').last().val();
	if(isNaN(i)){
		i =0;

	}

	if(isNaN(j)){
		j =0;
		
	}

	function add_more_customer_choice_option(){
		i++;
		$('#customer_choice_options').append('<div class="form-group"><div class="col-lg-2"><input type="hidden" name="choice_no[]" value="'+i+'"><input type="text" class="form-control" name="choice[]" value="" placeholder="Choice Title"></div><div class="col-lg-7"><input type="text" class="form-control" name="choice_options_'+i+'[]" placeholder="Enter choice values" data-role="tagsinput" onchange="update_sku()"></div><div class="col-lg-2"><button onclick="delete_row(this)" class="btn btn-danger btn-icon"><i class="demo-psi-recycling icon-lg"></i></button></div></div>');
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


	let catIDSArray = JSON.parse( $('#catIDS').val() );
	//console.log("catIDSArray is:", catIDSArray);
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

	function formatString(value){
		return value.split(' ').join('_').toLowerCase();
	}
	
	

	function delete_row(em){
		$(em).closest('.form-group').remove();
		update_sku();
	}

	function update_sku(){
		/*$.ajax({
		   type:"POST",
		   url:'<?php echo e(route('templates.sku_combination_edit')); ?>',
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
	   });*/
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
		   url:'<?php echo e(route('templates.more_options_edit')); ?>',
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

	

	$(document).ready(function(){
		$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
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

		update_sku();

		$('.remove-files').on('click', function(){
            $(this).parents(".col-md-4").remove();
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



	$('#slug').on('keyup', function(){
		

		$.post('<?php echo e(route('templates.slug_check')); ?>',{_token:'<?php echo e(csrf_token()); ?>', slug_check:'edit', slug_value: this.value}, function(data){

			//console.log(data);
			$('#slug_error').text( data );
		});//end of post
	});


	<?php $__currentLoopData = $template->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pids): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
	var namee = 'prod_id_'+'<?php echo e($pids); ?>';
	//alert( namee );
	$("#"+namee).spartanMultiImagePicker({
			fieldName:        namee+'[]',
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



	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/templates/edit.blade.php ENDPATH**/ ?>