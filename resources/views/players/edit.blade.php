@extends('layouts.app')

@section('content')

     <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Player edit')}}</h3>
            </div>

            <form class="form-horizontal" action="{{ route('players.update', $player_data->id) }}" method="POST" enctype="multipart/form-data">
                 <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('First name')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="first_name" value="{{ $player_data->first_name }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Last Name')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="last_name" value="{{ $player_data->last_name }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Jersey Number')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control" readonly="true" type="text" name="jersey_number" value="{{ $player_data->jersey_number }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Image of player')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="file" name="image_uri">
                            <img src="{{ asset($player_data->image_uri) }}" width="300px" height="300px">
                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Country')}}</label>
                        @php 
                        $country = array(
                        'IND' => 'INDIA',
                        'PAK' => 'PAKISTAN',
                        'ENG' => 'ENGLAND',
                        'AUS' => 'AUSTRALIA',
                        );
                        @endphp
                        <div class="col-lg-5">
                            <select required class="form-control" name="country">
                                <option> Select country</option>
                                @foreach($country as $c => $value)
                                    <option value="{{ $c }}" @if($player_data->country===$c) selected  @endif> {{ $value }} </option>
                                @endforeach
                                <!-- <option value="IND">INDIA</option>
                                <option value="PAK">PAKISTAN</option>
                                <option value="ENG">ENGLAND</option>
                                <option value="AUS">AUSTRALIA</option> -->
                            </select>
                        </div>
                    </div>

                    

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Matches')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="text" name="matches" value="{{ $player_data->matches }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Runs')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="text" name="runs" value="{{ $player_data->runs }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Highest Score')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="text" name="highest_score" value="{{ $player_data->highest_score }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('50s')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="text" name="fifties" value="{{ $player_data->fifties }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Hundreds')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control"  type="text" name="hundreds" value="{{ $player_data->hundreds }}">
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
