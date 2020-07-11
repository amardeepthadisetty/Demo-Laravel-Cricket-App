@extends('layouts.app')

@section('content')


<div class="row">
	<form class="form form-horizontal mar-top" action="{{route('filtergroups.update', $fg->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
		@csrf
		<input type="hidden" name="added_by" value="admin">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">{{__('Filter Groups')}}</h3>
			</div>
			<div class="panel-body">
				<div class="tab-base tab-stacked-left">
				    <!--Nav tabs-->
				    <ul class="nav nav-tabs">
				        <li class="active">
				            <a data-toggle="tab" href="#demo-stk-lft-tab-1" aria-expanded="true">{{__('General')}}</a>
				        </li>
				      

				    </ul>

				    <!--Tabs Content-->
				    <div class="tab-content">
				        <div id="demo-stk-lft-tab-1" class="tab-pane fade active in">
							<div class="form-group">
								<label class="col-lg-2 control-label">{{__('Filter Group Name')}}</label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="filter_group_name" placeholder="{{__('Filter Group Name')}}" value="{{ $fg->name }}"  required>
								</div>
							</div>


							
							<div class="form-group">
								<label class="col-lg-2 control-label">{{__('Sort Order')}}</label>
								<div class="col-lg-7">
									<input type="text" value="{{ $fg->sort_order }}" class="form-control" name="sort_order" placeholder="sort order" >
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label">{{__('Slug')}}</label>
								<div class="col-lg-7">
									<input type="text" value="{{ $fg->slug }}" class="form-control" name="slug" placeholder="slug" >
								</div>
							</div>

							<h3>Filter Name</h3>

							<table class="table-bordered">
								<thead>
									<tr>
										<td>Filter Name</td>
										<td>Sort Order</td>
										<td></td>
									</tr>
								</thead>
								<tbody class="filter_name_div">


									@if( $fg->filters )
									@foreach( $fg->filters as $ids ) 

									@php  
										$filterNameClass = \App\FilterName::where('ref', $ids)->first();
										
									@endphp

										<tr>
											<td>
												<input type="text" required name="filter_name[]" placeholder="Filter Name"
												value="{{ $filterNameClass->name }}" 
												>
											</td>
											<td>
												<input type="text" required name="filter_sort[]" placeholder="Sort order" value="{{ $filterNameClass->sort }}" >
											</td>
											<td>
												<button class=" btn-sm btn btn-danger remove_node">Remove</button>
											</td>
										</tr>

									@endforeach

									@endif
									
								</tbody>
							</table>
							<button class=" btn-sm btn btn-info add_filter_name_row">+</button>
							

							
				        </div>
				        
				 
						

					

				      

						

						{{-- <div id="demo-stk-lft-tab-8" class="tab-pane fade">

				        </div> --}}

				         
				    </div>
				</div>
			</div>
			<div class="panel-footer text-right">
				<button type="submit" name="button" class="btn btn-info">{{ __('Save') }}</button>
			</div>
		</div>
	</form>
</div>


@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
	var i = 0;
	var j = 0;
	$('.template_products').select2();

	$('document').ready(function(){

		$( "#parent_id_name" ).autocomplete({
      source: function(d,e){
      	

        $.ajax({
               type:"POST",
               url: '{{ route('ajax.templatecategories') }}',
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


	});


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
		   url:'{{ route('templates.more_options') }}',
		   data:{
		   //	'data':$('#choice_form .options_div_'+ref_row).serialize(),
		   	'data':$('#choice_form').serialize(),
		   	'_token': '{{ csrf_token() }}',
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
		   url:'{{ route('products.sku_combination') }}',
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
		$.post('{{ route('subcategories.get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
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
		$.post('{{ route('subsubcategories.get_subsubcategories_by_subcategory') }}',{_token:'{{ csrf_token() }}', subcategory_id:subcategory_id}, function(data){
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
		$.post('{{ route('subsubcategories.get_brands_by_subsubcategory') }}',{_token:'{{ csrf_token() }}', subsubcategory_id:subsubcategory_id}, function(data){
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


</script>
<script>
	$('.add_filter_name_row').on('click', function(){
		//alert("hello");
		var filter_name_html = '';


		

		filter_name_html += '<tr>';
		

		filter_name_html += '<td>';
		filter_name_html += '<input value="" type="text" required name="filter_name[]" placeholder="Filter Name" >';
		filter_name_html += '</td>'; 

		filter_name_html += '<td>';
		filter_name_html += '<input value="" type="text" required name="filter_sort[]" placeholder="Sort order" >';
		filter_name_html += '</td>';

		filter_name_html += '<td>';
		filter_name_html += '<button class=" btn-sm btn btn-danger remove_node">Remove</button>';
		filter_name_html += '</td>';
		


		filter_name_html += '</tr>';

		$('.filter_name_div').append( filter_name_html );
	});


	$('body').on('click','.remove_node', function(){
			//alert("click");
			$(this).parent().parent().remove();
	});	
</script>

@endsection
