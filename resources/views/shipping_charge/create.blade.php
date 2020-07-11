@extends('layouts.app')

@section('content')

    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Add Shipping Charge')}}</h3>
            </div>

            <form class="form-horizontal" action="{{ route('shipping_charge.store') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Shipping Station')}}</label>
                        <div class="col-lg-9">
                            <select name="shipping_station_id" id="shipping_station_id" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                                @foreach($states as $st)
                                    <option value="{{ $st->id }}">{{  $st->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('States')}}</label>
                        <div class="col-lg-9">
                            <select name="state_id" id="state_id" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                                @foreach($states as $st)
                                    <option value="{{ $st->id }}">{{  $st->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Min in Kgs ')}}</label>
                        <div class="col-lg-9">
                            <input type="text" name="min" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Max in Kgs ') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="max" class="form-control" value="">
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Shipping Methods')}}</label>
                        <div class="col-lg-9">
                            <select name="shipping_method_id" id="shipping_method_id" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                                @foreach($sMethods as $sm)
                                    <option value="{{ $sm->id }}">{{  $sm->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Price') }}</label>
                        <div class="col-lg-9">
                            <input type="text" name="price" class="form-control" value="">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Status')}}</label>
                        <div class="col-lg-9">
                            <select name="status" id="status" class="form-control demo-select2"  required>
                                <option value="">Select One</option>
                               
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                
                            </select>
                        </div>
                    </div>


                    

                <div class="panel-footer text-right">
                    <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                </div>
            </form>

        </div>
    </div>

@endsection
@section('script')



@endsection
