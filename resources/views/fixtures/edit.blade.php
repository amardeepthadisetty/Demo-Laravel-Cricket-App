@extends('layouts.app')

@section('content')

     <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Team edit')}}</h3>
            </div>

            <form class="form-horizontal" action="{{ route('fixtures.update', $fixtures_data->id) }}" method="POST" enctype="multipart/form-data">
                 <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="panel-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">{{__('Match Date')}}</label>
                            <div class="col-lg-5">
                                <input class="form-control" required type="date" value="{{ $fixtures_data->match_date }}" name="match_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">{{__('Team A')}}</label>
                            <div class="col-lg-5">
                                <select class="form-control" required name="team_a">
                                    <option>Select Team</option>
                                    @foreach($all_teams as $at)
                                        <option value="{{ $at->id }}"
                                            @php  
                                                if($at->id===$fixtures_data->team_a){
                                                    echo 'selected';
                                                }
                                            @endphp

                                            >{{ $at->name }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">{{__('Team B')}}</label>
                            <div class="col-lg-5">
                                <select class="form-control" required name="team_b">
                                    <option>Select Team</option>
                                    @foreach($all_teams as $at)
                                        <option value="{{ $at->id }}"
                                            @php  
                                                if($at->id===$fixtures_data->team_b){
                                                    echo 'selected';
                                                }
                                            @endphp

                                            >{{ $at->name }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">{{__('Venue')}}</label>
                            <div class="col-lg-5">
                                <input class="form-control" required type="text" name="venue" value="{{ $fixtures_data->venue }}">

                            </div>
                        </div>


                         <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">{{__('Team B')}}</label>
                            @php  
                                $statuses = array(
                                    '1' => 'pending',
                                    '2' => 'draw'
                                );
                            @endphp
                            <div class="col-lg-5">
                                <select class="form-control" required name="status">
                                    <option>Status</option>
                                    @foreach($statuses as $s => $v)
                                        <option value="{{ $s }}"
                                            @php  
                                                if($s===$fixtures_data->status){
                                                    echo 'selected';
                                                }
                                            @endphp

                                            >{{ $v }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="name">{{__('Winner')}}</label>
                            <div class="col-lg-5">
                                <select class="form-control" name="winner">
                                    <option>Select Team</option>
                                    @foreach($all_teams as $at)
                                        <option value="{{ $at->id }}"
                                            @php  
                                                if($at->id===$fixtures_data->winner){
                                                    echo 'selected';
                                                }
                                            @endphp

                                            >{{ $at->name }}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
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

   $('.players').select2();


</script>

@endsection
