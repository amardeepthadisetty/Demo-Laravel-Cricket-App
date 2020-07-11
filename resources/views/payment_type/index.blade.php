@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('payment_type.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Payment type')}}</a>
        </div>
    </div><br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Payment type Information')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Payment type')}}</th>
                        <th>{{__('Code')}}</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('Status')}}</th>
                        <th width="10%">{{__('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment_types as $key => $p_types)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$p_types->type}}</td>
                            <td>{{$p_types->code}}</td>
                            <td>{{$p_types->description}}</td>
                            <td>
                                
                                @if($p_types->status=="1")
                                    Active
                                @elseif($p_types->status=="0")
                                    In active
                                @endif

                            </td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{route('payment_type.edit', encrypt($p_types->id))}}">{{__('Edit')}}</a></li>
                                        <li><a onclick="confirm_modal('{{route('payment_type.destroy', $p_types->id)}}');">{{__('Delete')}}</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection
