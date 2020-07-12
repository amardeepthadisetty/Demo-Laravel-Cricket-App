@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('players.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Player')}}</a>
        </div>
    </div><br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Players Information')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Player Name')}}</th>
                        <th>{{__('Jersey Number')}}</th>
                        <th>{{__('Country')}}</th>
                        <th>{{__('Image')}}</th>
                        <th width="10%">{{__('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($players as $key => $player)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$player->first_name.' '. $player->last_name}}</td>
                            <td>{{$player->jersey_number}}</td>
                            <td>{{$player->country}}</td>
                            <td><img width="100px" height="100px" src="{{asset($player->image_uri)}}"></td>
                            
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{route('players.edit', encrypt($player->id))}}">{{__('Edit')}}</a></li>
                                        <li><a onclick="confirm_modal('{{route('players.destroy', $player->id)}}');">{{__('Delete')}}</a></li>
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
