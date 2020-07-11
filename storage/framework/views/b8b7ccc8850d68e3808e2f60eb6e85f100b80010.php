<?php $__env->startSection('content'); ?>


<style type="text/css">
	.ui-menu {
		position: relative;
		z-index: 9999;
	}
</style>

<div class="row">
	<form class="form form-horizontal mar-top" action="<?php echo e(route('products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data" id="choice_form">
		<input name="_method" type="hidden" value="POST">
		<input type="hidden" name="id" value="<?php echo e($product->id); ?>">
		<?php echo csrf_field(); ?>
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
	                                <input type="hidden" name="product_ref" value="<?php echo e($product->ref); ?>"   >
	                                <input type="text" class="form-control" name="name" placeholder="<?php echo e(__('Product Name')); ?>" value="<?php echo e($product->name); ?>"   required>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Product Type')); ?></label>
	                            <div class="col-lg-7">
	                                <input type="text" class="form-control" name="product_type" placeholder="<?php echo e(__('Product Type')); ?>" value="<?php echo e($product->product_type); ?>"   required>
	                            </div>
	                        </div>

	                        <div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Slug')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" id="slug" name="slug" value="<?php echo e($product->slug); ?>" placeholder="<?php echo e(__('SLUG')); ?>" required>
									<span id="slug_error"></span>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Model')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" value="<?php echo e($product->model); ?>" name="model" placeholder="<?php echo e(__('Model')); ?>" required>
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

										<?php if( $product->categories ): ?> 
											<?php $__currentLoopData = $product->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
	                            <label class="col-lg-2 control-label"><?php echo e(__('Unit')); ?></label>
	                            <div class="col-lg-7">
	                            	<select name="unit" class="form-control" required>
	                            		<option value="">Select Unit</option>
	                            		<option value="kg" <?php echo ($product->unit==="kg") ? 'selected' : '';  ?> >Kgs</option>
	                            		<option value="gram" <?php echo ($product->unit==="gram") ? 'selected' : '';  ?> >Grams</option>
	                            	</select>
	                                
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Tags')); ?></label>
	                            <div class="col-lg-7">
	                                <input type="text" class="form-control" name="tags[]" id="tags" value="<?php echo e($product->tags); ?>" placeholder="Type to add a tag" data-role="tagsinput">
	                            </div>
	                        </div>


	                        <div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Filters')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" id="filter_name" name="filter_name" placeholder="Type to get suggestions" data-role="" value="">
									<div id="filters">
										<?php  
											$fNameIDS = [];
											$completeName = '';
										?>

										<?php if( !empty( $product->filters ) ): ?> 
											<?php $__currentLoopData = $product->filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fIDS): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php  
													$c = \App\FilterName::where('ref', $fIDS)->first();

													if( $c ){

														$filterGroup = \App\FilterGroup::where('filters',$c->ref)->first();

														if ($filterGroup) {
											               $completeName = $filterGroup->name.' >  '.$c->name;
											                 $tmp = array(
																"id" =>  $c->ref,
															    "name" => $completeName
															);
															array_push($fNameIDS,$tmp);
											            }

													}

													
						                               

						                              
												?>
												<div >
													<button id="<?php echo e($fIDS); ?>" type="button" class="removeFilterItem btn btn-purple btn-xs">X</button>
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
								<label class="col-lg-2 control-label"><?php echo e(__('Related Products')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" id="related_product_name" name="related_product_name" placeholder="Type to get suggestions" data-role="" value="">
									<div id="related_products">
										<?php  
											$rProdNIDS = [];
											$productNames = '';
										?>

										<?php if( $product->related_products ): ?> 
											<?php $__currentLoopData = $product->related_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rprodIDS): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<?php  
													$c = \App\Product::where('ref', $rprodIDS)->first();

													

													if ($c) {
										               $productNames =$c->name;
										                 $tmp = array(
															"id" =>  $c->ref,
														    "name" => $productNames
														);
														array_push($rProdNIDS,$tmp);
										            }
						                               

						                              
												?>
												<div >
													<button id="<?php echo e($rprodIDS); ?>" type="button" class="removeRelatedProductItem btn btn-purple btn-xs">X</button>
													<label><?php echo e($productNames); ?></label>
													<input type="hidden" name="related_prod_ids[]" value="<?php echo e($rprodIDS); ?>">
												</div>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

										<?php endif; ?>
										
											
									</div>
									 <input type="hidden" id="r_product_ids" name="r_product_ids" value='<?php echo json_encode($rProdNIDS);  ?>'> 
								</div>
							</div>

	                        <div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Is Template')); ?></label>
								<div class="col-lg-7">
								
									<label class="switch" style="margin-top:5px;">
										<input value="<?php echo e($product->is_template); ?>" type="checkbox" name="is_template" <?php if($product->is_template =="1" ){ echo "checked"; } ?> >
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
										<?php if(is_array($product->photos)): ?>
											<?php $__currentLoopData = $product->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
				        <div id="demo-stk-lft-tab-3" class="tab-pane fade">
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Video Provider')); ?></label>
								<div class="col-lg-7">
									<select class="form-control demo-select2-placeholder" name="video_provider" id="video_provider">
										<option value="youtube" <?php if($product->video_provider == 'youtube') echo "selected";?> ><?php echo e(__('Youtube')); ?></option>
										<option value="dailymotion" <?php if($product->video_provider == 'dailymotion') echo "selected";?> ><?php echo e(__('Dailymotion')); ?></option>
										<option value="vimeo" <?php if($product->video_provider == 'vimeo') echo "selected";?> ><?php echo e(__('Vimeo')); ?></option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Video Link')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="video_link" value="<?php echo e($product->video_link); ?>" placeholder="Video Link">
								</div>
							</div>
				        </div>
						<div id="demo-stk-lft-tab-4" class="tab-pane fade">
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Meta Title')); ?></label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="meta_title" value="<?php echo e($product->meta_title); ?>" placeholder="<?php echo e(__('Meta Title')); ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Description')); ?></label>
								<div class="col-lg-7">
									<textarea name="meta_description" rows="8" class="form-control"><?php echo e($product->meta_description); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Meta Image')); ?></label>
								<div class="col-lg-7">
									<div id="meta_photo">
										<?php if($product->meta_img != null): ?>
											<div class="col-md-4 col-sm-4 col-xs-6">
												<div class="img-upload-preview">
													<img loading="lazy"  src="<?php echo e(asset($product->meta_img)); ?>" alt="" class="img-responsive">
													<input type="hidden" name="previous_meta_img" value="<?php echo e($product->meta_img); ?>">
													<button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
												</div>
											</div>
										<?php endif; ?>
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
									
								</div>
								<div class="col-lg-2">
									<label class="switch" style="margin-top:5px;">
										<input value="1" type="checkbox" name="colors_active" <?php if(count($product->colors) > 0) echo "checked";?> >
										<span class="slider round"></span>
									</label>
								</div>
							</div>

							<div class="customer_choice_options" id="customer_choice_options">
								<?php if( !empty($product->choice_options) ): ?>
								<?php if(count($product->choice_options)>0): ?>
								<?php $__currentLoopData = $product->choice_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $choice_option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<div class="form-group">
										<div class="col-lg-2">
											<input type="hidden" name="choice_no[]" value="<?php echo e(explode('_', $choice_option->name)[1]); ?>">
											<input type="text" class="form-control" name="choice[]" value="<?php echo e($choice_option->title); ?>" placeholder="Choice Title">
										</div>
										<div class="col-lg-7">
											<input type="text" class="form-control" name="choice_options_<?php echo e(explode('_', $choice_option->name)[1]); ?>[]" placeholder="Enter choice values" value="<?php echo e(implode(',', $choice_option->options)); ?>" data-role="tagsinput" onchange="update_sku()">
										</div>
										<div class="col-lg-2">
											<button onclick="delete_row(this)" class="btn btn-danger btn-icon"><i class="demo-psi-recycling icon-lg"></i></button>
										</div>
									</div>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
								<?php endif; ?>
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
	                                <input type="text" placeholder="<?php echo e(__('Unit price')); ?>" name="unit_price" class="form-control" value="<?php echo e($product->unit_price); ?>" required>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Purchase price')); ?></label>
	                            <div class="col-lg-7">
	                                <input type="number" min="0" step="0.01" placeholder="<?php echo e(__('Purchase price')); ?>" name="purchase_price" class="form-control" value="<?php echo e($product->purchase_price); ?>" required>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Tax')); ?></label>
	                            <div class="col-lg-7">
	                                <input type="number" min="0" step="0.01" placeholder="<?php echo e(__('tax')); ?>" name="tax" class="form-control" value="<?php echo e($product->tax); ?>" required>
	                            </div>
	                            <div class="col-lg-1">
	                                <select class="demo-select2" name="tax_type" required>
	                                	<option value="amount" <?php if($product->tax_type == 'amount') echo "selected";?> >$</option>
	                                	<option value="percent" <?php if($product->tax_type == 'percent') echo "selected";?> >%</option>
	                                </select>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Discount')); ?></label>
	                            <div class="col-lg-7">
	                                <input type="number" min="0" step="0.01" placeholder="<?php echo e(__('Discount')); ?>" name="discount" class="form-control" value="<?php echo e($product->discount); ?>" required>
	                            </div>
	                            <div class="col-lg-1">
	                                <select class="demo-select2" name="discount_type" required>
	                                	<option value="amount" <?php if($product->discount_type == 'amount') echo "selected";?> >$</option>
	                                	<option value="percent" <?php if($product->discount_type == 'percent') echo "selected";?> >%</option>
	                                </select>
	                            </div>
	                        </div>
							<div class="form-group" id="quantity">
								<label class="col-lg-2 control-label"><?php echo e(__('Quantity')); ?></label>
								<div class="col-lg-7">
									<input type="number" min="0" value="<?php echo e($product->current_stock); ?>" step="1" placeholder="<?php echo e(__('Quantity')); ?>" name="current_stock" class="form-control" required>
								</div>
							</div>
							<br>

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Is Variant')); ?></label>
								<div class="col-lg-7">
								
									<label class="switch" style="margin-top:5px;">
										<input value="1" type="checkbox" name="is_variant" <?php
										if($product->is_variant=="1"){
											echo "checked";
										}
										 ?> >
										
										<span class="slider round"></span>
									</label>
								</div>
								
							</div>


							<div class="sku_combination" id="sku_combination">

							</div>

							
				        </div>
				        
				        <div id="demo-options" class="tab-pane fade">
				        	<div id="more_options"> 
				        	 <?php if(isset($product->additional_options)): ?>

				        		<?php $__currentLoopData = $product->additional_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
	                                <textarea class="editor" name="small_description"><?php echo e($product->small_description); ?></textarea>
	                            </div>
	                        </div>

	                        <div class="form-group">
	                            <label class="col-lg-2 control-label"><?php echo e(__('Description')); ?></label>
	                            <div class="col-lg-9">
	                                <textarea class="editor" name="description"><?php echo e($product->description); ?></textarea>
	                            </div>
	                        </div>
				        </div>
						
						<div id="demo-stk-lft-tab-9" class="tab-pane fade">
							<!-- <div class="row bord-btm">
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
												<input type="radio" name="shipping_type" value="free" <?php if($product->shipping_type == 'free'): ?> checked <?php endif; ?>>
												<span class="slider round"></span>
											</label>
										</div>
									</div>
								</div>
							</div> -->

							<!-- <div class="row bord-btm">
								<div class="col-md-2">
									<div class="panel-heading">
										<h3 class="panel-title"><?php echo e(__('Local Pickup')); ?></h3>
									</div>
								</div>
								<div class="col-md-10">
									<div class="form-group">
										<label class="col-lg-2 control-label"><?php echo e(__('Status')); ?></label>
										<div class="col-lg-7">
											<label class="switch" style="margin-top:5px;">
												<input type="radio" name="shipping_type" value="local_pickup" <?php if($product->shipping_type == 'local_pickup'): ?> checked <?php endif; ?>>
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label"><?php echo e(__('Shipping cost')); ?></label>
										<div class="col-lg-7">
											<input type="number" min="0" step="0.01" placeholder="<?php echo e(__('Shipping cost')); ?>" name="local_pickup_shipping_cost" class="form-control" value="<?php echo e($product->shipping_cost); ?>" required>
										</div>
									</div>
								</div>
							</div> -->

							<div class="row bord-btm">
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
												<input type="checkbox" name="flat_rate"
												<?php

												if($product->flat_rate == '1'){
													echo 'checked';
													echo ' value="1" ';
												}

												?>  >
												<span class="slider round"></span>
											</label>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label"><?php echo e(__('Shipping cost')); ?></label>
										<div class="col-lg-7">
											<input type="number" min="0" step="0.01" placeholder="<?php echo e(__('Shipping cost')); ?>" name="flat_shipping_cost" class="form-control" value="<?php echo e($product->shipping_cost); ?>" required>
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
										<input value="1" type="checkbox" name="upload_active" <?php if($product->more_settings->upload_settings->is_upload =="1" ) echo "checked";?> >
										<span class="slider round"></span>
									</label>
								</div>
								
							</div>

							<div class="form-group upload_limit_div">
										<label class="col-lg-2 control-label"><?php echo e(__('Limit Number Of Images')); ?></label>
										<div class="col-lg-7">
											<input type="number" min="0" step="0.01" placeholder="<?php echo e(__('Upload Limit')); ?>" name="upload_limit" class="form-control" value="<?php echo e($product->more_settings->upload_settings->upload_limit); ?>" >
										</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Instructions')); ?></label>
								<div class="col-lg-2">
								
									<label class="switch" style="margin-top:5px;">
										<input value="1" type="checkbox" name="instructions_active" <?php if($product->more_settings->instructions =="1" ) echo "checked";?> >
										<span class="slider round"></span>
									</label>
								</div>
								
							</div>





							<div class="form-group">
								<label class="col-lg-2 control-label"><?php echo e(__('Promotion')); ?></label>
								<div class="col-lg-2">
								
									<label class="switch" style="margin-top:5px;">
										<input value="1" type="checkbox" name="promotion_active" <?php if($product->more_settings->promotion_settings->is_promotion =="1" ) echo "checked";?> >
										<span class="slider round"></span>
									</label>
								</div>
								
							</div>

							<div class="promotion_div">
								<div class="form-group ">
											<label class="col-lg-2 control-label"><?php echo e(__('Text to appear for promotion')); ?></label>
											<div class="col-lg-7">
												<input type="text" placeholder="<?php echo e(__('Text')); ?>" name="promotion_text" class="form-control" value="<?php echo e($product->more_settings->promotion_settings->promotion_text); ?>" >
											</div>
								</div>

								<div class="form-group upload_limit_div">
											<label class="col-lg-2 control-label"><?php echo e(__('Discount')); ?></label>
											<div class="col-lg-7">
												<input type="number" placeholder="<?php echo e(__('Text')); ?>" name="promotion_discount" class="form-control" value="<?php echo e($product->more_settings->promotion_settings->promotion_discount); ?>" >
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


	$('input[name="flat_rate"]').on('change', function() {
	    if($('input[name="flat_rate"]').is(':checked')){
			//$('.upload_limit_div').show();
			$('input[name="flat_rate"]').val(1);
		}
		else{
			//$('#colors').prop('disabled', false);
			//$('.upload_limit_div').hide();
			$('input[name="flat_rate"]').val(0);
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
		$.ajax({
		   type:"POST",
		   url:'<?php echo e(route('products.sku_combination_edit')); ?>',
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
		   url:'<?php echo e(route('products.more_options_edit')); ?>',
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

	function get_subcategories_by_category(){
		var category_id = $('#category_id').val();
		$.post('<?php echo e(route('subcategories.get_subcategories_by_category')); ?>',{_token:'<?php echo e(csrf_token()); ?>', category_id:category_id}, function(data){
		    $('#subcategory_id').html(null);
		    for (var i = 0; i < data.length; i++) {
		        $('#subcategory_id').append($('<option>', {
		            value: data[i].id,
		            text: data[i].name
		        }));
		    }
		    $("#subcategory_id > option").each(function() {
		        if(this.value == '<?php echo e($product->subcategory_id); ?>'){
		            $("#subcategory_id").val(this.value).change();
		        }
		    });

		    $('.demo-select2').select2();

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
		    }
		    $("#subsubcategory_id > option").each(function() {
		        if(this.value == '<?php echo e($product->subsubcategory_id); ?>'){
		            $("#subsubcategory_id").val(this.value).change();
		        }
		    });

		    $('.demo-select2').select2();

		    get_brands_by_subsubcategory();
		});
	}

	function get_brands_by_subsubcategory(){
		var subsubcategory_id = $('#subsubcategory_id').val();
		$.post('<?php echo e(route('subsubcategories.get_brands_by_subsubcategory')); ?>',{_token:'<?php echo e(csrf_token()); ?>', subsubcategory_id:subsubcategory_id}, function(data){
		    $('#brand_id').html(null);
		    for (var i = 0; i < data.length; i++) {
		        $('#brand_id').append($('<option>', {
		            value: data[i][0].id,
		            text: data[i][0].name
		        }));
		    }
		    $("#brand_id > option").each(function() {
		        if(this.value == '<?php echo e($product->brand_id); ?>'){
		            $("#brand_id").val(this.value).change();
		        }
		    });

		    $('.demo-select2').select2();

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



	$('#slug').on('keyup', function(){
		

		$.post('<?php echo e(route('products.slug_check')); ?>',{_token:'<?php echo e(csrf_token()); ?>', slug_check:'edit', slug_value: this.value}, function(data){

			//console.log(data);
			$('#slug_error').text( data );
		});//end of post
	});


</script>

<script>
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
			divHTML += '<button  id="'+filtrIDSArray[i].id+'" type="button" class="removeFilterItem btn btn-purple btn-xs">X</button>';
			divHTML += '<label>'+  filtrIDSArray[i].name  +'</label>';
			divHTML += '<input type="hidden" name="filter_ids[]" value="'+filtrIDSArray[i].id+'"  >';
			divHTML += '</div>';
		}

		$('#filters').html( divHTML );

	}

	$('body').on('click','.removeFilterItem', function(){
		var idToRemove = this.id;

		//alert(this.id);
		for (var i = filtrIDSArray.length - 1; i >= 0; i--) {
			
			if( filtrIDSArray[i].id === this.id){
				filtrIDSArray.splice(i,1);
			}
		}

		showfiltrIDSArray( );

	});
</script>

<script>
	$('document').ready(function(){
		$( "#related_product_name" ).autocomplete({
		      source: function(d,e){
		      	

		        $.ajax({
		               type:"POST",
		               url: '<?php echo e(route('ajax.relatedprodids')); ?>',
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
		        $('#related_product_name').val(b.item.label);
		        //$('#parent_id').val(b.item.value);

		        pushRelatedProductIDS_n_Labels( b.item.value , b.item.label);
		        //console.log(a);
		        //console.log(b);
		        $('#related_product_name').val('');
		      },
			    focus: function(a, b) {
			        a.preventDefault();
			        $('#related_product_name').val(b.item.label);
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
	});




	let relatedproducts_IDSArray = JSON.parse( $('#r_product_ids').val() );
	//console.log("relatedproducts_IDSArray is:", relatedproducts_IDSArray);
	function pushRelatedProductIDS_n_Labels( product_ref, product_name){


		const index = relatedproducts_IDSArray.findIndex((e) => e.id ===  product_ref);

	    if (index === -1) {
	        relatedproducts_IDSArray.push({ 
			'id' :  product_ref,
			'name': product_name

			});
	    } 

		//console.log("relatedproducts_IDSArray is:", relatedproducts_IDSArray);

		showrelatedproducts_IDSArray();

	}


	function showrelatedproducts_IDSArray( ){

		let divHTML = '';

		for (var i = relatedproducts_IDSArray.length - 1; i >= 0; i--) {
			//relatedproducts_IDSArray[i].id;
			//relatedproducts_IDSArray[i].name;

			divHTML += '<div>';
			divHTML += '<button  id="'+relatedproducts_IDSArray[i].id+'" type="button" class="removeRelatedProductItem btn btn-purple btn-xs">X</button>';
			divHTML += '<label>'+  relatedproducts_IDSArray[i].name  +'</label>';
			divHTML += '<input type="hidden" name="related_prod_ids[]" value="'+relatedproducts_IDSArray[i].id+'"  >';
			divHTML += '</div>';
		}

		$('#related_products').html( divHTML );

	}

	$('body').on('click','.removeRelatedProductItem', function(){
		var idToRemove = this.id;

		//alert(this.id);
		for (var i = relatedproducts_IDSArray.length - 1; i >= 0; i--) {
			
			if( relatedproducts_IDSArray[i].id === this.id){
				relatedproducts_IDSArray.splice(i,1);
			}
		}

		showrelatedproducts_IDSArray( );

	});
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/products/edit.blade.php ENDPATH**/ ?>