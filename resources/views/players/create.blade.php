@extends('layouts.app')

@section('content')

    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Players')}}</h3>
            </div>

            <form class="form-horizontal" action="{{ route('players.store') }}" method="POST" enctype="multipart/form-data">
            	@csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('First name')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="first_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Last Name')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="last_name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Jersey Number')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="text" name="jersey_number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Image of player')}}</label>
                        <div class="col-lg-5">
                            <input class="form-control" required type="file" name="image_uri">

                        </div>
                    </div>

                     <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Country')}}</label>
                        <div class="col-lg-5">
                            <select required class="form-control" name="country">
                                <option> Select country</option>
                                <option value="IND">INDIA</option>
                                <option value="PAK">PAKISTAN</option>
                                <option value="ENG">ENGLAND</option>
                                <option value="AUS">AUSTRALIA</option>
                            </select>
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
