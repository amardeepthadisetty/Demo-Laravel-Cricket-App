<div class="header">

    <div class="position-relative logo-bar-area">
        <div class="">
            <div class="container">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-2 col-8">
                        <div class="d-flex">
                            <div class="d-block d-lg-none mobile-menu-icon-box">
                                <!-- Navbar toggler  -->
                                <a href="" onclick="sideMenuOpen(this)">
                                    <div class="hamburger-icon">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                            </div>

                            <!-- Brand/Logo -->
                            <a class="navbar-brand w-100" href="{{ route('home') }}">
                                @php
                                    $generalsetting = \App\GeneralSetting::first();
                                @endphp
                                @if($generalsetting->logo != null)
                                    <img loading="lazy"  src="{{ asset($generalsetting->logo) }}" class="" alt="active shop">
                                @else
                                    <img loading="lazy"  src="{{ asset('frontend/images/logo/logo.png') }}" class="" alt="active shop">
                                @endif
                            </a>

                            @if(Route::currentRouteName() != 'home' && Route::currentRouteName() != 'categories.all')
                                <!-- <div class="d-none d-xl-block category-menu-icon-box">
                                    <div class="dropdown-toggle navbar-light category-menu-icon" id="category-menu-icon">
                                        <span class="navbar-toggler-icon"></span>
                                    </div>
                                </div> -->
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-10 col-4 position-static">
                        <div class="d-flex w-100">
                            <div class="search-box flex-grow-1 px-4">
                                <form action="{{ route('search_post') }}" method="POST">
                                    @csrf
                                    <div class="d-flex position-relative">
                                        <div class="d-lg-none search-box-back">
                                            <button class="" type="button"><i class="la la-long-arrow-left"></i></button>
                                        </div>
                                @php 
                                   $cookieSearchType = getSearchTypeCookie();
                                   $tP = '';
                                   $nP = '';
                                   $all = '';
                                   //echo "cookie is: ".$cookieSearchType."<br>";
                                   if( $cookieSearchType=="template_products" ){
                                        $tP= 'selected';
                                    }else if( $cookieSearchType=="normal_products"  ){
                                        $nP= 'selected';
                                    }else{
                                        $all = 'selected';
                                    }

                                @endphp
                                        <div class="form-group category-select d-none d-xl-block">
                                            <select class="form-control selectpicker" name="search_type">
                                                <option value="all" {{ $all }}>All</option>
                                                <option value="normal_products" {{ $nP }}>Products</option>
                                                <option value="template_products" {{ $tP }} >Templates</option>
                                                
                                            </select>
                                        </div>
                                        <div class="w-100">
                                            @php 
                                                $search_string = '';
                                                if( !empty(request()->segment(1)) ){
                                                    if( request()->segment(1)=="search" ){
                                                        $search_string = request()->segment(2);
                                                    }

                                                }

                                            @endphp
                                            <input type="text" aria-label="Search" id="search" name="q" class="w-100" placeholder="I'm shopping for..." autocomplete="off" value="{{ $search_string }}">
                                        </div>
                                        <button class="d-none d-lg-block" type="submit">
                                            <i class="la la-search la-flip-horizontal"></i>
                                        </button>
                                        <!-- <div class="typed-search-box d-none">
                                            <div class="search-preloader">
                                                <div class="loader"><div></div><div></div><div></div></div>
                                            </div>
                                            <div class="search-nothing d-none">

                                            </div>
                                            <div id="search-content">

                                            </div>
                                        </div> -->
                                    </div>
                                </form>

                            </div>

                            <div class="logo-bar-icons d-inline-block ml-auto">
                                <div class="d-inline-block d-lg-none">
                                    <div class="nav-search-box">
                                        <a href="#" class="nav-box-link">
                                            <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                                        </a>
                                    </div>
                                </div>

                                                               
                                <?php /*

                                <div class="d-none d-lg-inline-block">
                                    <div class="nav-compare-box" id="compare">
                                        <a href="{{ route('compare') }}" class="nav-box-link">
                                            <i class="la la-refresh d-inline-block nav-box-icon"></i>
                                            <span class="nav-box-text d-none d-xl-inline-block">{{__('Compare')}}</span>
                                            @if(Session::has('compare'))
                                                <span class="nav-box-number">{{ count(Session::get('compare'))}}</span>
                                            @else
                                                <span class="nav-box-number">0</span>
                                            @endif
                                        </a>
                                    </div>
                                </div> 
                                
                                <div class="d-none d-lg-inline-block">
                                    <div class="nav-wishlist-box" id="wishlist">
                                        <a href="{{ route('wishlists.index') }}" class="nav-box-link">
                                            <i class="la la-heart-o d-inline-block nav-box-icon"></i>
                                            <span class="nav-box-text d-none d-xl-inline-block">{{__('Wishlist')}}</span>
                                            @if(Auth::check())
                                               {{--  <span class="nav-box-number">{{ count(Auth::user()->wishlists)}}</span> --}}
                                            @else
                                                <span class="nav-box-number">0</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>  
                               
                                */  ?>


                                <div class=" d-none d-lg-block">
                    <ul class="inline-links">
                         <li>
                            <a href="{{ route('orders.track') }}" class="top-bar-item">{{__('Track Order')}}</a>
                        </li> 
                        @auth
                        <li>
                            <a href="{{ route('dashboard') }}" class="top-bar-item">{{__('My Account')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" class="top-bar-item">{{__('Logout')}}</a>
                        </li>
                        @else
                        <li>
                            <a href="{{ route('user.login') }}" class="top-bar-item">{{__('My Account')}}</a>
                        </li>
                        <li>
                            <!-- <a href="{{ route('user.registration') }}" class="top-bar-item">{{__('Registration')}}</a> -->

                            <a href="" class="top-bar-item">{{__('Offers')}}</a>
                        </li>
                        @endauth


                        <li>

                            <div class="d-inline-block" data-hover="dropdown">
                                <div class="nav-cart-box dropdown" id="cart_items">
                                    <a href="{{ route('cart') }}" class="nav-box-link" >
                                        <i class="la la-shopping-cart d-inline-block nav-box-icon"></i>
                                        <span class="nav-box-text d-none d-xl-inline-block">{{__('Cart')}}</span>
                                        @if(Session::has('cart'))
                                            <span class="nav-box-number">{{ count(Session::get('cart'))}}</span>
                                        @else
                                            <span class="nav-box-number">0</span>
                                        @endif
                                    </a>
                                  <?php /*
                                    <ul class="dropdown-menu dropdown-menu-right px-0">
                                        <li>
                                            <div class="dropdown-cart px-0">
                                                @if(Session::has('cart'))
                                                    @if(count($cart = Session::get('cart')) > 0)
                                                        <div class="dc-header">
                                                            <h3 class="heading heading-6 strong-700">{{__('Cart Items')}}</h3>
                                                        </div>
                                                        <div class="dropdown-cart-items c-scrollbar">
                                                            @php
                                                                $total = 0;
                                                            @endphp
                                                            @foreach($cart as $key => $cartItem)
                                                                @php
                                                                    $product = \App\Product::find($cartItem['id']);
                                                                    $total = $total + $cartItem['price']*$cartItem['quantity'];
                                                                @endphp
                                                                <div class="dc-item">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="dc-image">
                                                                            <a href="{{ route('product', $product->slug) }}">
                                                                                <img loading="lazy"  src="{{ asset($product->thumbnail_img) }}" class="img-fluid" alt="">
                                                                            </a>
                                                                        </div>
                                                                        <div class="dc-content">
                                                                            <span class="d-block dc-product-name text-capitalize strong-600 mb-1">
                                                                                <a href="{{ route('product', $product->slug) }}">
                                                                                    {{ __($product->name) }}
                                                                                </a>
                                                                            </span>

                                                                            <span class="dc-quantity">x{{ $cartItem['quantity'] }}</span>
                                                                            <span class="dc-price">{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                                                                        </div>
                                                                        <div class="dc-actions">
                                                                            <button onclick="removeFromCart({{ $key }})">
                                                                                <i class="la la-close"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="dc-item py-3">
                                                            <span class="subtotal-text">{{__('Subtotal')}}</span>
                                                            <span class="subtotal-amount">{{ single_price($total) }}</span>
                                                        </div>
                                                        <div class="py-2 text-center dc-btn">
                                                            <ul class="inline-links inline-links--style-3">
                                                                <li class="px-1">
                                                                    <a href="{{ route('cart') }}" class="link link--style-1 text-capitalize btn btn-base-1 px-3 py-1">
                                                                        <i class="la la-shopping-cart"></i> {{__('View cart')}}
                                                                    </a>
                                                                </li>
                                                                @if (Auth::check())
                                                                <li class="px-1">
                                                                    <a href="{{ route('checkout.shipping_info') }}" class="link link--style-1 text-capitalize btn btn-base-1 px-3 py-1 light-text">
                                                                        <i class="la la-mail-forward"></i> {{__('Checkout')}}
                                                                    </a>
                                                                </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    @else
                                                        <div class="dc-header">
                                                            <h5 class="heading heading-6">{{__('Your Cart is empty')}}</h5>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="dc-header">
                                                        <h5 class="heading heading-6">{{__('Your Cart is empty')}}</h5>
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    </ul>

                                    */ ?>
                                </div>
                            </div>

                        </li>
                    </ul>
                </div>


                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php /*
        <div class="hover-category-menu" id="hover-category-menu">
            <div class="container">
                <div class="row no-gutters position-relative">
                    <div class="col-lg-3 position-static">
                        <div class="category-sidebar" id="category-sidebar">
                            <div class="all-category">
                                <span>{{__('CATEGORIES')}}</span>
                                <a href="{{ route('categories.all') }}" class="d-inline-block">See All ></a>
                            </div>
                            <ul class="categories">
                                @foreach (\App\Category::all()->take(11) as $key => $category)
                                    @php
                                        $brands = array();
                                        $subCat = \App\SubCategory::where('category_id', $category->id)->get();
                                    @endphp
                                    <li>
                                        <a href="{{ route('products.category', $category->slug) }}">
                                            <img loading="lazy"  class="cat-image" src="{{ asset($category->icon) }}" width="30">
                                            <span class="cat-name">{{ __($category->name) }}</span>
                                        </a>
                                        @if(count($subCat)>0)
                                            <div class="sub-cat-menu c-scrollbar">
                                                <div class="sub-cat-main row no-gutters">
                                                    <div class="col-9">
                                                        <div class="sub-cat-content">
                                                            <div class="sub-cat-list">
                                                                <div class="card-columns">
                                                                    @foreach ($subCat as $subcategory)
                                                                        @php
                                                                                $subSubCat = \App\SubSubCategory::where('sub_category_id', $subcategory->id)->get();
                                                                        @endphp
                                                                        <div class="card">
                                                                            <ul class="sub-cat-items">
                                                                                <li class="sub-cat-name"><a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ __($subcategory->name) }}</a></li>
                                                                                @foreach ($subSubCat as $subsubcategory)
                                                                                    @php
                                                                                        foreach (json_decode($subsubcategory->brands) as $brand) {
                                                                                            if(!in_array($brand, $brands)){
                                                                                                array_push($brands, $brand);
                                                                                            }
                                                                                        }
                                                                                    @endphp
                                                                                    <li><a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}">{{ __($subsubcategory->name) }}</a></li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="sub-cat-featured">
                                                                {{-- <ul class="sub-cat-featured-list inline-links d-flex">
                                                                    <li class="col">
                                                                        <a href="" >
                                                                            <span class="featured-name">New arrival plus size</span>
                                                                            <span class="featured-img">
                                                                                <img loading="lazy"  src="{{ asset('frontend/images/girls/1.png') }}" class="img-fluid">
                                                                            </span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="col">
                                                                        <a href="" >
                                                                            <span class="featured-name">Sweater Collection</span>
                                                                            <span class="featured-img">
                                                                                <img loading="lazy"  src="{{ asset('frontend/images/girls/2.png') }}" class="img-fluid">
                                                                            </span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="col">
                                                                        <a href="" >
                                                                            <span class="featured-name">High Quality Formal Dresses</span>
                                                                            <span class="featured-img">
                                                                                <img loading="lazy"  src="{{ asset('frontend/images/girls/3.png') }}" class="img-fluid">
                                                                            </span>
                                                                        </a>
                                                                    </li>
                                                                </ul> --}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="sub-cat-brand">
                                                            <ul class="sub-brand-list">
                                                                @foreach ($brands as $brand_id)
                                                                    @if(\App\Brand::find($brand_id) != null)
                                                                        <li class="sub-brand-item">
                                                                            <a href="{{ route('products.brand', \App\Brand::find($brand_id)->slug) }}" ><img loading="lazy"  src="{{ asset(\App\Brand::find($brand_id)->logo) }}" class="img-fluid"></a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>  
               
           */ ?>
    </div>
    <!-- Navbar -->

   

    <div class="main-nav-area d-none d-lg-block">
        <nav class="navbar navbar-expand-lg  navbar--style-2 navbar-light bg-light">
            <div class="container">
                <div class="collapse navbar-collapse  justify-content-center" id="navbar_main">
                    <!-- Navbar links -->
                    <!-- <ul class="navbar-nav">
                        @foreach (\App\Search::orderBy('count', 'desc')->get()->take(5) as $key => $search)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('suggestion.search', $search->query) }}">{{ $search->query }}</a>
                            </li>
                        @endforeach
                    </ul> -->

                         <!-- <ul class="navbar-nav">
                     
                            <li class="nav-item"><a class="nav-link" href=" ">Photo to Art</a> </li>
                            <li class="nav-item"><a class="nav-link" href=" ">Handmade Art</a> </li>
                            <li class="nav-item"><a class="nav-link" href=" ">Caricature</a> </li>
                            <li class="nav-item"><a class="nav-link" href=" ">Backlit Frame</a> </li>
                            <li class="nav-item"><a class="nav-link" href=" ">Canvas</a> </li>
                            <li class="nav-item"><a class="nav-link" href=" ">Posters</a> </li>
                            <li class="nav-item"><a class="nav-link" href=" ">Mobile</a> </li>
                            <li class="nav-item"><a class="nav-link" href=" ">Photo Gifts</a> </li>
                     
                    </ul>  -->

                    @php 
                    $m = \App\Menu::where('ref', '2')->firstorfail();
                    $json_beautified = json_decode( $m->menu );
                    @endphp

                    


                    <nav class="navbar navbar-expand-lg navbar-classic">
                       
                        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar-classic" aria-controls="navbar-classic" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="icon-bar top-bar mt-0"></span>
                            <span class="icon-bar middle-bar"></span>
                            <span class="icon-bar bottom-bar"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbar-classic">
                            <ul class="navbar-nav ">
                                @if( $json_beautified )
                                    @foreach( $json_beautified as $first_level )
                                        @if( empty( $first_level->children ) )
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ env('APP_URL').'/'.$first_level->href  }}">
                                                {{ $first_level->text }}
                                                </a>
                                            
                                            </li>
                                        @else
                                        {{-- this is for submenu --}}
                                            <li class="nav-item dropdown mega-dropdown">
                                                <a class="nav-link dropdown-toggle" href="{{ env('APP_URL').'/'.$first_level->href  }}">
                                                {{ $first_level->text }}
                                                </a>
                                                @if( !empty( $first_level->children ) )
                                                    <div class="dropdown-menu mega-dropdown-menu">
                                                            <div class="row">
                                                    @foreach( $first_level->children as $second_level )

                                                        
                                                                
                                                               
                                                                <div class="col-md-3">
                                                                <div class=""><h4><span> <a href="{{ env('APP_URL').'/'.$second_level->href  }}">{{ $second_level->text }}</a></span></h4>
                                                                    @if( !empty( $second_level->children ) )
                                                                    <ul class="menu">
                                                                    @foreach( $second_level->children as $third_level )
                                                                        <li> <a href="{{ env('APP_URL').'/'.$third_level->href  }}">{{ $third_level->text }}</a></li>
                                                                    @endforeach
                                                                    </ul>



                                                                    @endif
                                                                </div>
                                                                </div>
                                                               
                                                            

                                                    @endforeach
                                                    </div>
                                                </div>

                                                @endif

                                                
                                            </li>

                                        @endif

                                    @endforeach

                                @endif

                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="{{ env('APP_URL')  }}/cat-Photo-To-Art">
                                    Photo to Art
                                    </a>
                                
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                    Handmade Art
                                    </a>
                                   
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                    Caricature
                                    </a>
                                   
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Backlit Frame</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Canvas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Posters</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Mobile</a>
                                </li>

                                <li class="nav-item dropdown mega-dropdown">
                                    <a class="nav-link dropdown-toggle" href="">
                                    Photo Gifts
                                    </a>
                                    <div class="dropdown-menu mega-dropdown-menu">
                                        <div class="row">
                                            
                                           
                                            <div class="col-md-3">
                                            <div class=""><h4><span> <a href="#">Photo Frames</a></span></h4>
                                            <ul class="menu">
                                                <li> <a href="#">Alu &amp; MDF Frames</a></li>
                                                <li><a href="#">Alu Frame With Wooden Stand</a></li>
                                                <li><a href="#">Aluminium Photo Frames</a></li>
                                                <li><a href="#">Word Frames</a></li>
                                                <li><a href="#">Glass Photo Frames</a></li>
                                                <li><a href="#"> LED Photo Frames</a></li>
                                            </ul>
                                            </div>
                                            </div>


                                            <div class="col-md-3">
                                            <div class="">
                                            <h4><span><a href="#">Decor</a></span></h4>
                                            <ul class="menu">
                                            <li><a href="#">Pillows</a></li>
                                            <li><a href="#">Clocks</a></li>
                                            <li><a href="#">Sublimation Rocks</a></li>
                                            <li><a href="#">Photo Crystals</a></li>
                                            <li><a href="#"> Photo Wooden Cut Outs</a></li>
                                            <li><a href="#"> Photo LED Lamps</a></li>
                                            </ul>
                                            </div>
                                            </div>

                                            <div class="col-md-3">
                                            <div class=""><h4><span>
                                            <a href="#">Utilities</a></span></h4>
                                            <ul class="menu">
                                            <li> <a href="#">Key Chains</a></li>
                                            <li><a href="#">Water Bottles</a></li>
                                            <li><a href="#">Coin Collector</a></li>
                                            <li><a href="#">Puzzles</a></li>
                                            <li><a href="#">Mouse Pad</a></li>
                                            <li><a href="#">T Shirts</a></li>
                                            <li><a href="#">Photo Calendars</a></li>
                                            </ul>
                                            </div>
                                            </div>


                                            <div class="col-md-3">
                                            <div class="#"><h4><span><a href="#">Mugs</a></span></h4>
                                            <ul class="menu">
                                            <li><a href="#">Two tone mugs</a></li>
                                            <li><a href="#">Magic mugs</a></li>
                                            <li><a href="#">Heart handle mugs</a></li>
                                            <li><a href="#">Heart shape mugs</a></li>
                                            <li><a href="#">Gold &amp; Silver Colored Photo Mugs</a></li>
                                            </ul>
                                            </div>
                                            </div>

                                           
                                        </div>
                                    </div>
                                </li> -->
                               
                            </ul>
                           
                        </div>
                    </nav>



                </div>
            </div>
        </nav>
    </div>
</div>
