@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Shipping Settings')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('shippingsetting.update', 1 ) }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <input type="hidden" name="_method" value="PATCH">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="tag">{{__('Free Shipping')}}</label>

                        @php 
                            $free_shipping = \App\ShippingSetting::where('s_key','free_shipping')->first()->s_value;
                        @endphp
                        <div class="col-sm-9">
                            <select class="form-control" name="free_shipping">
                                <option value="">Activate Free Shipping ?</option>
                                <option value="1" @php echo ($free_shipping=="1") ? 'selected' :''; @endphp >Yes</option>
                                <option value="0" @php echo ($free_shipping=="0") ? 'selected' :''; @endphp  >No</option>
                            </select>
                            
                        </div>
                    </div>
                    
                </div>

                 <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="tag">{{__('Local Pickup')}}</label>
                        <div class="col-sm-9">
                            @php 
                                $local_pickup = \App\ShippingSetting::where('s_key','local_pickup')->first()->s_value;
                            @endphp
                            <select class="form-control" name="local_pickup">
                                <option value="">Activate Local Pickup ?</option>
                                <option value="1" @php echo ($local_pickup=="1") ? 'selected' :''; @endphp >Yes</option>
                                <option value="0" @php echo ($local_pickup=="0") ? 'selected' :''; @endphp  >No</option>
                            </select>
                            
                        </div>
                    </div>
                    
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="tag">{{__('Local Pickup ship cost')}}</label>
                        <div class="col-sm-9">
                            @php 
                                $local_pickup_ship_cost = \App\ShippingSetting::where('s_key','local_pickup_ship_cost')->first()->s_value;
                            @endphp
                            <input type="text" class="form-control" name="local_pickup_ship_cost" value="{{ $local_pickup_ship_cost }}">
                            
                        </div>
                    </div>
                    
                </div>


                <div class="panel-footer text-right">
                    <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                </div>
            </form>
            <!--===================================================-->
            <!--End Horizontal Form-->

        </div>
    </div>

@endsection
