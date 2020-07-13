@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            
        </div>
    </div><br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Points')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('Teams')}}</th>
                        <th>{{__('Matches')}}</th>
                        <th>{{__('Won')}}</th>
                        <th>{{__('Lost')}}</th>
                        <th>{{__('Tie')}}</th>
                        <!-- <th width="10%">{{__('Options')}}</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($teams as $key => $team)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>
                                <a href="{{ route('teams.team_info.teamid', $team->id) }}">
                                    {{$team->name}}
                                </a>
                                
                            </td>
                            <td>
                               @php  
                               $orThose = ['team_a' => $team->id , 'team_b' => $team->id ];
                                   $matches =  \App\Fixtures::orWhere($orThose)->count();
                                   echo $matches;
                               @endphp
                            </td>
                            <td>
                            @php  
                               $whereCond = ['status' => 3 , 'winner' => $team->id ];
                                   $won_matches =  \App\Fixtures::where($whereCond)->count();
                                   echo $won_matches;
                            @endphp
                            </td>
                            <td> 
                            @php  
                             $orThose = ['team_a' => $team->id , 'team_b' => $team->id ];

                                   $lost_matches =  \App\Fixtures::orWhere($orThose)->where('winner','!=', $team->id )->count();
                                   echo $lost_matches;
                            @endphp
                            </td>
                            <td> 
                            @php  
                              $orThose = ['team_a' => $team->id , 'team_b' => $team->id ];

                                   $draw_matches =  \App\Fixtures::orWhere($orThose)->where('status','=', 2 )->count();
                                   echo $draw_matches;
                            @endphp

                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection
