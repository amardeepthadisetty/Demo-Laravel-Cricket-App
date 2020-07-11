@extends('desktop.frontend.layouts.app')

@if(isset($subsubcategory_id))
    @php
        $meta_title = \App\SubSubCategory::find($subsubcategory_id)->meta_title;
        $meta_description = \App\SubSubCategory::find($subsubcategory_id)->meta_description;
    @endphp
@elseif (isset($subcategory_id))
    @php
        $meta_title = \App\SubCategory::find($subcategory_id)->meta_title;
        $meta_description = \App\SubCategory::find($subcategory_id)->meta_description;
    @endphp
@elseif (isset($category_id))
    @php
        
        $meta_title = \App\Category::where('id',$category_id)->first()->meta_title;
        $meta_description = \App\Category::where('id',$category_id)->first()->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Brand::find($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title = env('APP_NAME');
        $meta_description = \App\SeoSetting::first()->description;
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')

    <!-- <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    <ul class="breadcrumb">
                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                        <li><a href="{{ route('products') }}">{{__('All Categories')}}</a></li>
                        @if(isset($category_id))
                            <li class="active"><a href="{{ route('products.category', \App\Category::find($category_id)->slug) }}">{{ \App\Category::find($category_id)->name }}</a></li>
                        @endif
                        @if(isset($subcategory_id))
                            <li ><a href="{{ route('products.category', \App\SubCategory::find($subcategory_id)->category->slug) }}">{{ \App\SubCategory::find($subcategory_id)->category->name }}</a></li>
                            <li class="active"><a href="{{ route('products.subcategory', \App\SubCategory::find($subcategory_id)->slug) }}">{{ \App\SubCategory::find($subcategory_id)->name }}</a></li>
                        @endif
                        @if(isset($subsubcategory_id))
                            <li ><a href="{{ route('products.category', \App\SubSubCategory::find($subsubcategory_id)->subcategory->category->slug) }}">{{ \App\SubSubCategory::find($subsubcategory_id)->subcategory->category->name }}</a></li>
                            <li ><a href="{{ route('products.subcategory', \App\SubsubCategory::find($subsubcategory_id)->subcategory->slug) }}">{{ \App\SubsubCategory::find($subsubcategory_id)->subcategory->name }}</a></li>
                            <li class="active"><a href="{{ route('products.subsubcategory', \App\SubSubCategory::find($subsubcategory_id)->slug) }}">{{ \App\SubSubCategory::find($subsubcategory_id)->name }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div> -->

  <form id="filter_form">
  @csrf
    <section class="gry-bg py-4">
        <div class="container">
            <div class="row">
                <!---------- sidebar Filters Start ---------->
                      <div class="col-xl-3 d-none d-xl-block my-2">
                        <input type="hidden" id="base_url" value="{{ config('app.url') }}">
                        <input type="hidden" id="search_url" value="{{ $search_url }}">
                        <input type="hidden" id="search_param" name="search_param" value="{{ request()->segment(2) }}">
                        
                        <input type="hidden" id="filter_output_array" name="filter_output_array" value="">

                        @if( count( $filter_output_array )>0 )
                        <div class="bg-white sidebar-box mb-3">
                            <div class="box-title text-center">
                                Filters
                            </div>
                                @foreach( $filter_output_array as $key => $innerArray  )
                                    <div class="box-content">
                                            <ul class="sub-sub-category-list">
                                                <li>{{ $innerArray[0]['filter_group_name'] }}</li>
                                                <ul class="sub-sub-category-list">
                                    @foreach($innerArray as $value)
                                                <li>
                                                   
                                                    <input type="checkbox" class="checkbox_filters" name="filter_name[]" value="{{ $value['filter_group_slug'].'_'.$value['filter_name_slug'] }}"  
                                                    @if( in_array( trim($value['filter_name_slug']), $filter_slugs ) ) 
                                                        checked
                                                    @endif
                                                     >
                                                     <label>{{ $value['filter_name'] }}</label>
                                                  </li>
                                    @endforeach     

                                                </ul>
                                            </ul>
                                            
                                            
                                    </div>
                                  @endforeach
                           </div>
                           @endif



                      </div>

        <!---------- sidebar Filters End ---------->
                <div class="col-xl-9">
                    <!-- <div class="bg-white"> -->
                        <div class="brands-bar row no-gutters pb-3 bg-white p-3">
                            <div class="col-11">
                                <div class="brands-collapse-box" id="brands-collapse-box">
                                    
                                </div>
                            </div>
                           
                        </div>
                       <!--  <form class="" id="search-form" action="{{ route('search_post') }}" method="POST">
                            @csrf
                            
                        </form> -->
                        <!-- <hr class=""> -->

                         <div class="filter_results">

                            <!---------- Templates and  Products will be loaded here ---------->
                            
                        </div>

                       


                       
                       

                    <!-- </div> -->
                </div>
            </div>
        </div>
    </section>
  </form>
@endsection

@section('script')
    <script type="text/javascript">
        function filter(){
            $('#search-form').submit();
        }
        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
    </script>

    <script>

        $('document').ready(function(){
            var filter_url = '';
            filter_url = getFilterCheckedValues(filter_url);
            pull_filters_ajax();
        });
        
        $('.checkbox_filters').on('change', function(){

            var filter_url = '';
            filter_url = getFilterCheckedValues(filter_url);                        
            window.history.pushState(null, null, $('#base_url').val()+ $('#search_url').val() +filter_url );
            pull_filters_ajax();
        });

        function getFilterCheckedValues( filter_url = ''){
            var filter_output_array = [];
            $.each($(".checkbox_filters:checked"), function(){
                var checkbox_value = $(this).val();
                var splitValues = checkbox_value.split("_");

                filter_output_array.push({'filter_group_name' : splitValues[0],'filter_name' : splitValues[1] });

                filter_url += splitValues[0]+'_'+splitValues[1]+'/';

            });
            if ( filter_url!='') {
                filter_url = '/filters/'+filter_url ;
            }
            $('#filter_output_array').val( JSON.stringify( filter_output_array ) );
            return filter_url;
        }


        function pull_filters_ajax(){

            $.ajax({
               type:"POST",
               url: '{{ route('filters.pull_search_filter_data') }}',
               data: $('#filter_form').serializeArray(),
               success: function(data){
                   //console.log(data);
                   if (data) {
                    //var d = JSON.parse(data);
                    //$('.filter_results').html(d.products_view);
                    $('.filter_results').html(data);
                   }
               }
           });


        }
    </script>
@endsection
