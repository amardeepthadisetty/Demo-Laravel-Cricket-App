@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('fixtures.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Fixture')}}</a>
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
                        <th>{{__('Date')}}</th>
                        <th>{{__('Fixture')}}</th>
                        <th>{{__('Venue')}}</th>
                        <th width="10%">{{__('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fixtures as $key => $fixture)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$fixture->match_date}}</td>
                            <td>
                                {{
                                    \App\Teams::where('id', $fixture->team_a)->first()->name.' Vs '.\App\Teams::where('id', $fixture->team_b)->first()->name }}
                            </td>
                            <td>
                                
                                {{ $fixture->venue }}
                            </td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{route('fixtures.edit', encrypt($fixture->id))}}">{{__('Edit')}}</a></li>
                                        <li><a onclick="confirm_modal('{{route('fixtures.destroy', $fixture->id)}}');">{{__('Delete')}}</a></li>
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
