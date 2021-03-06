@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('teams.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Team')}}</a>
        </div>
    </div><br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Teams Information')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Team Name')}}</th>
                        <th>{{__('Image')}}</th>
                        <th>{{__('Status')}}</th>
                        <th width="10%">{{__('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $key => $team)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$team->name}}</td>
                            <td><img width="100px" height="100px" src="{{asset($team->logo_uri)}}"></td>
                            <td>
                                
                                @if($team->club_state=="1")
                                    Active
                                @elseif($team->club_state=="0")
                                    In active
                                @endif

                            </td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{route('teams.edit', encrypt($team->id))}}">{{__('Edit')}}</a></li>

                                        <li>

                                            <form action="{{ route('teams.destroy',$team->id) }}" method="POST">
                   
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </li>
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
