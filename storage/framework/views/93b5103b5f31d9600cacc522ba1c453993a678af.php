<?php /* Shankar
<section class="slice-sm footer-top-bar bg-white">
    <div class="container sct-inner">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('sellerpolicy') }}">
                        <i class="la la-file-text"></i>
                        <h4 class="heading-5">{{__('Seller Policy')}}</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('returnpolicy') }}">
                        <i class="la la-mail-reply"></i>
                        <h4 class="heading-5">{{__('Return Policy')}}</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('supportpolicy') }}">
                        <i class="la la-support"></i>
                        <h4 class="heading-5">{{__('Support Policy')}}</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('profile') }}">
                        <i class="la la-dashboard"></i>
                        <h4 class="heading-5">{{__('My Profile')}}</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

Shankr */ ?>





<!-- FOOTER -->
<footer id="footer" class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <?php
                    $generalsetting = \App\GeneralSetting::first();
                ?>
                <div class="col-md-3 col-lg-3">
                   
                        <a href="<?php echo e(route('home')); ?>" class="d-block">
                            <?php if($generalsetting->logo != null): ?>
                                <img loading="lazy"  src="<?php echo e(asset($generalsetting->logo)); ?>" class="" height="44">
                            <?php else: ?>
                                <img loading="lazy"  src="<?php echo e(asset('frontend/images/logo/logo.png')); ?>" class="" height="44">
                            <?php endif; ?>
                        </a>

                      <p class="f-mail"><i class="fa fa-envelope-o"></i><a href="mailto:support@doozypics.com">support@doozypics.com</a></p>
                      <p class="f-phone"><i class="fa fa-phone"></i><a href="tel:7799779935">7799779935</a></p> 
                         

                      <ul class="f-socials">
                           <li class="facebook"><a href="https://www.facebook.com/doozypicsart/" target="_blank"><i class="fa fa-facebook"></i><span>Facebook</span></a></li>
                           <li class="twitter"><a href="https://twitter.com/Doozy_Pics" target="_blank"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>
                           <li class="pinterest"><a href="https://pinterest.com/doozypics/" target="_blank"><i class="fa fa-pinterest"></i><span>Pinterest</span></a></li>
                           <li class="instagram"><a href="https://www.instagram.com/doozypics_art/" target="_blank"><i class="fa fa-instagram"></i><span>Pinterest</span></a></li>
                       </ul>


                   
                </div>


                <div class="col-md-3 col-lg-3">
                   
                        <h4>Photo To Art</h4>
                        <ul class="footer-links">
                            <li><a href="<?php echo e(env('APP_URL').'/product/digital-painting'); ?>">Digital Painting</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/product/oil-painting'); ?>">Oil Painting</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Caricature-Art'); ?>">Caricature Art</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Photo-Canvas'); ?>">Photo Canvas</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Backlit-Frame'); ?>">Backlit Frame</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Backlit-Frame'); ?>">Handmade Art</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Posters'); ?>">Posters</a></li>
                       
                        </ul>
                   
                </div>
                <div class="col-lg-3 col-md-3">
                    
                        <h4> Photo Gifts</h4>
                        <ul class="footer-links">
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Mugs'); ?>">Mugs</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Photo-Crystals'); ?>">Photo Crystals</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Word-Frames'); ?>">Word Frames</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Alu--MDF-Frames'); ?>">Alu & MDF Frames</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Aluminium-Photo-Frames'); ?>">Aluminium Photo Frames</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Glass-Photo-Frames'); ?>">Glass Photo Frames</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-LED-Photo-Frames'); ?>">LED Photo Frames</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Mobile-Cases'); ?>">Mobile Cases</a></li>
                            <li><a href="<?php echo e(env('APP_URL').'/cat-Photo-Frames'); ?>">Photo Frames</a></li>
                       
                        </ul>
               
                </div>

                <div class="col-md-3 col-lg-3">
                       <h4>Information</h4>
                       <ul class="menu">
                            <li><a href="about-us"> About Us</a></li>
                            <li><a href="what-we-do">What We Do</a></li>
                             <li><a href="how-it-works">How It Works</a></li>
                             <li><a href="faqs">FAQs</a></li>
                             <li><a href="contact-us">Contact Us</a></li>
                             <li><a href="whatsapp-order">WhatsApp Process</a></li>
                        </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom ">
        <div class="container">
            <div class="row">

							<div class="col-lg-6 col-md-6">
                © 2019 Picasoul. All Rights Reserved. &nbsp; &nbsp;Website by <a href="http://www.annait.com/" target="_blank" style="color:#f6416c">Anna IT</a>																				</div> 			
					<div class="col-lg-6 col-md-6">
						<ul class="copy-right-privacy">
                       <li><a href="cancellation-replacement" class="">Cancellation &amp; Replacement</a></li>
                       <li><a href="privacy" class="">Privacy Policy</a></li>
                       <li><a href="terms-conditions">Terms &amp; Conditions</a></li>
                       <li><a href="site-map">Site Map</a></li>
                      </ul>				
                    </div> 			
	
              
               
               
            </div>
        </div>
    </div>
</footer>



















<!-- FOOTER -->

<?php /* Shankar 
<footer id="footer" class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <?php
                    $generalsetting = \App\GeneralSetting::first();
                ?>
                <div class="col-lg-5 col-xl-4 text-center text-md-left">
                    <div class="col">
                        <a href="{{ route('home') }}" class="d-block">
                            @if($generalsetting->logo != null)
                                <img loading="lazy"  src="{{ asset($generalsetting->logo) }}" class="" height="44">
                            @else
                                <img loading="lazy"  src="{{ asset('frontend/images/logo/logo.png') }}" class="" height="44">
                            @endif
                        </a>
                        <p class="mt-3">{{ $generalsetting->description }}</p>
                        <div class="d-inline-block d-md-block">
                            <form class="form-inline" method="POST" action="{{ route('subscribers.store') }}">
                                @csrf
                                <div class="form-group mb-0">
                                    <input type="email" class="form-control" placeholder="{{__('Your Email Address')}}" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-base-1 btn-icon-left">
                                    {{__('Subscribe')}}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 offset-xl-1 col-md-4">
                    <div class="col text-center text-md-left">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            {{__('Contact Info')}}
                        </h4>
                        <ul class="footer-links contact-widget">
                            <li>
                               <span class="d-block opacity-5">{{__('Address')}}:</span>
                               <span class="d-block">{{ $generalsetting->address }}</span>
                            </li>
                            <li>
                               <span class="d-block opacity-5">{{__('Phone')}}:</span>
                               <span class="d-block">{{ $generalsetting->phone }}</span>
                            </li>
                            <li>
                               <span class="d-block opacity-5">{{__('Email')}}:</span>
                               <span class="d-block">
                                   <a href="mailto:{{ $generalsetting->email }}">{{ $generalsetting->email  }}</a>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4">
                    <div class="col text-center text-md-left">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            {{__('Useful Link')}}
                        </h4>
                        <ul class="footer-links">
                            @foreach (\App\Link::all() as $key => $link)
                                <li>
                                    <a href="{{ $link->url }}" title="">
                                        {{ $link->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 col-lg-2">
                    <div class="col text-center text-md-left">
                       <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                          {{__('My Account')}}
                       </h4>

                       <ul class="footer-links">
                            @if (Auth::check())
                                <li>
                                    <a href="{{ route('logout') }}" title="Logout">
                                        {{__('Logout')}}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('user.login') }}" title="Login">
                                        {{__('Login')}}
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('purchase_history.index') }}" title="Order History">
                                    {{__('Order History')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('wishlists.index') }}" title="My Wishlist">
                                    {{__('My Wishlist')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('orders.track') }}" title="Track Order">
                                    {{__('Track Order')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                    @if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                        <div class="col text-center text-md-left">
                            <div class="mt-4">
                                <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                                    {{__('Be a Seller')}}
                                </h4>
                                <a href="{{ route('shops.create') }}" class="btn btn-base-1 btn-icon-left">
                                    {{__('Apply Now')}}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom py-3 sct-color-3">
        <div class="container">
            <div class="row row-cols-xs-spaced flex flex-items-xs-middle">
                <div class="col-md-4">
                    <div class="copyright text-center text-md-left">
                        <ul class="copy-links no-margin">
                            <li>
                                © {{ date('Y') }} {{ $generalsetting->site_name }}
                            </li>
                            <li>
                                <a href="{{ route('terms') }}">{{__('Terms')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('privacypolicy') }}">{{__('Privacy policy')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="text-center my-3 my-md-0 social-nav model-2">
                        @if ($generalsetting->facebook != null)
                            <li>
                                <a href="{{ $generalsetting->facebook }}" class="facebook" target="_blank" data-toggle="tooltip" data-original-title="Facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                        @endif
                        @if ($generalsetting->instagram != null)
                            <li>
                                <a href="{{ $generalsetting->instagram }}" class="instagram" target="_blank" data-toggle="tooltip" data-original-title="Instagram">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                        @endif
                        @if ($generalsetting->twitter != null)
                            <li>
                                <a href="{{ $generalsetting->twitter }}" class="twitter" target="_blank" data-toggle="tooltip" data-original-title="Twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                        @endif
                        @if ($generalsetting->youtube != null)
                            <li>
                                <a href="{{ $generalsetting->youtube }}" class="youtube" target="_blank" data-toggle="tooltip" data-original-title="Youtube">
                                    <i class="fa fa-youtube"></i>
                                </a>
                            </li>
                        @endif
                        @if ($generalsetting->google_plus != null)
                            <li>
                                <a href="{{ $generalsetting->google_plus }}" class="google-plus" target="_blank" data-toggle="tooltip" data-original-title="Google Plus">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="text-center text-md-right">
                        <ul class="inline-links">
                            @if (\App\BusinessSetting::where('type', 'paypal_payment')->first()->value == 1)
                                <li>
                                    <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/paypal.png')}}" height="20">
                                </li>
                            @endif
                            @if (\App\BusinessSetting::where('type', 'stripe_payment')->first()->value == 1)
                                <li>
                                    <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/stripe.png')}}" height="20">
                                </li>
                            @endif
                            @if (\App\BusinessSetting::where('type', 'sslcommerz_payment')->first()->value == 1)
                                <li>
                                    <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/sslcommerz.png')}}" height="20">
                                </li>
                            @endif
                            @if (\App\BusinessSetting::where('type', 'instamojo_payment')->first()->value == 1)
                                <li>
                                    <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/instamojo.png')}}" height="20">
                                </li>
                            @endif
                            @if (\App\BusinessSetting::where('type', 'razorpay')->first()->value == 1)
                                <li>
                                    <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/rozarpay.png')}}" height="20">
                                </li>
                            @endif
                            @if (\App\BusinessSetting::where('type', 'paystack')->first()->value == 1)
                                <li>
                                    <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/paystack.png')}}" height="20">
                                </li>
                            @endif
                            @if (\App\BusinessSetting::where('type', 'cash_payment')->first()->value == 1)
                                <li>
                                    <img loading="lazy"  src="{{ asset('frontend/images/icons/cards/cod.png')}}" height="20">
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

*/ ?>
<?php /**PATH C:\xampp\htdocs\cricket\resources\views/desktop/frontend/inc/footer.blade.php ENDPATH**/ ?>