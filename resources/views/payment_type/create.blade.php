@extends('layouts.app')

@section('content')

    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Setting up payment types')}}</h3>
            </div>

            <form class="form-horizontal" action="{{ route('payment_type.store') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Type')}}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="type">
                           
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Code')}}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="code">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Description')}}</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="description"></textarea>
                           
                        </div>
                    </div>


                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Status')}}</label>
                        <div class="col-lg-9">
                            <select class="form-control" name="status">
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">In Active</option>
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

<script type="text/javascript">

   

</script>

@endsection
