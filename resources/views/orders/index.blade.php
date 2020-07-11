@extends('layouts.app')

@section('content')

    <div class="row">
       
    </div><br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Orders Information')}}</h3>
        </div>
        <div class="panel-body">
             <section class="gry-bg py-4 profile">
                    <div class="container">
                        <div class="row cols-xs-space cols-sm-space cols-md-space">
                            

                            <div class="col-lg-9">
                                <div class="main-content">
                                    <!-- Page title -->
                                    <div class="page-title">
                                        <div class="row align-items-center">
                                            <div class="col-md-6 col-12">
                                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                                    {{__('Orders History')}}
                                                </h2>
                                            </div>
                                            
                                        </div>
                                    </div>

                                    @if (count($orders) > 0)
                                        <!-- Order history table -->
                                        <div class="card no-border mt-4">
                                            <div>
                                                <table class="table table-sm table-hover table-responsive-md">
                                                    <thead>
                                                        <tr>
                                                            <th>{{__('Order ID')}}</th>
                                                            <th>{{__('Date')}}</th>
                                                            <th>{{__('Amount')}}</th>
                                                            <th>{{__('Delivery Status')}}</th>
                                                            <th>{{__('Payment Status')}}</th>
                                                            <th>{{__('Options')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($orders as $key => $order)
                                                            <tr>
                                                                <td>
                                                                    <a href="#{{ $order->code }}" onclick="show_purchase_history_details({{ $order->id }})">{{ $order->code }}</a>
                                                                </td>
                                                                <td>{{ date('d-m-Y', $order->date) }}</td>
                                                                <td>
                                                                    {{ single_price($order->grand_total) }}
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $status = $order->orderDetails->first()->delivery_status;
                                                                    @endphp
                                                                    @if($order->delivery_viewed == 0)
                                                                        <span class="ml-2" style="color:green"><strong>({{ __('Updated') }})</strong></span>
                                                                    @else
                                                                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge--2 mr-4">
                                                                        @if ($order->payment_status == 'paid')
                                                                            <i class="bg-green"></i> {{__('Paid')}}
                                                                        @else
                                                                            <i class="bg-red"></i> {{__('Unpaid')}}
                                                                        @endif
                                                                        @if($order->payment_status_viewed == 0)<span class="ml-2" style="color:green"><strong>({{ __('Updated') }})</strong></span>@endif
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button class="btn" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                        </button>

                                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="">
                                                                            <!-- <button onclick="show_purchase_history_details({{ $order->id }})" class="dropdown-item">{{__('Order Details')}}</button> -->
                                                                            <a href="{{ route('orders.order_details.orderid', $order->id) }}" class="dropdown-item">{{__('Order Details')}}</a>
                                                                            <!-- <a href="{{ route('customer.invoice.download', $order->id) }}" class="dropdown-item">{{__('Download Invoice')}}</a> -->
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="pagination-wrapper py-4">
                                        <ul class="pagination justify-content-end">
                                            {{ $orders->links() }}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

        </div>
    </div>

@endsection
