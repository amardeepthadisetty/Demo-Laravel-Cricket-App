<!--MAIN NAVIGATION-->
<!--===================================================-->
<nav id="mainnav-container">
    <div id="mainnav">

        <!--Menu-->
        <!--================================-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">

                    <!--Profile Widget-->
                    <!--================================-->
                    {{-- <div id="mainnav-profile" class="mainnav-profile">
                        <div class="profile-wrap text-center">
                            <div class="pad-btm">
                                <img loading="lazy"  class="img-circle img-md" src="{{ asset('img/profile-photos/1.png') }}" alt="Profile Picture">
                            </div>
                            <a href="#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
                                <span class="pull-right dropdown-toggle">
                                    <i class="dropdown-caret"></i>
                                </span>
                                <p class="mnp-name">{{Auth::user()->name}}</p>
                                <span class="mnp-desc">{{Auth::user()->email}}</span>
                            </a>
                        </div>
                        <div id="profile-nav" class="collapse list-group bg-trans">
                            <a href="#" class="list-group-item">
                                <i class="demo-pli-male icon-lg icon-fw"></i> View Profile
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="demo-pli-gear icon-lg icon-fw"></i> Settings
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="demo-pli-information icon-lg icon-fw"></i> Help
                            </a>
                            <a href="#" class="list-group-item">
                                <i class="demo-pli-unlock icon-lg icon-fw"></i> Logout
                            </a>
                        </div>
                    </div> --}}


                    <!--Shortcut buttons-->
                    <!--================================-->
                    <div id="mainnav-shortcut" class="hidden">
                        <ul class="list-unstyled shortcut-wrap">
                            <li class="col-xs-3" data-content="My Profile">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                                    <i class="demo-pli-male"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Messages">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                                    <i class="demo-pli-speech-bubble-3"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Activity">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-success">
                                    <i class="demo-pli-thunder"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Lock Screen">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-purple">
                                    <i class="demo-pli-lock-2"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--================================-->
                    <!--End shortcut buttons-->


                    <ul id="mainnav-menu" class="list-group">
                          {{-- <li class="active">
                                <a class="nav-link" href="{{route('products.create')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Products')}}</span>
                                </a>
                            </li> --}}

                          

                            <li class="active">
                                <a class="nav-link" href="{{route('teams.index')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Teams')}}</span>
                                </a>
                            </li> 


                           <!--  <li class="active">
                                <a class="nav-link" href="{{route('products.admin')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Products')}}</span>
                                </a>
                            </li> 
                            <li class="active">
                                <a class="nav-link" href="{{route('templates.admin')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Templates')}}</span>
                                </a>
                            </li>
                            <li class="active">
                                <a class="nav-link" href="{{route('templatecategories.admin')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Categories')}}</span>
                                </a>
                            </li>  
                            <li class="active">
                                <a class="nav-link" href="{{route('filtergroups.admin')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Filters')}}</span>
                                </a>
                            </li> 
                            <li class="active">
                                <a class="nav-link" href="{{route('coupon.index')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Coupons')}}</span>
                                </a>
                            </li> 


                            <li class="active">
                                <a class="nav-link" href="{{route('local_pickup.index')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Local Pick Up Addresses')}}</span>
                                </a>
                            </li> 

                             <li class="active">
                                <a class="nav-link" href="{{route('status_code.index')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Status codes for orders')}}</span>
                                </a>
                            </li> 

                             <li class="active">
                                <a class="nav-link" href="{{route('payment_type.index')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Payment types')}}</span>
                                </a>
                            </li> 

                             <li class="active">
                                <a class="nav-link" href="{{route('shipping_charge.index')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Shipping Charges')}}</span>
                                </a>
                            </li>  

                              <li class="active">
                                <a class="nav-link" href="{{route('shippingmethod.admin')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Shipping Method')}}</span>
                                </a>
                            </li> 

                             <li class="active">
                                <a class="nav-link" href="{{route('shippingsetting.index')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Global Shipping Settings')}}</span>
                                </a>
                            </li>  

                            <li class="active">
                                <a class="nav-link" href="{{route('orders.index')}}">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title">{{__('Orders')}}</span>
                                </a>
                            </li>  -->
                       
                    </ul>
                </div>
            </div>
        </div>
        <!--================================-->
        <!--End menu-->

    </div>
</nav>
