<?php $__env->startSection('content'); ?>


<div class="row">
	<form class="form form-horizontal mar-top" action="<?php echo e(route('templatecategories.update', $template->id)); ?>" method="POST" enctype="multipart/form-data" id="choice_form">
		<input name="_method" type="hidden" value="POST">
		<input type="hidden" name="id" value="<?php echo e($template->id); ?>">
		<?php echo csrf_field(); ?>
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo e(__('Template Category Information')); ?></h3>
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
						
				    </ul>

				    <!--Tabs Content-->
				    <div class="tab-content">
				        <div id="demo-stk-lft-tab-1" class="tab-pane fade active in">
							<div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Category Name')); ?></label>
	                            <div class="col-lg-7">
	                                <input type="text" class="form-control" name="name" placeholder="<?php echo e(__('Template Name')); ?>" value="<?php echo e($template->name); ?>"   required>
	                                <input type="hidden" name="category_id" value="<?php echo e($template->id); ?>">
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
	                            <label class="col-lg-2 control-label"><?php echo e(__('Tags')); ?></label>
	                            <div class="col-lg-7">
	                                <input type="text" class="form-control" name="tags[]" id="tags" value="<?php echo e($template->tags); ?>" placeholder="Type to add a tag" data-role="tagsinput">
	                            </div>
	                        </div>

	                        <?php  
	                        use \App\TemplateCategories as TC;
	                         $categoryName = '';

	                         $name = '';
				            $data = array();
				            $firstName = '';
				            $secondName = '';
				            $thirdName = '';
                                  $data['name'] = '';
					              if ($template->parent_id=="0") {
					                //this if is to stop searching for parents , if parent id is 0.
					                  $data['id'] = '';
					                  $data['name'] = '';
					                  //array_push($result, $data);
					              }else{

					                  $secondLevel = TC::where('ref',$template->parent_id)->where('active','1')->first();
					                  if ($secondLevel) {
					                     $secondName = $secondLevel->name;

					                      $thirdLevel = TC::where('ref',$secondLevel->parent_id)->where('active','1')->first();
					                      if ($thirdLevel) {
					                        $thirdName = $thirdLevel->name;
					                      }
					                  }//end of secondLevel if
					                  $data['id'] = $template->ref;
					                  //if ($secondLevel->parent_id!=0) {
					                  	$firstName = $template->name;
					                  //}
					                  


					                  if ($thirdName!='') {
					                     $data['name'] = $thirdName;
					                  }


					                  if ($secondName!='') {
					                     $data['name'] .= ' > '.$secondName;
					                  }

					                  if ($firstName!='') {
					                     $data['name'] .= ' > '.$firstName;
					                  }

					                  $data['name'] = ltrim($data['name'],' > ');
					                  //array_push($result, $data);

					                  //this line not to show the present name in hierarchy
					                  $data['name'] = str_replace(" > ".$template->name , "", $data['name']);

					              }
                           // }

	                        ?>

	                        	<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Parent')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" id="parent_id_name" name="parent_id_name" placeholder="Type to get suggestions" data-role="" value="<?php echo e($data['name']); ?>">
									<input type="hidden" id="parent_id" name="parent_id" value="<?php echo e($template->parent_id); ?>">
								</div>
							</div>


							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Filters')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" id="filter_name" name="filter_name" placeholder="Type to get suggestions" data-role="" value="">
									<div id="filters">
										<?php  
											$fNameIDS = [];
										?>

										<?php if( $template->filters ): ?> 
											<?php $__currentLoopData = $template->filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fIDS): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php  
													$c = \App\FilterName::where('ref', $fIDS)->first();

													
													$filterGroup = \App\FilterGroup::where('filters',$c->ref)->first();

													if ($filterGroup) {
										               $completeName = $filterGroup->name.' >  '.$c->name;
										                 $tmp = array(
															"id" =>  $c->ref,
														    "name" => $completeName
														);
														array_push($fNameIDS,$tmp);
										            }
						                               

						                              
												?>
												<div >
													<button id="<?php echo e($fIDS); ?>" type="button" class="removeCatItem btn btn-purple btn-xs">X</button>
													<label><?php echo e($completeName); ?></label>
													<input type="hidden" name="filter_ids[]" value="<?php echo e($fIDS); ?>">
												</div>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

										<?php endif; ?>
										
											
									</div>
									 <input type="hidden" id="filtrIDS" name="filtrIDS" value='<?php echo json_encode($fNameIDS);  ?>'> 
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Is Template')); ?></label>
								<div class="col-lg-7">
								
									<label class="switch" style="margin-top:5px;">
										<input value="<?php echo e($template->is_template); ?>" type="checkbox" name="is_template" <?php if($template->is_template =="1" ){ echo "checked"; } ?> >
										<span class="slider round"></span>
									</label>
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

	$('.template_products').select2();
	$('document').ready(function(){

		$( "#filter_name" ).autocomplete({
		      source: function(d,e){
		      	

		        $.ajax({
		               type:"POST",
		               url: '<?php echo e(route('ajax.filtergroups')); ?>',
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
		        $('#filter_name').val(b.item.label);
		        //$('#parent_id').val(b.item.value);

		        pushFilterGroupName_n_Labels( b.item.value , b.item.label);
		        //console.log(a);
		        //console.log(b);
		        $('#filter_name').val('');
		      },
			    focus: function(a, b) {
			        a.preventDefault();
			        $('#filter_name').val(b.item.label);
			        //$('#parent_id').val(b.item.value);
			    }
	  	}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $( "<li></li>" )
                    .data( "ui-autocomplete-item", item )
                    .append( "<a>"+ item.label + "</a>" ) 
                       // Here I want to append a.id as class of this
                       // but the only values are value and label.
                    .appendTo( ul );
            };

		
    $( "#parent_id_name" ).autocomplete({
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
        $('#parent_id_name').val(b.item.label);
        $('#parent_id').val(b.item.value);
      },
	    focus: function(a, b) {
	        a.preventDefault();
	        $('#parent_id_name').val(b.item.label);
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


	let filtrIDSArray = JSON.parse( $('#filtrIDS').val() );
	//console.log("filtrIDSArray is:", filtrIDSArray);
	function pushFilterGroupName_n_Labels(filter_ref, filter_group_filter_name){


		const index = filtrIDSArray.findIndex((e) => e.id === filter_ref);

	    if (index === -1) {
	        filtrIDSArray.push({ 
			'id' : filter_ref,
			'name': filter_group_filter_name

			});
	    } 

		console.log("filtrIDSArray is:", filtrIDSArray);

		showfiltrIDSArray();

	}


	function showfiltrIDSArray( ){

		let divHTML = '';

		for (var i = filtrIDSArray.length - 1; i >= 0; i--) {
			//filtrIDSArray[i].id;
			//filtrIDSArray[i].name;

			divHTML += '<div>';
			divHTML += '<button  id="'+filtrIDSArray[i].id+'" type="button" class="removeCatItem btn btn-purple btn-xs">X</button>';
			divHTML += '<label>'+  filtrIDSArray[i].name  +'</label>';
			divHTML += '<input type="hidden" name="filter_ids[]" value="'+filtrIDSArray[i].id+'"  >';
			divHTML += '</div>';
		}

		$('#filters').html( divHTML );

	}

	$('body').on('click','.removeCatItem', function(){
		var idToRemove = this.id;

		//alert(this.id);
		for (var i = filtrIDSArray.length - 1; i >= 0; i--) {
			
			if( filtrIDSArray[i].id === this.id){
				filtrIDSArray.splice(i,1);
			}
		}

		showfiltrIDSArray( );

	});

	


	$('#parent_id_name').change( function(){
		var autocomplete_text = this.value;

		if (autocomplete_text=="") {
			$('#parent_id').val(0);
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
		

		$.post('<?php echo e(route('template_categories.slug_check')); ?>',{_token:'<?php echo e(csrf_token()); ?>', slug_check:'edit', slug_value: this.value}, function(data){

			//console.log(data);
			$('#slug_error').text( data );
		});//end of post
	});	


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/templatecategories/edit.blade.php ENDPATH**/ ?>