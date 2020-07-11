@extends('layouts.app')

@section('content')

@if($type != 'Seller')
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('templatecategories.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Template')}}</a>
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
            <h3 class="panel-title">{{ __($type.' Template Categories') }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reference ID</th>
                        <th width="20%">{{__('Name')}}</th>
                        <th width="20%">{{__('Slug')}}</th>
                        <th>{{__('Photo')}}</th>
                        <th>{{__('Status')}}</th>
                        <th>{{__('Published')}}</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($templates as $key => $template)
                        <tr>
                            <td>{{$key+1}} </td>
                            <td>{{ $template->ref }}</td>
                            <td>
                                @php

                                $categoryName = '';
                            if($template->parent_id!="0" ){
                                $firstLevel = \App\TemplateCategories::where('ref',$template->parent_id)->first();
                                if ($firstLevel) {
                                     $categoryName = $firstLevel->name;

                                     //echo $categoryName."<br>";
                                     //die;


                                          $secondLevel = \App\TemplateCategories::where('ref',$firstLevel->parent_id)->where('active','1')->first();
                                          if ($secondLevel) {
                                              $categoryName .= ' > '.$secondLevel->name;

                                              $thirdLevel = \App\TemplateCategories::where('ref',$secondLevel->parent_id)->where('active','1')->first();
                                              if ($thirdLevel) {
                                                 $categoryName .= ' > '.$thirdLevel->name;
                                              }
                                          }//end of secondLevel if
                                }
                            }

                                $categoryName .= ' > '.$template->name;

                                @endphp


                                 @if($template->parent_id!="0" )
                                 <a href="{{ route('product', $template->slug) }}" target="_blank">{{ __($categoryName) }}</a>
                                @else
                                 <a href="{{ route('product', $template->slug) }}" target="_blank">{{ __($template->name) }}</a>
                                @endif
                               
                            </td>
                            <td> {{ $template->slug  }}</td>
                            <td>
                                @php 
                                  
                                        $imageURL = '';
                                        if( !empty( $template->photos ) )
                                            $imageURL = $template->photos[0];
                                           

                                    @endphp

                                <img loading="lazy"  class="img-md" src="{{ asset( getImageURL( $imageURL,'icon')  ) }}" alt="Image">

                            </td>
                            
                            
                           
                            <td><label class="switch">
                                <input onchange="update_todays_deal(this)" value="{{ $template->id }}" type="checkbox" <?php if($template->active == 1) echo "checked";?> >
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
                                            <li><a href="{{route('templatecategories.admin.edit', encrypt($template->id))}}">{{__('Edit')}}</a></li>
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
