@if( count($product_array)>0 )
    <div class="products-box-bar bg-white">
    <h1 class="title-heading ">Product Templates</h1>
        <div class="row sm-no-gutters gutters-5">
            @foreach ($product_array as  $prd)
                @php 
                    $prod_image_name = $prd->ref.'_images';
                    $obj = json_decode( json_encode( $template->product_images, FALSE ) );
                    $imageURL = '';
                    if( !empty( $obj->$prod_image_name[0] ) )
                        $imageURL = $obj->$prod_image_name[0];                               

                @endphp
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-6">
                    <div class="product-box-2 bg-white alt-box my-2">
                        <div class="position-relative overflow-hidden">
                            <a href="{{ route('template.product',[ 'tmpslug' => $template->slug, 'prodslug' => $prd->slug ]) }}" class="d-block product-image h-100" style="background-image:url('{{ asset( getImageURL( $imageURL ,'thumbnail') ) }}');" tabindex="0">
                            </a>
                           
                        </div>
                        <div class="p-2">
                            <p class="product-title p-0 text-truncate">
                                <a href="{{ route('template.product',[ 'tmpslug' => $template->slug, 'prodslug' => $prd->slug ]) }}" tabindex="0">{{ __($template->name.' '.$prd->name) }}</a>
                            </p>
                            <div class="clearfix">
                                    <div class="price-box float-left">
                                      <span class="product-price strong-600"><i class="fa fa-inr" aria-hidden="true"></i>{{ format_price( $template->display_price ) }}</span>
                                     </div>
                             </div>
                            
                        </div>
                    </div>
                    
                </div>
            @endforeach
        </div>
    </div>
    @endif



