@if($request->option_type !='')
	<table class="table table-bordered">
		<thead>
			<tr>
				<td class="text-center">
					<label for="" class="control-label">{{__('Option Name')}}</label>
				</td>
				<td class="text-center">
					<label for="" class="control-label">{{__('Default Value')}}</label>
				</td>
				<td class="text-center">
					<label for="" class="control-label">{{__('Price')}}</label>
				</td>
				<td class="text-center">
					<label for="" class="control-label">{{__('Sort Order')}}</label>
				</td>
			</tr>
		</thead>
		<tbody>
			<!-- This is for radio and checkbox -->
			@if($request->option_type=="radio" || $request->option_type=="checkbox")
			@foreach($option_values as $o)
		<tr>
			<td>
				<label for="" class="control-label">{{ concat_string($option,$o) }}</label>
			</td>
			<td>
					<input type="text" name="default_{{ concat_string($option,$o)  }}" value="@php 
				$str = concat_string($option,$o);
				//echo $str;
				//print_r($template->additional_options_variations);
				if(isset($template->additional_options_variations->$str->default)){
	                        echo $template->additional_options_variations->$str->default;
	                    }
	                    else{
	                        echo '0';
	                    }

				@endphp" class="form-control" >
				</td>
			<td>
				<input type="number" name="price_{{ concat_string($option,$o)  }}" value="@php 
				$str = concat_string($option,$o);
				//echo $str;
				//print_r($template->additional_options_variations);
				if(isset($template->additional_options_variations->$str->price)){
	                        echo $template->additional_options_variations->$str->price;
	                    }
	                    else{
	                        echo '0';
	                    }

				@endphp"  min="0" step="0.01" class="form-control" required="">
			</td>
			<td>
				<input type="number" name="sort_{{ concat_string($option,$o) }}" value="@php 
				$str = concat_string($option,$o);
				//echo $str;
				//print_r($template->additional_options_variations);
				if(isset($template->additional_options_variations->$str->sort)){
	                        echo $template->additional_options_variations->$str->sort;
	                    }
	                    else{
	                        echo '0';
	                    }

				@endphp" min="0" step="1" class="form-control" required="">
			</td>
		</tr>
		@endforeach
		@endif
		<!-- End of radio and checkbox -->

		<!-- This is for text and text area -->
		@if($request->option_type=="text" || $request->option_type=="textarea")
		 	<tr>
				<td>
					<label for="" class="control-label">{{ concat_string($option,$request->option_type) }}</label>
				</td>
				<td>
					<input type="text" name="default_{{ concat_string($option,$request->option_type)  }}" value="@php 
				$str = concat_string($option,$request->option_type);
				//echo $str;
				//print_r($template->additional_options_variations);
				if(isset($template->additional_options_variations->$str->default)){
	                        echo $template->additional_options_variations->$str->default;
	                    }
	                    else{
	                        echo '0';
	                    }

				@endphp" class="form-control" required="">
				</td>
				<td>
					<input type="number" name="price_{{ concat_string($option,$request->option_type)  }}" value="@php 
				$str = concat_string($option,$request->option_type);
				//echo $str;
				//print_r($template->additional_options_variations);
				if(isset($template->additional_options_variations->$str->price)){
	                        echo $template->additional_options_variations->$str->price;
	                    }
	                    else{
	                        echo '0';
	                    }

				@endphp" class="form-control" required="">
				</td>
				<td>
					<input type="number" name="sort_{{ concat_string($option,$request->option_type) }}" value="@php 
				$str = concat_string($option,$request->option_type);
				//echo $str;
				//print_r($template->additional_options_variations);
				if(isset($template->additional_options_variations->$str->sort)){
	                        echo $template->additional_options_variations->$str->sort;
	                    }
	                    else{
	                        echo '0';
	                    }

				@endphp" min="0" step="1" class="form-control" required="">
				</td>
			</tr>
		@endif
		<!-- End of text and text area -->

	</tbody>
</table>
@endif
