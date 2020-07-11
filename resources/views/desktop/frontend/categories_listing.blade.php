@extends('desktop.frontend.layouts.app')

@php  
$meta_title = '';
$meta_description = ''; 
@endphp

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

<link type="text/css" href="{{ asset('frontend/css/category.css') }}" rel="stylesheet" media="screen"> 
@section('content')

    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col">
                    
                </div>
            </div>
        </div>
    </div>

    <form id="filter_form">
    @csrf
    <section class="gry-bg py-2">
        <div class="container">
            <div class="row">

              <!---------- sidebar Filters Start ---------->
              <div class="col-xl-3 d-none d-xl-block my-2">
                <input type="hidden" id="base_url" value="{{ config('app.url') }}">
                <input type="hidden" id="category_url" value="{{ $cat_url }}">
                <input type="hidden" id="category_ref" name="category_ref" value="{{ $category->ref }}">
                <input type="hidden" id="filter_output_array" name="filter_output_array" value="">
                @if( count( $categories )>0 )

                <div class="bg-white sidebar-box mb-3">
                    <div class="box-title text-center">
                        Categories
                    </div>
                    @foreach( $categories as $cat  )
                    <div class="box-content">
                        <ul class="sub-sub-category-list">
                          <li>
                            <a href="{{ route('categories', $cat->slug) }}" class="d-block " tabindex="0">
                              {{ $cat->name }}
                            </a>
                          </li>
                        </ul>
                      </div>
                      @endforeach
                   </div>
                 @endif  



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
                    @if( count($categories)>0 )
                        <div class="products-box-bar bg-white">
                               
                                   <h1 class="title-heading">Categories</h1>
                            <div class="row sm-no-gutters gutters-5">
                                @foreach ($categories as  $cat)
                                    @php 
                                  
                                        $imageURL = '';
                                        if( !empty( $cat->photos ) )
                                            $imageURL = $cat->photos[0];
                                           

                                    @endphp
                                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-6">
                                        <div class="product-box-2 bg-white alt-box my-2">
                                            <div class="position-relative overflow-hidden">
                                                <a href="{{ route('categories', $cat->slug) }}" class="d-block product-image h-100" style="background-image:url('{{ asset( getImageURL($imageURL, 'thumbnail') ) }}');" tabindex="0">
                                                </a>
                                                <div class="product-btns clearfix">
                                                    
                                                </div>
                                            </div>
                                            <div class="p-2">
                                                <p class="product-title p-0 text-truncate">
                                                    <a href="{{ route('categories', $cat->slug) }}" tabindex="0">{{ __($cat->name) }}</a>
                                                  </p>
                                               <!--  <div class="clearfix">
                                                        <div class="price-box float-left">
                                                          <span class="product-price strong-600"><i class="fa fa-inr" aria-hidden="true"></i>600</span>
                                                         </div>
                                                 </div> -->
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif


                        


                        <div class="filter_results">

                            <!---------- Templates and  Products will be loaded here ---------->
                            
                        </div>
                        


                        <div class="products-pagination bg-white p-3">
                            <nav aria-label="Center aligned pagination">
                                <ul class="pagination justify-content-center">
                                    {{-- $products->links() --}}
                                </ul>
                            </nav>
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
            window.history.pushState(null, null, $('#base_url').val()+ $('#category_url').val() +filter_url );
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
               url: '{{ route('filters.pull_filter_data') }}',
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
