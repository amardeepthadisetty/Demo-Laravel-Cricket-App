@extends('layouts.app')

@section('content')


<div class="row">
	<form class="form form-horizontal mar-top" action="{{route('shippingmethod.update', $sm->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
		@csrf
		<input type="hidden" name="added_by" value="admin">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">{{__('Shipping Methods')}}</h3>
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
								<label class="col-lg-2 control-label">{{__('Shipping Name')}}</label>
								<div class="col-lg-7">
									<input type="text" class="form-control" name="shipping_name" placeholder="{{__('Shipping Name')}}" value="{{ $sm->name }}"  required>
								</div>
							</div>

							<div class="form-group">
								<label class="col-lg-2 control-label">{{__('Status')}}</label>
								<div class="col-lg-7">
									<select class="form-control" name="status" >
										<option value="1" @php echo ($sm->status=="1") ? 'selected' :'';  @endphp >Active</option>
										<option value="0" @php echo ($sm->status=="0") ? 'selected' :'';  @endphp >In Active</option>
									</select>
									
								</div>
							</div>


							
							

							
							

							
				        </div>
				        
				 
						

					

				      

						

						{{-- <div id="demo-stk-lft-tab-8" class="tab-pane fade">

				        </div> --}}

				         
				    </div>
				</div>
			</div>
			<div class="panel-footer text-right">
				<button type="submit" name="button" class="btn btn-info">{{ __('Update') }}</button>
			</div>
		</div>
	</form>
</div>


@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


@endsection
