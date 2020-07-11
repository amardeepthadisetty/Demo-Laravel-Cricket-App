@extends('layouts.app')

@section('content')

@if($type != 'Seller')
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('templates.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Template')}}</a>
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
            <h3 class="panel-title">{{ __($type.' Templates') }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reference ID</th>
                        <th width="20%">{{__('Name')}}</th>
                        <th>{{__('Photo')}}</th>
                        <th>{{__('Base Price')}}</th>
                        <th>{{__('Display Price')}}</th>
                        <th>{{__('Todays Deal')}}</th>
                        <th>{{__('Published')}}</th>
                        <th>{{__('Featured')}}</th>
                        <th>{{__('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($templates as $key => $template)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $template->ref }}</td>
                            <td><a href="{{ route('product', $template->slug) }}" target="_blank">{{ __($template->name) }}</a></td>
                            <td>
                                @php 
                                  
                                        $imageURL = '';
                                        if( !empty( $template->photos ) )
                                            $imageURL = $template->photos[0];
                                           

                                    @endphp

                                <img loading="lazy"  class="img-md" src="{{ asset( getImageURL( $imageURL,'icon')  ) }}" alt="Image">

                            </td>
                            
                            <td>{{ number_format($template->base_price,2) }}</td>
                            <td>{{ number_format($template->display_price,2) }}</td>
                            <td><label class="switch">
                                <input onchange="update_todays_deal(this)" value="{{ $template->id }}" type="checkbox" <?php if($template->todays_deal == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                            <td><label class="switch">
                                <input onchange="update_published(this)" value="{{ $template->id }}" type="checkbox" <?php if($template->published == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                            <td><label class="switch">
                                <input onchange="update_featured(this)" value="{{ $template->id }}" type="checkbox" <?php if($template->featured == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                            <td>
                                <div class="btn-group dropdown">
                                    <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                        {{__('Actions')}} <i class="dropdown-caret"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        @if ($type == 'Seller')
                                            <li><a href="{{route('templates.seller.edit', encrypt($template->id))}}">{{__('Edit')}}</a></li>
                                        @else
                                            <li><a href="{{route('templates.admin.edit', encrypt($template->id))}}">{{__('Edit')}}</a></li>
                                        @endif
                                        <li><a onclick="confirm_modal('{{route('templates.destroy', $template->id)}}');">{{__('Delete')}}</a></li>
                                       {{--  <li><a href="{{route('templates.duplicate', $template->id)}}">{{__('Duplicate')}}</a></li> --}}
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
            $.post('{{ route('templates.todays_deal') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showAlert('success', 'Todays Deal updated successfully');
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
