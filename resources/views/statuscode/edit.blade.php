@extends('layouts.app')

@section('content')

     <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Status code info')}}</h3>
            </div>

            <form class="form-horizontal" action="{{ route('status_code.update', $statusCode->id) }}" method="POST" enctype="multipart/form-data">
                 <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Status code')}}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="status_code" value="{{ $statusCode->status_code }}">
                           
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Display Name')}}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="display_name" value="{{ $statusCode->display_name }}">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Description')}}</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="description">{{ $statusCode->description }}</textarea>
                           
                        </div>
                    </div>


                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Status')}}</label>
                        <div class="col-lg-9">
                            <select class="form-control" name="status">
                                    <option value="">Select Status</option>
                                    <option value="1" @php if($statusCode->status=="1"){ echo 'selected'; } @endphp >Active</option>
                                    <option value="0" @php if($statusCode->status=="0"){ echo 'selected'; } @endphp >In Active</option>
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
