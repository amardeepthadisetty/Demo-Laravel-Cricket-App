 

<link type="text/css" href="<?php echo e(asset('frontend/css/testimonial.css')); ?>" rel="stylesheet" media="screen"> 
<link type="text/css" href="<?php echo e(asset('frontend/css/slider.css')); ?>" rel="stylesheet" media="screen">   
<link type="text/css" href="<?php echo e(asset('frontend/css/slick.css')); ?>" rel="stylesheet">

<?php $__env->startSection('content'); ?>
    <section class="home-banner-area">
      
            <div class="no-gutters position-relative">

                <?php /*

                <div class="col-lg-3 position-static order-2 order-lg-0">
                    <div class="category-sidebar">
                        <div class="all-category d-none d-lg-block">
                            <span >{{__('Categories')}}</span>
                            <a href="{{ route('categories.all') }}">
                                <span class="d-none d-lg-inline-block">{{__('See All')}} ></span>
                            </a>
                        </div>
                        <ul class="categories no-scrollbar">
                            <li class="d-lg-none">
                                <a href="{{ route('categories.all') }}">
                                    <img loading="lazy"  class="cat-image" src="{{ asset('frontend/images/icons/list.png') }}" width="30">
                                    <span class="cat-name">{{__('All')}} <br> {{__('Categories')}}</span>
                                </a>
                            </li>
                            @foreach (\App\Category::all()->take(11) as $key => $category)
                                <?php
                                    $brands = array();
                                    $subCat = \App\SubCategory::where('category_id', $category->id)->get();
                                ?>
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
                                                                    <?php
                                                                            $subSubCat = \App\SubSubCategory::where('sub_category_id', $subcategory->id)->get();
                                                                    ?>
                                                                    <div class="card">
                                                                        <ul class="sub-cat-items">
                                                                            <li class="sub-cat-name"><a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ __($subcategory->name) }}</a></li>
                                                                            @foreach ($subSubCat as $subsubcategory)
                                                                                <?php
                                                                                    foreach (json_decode($subsubcategory->brands) as $brand) {
                                                                                        if(!in_array($brand, $brands)){
                                                                                            array_push($brands, $brand);
                                                                                        }
                                                                                    }
                                                                                ?>
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
                     
                    */ ?>

                <div class="order-1 order-lg-0">
                    <div class="home-slide">
                       
                            <div class="slick-carousel" data-slick-arrows="true"  data-slick-autoplay="true">
                                <?php $__currentLoopData = \App\Slider::where('published', '1')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="" style="height:auto;">
                                        <img loading="lazy"  class="d-block w-100 " src="<?php echo e(asset('public/'.$slider->photo)); ?>" alt="Slider Image">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    

                    <?php /*
                    <div class="trending-category  d-none d-lg-block">
                        <ul>
                            @foreach (\App\Category::where('featured', '1')->get()->take(7) as $key => $category)
                                <li @if ($key == 0) class="active" @endif>
                                    <div class="trend-category-single">
                                        <a href="{{ route('products.category', $category->slug) }}" class="d-block">
                                            <div class="name">{{ __($category->name) }}</div>
                                            <div class="img" style="background-image:url('{{ asset($category->banner) }}')">
                                            </div>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    */ ?>
              

                
                <?php /*

                <?php
                    //$flash_deal = \App\FlashDeal::where('status', 1)->first();
                    $flash_deal = null;
                ?>
                @if($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date)
                    <div class="col-lg-2 d-none d-lg-block">
                        <div class="flash-deal-box bg-white h-100">
                            <div class="title text-center p-2 gry-bg">
                                <h3 class="heading-6 mb-0">
                                    {{__('Flash Deal')}}
                                    <span class="badge badge-danger">{{__('Hot')}}</span>
                                </h3>
                                <div class="countdown countdown--style-1 countdown--style-1-v1" data-countdown-date="{{ date('m/d/Y', $flash_deal->end_date) }}" data-countdown-label="show"></div>
                            </div>
                            <div class="flash-content c-scrollbar">
                                @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                                    <?php
                                        $product = \App\Product::find($flash_deal_product->product_id);
                                    ?>
                                    @if ($product != null)
                                        <a href="{{ route('product', $product->slug) }}" class="d-block flash-deal-item">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col">
                                                    <div class="img" style="background-image:url('{{ asset($product->flash_deal_img) }}')">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="price">
                                                        <span class="d-block">{{ home_discounted_base_price($product->id) }}</span>
                                                        @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                            <del class="d-block">{{ home_base_price($product->id) }}</del>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-2 d-none d-lg-block">
                        <div class="flash-deal-box bg-white h-100">
                            <div class="title text-center p-2 gry-bg">
                                <h3 class="heading-6 mb-0">
                                    {{ __('Todays Deal') }}
                                    <span class="badge badge-danger">{{__('Hot')}}</span>
                                </h3>
                            </div>
                            <div class="flash-content c-scrollbar c-height">
                            <?php 
                             //$products = \App\Product::where('published', '1')->where('todays_deal', '1')->get();
                             //print_r($products);
                             
                            ?>
                                @foreach (\App\Product::where('published', '1')->where('todays_deal', '1')->get() as $key => $product)
                                    @if ($product != null)
                                        <a href="{{ route('product', $product->slug) }}" class="d-block flash-deal-item">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col">
                                                    <div class="img" style="background-image:url('{{ asset($product->flash_deal_img) }}')">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="price">
                                                    
                                                        <span class="d-block">{{ home_discounted_base_price($product->id) }}</span>
                                                        
                                                         @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                            <del class="d-block">{{ home_base_price($product->id) }}</del>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                      */ ?>

            </div>
        
    </section>
               



           
             <!--  Featured Products Startt -->

             <section class="featured-products text-center">
                <div class="container">
                    <div class="row ">
                      <div class="col-lg-12">
                         <h3>Featured Products</h3>
                     </div>
                 </div>

                 <div class="row ps">
               
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/product/digital-painting'); ?>">
                                <img src="./img/home/dp/trending/digital-painting.jpg" alt=" Digital Painting">
                               <div class="pr-title">Digital Painting</div>
                            </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/product/oil-painting'); ?>">
                                <img src="./img/home/dp/trending/oil-painting.jpg" alt="Oil Painting">
                               <div class="pr-title">oil painting</div>
                            </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/category/Caricature-Art'); ?>">
                                <img src="./img/home/dp/trending/caricature.jpg" alt=" Caricature Art">
                               <div class="pr-title">Caricature Art</div>
                            </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/category/handmade-art'); ?>">
                                <img src="./img/home/dp/trending/handmade-painting.jpg" alt="handmade painting">
                               <div class="pr-title">Handmade painting</div>
                            </a>
                    </div>
                </div>
            </div>
            
                </div>
            </section>

                <!--  Featured Products End -->


                   

                
             <!--  Popular Collections Startt -->

             <section class="popular-collections text-center">
                <div class="container">
                    <div class="row ">
                      <div class="col-lg-12">
                         <h3>Popular Collections</h3>
                     </div>
                 </div>

                 <div class="row ps">

                 <div class="col-6 col-md-3 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/category/Photo-Canvas'); ?>">
                                <img src="./img/home/dp/popular/photo-canvas.jpg" alt="Photo Canvas">
                               <div class="pr-title">Photo Canvas</div>
                            </a>
                    </div>
                </div>
               
               

                <div class="col-6 col-md-3 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/category/Mugs'); ?>">
                                <img src="./img/home/dp/popular/mugs.jpg" alt=" Mugs">
                               <div class="pr-title">mugs</div>
                            </a>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/category/Photo-Wooden-Cut-Outs'); ?>">
                                <img src="./img/home/dp/popular/wood-cut-out.jpg" alt=" >wood cut out">
                               <div class="pr-title">wood cut out</div>
                            </a>
                    </div>
                </div>


                <div class="col-6 col-md-3 col-lg-3">
                <div class="pr-span">
                           <a href="<?php echo e(env('APP_URL').'/category/Photo-Canvas'); ?>">
                                <img src="./img/home/dp/trending/canvas.jpg" alt=" Photo Canvas">
                               <div class="pr-title">Photo Canvas</div>
                            </a>
                    </div>
                </div>

                

               

               
            </div>
            
                </div>
            </section>

                <!--  Popular Collections End -->










             <!--  Trending Products Startt -->

            <section class="trending-products text-center">
                <div class="container">
                    <div class="row ">
                      <div class="col-lg-12">
                         <h3>new arrivals</h3>
                     </div>
                 </div>

                 <div class="row ps">
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/product/digital-painting'); ?>">
                                <img src="./img/home/dp/trending/digital-painting.jpg" alt=" Digital Painting">
                               <div class="pr-title">Digital Painting</div>
                            </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/product/oil-painting'); ?>">
                                <img src="./img/home/dp/trending/oil-painting.jpg" alt="Oil Painting">
                               <div class="pr-title">oil painting</div>
                            </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/category/Caricature-Art'); ?>">
                                <img src="./img/home/dp/trending/caricature.jpg" alt=" Caricature Art">
                               <div class="pr-title">caricature Art</div>
                            </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/category/Handmade-Art'); ?>">
                                <img src="./img/home/dp/trending/handmade-painting.jpg" alt="handmade painting">
                               <div class="pr-title">handmade painting</div>
                            </a>
                    </div>
                </div>

                   </div>
                <div class="row ps">

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/category/Photo-Canvas'); ?>">
                                <img src="./img/home/dp/trending/canvas.jpg" alt=" Photo Canvas">
                               <div class="pr-title">Photo Canvas</div>
                            </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/category/Backlit-Frame'); ?>">
                                <img src="./img/home/dp/trending/backlight.gif" alt=" Backlight Frame">
                               <div class="pr-title"> backlight Frame</div>
                            </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/category/mugs'); ?>">
                                <img src="./img/home/dp/trending/mugs.jpg" alt="Mugs">
                               <div class="pr-title">Mugs</div>
                            </a>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3">
                    <div class="pr-span">
                            <a href="<?php echo e(env('APP_URL').'/category/Photo-Wooden-Cut-Outs'); ?>">
                                <img src="./img/home/dp/trending/wood-cut-out.jpg" alt=" Wood Cut Out">
                               <div class="pr-title">Wood Cut out</div>
                            </a>
                    </div>
                </div>
            </div>



                </div>
            </section>

                <!--  Trending Products End -->



                   <!--  Testimonial -->
                <section class="testimonial-home">

                <div class="container">
	<div class="row">
		<div class="col-sm-12 text-center">
            <h3>check out our customer reviews !!</h3>
          </div>
          <div class="col-sm-12">
            <div class="ps">
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<!-- Carousel indicators -->
				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#myCarousel" data-slide-to="1"></li>
					<li data-target="#myCarousel" data-slide-to="2"></li>
				</ol>   
				<!-- Wrapper for carousel items -->
				<div class="carousel-inner">
					<div class="item carousel-item active">
						<div class="row">
							<div class="col-sm-6">
								<div class="media">
									<div class="media-left d-flex mr-3">
										<a href="#">
                                        <img src="./img/testimonials/supriya.jpg" alt=" Supriya">
										</a>
									</div>
									<div class="media-body">
										<div class="testimonial">
											<p>Thank you so much  for such an amazing painting !! My Sister was so happy with the gift , would love to order more, ones again thank you so much.</p>
                                            <p class="overview">-- supriya</p>
                                            <div class="star-rating">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                </ul>
			</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="media">
									<div class="media-left d-flex mr-3">
										<a href="#">
                                        <img src="./img/testimonials/aneesh.jpg" alt=" Aneesh">
										</a>
									</div>
									<div class="media-body">
										<div class="testimonial">
                                        </p>Extremely artistic thank you for the unforgettable painting !! Kudos to the Artist and support team, get ready for my second order</p>
                                            <p class="overview">-- Aneesh.p</p>
                                            <div class="star-rating">
                                            <ul class="list-inline">
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                </ul>
                                               </div>
										</div>
									</div>
								</div>
							</div>
						</div>			
                    </div>
                    
					<div class="item carousel-item">
						<div class="row">
							<div class="col-sm-6">
								<div class="media">
									<div class="media-left d-flex mr-3">
										<a href="#">
                                        <img src="./img/testimonials/deepika.jpg" alt=" Deepika">
										</a>
									</div>
									<div class="media-body">
										<div class="testimonial">
											<p>Doozypics puts life in paintings. I am very happy with the team and their work. Ordered a digital painting and came out to be beautiful.</p>
                                            <p class="overview">-- Deepika</p>
                                            <div class="star-rating">
                                            <ul class="list-inline">
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                </ul>
                                             </div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="media">
									<div class="media-left d-flex mr-3">
										<a href="#">
                                        <img src="./img/testimonials/bhavani.jpg" alt=" Bhavani">
										</a>
									</div>
									<div class="media-body">
										<div class="testimonial">
											<p>Awesome experience with doozypics. They were in touch with me from beginning to end and gave me a wonderful portrait of my favorite photo. thank you Doozypics.</p>
                                            <p class="overview">-- bhavani</p>
                                            <div class="star-rating">
                                            <ul class="list-inline">
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                </ul>
                                               </div>
										</div>
									</div>
								</div>
							</div>
						</div>			
					</div>
					<div class="item carousel-item">
						<div class="row">
							<div class="col-sm-6">
								<div class="media">
									<div class="media-left d-flex mr-3">
										<a href="#">
                                        <img src="./img/testimonials/avinash.jpg" alt=" Avinash">
										</a>
									</div>
									<div class="media-body">
										<div class="testimonial">
											<p>Very good Service which helped me to give beautiful Image with caricature to my friend as a gift. I am very happy to choose Doozypics. Thank you.</p>
                                            <p class="overview">-- avinash</p>
                                            <div class="star-rating">
                                            <ul class="list-inline">
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                </ul>
                                             </div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="media">
									<div class="media-left d-flex mr-3">
										<a href="#">
                                        <img src="./img/testimonials/aditya-mohan.jpg" alt=" Aditya Mohan">
										</a>
									</div>
									<div class="media-body">
										<div class="testimonial">
                                        <p>Opted for oil caricature and it was excellent!!!</p>
                                        <p> Quick delivery and very beautifully made !! </p>
                                        <p>Gifted it to my brother and he loved it !! Thank you Doozypics !!</p>
                                            <p class="overview">-- aditya mohan</p>
                                            <div class="star-rating">
                                            <ul class="list-inline">
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                                </ul>
                                                </div>
										</div>
									</div>
								</div>
							</div>
						</div>			
					</div>
				</div>
            </div>
               </div>
               </div>
		</div>
	</div>
</div>
 </section>


   <!--  Testimonial End -->

              

                         <!--  How It Works Startt -->

             <section class="how-it-works-home">
                <div class="container">
                   

                 <div class="row text-center">

                 <div class="col-6 col-md-3 col-lg-3">
                <div class="how-span">
               
                <img src="./img/satisfaction/bulk.png" alt=" Bulk Orders">
             
                   <h5>Bulk Orders</h5>
                    <p>Buy Wholesale Get Amazing Discounts.</p>
                    <div class="readmore"><a href="">Learn more</a></div>
                    </div>
                </div>
               
                <div class="col-6 col-md-3 col-lg-3">
                    <div class="how-span">
                   
                    <img src="./img/satisfaction/free-shipping.png" alt=" Indiawide Free Shipping">
                      
                   <h5> Indiawide Free Shipping</h5>
                    <p>Available as Standard or Express delivery.</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-lg-3">
                <div class="how-span">
              
                <img src="./img/satisfaction/secure-payments.png" alt="  Secure Payments">
               
                   <h5> Secure Payments</h5>
                    <p>100% Secure payment with 256-bit SSL Encryption.</p>
                    </div>
                </div>

                <div class="col-6 col-md-3 col-lg-3">
                <div class="how-span">
              
                <img src="./img/satisfaction/satisfaction.png" alt=" Customer Satisfaction">
                 
                   <h5>Customer Satisfaction</h5>
                    <p>100% Satisfaction Guaranteed</p>
                    </div>
                </div>
                

               
            </div>
            
                </div>
            </section>

                <!--  How It Works End -->
















   
<!--

    
    <section class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                <?php $__currentLoopData = \App\Banner::where('position', 1)->where('published', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-<?php echo e(12/count(\App\Banner::where('position', 1)->where('published', 1)->get())); ?>">
                        <div class="media-banner mb-3 mb-lg-0">
                            <a href="<?php echo e($banner->url); ?>" target="_blank" class="banner-container">
                                <img loading="lazy"  src="<?php echo e(asset($banner->photo)); ?>" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>


    <section class="mb-4">
        <div class="container">
            <div class="px-2 py-4 p-md-4 bg-white shadow-sm">
                <div class="section-title-1 clearfix">
                    <h3 class="heading-5 strong-700 mb-0 float-left">
                        <span class="mr-4"><?php echo e(__('Categories')); ?></span>
                    </h3>
                </div>
                <div class="caorusel-box">
                    <div class="slick-carousel" data-slick-items="6" data-slick-xl-items="5" data-slick-lg-items="4"  data-slick-md-items="3" data-slick-sm-items="2" data-slick-xs-items="2">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product-card-2 card card-product m-2 shop-cards shop-tech">
                            <div class="card-body p-0">

                                <div class="card-image">
                                    <a href="<?php echo e(route('categories', $cat->slug)); ?>" class="d-block" style="background-image:url('<?php echo e(asset($cat->thumbnail_img)); ?>');">
                                    </a>
                                </div>

                                <div class="p-3">
                                   
                                    
                                    <h2 class="product-title p-0 text-truncate-2">
                                        <a href="<?php echo e(route('product', $cat->slug)); ?>"><?php echo e(__($cat->name)); ?></a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div class="container">
            <div class="px-2 py-4 p-md-4 bg-white shadow-sm">
                <div class="section-title-1 clearfix">
                    <h3 class="heading-5 strong-700 mb-0 float-left">
                        <span class="mr-4"><?php echo e(__('Featured Products')); ?></span>
                    </h3>
                </div>
                <div class="caorusel-box">
                    <div class="slick-carousel" data-slick-items="6" data-slick-xl-items="5" data-slick-lg-items="4"  data-slick-md-items="3" data-slick-sm-items="2" data-slick-xs-items="2">
                        <?php $__currentLoopData = filter_products(\App\Product::where('published', '1')->where('featured', '1'))->limit(12)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product-card-2 card card-product m-2 shop-cards shop-tech">
                            <div class="card-body p-0">

                                <div class="card-image">
                                    <a href="<?php echo e(route('product', $product->slug)); ?>" class="d-block" style="background-image:url('<?php echo e(asset($product->thumbnail_img)); ?>');">
                                    </a>
                                </div>

                                <div class="p-3">
                                    <div class="price-box">
                                        <?php if(home_base_price($product->id) != home_discounted_base_price($product->id)): ?>
                                            <del class="old-product-price strong-400"><?php echo e(home_base_price($product->id)); ?></del>
                                        <?php endif; ?>
                                        <span class="product-price strong-600"><?php echo e(home_discounted_base_price($product->id)); ?></span>
                                    </div>
                                    <div class="star-rating star-rating-sm mt-1">
                                        <?php echo e(renderStarRating($product->rating)); ?>

                                    </div>
                                    <h2 class="product-title p-0 text-truncate-2">
                                        <a href="<?php echo e(route('product', $product->slug)); ?>"><?php echo e(__($product->name)); ?></a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <?php if(\App\BusinessSetting::where('type', 'best_selling')->first()->value == 1): ?>
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 p-md-4 bg-white shadow-sm">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0 float-left">
                            <span class="mr-4"><?php echo e(__('Best Selling')); ?></span>
                        </h3>
                        <ul class="inline-links float-right">
                            <li><a  class="active"><?php echo e(__('Top 20')); ?></a></li>
                        </ul>
                    </div>
                    <div class="caorusel-box">
                        <div class="slick-carousel" data-slick-items="3" data-slick-lg-items="3"  data-slick-md-items="2" data-slick-sm-items="2" data-slick-xs-items="1" data-slick-dots="true" data-slick-rows="2">
                            <?php $__currentLoopData = filter_products(\App\Product::where('published', '1')->orderBy('num_of_sale', 'desc'))->limit(20)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-2">
                                    <div class="row no-gutters product-box-2 align-items-center">
                                        <div class="col-4">
                                            <div class="position-relative overflow-hidden h-100">
                                                <a href="<?php echo e(route('product', $product->slug)); ?>" class="d-block product-image h-100" style="background-image:url('<?php echo e(asset($product->thumbnail_img)); ?>');">
                                                </a>
                                                <div class="product-btns">
                                                    <button class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList(<?php echo e($product->id); ?>)">
                                                        <i class="la la-heart-o"></i>
                                                    </button>
                                                    <button class="btn add-compare" title="Add to Compare" onclick="addToCompare(<?php echo e($product->id); ?>)">
                                                        <i class="la la-refresh"></i>
                                                    </button>
                                                    <button class="btn quick-view" title="Quick view" onclick="showAddToCartModal(<?php echo e($product->id); ?>)">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-8 border-left">
                                            <div class="p-3">
                                                <h2 class="product-title mb-0 p-0 text-truncate-2">
                                                    <a href="<?php echo e(route('product', $product->slug)); ?>"><?php echo e(__($product->name)); ?></a>
                                                </h2>
                                                <div class="star-rating star-rating-sm mb-2">
                                                    <?php echo e(renderStarRating($product->rating)); ?>

                                                </div>
                                                <div class="clearfix">
                                                    <div class="price-box float-left">
                                                        <?php if(home_base_price($product->id) != home_discounted_base_price($product->id)): ?>
                                                            <del class="old-product-price strong-400"><?php echo e(home_base_price($product->id)); ?></del>
                                                        <?php endif; ?>
                                                        <span class="product-price strong-600"><?php echo e(home_discounted_base_price($product->id)); ?></span>
                                                    </div>
                                                    <div class="float-right">
                                                        <button class="add-to-cart btn" title="Add to Cart" onclick="showAddToCartModal(<?php echo e($product->id); ?>)">
                                                            <i class="la la-shopping-cart"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>


    <?php $__currentLoopData = \App\HomeCategory::where('status', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $homeCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 p-md-4 bg-white shadow-sm">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0 float-left">
                            <span class="mr-4"><?php echo e($homeCategory->category->name); ?></span>
                        </h3>
                        <ul class="inline-links float-right nav d-none d-lg-inline-block">
                            <?php $__currentLoopData = json_decode($homeCategory->subsubcategories); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subsubcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(\App\SubSubCategory::find($subsubcategory) != null): ?>
                                    <li class="<?php if($key == 0) echo 'active'; ?>">
                                        <a href="#subsubcat-<?php echo e($subsubcategory); ?>" data-toggle="tab" class="d-block <?php if($key == 0) echo 'active'; ?>"><?php echo e(\App\SubSubCategory::find($subsubcategory)->name); ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <?php $__currentLoopData = json_decode($homeCategory->subsubcategories); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subsubcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(\App\SubSubCategory::find($subsubcategory) != null): ?>
                            <div class="tab-pane fade <?php if($key == 0) echo 'show active'; ?>" id="subsubcat-<?php echo e($subsubcategory); ?>">
                                <div class="row gutters-5 sm-no-gutters">
                                    <?php $__currentLoopData = filter_products(\App\Product::where('published', 1)->where('subsubcategory_id', $subsubcategory))->limit(6)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-xl-2 col-lg-3 col-md-4 col-6">
                                            <div class="product-box-2 bg-white alt-box my-2">
                                                <div class="position-relative overflow-hidden">
                                                    <a href="<?php echo e(route('product', $product->slug)); ?>" class="d-block product-image h-100" style="background-image:url('<?php echo e(asset($product->thumbnail_img)); ?>');" tabindex="0">
                                                    </a>
                                                    <div class="product-btns clearfix">
                                                        <button class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList(<?php echo e($product->id); ?>)" tabindex="0">
                                                            <i class="la la-heart-o"></i>
                                                        </button>
                                                        <button class="btn add-compare" title="Add to Compare" onclick="addToCompare(<?php echo e($product->id); ?>)" tabindex="0">
                                                            <i class="la la-refresh"></i>
                                                        </button>
                                                        <button class="btn quick-view" title="Quick view" onclick="showAddToCartModal(<?php echo e($product->id); ?>)" tabindex="0">
                                                            <i class="la la-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="p-3 border-top">
                                                    <h2 class="product-title p-0 text-truncate">
                                                        <a href="<?php echo e(route('product', $product->slug)); ?>" tabindex="0"><?php echo e(__($product->name)); ?></a>
                                                    </h2>
                                                    <div class="star-rating mb-1">
                                                        <?php echo e(renderStarRating($product->rating)); ?>

                                                    </div>
                                                    <div class="clearfix">
                                                        <div class="price-box float-left">
                                                            <?php if(home_base_price($product->id) != home_discounted_base_price($product->id)): ?>
                                                                <del class="old-product-price strong-400"><?php echo e(home_base_price($product->id)); ?></del>
                                                            <?php endif; ?>
                                                            <span class="product-price strong-600"><?php echo e(home_discounted_base_price($product->id)); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <section class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                <?php $__currentLoopData = \App\Banner::where('position', 2)->where('published', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-<?php echo e(12/count(\App\Banner::where('position', 2)->where('published', 1)->get())); ?>">
                        <div class="media-banner mb-3 mb-lg-0">
                            <a href="<?php echo e($banner->url); ?>" target="_blank" class="banner-container">
                                <img loading="lazy"  src="<?php echo e(asset($banner->photo)); ?>" alt="" class="img-fluid">
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
                                                            -->
    

    <!-- <section class="mb-3">
        <div class="container">
            <div class="row gutters-10">
                <div class="col-lg-6">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0 float-left">
                            <span class="mr-4"><?php echo e(__('Top 10 Catogories')); ?></span>
                        </h3>
                        <ul class="float-right inline-links">
                            <li>
                                <a href="<?php echo e(route('categories.all')); ?>" class="active"><?php echo e(__('View All Catogories')); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="row gutters-5">
                        <?php $__currentLoopData = \App\Category::where('top', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-3 col-6">
                                <a href="<?php echo e(route('products.category', $category->slug)); ?>" class="bg-white border d-block c-base-2 box-2 icon-anim pl-2">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-3 text-center">
                                            <img loading="lazy"  src="<?php echo e(asset($category->banner)); ?>" alt="" class="img-fluid img">
                                        </div>
                                        <div class="info col-7">
                                            <div class="name text-truncate pl-3 py-4"><?php echo e(__($category->name)); ?></div>
                                        </div>
                                        <div class="col-2">
                                            <i class="la la-angle-right c-base-1"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0 float-left">
                            <span class="mr-4"><?php echo e(__('Top 10 Brands')); ?></span>
                        </h3>
                        <ul class="float-right inline-links">
                            <li>
                                <a href="<?php echo e(route('brands.all')); ?>" class="active"><?php echo e(__('View All Brands')); ?></a>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <?php $__currentLoopData = \App\Brand::where('top', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-3 col-6">
                                <a href="<?php echo e(route('products.brand', $brand->slug)); ?>" class="bg-white border d-block c-base-2 box-2 icon-anim pl-2">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col-3 text-center">
                                            <img loading="lazy"  src="<?php echo e(asset($brand->logo)); ?>" alt="" class="img-fluid img">
                                        </div>
                                        <div class="info col-7">
                                            <div class="name text-truncate pl-3 py-4"><?php echo e(__($brand->name)); ?></div>
                                        </div>
                                        <div class="col-2">
                                            <i class="la la-angle-right c-base-1"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

    </section> -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('desktop.frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\cricket\resources\views/desktop/frontend/index.blade.php ENDPATH**/ ?>