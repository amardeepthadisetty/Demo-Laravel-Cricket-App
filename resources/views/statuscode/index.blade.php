@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('status_code.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Status Code')}}</a>
        </div>
    </div><br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Status code Information')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Status code')}}</th>
                        <th>{{__('Display Name')}}</th>
                        <th>{{__('Description')}}</th>
                        <th>{{__('Status')}}</th>
                        <th width="10%">{{__('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($status_codes as $key => $status_code)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$status_code->status_code}}</td>
                            <td>{{$status_code->display_name}}</td>
                            <td>{{$status_code->description}}</td>
                            <td>
                                
                                @if($status_code->status=="1")
                                    Active
                                @elseif($status_code->status=="0")
                                    In active
                                @endif

                            </td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{route('status_code.edit', encrypt($status_code->id))}}">{{__('Edit')}}</a></li>
                                        <li><a onclick="confirm_modal('{{route('status_code.destroy', $status_code->id)}}');">{{__('Delete')}}</a></li>
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
