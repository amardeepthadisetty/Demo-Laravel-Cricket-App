@extends('layouts.app')

@section('content')


    <div class="row ">

        <div class="col-lg-12">
            <a href="{{ route('shipping_charge.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Ship Charges')}}</a>
        </div>


        @if($ssArray)
        <ul class="nav nav-tabs ">
                @php 
                $i=0;
                @endphp
                @foreach($ssArray as $ssa)
               
                     <li class="@php if($i==0){ echo 'active'; } @endphp">
                        <a data-toggle="tab" href="#s{{$ssa['row_id']}}">{{$ssa['name']}}</a>
                     </li>
                @php 
                    $i++;
                @endphp
                @endforeach
            
             
        </ul>

            <div class="tab-content ">
                @php 
                $j=0;
                @endphp
                @foreach($ssArray as $ssa)
                    <div id="s{{$ssa['row_id']}}" class="tab-pane fade @php if($j=='0'){ echo 'in active'; } @endphp">
                        <h3>{{$ssa['name']}} Shipping Station</h3>
                        @php 
                            $sChargees = App\ShippingCharge::where('ship_station_id', $ssa['ship_station_id'])->orderBy('id','desc')->get();

                            $groupByColumns = array();
                            foreach($sChargees as $s){
                                $common_column = $s->state_id."_".str_replace(".","-", $s->min)."_".str_replace(".","-", $s->max);

                                $priceArray['state_id'] = $s->state_id;
                                $priceArray['min'] = $s->min;
                                $priceArray['max'] = $s->max;
                                $priceArray['shipping_method_id'] = $s->shipping_method_id;
                                $priceArray['price'] = $s->price;
                                $priceArray['status'] = $s->status;
                                $priceArray['id'] = $s->id;

                                $groupByColumns[$common_column][] = $priceArray;

                             }

                            // echo '<pre>';
                            //    print_r($groupByColumns);
                            // echo '</pre>';
                            // foreach($groupByColumns as $g){
                            // echo $g[0]['state_id']."<br>";
                            //     foreach($g as $s){
                            //        echo "<br> Price is: ".$s['price']."    ";
                            //    }

                             //}
                             //die;

                             
                        @endphp


                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">{{__('Shipping Charges')}}</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                           <!--  <th>{{__('Shipping Station')}}</th> -->
                                            <th>{{__('State Name')}}</th>
                                            <th>{{__('Min')}}</th>
                                            <th>{{__('Max')}}</th>
                                            <th>{{__('Shipping Method and Price')}}</th>
                                            <th width="10%">{{__('Options')}}</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($groupByColumns as $key => $sg)
                                            <tr>
                                                <td> </td>
                                                
                                                <td>
                                                    {{ \App\State::where('id', $sg[0]['state_id'])->first()->name }}

                                                </td>
                                                <td>{{ $sg[0]['min'] }}</td>
                                                <td>{{ $sg[0]['max'] }}</td>
                                                @php  
                                                $s_ship_price_status = '';
                                                $ids = '';
                                                foreach($sg as $arrayValue){
                                                  $shipmethodid =  $arrayValue['shipping_method_id'];

                                                  $s_ship_price_status .= \App\ShippingMethod::where('id', $shipmethodid )->first()->name;

                                                   $statusforShipMethod = '';
                                                    if($arrayValue['status']=="1"){
                                                        $statusforShipMethod = 'Active';
                                                    }
                                                    else{
                                                        $statusforShipMethod = 'In active';    
                                                    }

                                                    $s_ship_price_status .= ' : '.$arrayValue['price'];
                                                    $s_ship_price_status .= ', Status : '.$statusforShipMethod. ' || ' ;

                                                    $ids .= $arrayValue['id']." || ";
                                                }

                                                $s_ship_price_status = rtrim($s_ship_price_status, ' || ');

                                                $ids = rtrim($ids, ' || ');

                                               
                                                @endphp
                                                
                                                <td> 
                                                    {{ $s_ship_price_status }}
                                                    <input type="hidden" id="{{$key.'_statename'}}" value="{{ \App\State::where('id', $sg[0]['state_id'])->first()->name  }}">

                                                    <input type="hidden" id="{{$key.'_min'}}" value="{{ $sg[0]['min'] }}">
                                                    <input type="hidden" id="{{$key.'_max'}}" value="{{ $sg[0]['max'] }}">
                                                    <input type="hidden" id="{{$key.'_allIDS'}}" value="{{ $ids }}">
                                                </td>
                                                <td>
                                                    <li><a class="edit_click" id="{{ $key }}">{{__('Edit')}}</a></li>
                                                    
                                                </td>



                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>





                        
                      @php 
                    $j++;
                @endphp
                 </div>
                @endforeach
              
           
        @endif



        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Shipping Method Charges</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form method="POST" action="{{ route('shipping_charge.saveShippingcharges') }}">
                @csrf
              <div class="modal-body">

                <div class="row">
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('State Name ')}}</label>
                        <div class="col-lg-9">
                            <input type="text" id="state_name" name="state_name" class="form-control" value="">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Min ')}}</label>
                        <div class="col-lg-9">
                            <input type="text" id="min" name="min" class="form-control" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="name">{{__('Max')}}</label>
                        <div class="col-lg-9">
                            <input type="text" id="max" name="max" class="form-control" value="">
                        </div>
                    </div>

                    <input type="hidden" id="allIDS" value="">
                    <div id="ajax_div">
                        
                    </div>
                    
                </div>
                
                
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
              </form>
            </div>
          </div>
        </div>


<script>

 $('.edit_click').on('click', function (){
    var id = this.id;
    var state_name_id = id + '_statename';
    var min_id = id + '_min';
    var max_id = id + '_max';
    var allIDS = id + '_allIDS';
    $('#exampleModal').modal('show');
    $('#state_name').val( $('#'+state_name_id).val()  );
    $('#min').val( $('#'+min_id).val() );
    $('#max').val( $('#'+max_id).val()  );
    $('#allIDS').val( $('#'+allIDS).val()  );

    $.post('{{ route('shipping_charge.sendShipCharges') }}', 
        { _token : '{{ @csrf_token() }}', 
        state_name_id : state_name_id,
        allIDS : $('#allIDS').val()

        }, function(data){
            $('#ajax_div').html(data);
            console.log(data);
        });
 });
    
</script>

   

    
@endsection
