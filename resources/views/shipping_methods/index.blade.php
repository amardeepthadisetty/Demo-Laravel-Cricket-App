@extends('layouts.app')

@section('content')

@if($type != 'Seller')
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('shippingmethod.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Shipping Method')}}</a>
        </div>
    </div>
@endif

<br>

@if(Session::get('success'))
    {{ Session::get('success') }}
@endif
<div class="col-lg-12">
    <div class="panel">
        <!--Panel heading-->
        <div class="panel-heading">
            <h3 class="panel-title">{{ __(' Shipping Methods') }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">{{__('Name')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Action')}}</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($shipping_methods as $key => $SM)
                        <tr>
                            <td>{{$key+1}} </td>
                            <td>
                                
                                 <a href="" target="_blank">{{ __($SM->name) }}</a>
                               
                               
                            </td>
                            <td>
                                @if( $SM->status==1 )
                                    Active
                                @else
                                    Inactive    
                                @endif

                            </td>
                            
                            
                            
                           
                           <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if ($type == 'Seller')
                                            <li><a href="{{route('templates.seller.edit', encrypt($SM->id))}}">{{__('Edit')}}</a></li>
                                        @else
                                            <li><a href="{{route('shippingmethod.admin.edit', encrypt($SM->id))}}">{{__('Edit')}}</a></li>
                                        @endif
                                        <li><a onclick="confirm_modal('{{route('templates.destroy', $SM->id)}}');">{{__('Delete')}}</a></li>
                                       {{--  <li><a href="{{route('templates.duplicate', $SM->id)}}">{{__('Duplicate')}}</a></li> --}}
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection


@section('script')
    <script type="text/javascript">

        $(document).ready(function(){
            //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
        });

        function update_todays_deal(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('templatecategories.todays_deal') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Status updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_published(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('templates.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Published templates updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_featured(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('templates.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Featured templates updated successfully');
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
