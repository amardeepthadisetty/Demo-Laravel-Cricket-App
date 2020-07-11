@extends('layouts.app')

@section('content')

@if($type != 'Seller')
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('filtergroups.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Filter')}}</a>
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
            <h3 class="panel-title">{{ __(' Filters') }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reference ID</th>
                        <th width="20%">{{__('Name')}}</th>
                        <th width="20%">{{__('Slug')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Action')}}</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($filtergroups as $key => $fGroup)
                        <tr>
                            <td>{{$key+1}} </td>
                            <td>{{ $fGroup->ref }}</td>
                            <td>
                                
                                 <a href="" target="_blank">{{ __($fGroup->name) }}</a>
                               
                               
                            </td>
                            <td> {{ $fGroup->slug  }}</td>
                            <td> {{ $fGroup->active  }}</td>
                            
                            
                            
                           
                           <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if ($type == 'Seller')
                                            <li><a href="{{route('templates.seller.edit', encrypt($fGroup->id))}}">{{__('Edit')}}</a></li>
                                        @else
                                            <li><a href="{{route('filtergroups.admin.edit', encrypt($fGroup->id))}}">{{__('Edit')}}</a></li>
                                        @endif
                                        <li><a onclick="confirm_modal('{{route('templates.destroy', $fGroup->id)}}');">{{__('Delete')}}</a></li>
                                       {{--  <li><a href="{{route('templates.duplicate', $fGroup->id)}}">{{__('Duplicate')}}</a></li> --}}
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
