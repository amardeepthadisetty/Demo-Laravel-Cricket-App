@extends('layouts.app')

@section('content')

     <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Team edit')}}</h3>
            </div>

            <form class="form-horizontal" action="{{ route('teams.update', $team_data->id) }}" method="POST" enctype="multipart/form-data">
                 <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Team Name')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="team_name" value="{{ $team_data->name}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Logo')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="file" name="logo_uri">
                            <img src="{{ asset( $team_data->logo_uri) }}" width="300px" height="200px">

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
