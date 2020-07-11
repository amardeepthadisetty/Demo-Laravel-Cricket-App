@extends('desktop.frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if(Auth::user()->user_type == 'seller')
                        @include('desktop.frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('desktop.frontend.inc.customer_side_nav')
                    @endif
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('Address Edit')}}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('profile') }}">{{__('Manage Profile')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(Session::has('error') )
                        <div>
                            {{ Session::get('error')  }}
                        </div>
                        @endif

                        <form class="address_details" action="{{ route('customer.address.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Address Edit')}}
                                </div>
                                <div class="form-box-content p-3">
                                     <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Name')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" required class="form-control mb-3" placeholder="{{__('Name')}}" name="name" value="{{ $addr->name }}">
                                            <input type="hidden" name="address_id" value="{{ $addr->id  }}" >
                                        </div>
                                    </div>

                                     <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Email')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" required class="form-control mb-3" placeholder="{{__('Email')}}" name="email" value="{{ $addr->email }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Address')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea class="form-control textarea-autogrow mb-3" placeholder="Your Address" rows="1" name="address">{{ $addr->address }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Address 1')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea class="form-control textarea-autogrow mb-3" placeholder="Your Address" rows="1" name="address1">{{ $addr->address1 }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Phone')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" required class="form-control mb-3" placeholder="Your Phone Number" name="phone" value="{{ $addr->phone }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Country')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <select class="form-control mb-3 selectpicker country_name" data-placeholder="Select your country" name="country">
                                                    @foreach (\App\Country::all() as $key => $country)
                                                        <option value="{{ $country->id }}" <?php if( $addr->country == $country->id) echo "selected";?> >{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('State')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <select class="form-control mb-3 selectpicker state-fill" data-placeholder="Select your country" name="state">
                                                    @foreach (\App\State::all() as $key => $country)
                                                        <option value="{{ $country->id }}" <?php if( $addr->country == $country->id) echo "selected";?> >{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('City')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="Your City" name="city" value="{{ Auth::user()->city }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Postal Code')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" placeholder="Your Postal Code" name="zip_code" value="{{ $addr->zip_code }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Default')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control" name="default_one" required>
                                                <option value="">Choose one</option>
                                                <option value="1" @php if($addr->default_address=="1"){ echo "selected"; } @endphp  >Yes</option>
                                                <option value="0" @php if($addr->default_address=="0"){ echo "selected"; } @endphp >No</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1">{{__('Update Address')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


     <script>
    loadStates();
    $('.country_name').on('change', function(){
        //console.log(this.value);
        loadStates();
        
    });

    function loadStates(){
         $.ajax({
               type:"POST",
               url: '{{ route('ajax.getStates.from.countryid') }}',
               data: $('.address_details').serializeArray(),
               success: function(data){
                  //console.log(data);
                  $('.state-fill').html(data);
               }
           });
    }
    </script>

@endsection
