@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('local_pickup.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Location Address')}}</a>
        </div>
    </div><br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Location Information')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Location Name')}}</th>
                        <th>{{__('Status')}}</th>
                        <th width="10%">{{__('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($locations as $key => $local_pickup)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$local_pickup->location}}</td>
                            <td>
                                
                                @if($local_pickup->status=="1")
                                    Active
                                @elseif($local_pickup->status=="0")
                                    In active
                                @endif

                            </td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{route('local_pickup.edit', encrypt($local_pickup->id))}}">{{__('Edit')}}</a></li>
                                        <li><a onclick="confirm_modal('{{route('local_pickup.destroy', $local_pickup->id)}}');">{{__('Delete')}}</a></li>
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
