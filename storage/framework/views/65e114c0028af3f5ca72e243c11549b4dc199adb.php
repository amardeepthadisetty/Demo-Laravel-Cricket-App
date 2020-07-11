<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Doozypics Admin Menu Builder</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
        <link rel="stylesheet" href="<?php echo e(asset('menu_includes/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')); ?>">

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        
        <div class="container">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header"><h5 class="float-left">Menu</h5>
                            <div class="float-right">
                                <button id="btnReload" type="button" class="btn btn-outline-secondary">
                                    <i class="fa fa-play"></i> Load Data</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul id="myEditor" class="sortableLists list-group">
                            </ul>
                        </div>
                    </div>
                    <p>Click the Output button to execute the function <code>getString();</code></p>
                    <div class="card">
	                    <div class="card-header">JSON Output
	                    <div class="float-right">
	                    <button id="btnOutput" type="button" class="btn btn-success"><i class="fas fa-check-square"></i> Output</button>
	                    </div>
	                    </div>
	                    <div class="card-body">
	                    <div class="form-group">
	                    	<form class="form form-horizontal mar-top" action="<?php echo e(route('menu.update', 2)); ?>" method="POST"  >
							<input name="_method" type="hidden" value="POST">
							<?php echo csrf_field(); ?>
		                    	<textarea id="out" name="JSON_output" class="form-control" cols="50" rows="10"></textarea>
		                    	<button id="Submit" type="submit" style="display: none;" class="btn btn-danger"> Save the JSON</button>
		                    	<input type="hidden" value="<?php echo e($menu->menu); ?>" name="json_data" id="json_data">
	                    	</form>
	                    </div>
	                    </div>
                    </div>


                </div>
                <div class="col-md-6">
                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary text-white">Edit item</div>
                        <div class="card-body">
                            <form id="frmEdit" class="form-horizontal">
                                <div class="form-group">
                                    <label for="text">Text</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control item-menu" name="text" id="text" placeholder="Text">
                                        <div class="input-group-append">
                                            <button type="button" id="myEditor_icon" class="btn btn-outline-secondary"></button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="icon" class="item-menu">
                                </div>
                                <div class="form-group">
                                    <label for="target">Type</label>
                                    <select name="type" id="type" class="form-control item-menu type_menu">
                                    	<option value="link">Link</option>
                                        <option value="category">Category</option>
                                        <option value="template">Template</option>
                                        
                                    </select>
                                </div>

                               


                                <div class="form-group">
                                    <label for="href">URL</label>
                                    <input type="text" class="form-control item-menu" id="href" name="href" placeholder="URL">
                                </div>
                                
                                <div class="form-group">
                                    <label for="image_url">Image URL</label>
                                    <input type="text" name="image_url" class="form-control item-menu" id="image_url" placeholder="Image URL">
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
                            <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
                        </div>
                    </div>

                    <div class="card">
	                    <div class="card-header">Auto Complete fields
	                    <div class="float-right">
	                    
	                    </div>
	                    </div>
	                    <div class="card-body">
		                    <div class="form-group">
		                    	 <form method="POST" enctype="multipart/form-data" id="choice_form">
						        	<input name="_method" type="hidden" value="POST">
						        	<?php echo csrf_field(); ?>
	                                <div class="form-group category_div" style="display:none;">
	                                    <label for="href">Categories</label>
	                                    <input type="text" class="form-control " id="category_id_name" name="parent_id_name" placeholder="Type to get suggestions">
	                                </div>

	                                <div class="form-group template_div" style="display:none;">
	                                    <label for="href">Templates</label>
	                                    <input type="text" class="form-control " id="template" name="template" placeholder="Type to get suggestions">
	                                    <input type="hidden" name="app_url" id="app_url" value="<?php echo e(env('APP_URL')); ?>">
	                                </div>
                            	</form>
		                    </div>
	                    </div>
                    </div>
                    <!-- <h2>More Projects</h2>
                    <ul>
                        <li><a href="https://github.com/davicotico/jQuery-Menu-From-JSON" target="_blank">jQuery Menu from JSON</a></li>
                        <li><a href="https://github.com/davicotico/PHP-Quick-Menu" target="_blank">PHP Quick Menu</a></li>
                        <li><a href="https://github.com/davicotico/Codeigniter-Form-Validation-Extension" target="_blank">Form Validator Extension for Codeigniter</a></li>
                        <li><a href="https://github.com/davicotico/Codeigniter-Imagify" target="_blank">Codeigniter Imagify (Image optimization)</a></li>
                        <li><a href="https://github.com/davicotico/jQuery-formHelper" target="_blank">jQuery formHelper</a></li>
                    </ul> -->
                </div>
            </div>
         
        </div>


        
    
        <script type="text/javascript" src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="<?php echo e(asset('menu_includes/jquery-menu-editor.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('menu_includes/bootstrap-iconpicker/js/iconset/fontawesome5-3-1.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('menu_includes/bootstrap-iconpicker/js/bootstrap-iconpicker.min.js')); ?>"></script>
        <script>
            jQuery(document).ready(function () {
                /* =============== DEMO =============== */
                // menu items
                var arrayjson =[{"text":"Christmas Gifts","icon":"","type":"template","href":"/Happy-Christmas","title":""}];
                // icon picker options
                var iconPickerOptions = {searchText: "Buscar...", labelHeader: "{0}/{1}"};
                // sortable list options
                var sortableListOptions = {
                    placeholderCss: {'background-color': "#cccccc"}
                };

                var editor = new MenuEditor('myEditor', {listOptions: sortableListOptions, iconPicker: iconPickerOptions});
                editor.setForm($('#frmEdit'));
                editor.setUpdateButton($('#btnUpdate'));

                arrayjson = $('#json_data').val();
                arrayjson = JSON.parse( arrayjson );
                editor.setData(arrayjson);


                $('#btnReload').on('click', function () {
                	arrayjson = $('#json_data').val();
                	arrayjson = JSON.parse( arrayjson );
                    editor.setData(arrayjson);
                });

                $('#btnOutput').on('click', function () {
                    var str = editor.getString();
                    $("#out").text(str);

                    //trigger click Save the JSON
                    $('#Submit').trigger('click');
                });

                $("#btnUpdate").click(function(){
                    editor.update();
                });

                $('#btnAdd').click(function(){
                    editor.add();
                });
                /* ====================================== */

                /** PAGE ELEMENTS **/
                $('[data-toggle="tooltip"]').tooltip();
                /*$.getJSON( "https://api.github.com/repos/davicotico/jQuery-Menu-Editor", function( data ) {
                    $('#btnStars').html(data.stargazers_count);
                    $('#btnForks').html(data.forks_count);
                });*/
            });

            $('.type_menu').on('change', function(){
            	//alert( this.value );
            	$('.category_div').hide();
            	$('.template_div').hide();
            	$('#href').val('');
            	if ( this.value=="category" ) {
            		$('.category_div').show();
            	}else if( this.value=="template" ){
            		$('.template_div').show();
            	}
            });






            $( "#category_id_name" ).autocomplete({
		      source: function(d,e){
		      	

		        $.ajax({
		               type:"POST",
		               url: '<?php echo e(route('ajax.categories.menu')); ?>',
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
		        //var url = $('#app_url').val();
		        url = 'category/'+b.item.value;
		        $('#category_id_name').val(b.item.label);
		        $('#href').val(url);

		        
		        //console.log(a);
		        //console.log(b);
		        $('#category_id_name').val('');
		      },
			    focus: function(a, b) {
			        a.preventDefault();
			        $('#category_id_name').val(b.item.label);
			        
		        	var url = 'category/'+b.item.value;
			        $('#href').val(url);
			    }
	  	}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $( "<li></li>" )
                    .data( "ui-autocomplete-item", item )
                    .append( "<a>"+ item.label + "</a>" ) 
                       // Here I want to append a.id as class of this
                       // but the only values are value and label.
                    .appendTo( ul );
            };


            
        </script>
        <script>
        	$( "#template" ).autocomplete({
		      source: function(d,e){
		      	

		        $.ajax({
		               type:"POST",
		               url: '<?php echo e(route('ajax.templates.menu')); ?>',
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
		        //var url = $('#app_url').val();
		        url = 'template/'+b.item.value;
		        $('#template').val(b.item.label);
		        $('#href').val(url);


		        $('#template').val('');
		      },
			    focus: function(a, b) {
			        a.preventDefault();
			        $('#template').val(b.item.label);
			        
		        	var url = 'template/'+b.item.value;
			        $('#href').val(url);
			    }
	  	}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                return $( "<li></li>" )
                    .data( "ui-autocomplete-item", item )
                    .append( "<a>"+ item.label + "</a>" ) 
                       // Here I want to append a.id as class of this
                       // but the only values are value and label.
                    .appendTo( ul );
            };


        </script>
    </body>
</html><?php /**PATH C:\xampp\htdocs\laramongo\resources\views/menu/edit.blade.php ENDPATH**/ ?>