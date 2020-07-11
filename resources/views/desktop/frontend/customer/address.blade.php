@extends('desktop.frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('desktop.frontend.inc.customer_side_nav')
                </div>
                <div class="col-lg-9">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-12">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    {{__('Address Book')}} <a class="btn btn-sm btn-primary" href="{{ route('address.new')  }}">+ Add new Address</a>
                                </h2>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                        <li class="active"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- dashboard content -->
                    <div class="">
                        
                        <div class="row">

                            @if($addresses)
                            @foreach($addresses as $addr)
                            <div class="col-md-5">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 clearfix ">
                                        {{__('Saved Address Info')}} 

                                        @if($addr->default_address=="1")
                                        - Default one
                                        @endif
                                        <div class="float-right">
                                            <a href="{{ route('address.info' , ['id' => $addr->id ] ) }}" class="btn btn-link btn-sm">{{__('Edit')}}</a>
                                            <form>
                                            @csrf  
                                            <a href="{{ route('address.delete' , ['id' => $addr->id ] ) }}" class="btn btn-danger btn-sm">{{__('Delete')}}</a>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="form-box-content p-3">
                                        <table>
                                            <tr>
                                                <td>{{__('Name')}}:</td>
                                                <td class="p-2">{{ $addr->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Email')}}:</td>
                                                <td class="p-2">{{ $addr->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Address')}}:</td>
                                                <td class="p-2">{{ $addr->address }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Address1')}}:</td>
                                                <td class="p-2">{{ $addr->address1 }}</td>
                                            </tr>

                                            <tr>
                                                <td>{{__('Phone')}}:</td>
                                                <td class="p-2">{{ $addr->phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Country')}}:</td>
                                                <td class="p-2">
                                                    @if ($addr->country != null)
                                                        {{ \App\Country::where('id', $addr->country )->first()->name }}
                                                    @endif
                                                </td>
                                            </tr>

                                             <tr>
                                                <td>{{__('State')}}:</td>
                                                <td class="p-2">
                                                    @if ($addr->state != null)
                                                        {{ \App\State::where('id', $addr->state  )->first()->name }}
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>{{__('City')}}:</td>
                                                <td class="p-2">{{ $addr->city }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('Postal Code')}}:</td>
                                                <td class="p-2">{{ $addr->zip_code }}</td>
                                            </tr>
                                           
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
