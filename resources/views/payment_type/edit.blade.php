@extends('layouts.app')

@section('content')

     <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Payment type info')}}</h3>
            </div>

            <form class="form-horizontal" action="{{ route('payment_type.update', $paymentType->id) }}" method="POST" enctype="multipart/form-data">
                 <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Type')}}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="type" value="{{ $paymentType->type }}">
                           
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Code')}}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="code" value="{{ $paymentType->code }}">
                           
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Description')}}</label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="description">{{ $paymentType->description }}</textarea>
                           
                        </div>
                    </div>


                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Status')}}</label>
                        <div class="col-lg-9">
                            <select class="form-control" name="status">
                                    <option value="">Select Status</option>
                                    <option value="1" @php if($paymentType->status=="1"){ echo 'selected'; } @endphp >Active</option>
                                    <option value="0" @php if($paymentType->status=="0"){ echo 'selected'; } @endphp >In Active</option>
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
