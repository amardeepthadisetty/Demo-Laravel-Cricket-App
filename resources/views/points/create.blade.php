@extends('layouts.app')

@section('content')

    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Fixtures')}}</h3>
            </div>

            <form class="form-horizontal" action="{{ route('fixtures.store') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Match Date')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="date" name="match_date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Team A')}}</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="team_a">
                                <option>Select Team</option>
                                @foreach($all_teams as $at)
                                    <option value="{{ $at->id }}">{{ $at->name }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Team B')}}</label>
                        <div class="col-lg-5">
                            <select class="form-control" name="team_b">
                                <option>Select Team</option>
                                @foreach($all_teams as $at)
                                    <option value="{{ $at->id }}">{{ $at->name }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Venue')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="venue">

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
