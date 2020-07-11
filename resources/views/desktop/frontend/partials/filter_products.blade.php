@if( count($templates)>0 )
    <div class="products-box-bar bg-white">
      <h2 class="title-heading">Templates</h2>
        <div class="row sm-no-gutters gutters-5">
            @foreach ($templates as  $tmplte)
                @php 
              
                    $imageURL = '';
                    if( !empty( $tmplte->photos ) )
                        $imageURL = $tmplte->photos[0];
                       

                @endphp
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-6">
                    <div class="product-box-2 bg-white alt-box my-2">
                        <div class="position-relative overflow-hidden">
                            <a href="{{ route('templates', $tmplte->slug) }}" class="d-block product-image h-100" style="background-image:url('{{ asset( getImageURL($imageURL, 'thumbnail')   ) }}');" tabindex="0">
                            </a>
                            <div class="product-btns clearfix">
                                
                            </div>
                        </div>
                        <div class="p-2">
                            <p class="product-title p-0 text-truncate">
                                <a href="{{ route('templates', $tmplte->slug) }}" tabindex="0">{{ __($tmplte->name) }}</a>
                             </p>
                             <div class="clearfix">
                                    <div class="price-box float-left">
                                      <span class="product-price strong-600"><i class="fa fa-inr" aria-hidden="true"></i>{{ format_price( $tmplte->display_price ) }}</span>
                                     </div>
                             </div>
                            
                        </div>
                    </div>
                    
                </div>
            @endforeach
        </div>
    </div>
    @endif


@if( count($products)>0 )
        <div class="products-box-bar p-3 bg-white">
                   <h3>Products</h3>
            <div class="row sm-no-gutters gutters-5 products_filters_show">
                @foreach ($products as  $prod)
                    @php 
                        $imageURL = '';
                        if( !empty( $prod->photos ) )
                            $imageURL = $prod->photos[0];
                           

                    @endphp
                    <div class="col-xxl-3 col-xl-4 col-lg-3 col-md-4 col-6">
                        <div class="product-box-2 bg-white alt-box my-2">
                            <div class="position-relative overflow-hidden">
                                <a href="{{ route('product', $prod->slug) }}" class="d-block product-image h-100" style="background-image:url('{{ asset( getImageURL( $imageURL ,'thumbnail') ) }}');" tabindex="0">
                                </a>
                                <div class="product-btns clearfix">
                                    
                                </div>
                            </div>
                            <div class="p-3 border-top">
                                <h2 class="product-title p-0 text-truncate">
                                    <a href="{{ route('product', $prod->slug) }}" tabindex="0">{{ __($prod->name) }}</a>
                                </h2>
                                <div class="clearfix">
                                        <div class="price-box float-left">
                                          <span class="product-price strong-600"><i class="fa fa-inr" aria-hidden="true"></i>
                                            @php 
                                            if( $prod->is_variant=="0" ){
                                              echo format_price( $prod->unit_price);
                                            }else{
                                              echo home_price( $prod->_id );
                                            }
                                            @endphp
                                          </span>
                                         </div>
                                 </div>
                                
                            </div>
                        </div>
                        
                    </div>
                @endforeach
            </div>
        </div>
        @endif